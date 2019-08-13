<?php

namespace App\Repository\Handbook;

use App\Entity\Handbook\City;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method City|null find($id, $lockMode = null, $lockVersion = null)
 * @method City|null findOneBy(array $criteria, array $orderBy = null)
 * @method City[]    findAll()
 * @method City[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CityRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, City::class);
    }

    /**
     * @param string $city
     * @return City
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getCityByCookieOrDefault(string $city): City
    {
        return $this->createQueryBuilder('c')
            ->where('c.name = :city')
            ->orWhere('c.isDefault is true')
            ->setParameter('city', $city)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getCitiesListWithEvents(): ?array
    {
        $currentDate = new \DateTime('now');

        return $this->createQueryBuilder('c')
            ->join('\App\Entity\Event', 'e', 'WITH', 'c.id = e.city')
            ->andWhere('e.isActive = true')
            ->andWhere('e.startedAt >= :currentDate')
            ->andHaving('COUNT(e.id) > 0')
            ->setParameter('currentDate', $currentDate->format('Y-m-d'))
            ->addGroupBy('c.id')
            ->addOrderBy('c.isDefault', 'DESC')
            ->addOrderBy('c.isMain', 'DESC')
            ->addOrderBy('c.sort', 'ASC')
            ->addOrderBy('c.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return City[] Returns an array of City objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?City
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
