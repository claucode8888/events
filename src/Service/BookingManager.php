<?php

namespace App\Service;

use Exception;
use App\Entity\User;
use App\Entity\Ticket;
use App\Entity\Booking;
use App\Entity\TicketCategory;
use App\Security\TokenGenerator;
use Doctrine\ORM\EntityManagerInterface;

class BookingManager
{
  public function __construct(private EntityManagerInterface $em, private TokenGenerator $tokenGenerator){}

  public function createBooking(array $datas, User $user): ? Booking
  {
    $serviceFee = $datas['service_fee'];
    $tickets = $datas['tickets'];

    /** Check if Ticket Categories were found */
    $TCEntities = $this->em->getRepository(TicketCategory::class)->findBy(['id' => array_keys($tickets)]);
    if(!$TCEntities) return null;

    $subtotal = 0;
    $booking = new Booking();
    $booking->setStatus(Booking::STATUS_PENDING);
    $booking->setBuyer($user);

    foreach($TCEntities as $TCEntity){
      $quantity = $tickets[$TCEntity->getId()];
      $subtotal += $TCEntity->getPrice() * $quantity;

      /** Check availability */
      if($TCEntity->ticketsAvailability() < $quantity){
        throw new Exception('Not enough tickets available for ' . $TCEntity->getName());
      }

      /** Tickets creation */
      for($i = 0; $quantity > $i; $i++){
        $ticket = $this->createTicket($TCEntity, $user, $booking);
        $booking->addTicket($ticket);
      }
    }
    
    $booking->setServiceFee($serviceFee);
    $booking->setSubtotal($subtotal);
    $this->em->persist($booking);
    $this->em->flush();
    return $booking;
  }

  public function createTicket(TicketCategory $TC, User $user, Booking $booking): Ticket
  {
    $qrToken = $this->tokenGenerator->generate();

    $ticket = new Ticket();
    $ticket->setCategory($TC);
    $ticket->setBuyer($user);
    $ticket->setQrtoken($qrToken);
    $ticket->setStatus(Ticket::PENDING_STATUS);
    $ticket->setBooking($booking);
    $this->em->persist($ticket);
    return $ticket;
  }
}