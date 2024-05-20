<?php

namespace App\Repository;

use App\Entity\Personnel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Personnel>
 */
class PersonnelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Personnel::class);
    }

    public  function  searchUser(String $search):array{
        $req= $this->createQueryBuilder('p');
           // ->innerJoin('p.bureau','b')
            //->innerJoin('p.statut','s')
           // ->addSelect('b','s');
            if($search != null && $search != ""){
                $req->where('p.nom LIKE :search OR p.prenom LIKE :search' );

                //$req ->andWhere('p.nom LIKE :search OR p.prenom LIKE :search OR b.num_bureau LIKE :search OR s.name LIKE :search' )
                $req ->setParameter('search',$search.'%');
                return $req->getQuery()->getResult();

            }
            return  [];

    }

    //    /**
    //     * @return Personnel[] Returns an array of Personnel objects
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

    //    public function findOneBySomeField($value): ?Personnel
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
