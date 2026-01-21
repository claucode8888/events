<?php

namespace App\Controller;

use Exception;
use App\Entity\Ticket;
use App\Service\QRService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[Route('/tickets')]
final class TicketController extends AbstractController
{
  /** QR generator ondemand */
  #[Route('/qr/{qrtoken}', name: 'app_ticket_generate_qr')]
  public function generateQR(Ticket $ticket, QRService $QRService): Response
  {
    try {
      $route = $this->generateUrl('app_staff_ticket_checkin', [
        'qrtoken' => $ticket->getQrtoken(),
        ],
        UrlGeneratorInterface::ABSOLUTE_URL
      );

      // $qr = $QRService->generateQRCode('http://192.168.1.76:8000/staff/ticket/scan');
      $qr = $QRService->generateQRCode($route);
      return new Response(
        $qr,
        200,
        ['Content-Type' => 'image/png'],
      );

      } catch (Exception $e) {
      return new Response('QR Error: ' . $e->getMessage(), 500);
    }
  }
}