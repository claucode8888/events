<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Repository\BookingRepository;
use App\Repository\TicketRepository;
use App\Service\EmailService;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Webhook;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use UnexpectedValueException;

#[Route('/stripe')]
final class StripeWebhookController extends AbstractController
{
  public function __construct(private EntityManagerInterface $em, private LoggerInterface $logger, private string $stripeWebhookSecret){}

  #[Route('/webhook', name: 'app_stripe_webhook', methods: ['POST'])]
  public function handle(
    Request $request,
    BookingRepository $bookingRepository,
    TicketRepository $ticketRepository,
    EmailService $emailService,
  ): Response
  {
    $payload = $request->getContent();
    $sigHeader = $request->headers->get('Stripe-Signature');

    try {
      $event = Webhook::constructEvent($payload, $sigHeader, $this->stripeWebhookSecret);
    }
    catch (SignatureVerificationException $e) {
      $this->logger->error('Stripe Webhook failed: Invalid Stripe signature', ['message' => $e->getMessage()]);
      return new Response('Stripe Webhook failed: Invalid signature', Response::HTTP_BAD_REQUEST);
    } catch (UnexpectedValueException $e) {
      $this->logger->error('Stripe Webhook failed:', ['message' => $e->getMessage()]);
      return new Response('Stripe Webhook failed: Invalid payload', Response::HTTP_BAD_REQUEST);
    }

    if ($event->type !== 'checkout.session.completed') {
      return new Response('Ignored.', Response::HTTP_OK);
    }

    $session = $event->data->object;
    $bookingId = $session->metadata->booking_id;
    $booking = $bookingRepository->find($bookingId);

    if ($booking && $booking->getStatus() === Booking::STATUS_PENDING) {

      // Send email confirmation
      $queryResults = $ticketRepository->getTicketsByCategory($booking);
      $emailService->sendBookingConfirmation($booking, $queryResults['total_tickets'], $queryResults['tickets_by_category']);
      
      // Mark Booking as paid
      $booking->setStatus(Booking::STATUS_PAID);
      $this->em->flush();
    } elseif(!$booking) {
      $this->logger->warning('Stripe webhook: booking not found', ['booking_id' => $bookingId]);
    }

    return new Response('OK', Response::HTTP_OK);
  }
}