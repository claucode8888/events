<?php

namespace App\Controller;

use DateTime;
use App\Entity\Event;
use App\Repository\EventRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/events')]
final class EventController extends AbstractController
{
  #[Route('/', name: 'app_event_index', methods: ['GET'])]
  public function index(EventRepository $eventRepository): Response
  {
    $now = new DateTime();
    
    $categorizedEvents = $eventRepository->findAllCategorized($now);
    $counts = $eventRepository->getCategoryCounts($now);
    
    return $this->render('event/index.html.twig', [
      'categorizedEvents' => $categorizedEvents,
      'counts' => $counts,
      'now' => $now,
    ]);
  }

  #[Route('/{id}', name: 'app_event_show', methods: ['GET'])]
  public function show(Event $event): Response
  {
    return $this->render('event/show.html.twig', [
      'event' => $event,
    ]);
  }

  #[Route('/{id}/ticket-selection', name: 'app_event_ticket_selection', methods: ['GET'])]
  public function ticketSelection(Event $event): Response
  {
    return $this->render('event/ticket_selection.html.twig', [
      'event' => $event,
    ]);
  }
}