<?php

namespace App\Repository;

use App\Entity\Competences;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Competences>
 */
class CompetencesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Competences::class);
    }

    public function findByFilters(?int $level, ?int $heroId): array
{
    $qb = $this->createQueryBuilder('c');

    if ($level) {
        $qb->andWhere('c.lvl = :level')
            ->setParameter('level', $level);
    }

    if ($heroId) {
        $qb->join('c.mercenheros', 'h')
            ->andWhere('h.id = :heroId')
            ->setParameter('heroId', $heroId);
    }

    return $qb->getQuery()->getResult();
}


//    /**
//     * @return Competences[] Returns an array of Competences objects
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

//    public function findOneBySomeField($value): ?Competences
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
