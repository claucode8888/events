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
    TicketRepository $ticketRepository,
    EmailService $emailService,
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

    // $paymentResult = true;

    // if(!$paymentResult){
    //   return new JsonResponse([
    //     'message' => 'Payment could not be done.',
    //     'success' => false
    //   ]);
    // }

    // Send email confirmation
    // $queryResults = $ticketRepository->getTicketsByCategory($booking);
    // $emailSent = $emailService->sendBookingConfirmation($booking, $queryResults['total_tickets'], $queryResults['tickets_by_category']);
    // if($emailSent){
    //   $this->addFlash('success', 'Booking confirmed! We\'ve emailed your tickets.');
    // }else{
    //   $this->addFlash('warning', 'Payment processed, but we couldn\'t send the confirmation email. Please check your booking in "My Tickets" or contact support.');
    // }

    return new JsonResponse([
      'message' => 'Payment was successfuly.',
      'success' => true,
      'redirect' => $stripeSession->url
    ]);
  }

  #[Route('/success', name: 'app_payment_success')]
  public function success(){
    return $this->render('');
  }

  #[Route('/cancel', name: 'app_payment_cancel')]
  public function cancel(){
    return $this->render('');
  }
}