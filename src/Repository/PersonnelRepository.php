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

    public function listPersonnelOdered($ordered):array{
        if (!in_array($ordered, ['ASC', 'DESC'])) {
            $ordered = 'ASC';
        }
        $req= $this->createQueryBuilder('p')
                ->orderBy('p.nom',$ordered)
                ->addOrderBy('p.prenom','ASC')
                ->getQuery()
                ->getResult();
        return $req;
    }

    public function listPersonnelGroupedByBureau($orderBy):array{

        if (!in_array($orderBy, ['ASC', 'DESC'])) {
            $orderBy = 'ASC';
        }
        $req= $this->createQueryBuilder('p')
            ->innerJoin('p.bureau','b')
            ->addSelect('b')
            ->orderBy('b.num_bureau',$orderBy )
            ->addOrderBy('p.nom','ASC');
        $result = $req->getQuery()->getResult();
           $groupedByBureau = [];
           foreach($result as $personne){
               $bureau= $personne->getBureau()->getNumBureau();
               $groupedByBureau[$bureau][] = $personne;


           }
        return $groupedByBureau;

    }

    public function listPersonnelOrderedByDateEnd($orderBy): array{
        if (!in_array($orderBy, ['ASC', 'DESC'])) {
            $orderBy = 'ASC';
        }

        $req = $this->createQueryBuilder('p')
            ->join('p.statut', 's')
            ->addSelect('s')
            ->where('s.name NOT LIKE :statut')
            ->setParameter('statut', '%titulaire%')
            ->orderBy('p.dateEnd', $orderBy);

        $result = $req->getQuery()->getResult();
        return $result;

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
    public function findTotalPersonnelByBureau($id){
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT count(p.nom) as total FROM personnel p
            WHERE p.bureau_id = :id';

        $resultSet = $conn->executeQuery($sql, ['id' => $id]);

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }
}
