<?php

namespace MDArticlesBundle\Entity;

use Doctrine\ORM\EntityRepository;

class NewsRepository extends EntityRepository
{
	public function findLimitedAll($batch, $page)
	{
		$queryBuilder = $this->createQueryBuilder('n')
		  ->setFirstResult($page*$batch)
		  ->setMaxResults($batch);
		$query = $queryBuilder->getQuery();
		$result = $query->getResult();
		return $result;
	}

	public function getCount()
	{
		return $this->createQueryBuilder('n')
			->select('COUNT(n)')
			->getQuery()
			->getSingleScalarResult();
	}

}
