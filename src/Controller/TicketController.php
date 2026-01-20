<?php

namespace App\Controller;

use App\Service\TicketManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/tickets')]
final class TicketController extends AbstractController
{
  #[Route('/purchase', name: 'app_ticket_purchase', methods: ['POST'])]
  public function purchase(Request $request, TicketManager $ticketManager): JsonResponse
  {
    $user = $this->getUser();
    $tickets = json_decode($request->getContent(), true)['tickets'];
    if(!$tickets){
      return new JsonResponse(
        ['message' => 'Any ticket was selected.'],
        Response::HTTP_BAD_REQUEST
      );
    }

    $processResult = $ticketManager->processTicketSelection($tickets, $user);
    if(!$processResult){
      return new JsonResponse(
        ['message' => 'Tickets could have not been created.'],
        Response::HTTP_CONFLICT
      );
    }

    return new JsonResponse(
      ['message' => 'Tickets created correctly.'],
      Response::HTTP_CREATED
    );
  }

  #[Route('/confirmation', name: 'app_ticket_confirmation', methods: ['GET'])]
  public function confirmation()
  {
    dd();
  }
}