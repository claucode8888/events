<?php

namespace App\Service;

use App\Entity\Booking;
use App\Entity\Ticket;
use App\Repository\TicketRepository;
use App\Service\EmailService;
use App\Service\TicketPDFService;
use Twig\Environment;

class BookingEmailService
{
  public function __construct(
    private EmailService $emailService,
    private TicketRepository $ticketRepository,
    private TicketPDFService $ticketPDFService,
    private Environment $twig
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
    $pdfName = $ticket->getPDFName();
    $pdf = $this->ticketPDFService->generatePDF($ticket);
    
    return [
      'content' => $pdf,
      'name' => $pdfName.'.pdf',
      'type' => 'application/pdf',
    ];
  }

}