<?php

namespace App\Repository;

use App\Entity\Jeux;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @extends ServiceEntityRepository<Jeux>
 */
class JeuxRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
        private RequestStack $requestStack,
        private PaginatorInterface $paginator,
    ) {
        parent::__construct($registry, Jeux::class);
    }

    public function getJeuxPromo($value = null)
    {
        $sql = $this->createQueryBuilder('u');
        if (!empty($value)) {
            $sql->where('u.reduction >= :reduction')
                ->setParameter('reduction', $value);
        }
        $sql = $sql->getQuery();
        return $sql->getResult();
    }

    public function search(?string $search, ?int $id): Query
    {
        $done = $this->createQueryBuilder('a')
            ->orderBy('a.nom', 'asc');
            
        if (!empty($id)) {
            $done = $done
                ->join("a.categories", "c")
                ->andWhere('c.id = :q')
                ->setParameter("q", "$id");
        }
        if (!empty($search)) {
            $done = $done
                ->andWhere('a.nom LIKE :s')
                ->setParameter("s", "%{$search}%");
        }


        return $done->getQuery();
    }

    public function getPaginationSearch($search, $id)
    {
        $request = $this->requestStack->getMainRequest();
        $page = $request->query->getInt('page', 1);
        $limit = 20;
        $articleQuery = $this->search($search, $id);
        return $this->paginator->paginate($articleQuery, $page, $limit);
    }
}
