<?php

namespace MDCategoryBundle\Entity;

use Doctrine\ORM\EntityRepository;

class CategoryRepository extends EntityRepository
{
	public function findLimitedAll($batch, $page)
	{
		$queryBuilder = $this->createQueryBuilder('c')
		->setFirstResult($page*$batch)
		->setMaxResults($batch);
		$query = $queryBuilder->getQuery();
		$result = $query->getResult();
		return $result;
	}

	public function getCount()
	{
		return $this->createQueryBuilder('c')
			->select('COUNT(c)')
			->getQuery()
			->getSingleScalarResult();
	}

}
