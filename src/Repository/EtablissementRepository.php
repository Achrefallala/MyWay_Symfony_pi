<?php

namespace App\Repository;

use App\Entity\Etablissement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Etablissement>
 *
 * @method Etablissement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Etablissement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Etablissement[]    findAll()
 * @method Etablissement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EtablissementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Etablissement::class);
    }

    public function save(Etablissement $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Etablissement $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByAnyField($input)
    {
        if($input == ''){
            return $this->findAll();
        }
        return $this->getEntityManager()
            ->createQuery("SELECT e FROM APP\Entity\Etablissement e WHERE e.nom LIKE :str ")
            ->setParameter('str', '%' . $input . '%')
            ->getResult();

    }

    public function filter($type, $adresse, $depart, $destination, $minViews, $maxViews, $minDateCreation, $maxDateCreation)
    {
        $query = $this->createQueryBuilder('e')
            ->join('e.trajet', 't')
            ->addSelect('t');
            
        if ($type) {
            $query->where('e.type = :type')
                ->setParameter('type', $type);
        }
        if ($adresse) {
            $query->andWhere("e.adresse LIKE :adresse")
                ->setParameter('adresse', '%' . $adresse . '%');
        }
        if ($depart) {
            $query->andwhere("t.depart = :depart")
                ->setParameter('depart', $depart);
        }
        if ($destination) {
            $query->andwhere("t.destination = :destination")
                ->setParameter('destination', $destination);
        }

        $query->andwhere("e.views BETWEEN :minViews AND :maxViews")
            ->setParameter('minViews', $minViews)
            ->setParameter('maxViews', $maxViews);

        $query->andwhere("e.dateCreation BETWEEN :minDateCreation AND :maxDateCreation")
            ->setParameter('minDateCreation', $minDateCreation)
            ->setParameter('maxDateCreation', $maxDateCreation);


        return $query->getQuery()->getResult();

    }




//    /**
//     * @return Etablissement[] Returns an array of Etablissement objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Etablissement
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}