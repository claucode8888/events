<?php

namespace App\Controller;

use App\Entity\Event;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

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

  //_______________________________________________________________________
  #[Route('/buy-ticket/{id}', name: 'app_buy_ticket', methods: ['GET'])]
  public function buyTicket(Event $event): Response
  {
    return $this->render('event/buy_ticket.html.twig', [
      'event' => $event,
    ]);
  }
}