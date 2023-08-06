<?php

namespace App\Repository;

use App\Entity\Blocker;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Blocker>
 *
 * @method Blocker|null find($id, $lockMode = null, $lockVersion = null)
 * @method Blocker|null findOneBy(array $criteria, array $orderBy = null)
 * @method Blocker[]    findAll()
 * @method Blocker[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BlockerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Blocker::class);
    }

//    /**
//     * @return Blocker[] Returns an array of Blocker objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Blocker
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
