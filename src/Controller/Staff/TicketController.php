<?php

namespace App\Controller\Staff;

use App\Entity\Ticket;
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
  
  #[Route('/checkin/{qrtoken}', name: 'app_staff_ticket_checkin', methods: ['GET','POST'])]
  public function checkin(Ticket $ticket): JsonResponse
  {
      return new JsonResponse([
          'success' => true,
          'event' => $ticket->getCategory()->getEvent()->getName()
      ]);
  }
}