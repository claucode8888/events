<?php

namespace App\Service;

use App\Entity\Booking;
use App\Entity\Ticket;
use App\Repository\TicketRepository;
use App\Service\EmailService;
use Psr\Log\LoggerInterface;
use Twig\Environment;

class BookingEmailService
{
  public function __construct(
    private LoggerInterface $logger,
    private EmailService $emailService,
    private TicketRepository $ticketRepository,
    private Environment $twig,
    private QRService $qrService,
    private PDFService $pdfService,
    private string $projectDir,
  ){}

  public function sendConfirmation(Booking $booking) : void
  {
    // Get Email content
    $html = $this->getMailHTML($booking);

    // Get attachments
    $attachments = $this->getTicketsPDF($booking);

    // Send Email
    $this->emailService->sendBookingConfirmation($booking, $html, $attachments);
  }

  public function getMailHTML(Booking $booking) : string
  {
    $queryResults = $this->ticketRepository->getTicketsByCategory($booking);
    $html = $this->twig->render(
      'email/booking_confirmation.html.twig',
      [
        'booking' => $booking,
        'total_tickets_booking' => $queryResults['total_tickets'],
        'tickets_by_category' => $queryResults['tickets_by_category'],
        ]
    );

    return $html;
  }

  public function getTicketsPDF(Booking $booking) : array
  {
    if(!$booking) return [];

    $pdfs = [];
    $tickets = $booking->getTickets();

    if($tickets)
    {
      foreach($tickets as $ticket)
      {
        $pdfs[] = $this->getTicketPDF($ticket);
      }
    }
    return $pdfs;
  }

  public function getTicketPDF(Ticket $ticket) : array
  {
    $pdfName = 'ticket_'.strtolower($ticket->getCategory()->getEvent()->getName()).'_'. $ticket->getId();
    
    // 1. Generate QR code
    $qrCode = $this->qrService->generateQRCode($ticket->getQrtoken());
    $qr = 'data:image/png;base64,' . base64_encode($qrCode);

    // 2. Generate logo
    $logoUrl = $this->projectDir. '/public/images/logo.jpg';
    $logoDataUri = 'data:image/jpeg;base64,' . base64_encode(file_get_contents($logoUrl));

    // 3. Render HTML
    $html = $this->twig->render('ticket/ticket_pdf.html.twig', [ 'ticket' => $ticket, 'qr' => $qr, 'logo' => $logoDataUri ]);

    if (empty($html)) {
      $this->logger->error('Ticket PDF not generated.', ['ticket_id' => $ticket->getId()]);
      return [];
    }

    // 4. Generate PDF
    $pdfContent = $this->pdfService->generatePDF($html);
    return [
      'content' => $pdfContent,
      'name' => $pdfName.'.pdf',
      'type' => 'application/pdf',
    ];
  }

}