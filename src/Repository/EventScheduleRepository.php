<?php

namespace App\Repository;

use App\Entity\EventSchedule;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method EventSchedule|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventSchedule|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventSchedule[]    findAll()
 * @method EventSchedule[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventScheduleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, EventSchedule::class);
    }

    // /**
    //  * @return EventSchedule[] Returns an array of EventSchedule objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EventSchedule
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
