<?php

namespace App\Controller\Staff;

use App\Repository\TicketRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/staff/ticket')]
final class TicketController extends AbstractController
{
  #[Route('/scan', name: 'app_staff_ticket_scan')]
  public function scan(): Response
  {
    return $this->render('staff/ticket/scan.html.twig');
  }
  
  #[Route('/checkin/{qrCode}', name: 'app_staff_ticket_checkin', methods: ['POST'])]
  public function checkin(string $qrCode, TicketRepository $ticketRepository): JsonResponse
  {
      $ticket = $ticketRepository->findOneBy(['QRCode' => $qrCode]);
      
      if (!$ticket) {
          return new JsonResponse(['error' => 'Ticket not found'], 404);
      }
      
      // Mark as checked in
      // $ticket->setCheckedInAt(new \DateTimeImmutable());
      // $this->em->flush();
      
      return new JsonResponse([
          'success' => true,
          'event' => $ticket->getCategory()->getEvent()->getName()
      ]);
  }
}