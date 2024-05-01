<?php

namespace App\Repository;

use App\Entity\Projet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Projet>
 *
 * @method Projet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Projet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Projet[]    findAll()
 * @method Projet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Projet::class);
    }

//    /**
//     * @return Projet[] Returns an array of Projet objects
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

//    public function findOneBySomeField($value): ?Projet
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
public function getProjectCountByType(): array
{
    $queryBuilder = $this->createQueryBuilder('p')
        ->select('p.typeProjet, COUNT(p.idProjet) as projectCount')
        ->groupBy('p.typeProjet');

    return $queryBuilder->getQuery()->getResult();
}
//count invested project
public function getInvestedProjectCount(): int
{
    $queryBuilder = $this->createQueryBuilder('p')
        ->select('COUNT(p.idProjet)')
        ->innerJoin('p.investissements', 'i')
        ->groupBy('p.idProjet');

    return count($queryBuilder->getQuery()->getResult());
}
public function getTotalProjectsCount(): int
{
    return $this->createQueryBuilder('p')
        ->select('COUNT(p.idProjet)')
        ->getQuery()
        ->getSingleScalarResult();
}

public function getInvestedProjectsByType(): array
{
    $queryBuilder = $this->createQueryBuilder('p')
        ->select('p.typeProjet, COUNT(p.idProjet) as projectCount')
        ->innerJoin('p.investissements', 'i')
        ->groupBy('p.typeProjet');

    return $queryBuilder->getQuery()->getResult();
}
}  

