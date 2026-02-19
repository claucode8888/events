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
    $availabilityTicketsByEvent = $eventRepository->getAvailabilityByEvent();
    $categorizedEvents = $eventRepository->getAllCategorized($now);

    return $this->render('event/index.html.twig', [
      'categorizedEvents' => $categorizedEvents,
      'availabilityTicketsByEvent' => $availabilityTicketsByEvent
    ]);
  }

  #[Route('/{id}', name: 'app_event_details', methods: ['GET'])]
  public function details(Event $event, EventRepository $eventRepository): Response
  {

    return $this->render('event/details.html.twig', [
      'event' => $event,
      'range_prices' => $eventRepository->getRangePrices($event)
    ]);
  }

  #[Route('/ticket-selection/{id}', name: 'app_event_ticket_selection', methods: ['GET'])]
  public function ticketSelection(Event $event): Response
  {
    return $this->render('event/ticket_selection.html.twig', [
      'event' => $event,
      'service_fee' => $this->getParameter('service_fee')
    ]);
  }
}