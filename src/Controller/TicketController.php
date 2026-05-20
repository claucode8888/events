<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Repository\TicketRepository;
use App\Service\PDFService;
use App\Service\QRService;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[Route('/tickets')]
final class TicketController extends AbstractController
{
  /** QR generator on demand */
  #[Route('/qr/{qrtoken}', name: 'app_ticket_generate_qr')]
  public function generateQR(Ticket $ticket, QRService $QRService): Response
  {
    try {
      $route = $this->generateUrl('app_staff_ticket_checkin', [
        'qrtoken' => $ticket->getQrtoken(),
        ],
        UrlGeneratorInterface::ABSOLUTE_URL
      );

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
    // Validations
    if(!$user){
      throw new AccessDeniedHttpException('You must be logged in to view your tickets.');
    }

    // Type of search references array
    $past = 'past';
    $upcoming = 'upcoming';
    $searches = [
      $upcoming => [ 'title' => 'upcoming events', 'active' => false ],
      $past => [ 'title' => 'previous events', 'active' => false ],
    ];

    if(!array_key_exists($search, $searches)){
      throw $this->createNotFoundException('Invalid search type');
    }

    $searches[$search]['active'] = true;

    // Query on demand
    $tickets = match($search)
    {
      $upcoming => $ticketRepository->getUpcomingTicketsByUser($user),
      $past => $ticketRepository->getPastTicketsByUser($user),
    };

    return $this->render('ticket/my_tickets.html.twig', [
      'myTickets' => $tickets,
      'searches' => $searches,
      'currentSearch' => $search,
      'pastSearch' => $past
    ]);
  }

  #[Route('/{id}', name: 'app_ticket_details', methods: ['GET'])]
  public function details(Ticket $ticket): Response
  {
    return $this->render('ticket/details.html.twig', [
      'ticket' => $ticket
    ]);
  }

  #[Route('/pdf/{id}', name: 'app_ticket_pdf', methods: ['GET'])]
  public function generatePDF(
      Ticket $ticket,
      QRService $QRService,
      PDFService $pdfService,
      LoggerInterface $logger,
  ): Response
  {
    // 1a. Generate QR code
    $qrCode = $QRService->generateQRCode($ticket->getQrtoken());
    $qr = 'data:image/png;base64,' . base64_encode($qrCode);

    // 1b. Generate logo
    $logoUrl = $this->getParameter('kernel.project_dir') . '/public/images/logo.jpg';
    $logoDataUri = 'data:image/jpeg;base64,' . base64_encode(file_get_contents($logoUrl));

    // 2. Render HTML
    $html = $this->renderView('ticket/ticket_pdf.html.twig', [ 'ticket' => $ticket, 'qr' => $qr, 'logo' => $logoDataUri ]);

    if (empty($html)) {
      $logger->error('Ticket PDF not generated.', ['ticket_id' => $ticket->getId()]);
      throw new \Exception('Failed to generate PDF template');
    }

    // 3. Generate PDF
    $pdf = $pdfService->generatePDF($html);
    
    // 4. Return PDF as download
    return new Response($pdf, 200, [
      'Content-Type' => 'application/pdf',
      'Content-Disposition' => 'attachment; filename="ticket_' . $ticket->getId() . '.pdf"',
    ]);
  }
}