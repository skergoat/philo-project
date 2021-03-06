<?php

namespace App\Repository;

use App\Entity\Lesson;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Lesson|null find($id, $lockMode = null, $lockVersion = null)
 * @method Lesson|null findOneBy(array $criteria, array $orderBy = null)
 * @method Lesson[]    findAll()
 * @method Lesson[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LessonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Lesson::class);
    }

    // get sidebar results
    // public function getSidebar()
    // {
    //     return $this->createQueryBuilder('l')
    //         ->setMaxResults(5)
    //         ->getQuery()
    //         ->getResult()
    //     ;
    // }

    // /**
    //  * @return Lesson[] Returns an array of Lesson objects
    //  */
   
    // public function findByExampleField($value)
    // {
    //     return $this->createQueryBuilder('l')
    //         ->andWhere('l.exampleField = :val')
    //         ->setParameter('val', $value)
    //         ->orderBy('l.id', 'ASC')
    //         ->setMaxResults(10)
    //         ->getQuery()
    //         ->getResult()
    //     ;
    // }
 
    public function getLessonByCoursLength($id)
    {
        return $this->createQueryBuilder('l')
            ->select('count(l.order_id)')
            ->andWhere('l.Cours ='.$id)
            ->getQuery()
            ->getSingleScalarResult();
        ;
    }

}
