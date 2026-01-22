<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\Ticket;
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

    //    public function findOneBySomeField($value): ?Ticket
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
