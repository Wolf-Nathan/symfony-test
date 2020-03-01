<?php

namespace App\Repository;

use App\Entity\LignePrescription;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method LignePrescription|null find($id, $lockMode = null, $lockVersion = null)
 * @method LignePrescription|null findOneBy(array $criteria, array $orderBy = null)
 * @method LignePrescription[]    findAll()
 * @method LignePrescription[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LignePrescriptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LignePrescription::class);
    }

    // /**
    //  * @return LignePrescription[] Returns an array of LignePrescription objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LignePrescription
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
