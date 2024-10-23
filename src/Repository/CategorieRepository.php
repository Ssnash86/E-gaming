<?php

namespace App\Repository;

use App\Entity\Categorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Categorie>
 */
class CategorieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categorie::class);
    }

    public function getCategorieJeux($id){

        $sql=$this->createQueryBuilder('u');

        if(empty($id)){
            $sql->where('u.categorie = :categorie')
            ->setParameter('categorie' , $id);
        }
            $categorie=$sql->getQuery();
            return $categorie->getResult();
    }
}
