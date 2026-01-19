<?php

namespace App\Controller;

use App\Entity\Event;
use App\Repository\EventRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/events')]
final class EventController extends AbstractController
{
  #[Route(name: 'app_event_index', methods: ['GET'])]
  public function index(EventRepository $eventRepository): Response
  {
    return $this->render('event/index.html.twig', [
      'events' => $eventRepository->findAll(),
    ]);
  }

  #[Route('/{id}', name: 'app_event_show', methods: ['GET'])]
  public function show(Event $event): Response
  {
    return $this->render('event/show.html.twig', [
      'event' => $event,
    ]);
  }

  #[Route('/{id}/ticket-selection', name: 'app_ticket_selection', methods: ['GET'])]
  public function buyTicket(Event $event): Response
  {
    return $this->render('event/ticket_selection.html.twig', [
      'event' => $event,
    ]);
  }

  #[Route('/{id}/purchase', name: 'app_event_purchase', methods: ['POST'])]
  public function purchase(Event $event): JsonResponse
  {
    return new JsonResponse(['message' => $event->getName()], 400);
  }
}