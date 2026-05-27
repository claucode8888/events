<?php

namespace App\Service;

use App\Entity\Ticket;
use App\Service\PDFService;
use App\Service\QRService;
use Psr\Log\LoggerInterface;
use Twig\Environment;

class TicketPDFService
{
  public function __construct(
    private LoggerInterface $logger,
    private Environment $twig,
    private QRService $qrService,
    private PDFService $pdfService,
    private string $projectDir,
  ){}

  public function generatePDF(Ticket $ticket)
  {
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
    return $pdfContent;
  }
}