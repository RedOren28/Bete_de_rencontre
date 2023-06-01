<?php

namespace App\Repository;

use App\Entity\Espece;
use App\Entity\Animal;
use App\Entity\Annonce;
use App\Data\SearchData;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Annonce>
 *
 * @method Annonce|null find($id, $lockMode = null, $lockVersion = null)
 * @method Annonce|null findOneBy(array $criteria, array $orderBy = null)
 * @method Annonce[]    findAll()
 * @method Annonce[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnnonceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Annonce::class);
    }

    public function save(Annonce $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Annonce $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    // Find/search annonces by title
    public function findByString(string $query)
    {
        $qb = $this->createQueryBuilder('p');
        $qb
            ->where(
                $qb->expr()->andX(
                    $qb->expr()->orX(
                        $qb->expr()->like('p.titre', ':query'),
                    ),
                    $qb->expr()->isNotNull('p.date_publication')
                )
            )
            ->setParameter('query', '%' . $query . '%')
        ;
        return $qb
            ->getQuery()
            ->getResult();
    }

     /**
     * On récupère les annonces en lien avec la recherche
     */
    public function findSearch(SearchData $search): array
    {
        $query = $this
            ->createQueryBuilder('a')
            ->select('a','animal','espece','poil','couleur','race','regime')
            ->join('a.animal', 'animal')
            ->join('animal.Espece', 'espece')
            ->join('espece.Race', 'race')
            ->join('animal.poil', 'poil')
            ->join('animal.Couleur', 'couleur')
            ->join('animal.Regime', 'regime')
        ;
    
        if (!empty($search->q)) {
            $query
                ->andWhere('a.titre LIKE :q')
                ->setParameter('q', "%{$search->q}%")
            ;
        }

        if (!empty($search->sexes && count($search->sexes) != 2)) {
            $query
                ->andWhere('animal.sexe = :sexes')
                ->setParameter('sexes', "{$search->sexes[0]}")
            ;
        }

        if (!empty($search->vaccins && count($search->vaccins) != 2)) {
            $query
                ->andWhere('animal.vaccin = :vaccins')
                ->setParameter('vaccins', "{$search->vaccins[0]}")
            ;
        }

        if (!empty($search->vermifugations && count($search->vermifugations) != 2)) {
            $query
                ->andWhere('animal.vermifugation = :vermifugations')
                ->setParameter('vermifugations', "{$search->vermifugations[0]}")
            ;
        }
    
        if (!empty($search->especes)) {
            $query
                ->andWhere('espece.id IN (:especes)')
                ->setParameter('especes', $search->especes)
            ;
        }

        if (!empty($search->poils)) {
            $query
                ->andWhere('poil.id IN (:poils)')
                ->setParameter('poils', $search->poils)
            ;
        }

        if (!empty($search->couleurs)) {
            $query
                ->andWhere('couleur.id IN (:couleurs)')
                ->setParameter('couleurs', $search->couleurs)
            ;
        }

        if (!empty($search->races)) {
            $query
                ->andWhere('race.id IN (:races)')
                ->setParameter('races', $search->races)
            ;
        }

        if (!empty($search->regimes)) {
            $query
                ->andWhere('regime.id IN (:regimes)')
                ->setParameter('regimes', $search->regimes)
            ;
        }
    
        return $query->getQuery()->getResult();
    }
    

//    /**
//     * @return Annonce[] Returns an array of Annonce objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Annonce
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
