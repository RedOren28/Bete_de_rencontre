<?php

namespace App\Repository;

use App\Entity\Regime;
use App\Entity\Alimentation;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Alimentation>
 *
 * @method Alimentation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Alimentation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Alimentation[]    findAll()
 * @method Alimentation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AlimentationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Alimentation::class);
    }

    public function save(Alimentation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Alimentation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Alimentation[] Returns an array of Alimentation objects
     */
    public function findByRegime(Regime $regime): array
    {
        $qb = $this->createQueryBuilder('a');

        $qb->select('a')
            ->innerJoin('a.regimes', 'r')
            ->where('r = :regime')
            ->setParameter('regime', $regime)
            ->orderBy('a.nom', 'ASC');
        
        return $qb->getQuery()->getResult();
    }

//    /**
//     * @return Alimentation[] Returns an array of Alimentation objects
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

//    public function findOneBySomeField($value): ?Alimentation
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
