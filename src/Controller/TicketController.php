<?php

namespace App\Controller;

use Exception;
use App\Entity\Ticket;
use App\Service\QRService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/tickets')]
final class TicketController extends AbstractController
{
  #[Route('/qr/{QRCode}', name: 'app_ticket_qr')]
  public function QRCode(Ticket $ticket, QRService $QRService): Response
  {
    try {
      $qr = $QRService->generateQRCode('http://192.168.1.76:8000/staff/ticket/scan');
      // $png = $qrService->generateQRCode($ticket->getQRCode());
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