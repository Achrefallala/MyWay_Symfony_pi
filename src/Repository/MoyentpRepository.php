<?php

namespace App\Repository;

use App\Entity\Moyentp;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Moyentp>
 *
 * @method Moyentp|null find($id, $lockMode = null, $lockVersion = null)
 * @method Moyentp|null findOneBy(array $criteria, array $orderBy = null)
 * @method Moyentp[]    findAll()
 * @method Moyentp[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MoyentpRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Moyentp::class);
    }

    public function save(Moyentp $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Moyentp $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Moyentp[] Returns an array of Moyentp objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Moyentp
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

public function getNbBus() {
 
    return $this->createQueryBuilder('m')

    ->select('COUNT(m.id)')
    ->where('m.type = :type')
    ->setParameter('type', 'BUS')
    ->getQuery()
    ->getSingleScalarResult();

}

public function getNbMetro() {
 
    return $this->createQueryBuilder('d')

    ->select('COUNT(d.id)')
    ->where('d.type = :type')
    ->setParameter('type', 'METRO')
    ->getQuery()
    ->getSingleScalarResult();

}

public function getNbTrain() {
 
    return $this->createQueryBuilder('t')

    ->select('COUNT(t.id)')
    ->where('t.type = :type')
    ->setParameter('type', 'TRAIN')
    ->getQuery()
    ->getSingleScalarResult();

}


}
