<?php

namespace MDCategoryBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CategoryRepository extends EntityRepository
{
    public function findLimitedAll($batch, $page)
    {
        return $this->createQueryBuilder('x')
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
	
	public function getCategoryQueryBuilder()
	{
		return $this->createQueryBuilder('c')
					->where('c.parent IS NOT NULL');
	}
	
}
