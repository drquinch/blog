<?php

namespace MDCommentBundle\Entity;

use Doctrine\ORM\EntityRepository;

class CommentRepository extends EntityRepository
{
	public function findByArticle($articleId)
	{
		$queryBuilder = $this->createQueryBuilder('c')
				->leftJoin('c.article', 'a')
				->where('a.id = :id')
				->setParameter('id' , $articleId);
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
