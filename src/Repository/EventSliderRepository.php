<?php

namespace App\Repository;

use App\Entity\EventSlider;
use App\Entity\Handbook\City;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method EventSlider|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventSlider|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventSlider[]    findAll()
 * @method EventSlider[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventSliderRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, EventSlider::class);
    }

    /**
     * @param City $city
     * @return array|null
     */
    public function getActiveEventSlidesByCity(City $city): ?array
    {
        return $this->createQueryBuilder('es')
            ->where('es.isActive = true')
            ->leftJoin('es.event', 'event')
            ->andWhere('event.city = :city')
            ->setParameter('city', $city)
            ->orderBy('es.sort', 'ASC')
            ->orderBy('es.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return EventSlider[] Returns an array of EventSlider objects
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
    public function findOneBySomeField($value): ?EventSlider
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
