<?php

namespace App\Repository;

use DateTime;
use App\Entity\Event;
use DateTimeInterface;
use InvalidArgumentException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class EventRepository extends ServiceEntityRepository
{
  public function __construct(ManagerRegistry $registry)
  {
    parent::__construct($registry, Event::class);
  }

  public function findByDateRange(DateTimeInterface $date, ?string $range): array
  {
    $queryBuilder = $this->createQueryBuilder('e')
      ->andWhere('e.status = :status')
      ->setParameter('status', 'published')
      ->orderBy('e.startAt', 'ASC');
    
    switch ($range) {
      case 'today':
        $start = (clone $date)->setTime(0, 0, 0);
        $end = (clone $date)->setTime(23, 59, 59);
        break;
        
      case 'tomorrow':
        $start = (clone $date)->modify('+1 day')->setTime(0, 0, 0);
        $end = (clone $date)->modify('+1 day')->setTime(23, 59, 59);
        break;
        
      case 'today_tomorrow':
        $start = (clone $date)->setTime(0, 0, 0);
        $end = (clone $date)->modify('+1 day')->setTime(23, 59, 59);
        break;
        
      case 'this_weekend':
        $saturday = $this->getNextSaturday($date);
        $sunday = $this->getNextSunday($date);
        $start = $saturday->setTime(0, 0, 0);
        $end = $sunday->setTime(23, 59, 59);
        break;
        
      case 'next_week':
        $monday = $this->getNextMonday($date);
        $sunday = (clone $monday)->modify('+6 days');
        $start = $monday->setTime(0, 0, 0);
        $end = $sunday->setTime(23, 59, 59);
        break;
        
      case 'next_month':
        $firstDay = $this->getFirstDayOfNextMonth($date);
        $lastDay = $this->getLastDayOfNextMonth($date);
        $start = $firstDay->setTime(0, 0, 0);
        $end = $lastDay->setTime(23, 59, 59);
        break;
        
      case 'later':
        $start = $this->getLastDayOfNextMonth($date)->modify('+1 second');
        $end = null;
        break;
        
      default:
        throw new InvalidArgumentException("Invalid range: {$range}");
    }
    
    $queryBuilder->andWhere('e.startAt >= :start')
      ->setParameter('start', $start);
      
    if ($end !== null) {
      $queryBuilder->andWhere('e.startAt <= :end')
        ->setParameter('end', $end);
    }
    
    return $queryBuilder->getQuery()->getResult();
  }

  public function findAllCategorized(DateTimeInterface $now): array
  {
    return [
      'today_tomorrow' => $this->findByDateRange($now, 'today_tomorrow'),
      'weekend' => $this->findByDateRange($now, 'this_weekend'),
      'next_week' => $this->findByDateRange($now, 'next_week'),
      'next_month' => $this->findByDateRange($now, 'next_month'),
      'later' => $this->findByDateRange($now, 'later'),
    ];
  }

  public function getCategoryCounts(DateTimeInterface $now): array
  {
    $categories = $this->findAllCategorized($now);
    
    return [
      'total' => $this->createQueryBuilder('e')
        ->select('COUNT(e.id)')
        ->andWhere('e.status = :status')
        ->setParameter('status', 'published')
        ->getQuery()
        ->getSingleScalarResult(),
      'today_tomorrow' => count($categories['today_tomorrow']),
      'weekend' => count($categories['weekend']),
      'next_week' => count($categories['next_week']),
      'next_month' => count($categories['next_month']),
      'later' => count($categories['later']),
      'upcoming' => $this->createQueryBuilder('e')
        ->select('COUNT(e.id)')
        ->andWhere('e.startAt > :now')
        ->andWhere('e.status = :status')
        ->setParameter('status', 'published')
        ->setParameter('now', $now)
        ->getQuery()
        ->getSingleScalarResult(),
    ];
  }

  private function getNextSaturday(DateTimeInterface $date): DateTime
  {
    $saturday = clone $date;
    $currentDay = (int)$saturday->format('N');
    
    if ($currentDay === 6) {
      return $saturday;
    }
    
    if ($currentDay === 7) {
      return $saturday->modify('+6 days');
    }
    
    return $saturday->modify(sprintf('+%d days', 6 - $currentDay));
  }

  private function getNextSunday(DateTimeInterface $date): DateTime
  {
    $sunday = clone $date;
    $currentDay = (int)$sunday->format('N');
    
    if ($currentDay === 7) {
      return $sunday;
    }
    
    return $sunday->modify(sprintf('+%d days', 7 - $currentDay));
  }

  private function getNextMonday(DateTimeInterface $date): DateTime
  {
    $monday = clone $date;
    $currentDay = (int)$monday->format('N');
    
    if ($currentDay === 1) {
      return $monday->modify('+7 days');
    }
    
    return $monday->modify(sprintf('+%d days', 8 - $currentDay));
  }

  private function getFirstDayOfNextMonth(DateTimeInterface $date): DateTime
  {
    $firstDay = clone $date;
    return $firstDay->modify('first day of next month');
  }
  
  private function getLastDayOfNextMonth(DateTimeInterface $date): DateTime
  {
    $lastDay = clone $date;
    return $lastDay->modify('last day of next month');
  }

  public function findUpcoming(DateTimeInterface $from, ?int $limit): array
  {
    $qb = $this->createQueryBuilder('e')
      ->andWhere('e.startAt >= :from')
      ->andWhere('e.status = :status')
      ->setParameter('status', 'published')
      ->setParameter('from', $from)
      ->orderBy('e.startAt', 'ASC');
      
    if ($limit !== null) {
      $qb->setMaxResults($limit);
    }
      
    return $qb->getQuery()->getResult();
  }

  public function findTodayEvents(DateTimeInterface $date): array
  {
    return $this->findByDateRange($date, 'today');
  }
  
  public function findTomorrowEvents(DateTimeInterface $date): array
  {
    return $this->findByDateRange($date, 'tomorrow');
  }
}