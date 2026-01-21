<?php

namespace App\Controller;

use Exception;
use App\Entity\Booking;
use App\Service\BookingManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/bookings')]
final class BookingController extends AbstractController
{
  #[Route('/', name: 'app_create_booking', methods: ['POST'])]
  public function create(Request $request, BookingManager $bookingManager): JsonResponse
  {
    $user = $this->getUser();
    $tickets = json_decode($request->getContent(), true)['tickets'];
    if(!$tickets){
      return new JsonResponse(
        ['error' => 'No tickets selected.'],
        Response::HTTP_BAD_REQUEST
      );
    }

    try {
      $booking = $bookingManager->createBooking($tickets, $user);
      if(!$booking){
        return new JsonResponse(['error' => 'Booking creation failed.'], Response::HTTP_CONFLICT);
      }

      return new JsonResponse([
        'success' => true,
        'booking_id' => $booking->getId(),
        'redirect' => $this->generateUrl('app_booking_detail', ['id' => $booking->getId()])
        ], 
        Response::HTTP_CREATED
      );
    } catch (Exception $e) {
      return new JsonResponse([
        'success' => false,
        'error' => $e->getMessage()
      ], Response::HTTP_CONFLICT);
    }
  }

  #[Route('/detail/{id}', name: 'app_booking_detail', methods: ['GET'])]
  public function detail(Booking $booking)
  {
    return $this->render('booking/detail.html.twig', [
      'booking' => $booking
    ]);
  }
}