<?php

namespace App\Repository;

use App\Entity\Booking;
use App\Entity\Ticket;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

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
  public function getTicketsByUser(User $user, ?string $categoryTime = null): array
  {
    $now = new DateTime();

    // Main query
    $query = $this->createQueryBuilder('t')
      ->join('t.booking', 'booking')
      ->join('t.category', 'category')
      ->join('category.event', 'event')
      ->andWhere('booking.user = :user')
      ->setParameter('user', $user);

    // Get by category time
    if($categoryTime){
      $operator = $this->getOperator($categoryTime);
      $query = $query->andWhere('event.startAt '.$operator.' :now')
        ->setParameter('now', $now);
    }

    $query = $query->orderBy('event.startAt', 'ASC');
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

  public function getUpcomingTicketsByUser($user)
  {
    return $this->getTicketsByUser($user, 'upcoming');
  }

  public function getPastTicketsByUser($user)
  {
    return $this->getTicketsByUser($user, 'past');
  }

  // Helpers
  public function getOperator($categoryTime)
  {
    return match($categoryTime)
    {
      'upcoming' => '>=',
      'past' => '<',
      default => '>='
    };
  }
}