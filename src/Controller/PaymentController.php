<?php

namespace App\Controller;

use App\Repository\BookingRepository;
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
  public function processPayment(Request $request, BookingRepository $bookingRepo, EmailService $emailService) : JsonResponse
  {
    $sentData = json_decode($request->getContent(), true);

    $booking = $bookingRepo->find($sentData['booking_id']);

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
    $emailService->sendBookingConfirmation($booking);
    
    return new JsonResponse([
      'message' => 'Payment was successfuly.',
      'success' => true
    ]);
  }
}