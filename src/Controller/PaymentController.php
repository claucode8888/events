<?php

namespace App\Controller;

use App\Repository\BookingRepository;
use App\Repository\TicketRepository;
use App\Service\EmailService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/payment')]
final class PaymentController extends AbstractController
{
  #[Route('/process', name: 'app_payment_process', methods: ['POST'])]
  public function processPayment(
    Request $request,
    BookingRepository $bookingRepository,
    TicketRepository $ticketRepository,
    EmailService $emailService
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
    $paymentResult = true;

    if(!$paymentResult){
      return new JsonResponse([
        'message' => 'Payment could not be done.',
        'success' => false
      ]);
    }

    // Send email confirmation
    $queryResults = $ticketRepository->getTicketsByCategory($booking);
    $emailSent = $emailService->sendBookingConfirmation($booking, $queryResults['total_tickets'], $queryResults['tickets_by_category']);
    if($emailSent){
      $this->addFlash('success', 'Booking confirmed! We\'ve emailed your tickets.');
    }else{
      $this->addFlash('warning', 'Payment processed, but we couldn\'t send the confirmation email. Please check your booking in "My Tickets" or contact support.');
    }

    return new JsonResponse([
      'message' => 'Payment was successfuly.',
      'success' => true
    ]);
  }
}