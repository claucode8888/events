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
      // $route = 'http://192.168.1.142:8000/login';
      $route = 'https://www.linkedin.com/in/claudio-gandolffi/';

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

  #[Route('/my-tickets/{search}', name: 'app_my_tickets', methods: ['GET'], defaults: ['search' => 'upcoming'])]
  public function myTickets(TicketRepository $ticketRepository, string $search): Response
  {
    $user = $this->getUser();

    // Type of search references array
    $searches = [
      'upcoming' => [ 'title' => 'upcoming events', 'active' => false ],
      'past' => [ 'title' => 'previous events', 'active' => false ],
    ];

    // Validations
    if(!$user){
      throw new AccessDeniedHttpException('You must be logged in to view your tickets.');
    }

    if(!array_key_exists($search, $searches)){
      throw $this->createNotFoundException('Invalid search type');
    }

    $searches[$search]['active'] = true;

    // Query on demand
    $tickets = match($search)
    {
      'upcoming' => $ticketRepository->getUpcomingTicketsByUser($user),
      'past' => $ticketRepository->getPastTicketsByUser($user),
    };

    return $this->render('ticket/my_tickets.html.twig', [
      'myTickets' => $tickets,
      'searches' => $searches,
      'currentSearch' => $search
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