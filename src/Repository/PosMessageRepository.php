<?php

namespace App\Repository;

use App\Entity\PosMessage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PosMessage>
 *
 * @method PosMessage|null find($id, $lockMode = null, $lockVersion = null)
 * @method PosMessage|null findOneBy(array $criteria, array $orderBy = null)
 * @method PosMessage[]    findAll()
 * @method PosMessage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PosMessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PosMessage::class);
    }

    //    /**
    //     * @return PosMessage[] Returns an array of PosMessage objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?PosMessage
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
