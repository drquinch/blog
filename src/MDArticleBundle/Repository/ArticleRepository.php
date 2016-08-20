<?php

namespace MDArticleBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ArticleRepository extends EntityRepository
{
    public function findLimitedAll($category, $batch, $page)
    {
        return $this->createQueryBuilder('x')
		     ->leftJoin('x.category', 'c')
		     ->where('c.id = :cId')
		     ->setParameter('cId', $category)
                     ->setFirstResult($page*$batch)
                     ->setMaxResults($batch)
                     ->getQuery()
                     ->getResult();
    }

    public function getCount()
    {
        return $this->createQueryBuilder('x')
                     ->select('COUNT(x)')
                     ->getQuery()
                     ->getSingleScalarResult();
    }
}
