<?php

namespace App\Controller;

use App\Repository\BookingRepository;
use App\Repository\TicketRepository;
use App\Service\EmailService;
use App\Service\StripePaymentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/payment')]
final class PaymentController extends AbstractController
{
  #[Route('/process', name: 'app_payment_process', methods: ['POST'])]
  public function process(
    Request $request,
    BookingRepository $bookingRepository,
    StripePaymentService $stripePaymentService,
  ) : JsonResponse
  {
    $sentData = json_decode($request->getContent(), true);

    $booking = $bookingRepository->find($sentData['booking_id']);

    if(!$booking){
      return new JsonResponse([
        'message' => 'Booking not found',
        'success' => false
      ], Response::HTTP_NOT_FOUND);
    }

    // Call to Payment Service
    $stripeSession = $stripePaymentService->createPaymentSession($booking);

    return new JsonResponse([
      'message' => 'Payment was successfuly.',
      'success' => true,
      'redirect' => $stripeSession->url
    ]);
  }

  #[Route('/success', name: 'app_payment_success')]
  public function success(
    Request $request,
    BookingRepository $bookingRepository,
    // TicketRepository $ticketRepository,
    // EmailService $emailService,
  ){
    $bookingId = $request->query->get('booking_id');
    $booking = $bookingRepository->find($bookingId);

    if(!$booking){
      throw $this->createNotFoundException('Booking not found.');
    }

    //Send email confirmation
    // $queryResults = $ticketRepository->getTicketsByCategory($booking);
    // $emailSent = $emailService->sendBookingConfirmation($booking, $queryResults['total_tickets'], $queryResults['tickets_by_category']);
    $emailSent = true;
    return $this->render('payment/success.html.twig', ['booking' => $booking, 'emailSent' => $emailSent]);
  }

  #[Route('/cancel', name: 'app_payment_cancel')]
  public function cancel(Request $request, BookingRepository $bookingRepository){
    $bookingId = $request->query->get('booking_id');
    $booking = $bookingRepository->find($bookingId);

    if(!$booking){
      throw $this->createNotFoundException('Booking not found.');
    }

    return $this->render('payment/cancel.html.twig', ['booking' => $booking]);
  }
}