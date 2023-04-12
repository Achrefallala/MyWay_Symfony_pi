<?php

namespace App\Repository;

use App\Entity\LigneTransport;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LigneTransport>
 *
 * @method LigneTransport|null find($id, $lockMode = null, $lockVersion = null)
 * @method LigneTransport|null findOneBy(array $criteria, array $orderBy = null)
 * @method LigneTransport[]    findAll()
 * @method LigneTransport[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LigneTransportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LigneTransport::class);
    }

    public function save(LigneTransport $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(LigneTransport $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByIdTrajet($id){
        $em = $this->getEntityManager();
        return $em->createQuery('SELECT l FROM APP\Entity\LigneTransport l JOIN l.trajet t WHERE t.id = :id')
                  ->setParameter('id', $id)
                  ->getResult();
    }

//    /**
//     * @return LigneTransport[] Returns an array of LigneTransport objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?LigneTransport
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
