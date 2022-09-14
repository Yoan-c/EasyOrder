<?php

namespace App\Repository;

use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Produit>
 *
 * @method Produit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produit[]    findAll()
 * @method Produit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produit::class);
    }

    public function add(Produit $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Produit $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    public function searchProduct(String $categorie, String $search): array
    {
        $rawSql = "SELECT DISTINCT p.label, p.prix, p.description, p.quantity, p.image, c.nom , p.id FROM `produit` p, produit_categorie pc, categorie c 
                        WHERE pc.produit_id = p.id 
                        AND pc.categorie_id = c.id 
                        AND c.nom LIKE :cat
                        AND (`description` LIKE :search 
                        OR `label` LIKE :search) 
                        GROUP BY
                        p.label";


        $stmt = $this->getEntityManager()->getConnection()->prepare($rawSql);

        $result = $stmt->executeQuery(['cat' => $categorie, "search" => $search]);
        return $result->fetchAllAssociative();
        /*       SELECT DISTINCT p.label, p.prix, p.description, p.quantity, p.image, c.nom , p.id
        FROM `produit` p, produit_categorie pc, categorie c 
        WHERE pc.produit_id = p.id 
        AND pc.categorie_id = c.id 
        AND c.nom LIKE "%T-shirt"
        AND (`description` LIKE "%gris%" 
        OR `label` LIKE "%gris%") 
        GROUP BY
        p.label
            */
    }

    //    /**
    //     * @return Produit[] Returns an array of Produit objects
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

    //    public function findOneBySomeField($value): ?Produit
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
