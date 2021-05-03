<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function listBy($keyword = null, $order = 'asc', $limit = 10)
    {
        $queryBuilder = $this->createQueryBuilder('a');

        if( $keyword !== null){
            $queryBuilder->andWhere('a.title LIKE :val')
            ->setParameter('val', '%'.$keyword.'%');
        }

        $queryBuilder->orderBy('a.title', $order)
        ->setMaxResults($limit);

        return $queryBuilder->getQuery()->getResult();
    }
}
