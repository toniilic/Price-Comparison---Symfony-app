<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function findAllWithLowestPrice()
    {
        return $this->createQueryBuilder('p')
            ->leftJoin('p.prices', 'pr')
            ->select('p', 'MIN(pr.price) as lowestPrice')
            ->groupBy('p.id')
            ->getQuery()
            ->getResult();
    }
}
