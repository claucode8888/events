<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\Ticket;
use App\Entity\Booking;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Ticket>
 */
class TicketRepository extends ServiceEntityRepository
{
  public function __construct(ManagerRegistry $registry)
  {
    parent::__construct($registry, Ticket::class);
  }

  /**
  * @return Ticket[] Returns an array of Ticket objects
  */
  public function findAllTickets(User $user, ?string $status = null): array
  {
    $query = $this->createQueryBuilder('t')
      ->join('t.booking', 'booking')
      ->andWhere('booking.buyer = :buyer')
      ->setParameter('buyer', $user)
      ->orderBy('booking.id', 'DESC');

    if($status){
      $query = $query->andWhere('booking.status = :status')
        ->setParameter('status', $status);
    }

    $query = $query->getQuery()->getResult();
    return $query;
  }

  public function getTicketsByCategory(Booking $booking)
  {
    $query = $this->createQueryBuilder('t')
      ->select(
        [
          'COUNT(t.id) AS category_total_tickets',
          'tc.id',
          'tc.name',
          'tc.price',
          '(tc.price * COUNT(t.id)) total_price',
          'e.name AS event_name'
        ]
      )
      ->join('t.booking', 'booking')
      ->join('t.category', 'tc')
      ->join('tc.event', 'e')
      ->andWhere('t.booking = :booking')
      ->setParameter('booking', $booking)
      ->groupBy('tc.id')
      ->getQuery()->getResult();

    $totalTickets = array_sum(array_column($query, 'category_total_tickets'));
    
    $results['tickets_by_category'] = array_column($query, null, 'id');
    $results['total_tickets'] = $totalTickets;
    return $results;
  }
}