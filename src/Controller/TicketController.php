<?php

namespace App\Controller;

use Exception;
use App\Entity\Ticket;
use App\Service\QRService;
use App\Repository\TicketRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

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
      $route = 'http://192.168.1.142:8000/login';

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

  #[Route('/my', name: 'app_my_tickets', methods: ['GET'])]
  public function myTickets(TicketRepository $ticketRepository): Response
  {
    $user = $this->getUser();
    if(!$user){
      throw new AccessDeniedHttpException('You must be logged in to view your tickets.');
    }
    $userTickets = $ticketRepository->findAllTickets($user);
    return $this->render('ticket/my_tickets.html.twig', [
      'tickets' => $userTickets
    ]);
  }

  #[Route('/{id}', name: 'app_ticket_details', methods: ['GET'])]
  public function details(Ticket $ticket): Response
  {
    return $this->render('ticket/details.html.twig', [
      'ticket' => $ticket
    ]);
  }
}