<?php

namespace App\Repository;

use App\Entity\CoursCardsImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CoursCardsImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method CoursCardsImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method CoursCardsImage[]    findAll()
 * @method CoursCardsImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CoursCardsImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CoursCardsImage::class);
    }

    // /**
    //  * @return CoursCardsImage[] Returns an array of CoursCardsImage objects
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
    public function findOneBySomeField($value): ?CoursCardsImage
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
