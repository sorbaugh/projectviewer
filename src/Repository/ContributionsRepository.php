<?php

namespace App\Repository;

use App\Entity\Contributions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Contributions>
 *
 * @method Contributions|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contributions|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contributions[]    findAll()
 * @method Contributions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContributionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contributions::class);
    }

//    /**
//     * @return Contributions[] Returns an array of Contributions objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Contributions
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
