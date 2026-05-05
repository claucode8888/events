<?php

namespace App\Controller;

use Exception;
use App\Entity\Booking;
use App\Service\BookingManager;
use App\Service\PDFService;
use App\Service\QRService;
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
    $datas = json_decode($request->getContent(), true);
    $tickets = $datas['tickets'];
    if(!$tickets){
      return new JsonResponse(
        ['error' => 'No tickets selected.'],
        Response::HTTP_BAD_REQUEST
      );
    }

    try {
      $booking = $bookingManager->createBooking($datas, $user);
      if(!$booking){
        return new JsonResponse(['error' => 'Booking creation failed.'], Response::HTTP_CONFLICT);
      }

      return new JsonResponse([
        'success' => true,
        'booking_id' => $booking->getId(),
        'redirect' => $this->generateUrl('app_booking_confirmation', ['id' => $booking->getId()])
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

  #[Route('/confirmation/{id}', name: 'app_booking_confirmation', methods: ['GET'])]
  public function confirmation(Booking $booking)
  {
    return $this->render('booking/confirmation.html.twig', ['booking' => $booking]);
  }

  #[Route('/pdf/{id}', name: 'app_booking_pdf', methods: ['GET'])]
  public function generatePDF(Booking $booking, PDFService $pdfService, QRService $QRService)
  {
    /** 1. Prepare QR codes for each ticket */
    $ticketsWithQr = [];
    foreach ($booking->getTickets() as $ticket) {
      /** Generate QR code */
      $qrCode = $QRService->generateQRCode($ticket->getQrtoken());
      $ticketsWithQr[] = [
        'ticket' => $ticket,
        'qrCode' => 'data:image/png;base64,' . base64_encode($qrCode)
      ];
    }

    /** 2. Getting HTML */
    $html = $this->renderView('booking/booking.pdf.html.twig', [ 'booking' => $booking, 'ticketsWithQr' => $ticketsWithQr ]);

    if(empty($html)){
      throw new Exception('Failed to generate PDF template');
    }

    /** 3. Gerating PDF */
    $pdf = $pdfService->generatePDF($html);

    /** 4. Return PDF as download */
    return new Response($pdf, 200, [
      'Content-Type' => 'application/pdf',
      'Content-Disposition' => 'attachment; filename="booking-' . $booking->getId() . '.pdf"'
    ]);
  }
}