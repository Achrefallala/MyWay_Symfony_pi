<?php

namespace App\Repository;

use App\Entity\Trajet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Trajet>
 *
 * @method Trajet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Trajet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Trajet[]    findAll()
 * @method Trajet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrajetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trajet::class);
    }

    public function save(Trajet $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Trajet $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByDepartOrDestination($ville){
        return $this->createQueryBuilder('t')
                    ->where("t.depart LIKE :str")
                    ->orWhere("t.destination LIKE :str")
                    ->setParameter('str', '%'.$ville.'%')
                    ->getQuery()
                    ->getResult();

    }

    public function findByDepartAndDestination($depart, $destination){
        return $this->createQueryBuilder('t')
                    ->where("t.depart LIKE :depart")
                    ->andWhere("t.destination LIKE :destination")
                    ->setParameter('depart', $depart)
                    ->setParameter('destination', $destination)
                    ->getQuery()
                    ->getOneOrNullResult();

    }

    public function findDepartList(){
        return $this->getEntityManager()
                    ->createQuery("SELECT DISTINCT t.depart FROM APP\Entity\Trajet t")
                    ->getResult();

    }

    public function filter($depart, $destination,$minDistance, $maxDistance ,$minViews, $maxViews, $minDateCreation, $maxDateCreation)
    {
        $query = $this->createQueryBuilder('t');
        
        if ($depart) {
            $query->where("t.depart = :depart")
                ->setParameter('depart', $depart);
        }
        if ($destination) {
            $query->andwhere("t.destination = :destination")
                ->setParameter('destination', $destination);
        }

        $query->andwhere("t.distance BETWEEN :minDistance AND :maxDistance")
            ->setParameter('minDistance', $minDistance)
            ->setParameter('maxDistance', $maxDistance);

        $query->andwhere("t.views BETWEEN :minViews AND :maxViews")
            ->setParameter('minViews', $minViews)
            ->setParameter('maxViews', $maxViews);

        $query->andwhere("t.dateCreation BETWEEN :minDateCreation AND :maxDateCreation")
            ->setParameter('minDateCreation', $minDateCreation)
            ->setParameter('maxDateCreation', $maxDateCreation);


        return $query->getQuery()->getResult();

    }

    public function sort($trierPar, $type)
    {
        return $this->createQueryBuilder('t')
                      ->orderBy('t.'.$trierPar, $type)
                      ->getQuery()->getResult();
    }

//    /**
//     * @return Trajet[] Returns an array of Trajet objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Trajet
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
