<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\Ticket;
use App\Service\QRService;
use App\Entity\TicketCategory;
use Doctrine\ORM\EntityManagerInterface;

class TicketManager
{
  public function __construct(private EntityManagerInterface $em, private QRService $QRService){}

  public function processTicketSelection(array $tickets, User $user): bool
  {
    $TCEntities = $this->em->getRepository(TicketCategory::class)->findBy(['id' => array_keys($tickets)]);
    if($TCEntities){
      foreach($TCEntities as $TCEntity){
        $ticketQuantity = $tickets[$TCEntity->getId()];
        for($i = 0; $ticketQuantity > $i; $i++){
          $this->createTicket($TCEntity, $user);
        }
      }
      $this->em->flush();
      return true;
    }
    return false;
  }

  public function createTicket(TicketCategory $TC, User $user){
    $ticket = new Ticket();
    $ticket->setCategory($TC);
    $ticket->setBuyer($user);
    $ticket->setQRCode($this->QRService->generateQRCode('--'));
    $ticket->setStatus(Ticket::PENDING_STATUS);
    $this->em->persist($ticket);
  }
}