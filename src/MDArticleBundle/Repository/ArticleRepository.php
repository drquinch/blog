<?php

namespace MDArticleBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ArticleRepository extends EntityRepository
{
	public function findLimitedAllNoJoin($batch)
	{
		return $this->createQueryBuilder('x')
					->setMaxResults($batch)
					->orderBy('x.dateLastUpdate', 'DESC')
					->getQuery()
					->getResult();
	}
	
    public function findLimitedAllByUser($batch, $page, $user)
    {
	    return $this->createQueryBuilder('x')
		    ->leftJoin('x.author', 'author')
		    ->addSelect('author')
		    ->leftJoin('x.coverimage', 'image')
	    	    ->addSelect('image')
		    ->leftJoin('x.tags', 'tags')
		    ->addSelect('tags')
		    ->leftJoin('x.category', 'category')
		    ->addSelect('category')
			->where('x.author = :author')
			->setParameter('author', $user)
                     ->setFirstResult($page*$batch)
		     ->setMaxResults($batch)
		     ->orderBy('x.datePublication', 'DESC')
                     ->getQuery()
                     ->getResult();
    }
	
    public function findLimitedAll($batch, $page)
    {
	    return $this->createQueryBuilder('x')
		    ->leftJoin('x.author', 'author')
		    ->addSelect('author')
		    ->leftJoin('x.coverimage', 'image')
	    	    ->addSelect('image')
		    ->leftJoin('x.tags', 'tags')
		    ->addSelect('tags')
		    ->leftJoin('x.category', 'category')
		    ->addSelect('category')
                     ->setFirstResult($page*$batch)
		     ->setMaxResults($batch)
		     ->orderBy('x.datePublication', 'DESC')
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

    public function getCountByCat($cat)
    {
		return $this->createQueryBuilder('x')
                     ->select('COUNT(x)')
					 ->where('x.category = :cat')
					 ->setParameter('cat', $cat)
					->getQuery()
                     ->getSingleScalarResult();
    }

    public function findHighlightedLimitedAll($batch)
    {
	return $this->createQueryBuilder('x')
		->leftJoin('x.coverimage', 'image')
		->addSelect('image')
		->leftJoin('x.category', 'category')
		->addSelect('category')
		->where('x.highlight = true')
		->setMaxResults($batch)
		->orderBy('x.datePublication', 'DESC')
		->getQuery()
		->getResult();
    }

    public function findPublishedLimitedAll($batch, $page)
    {
	    return $this->createQueryBuilder('x')
		    ->leftJoin('x.author', 'author')
		    ->addSelect('author')
		    ->leftJoin('x.coverimage', 'image')
	    	    ->addSelect('image')
		    ->leftJoin('x.tags', 'tags')
		    ->addSelect('tags')
		    ->leftJoin('x.category', 'category')
		    ->addSelect('category')
		    ->where('x.datePublication < :datePubl')
			->setParameter('datePubl', new \DateTime())
		->setFirstResult($page*$batch)
		->setMaxResults($batch)
		->orderBy('x.datePublication', 'DESC')
		->getQuery()
		->getResult();
    }

    public function findLimitedByCategory($batch, $page, $category)
    {
	return $this->createQueryBuilder('x')
		    ->leftJoin('x.author', 'author')
		    ->addSelect('author')
		    ->leftJoin('x.coverimage', 'image')
	    	    ->addSelect('image')
		    ->leftJoin('x.tags', 'tags')
		    ->addSelect('tags')
		    ->leftJoin('x.category', 'category')
		    ->addSelect('category')
		->where('x.category = :cat')
		->setParameter('cat', $category)
		->andWhere('x.datePublication < :datePubl')
		->setParameter('datePubl', new \DateTime())
		->setFirstResult($page*$batch)
		->setMaxResults($batch)
		->orderBy('x.datePublication', 'DESC')
		->getQuery()
		->getResult();
    }

    public function findLimitedAllByCategory($batch, $page, $category)
    {
	return $this->createQueryBuilder('x')
		    ->leftJoin('x.author', 'author')
		    ->addSelect('author')
		    ->leftJoin('x.coverimage', 'image')
	    	    ->addSelect('image')
		    ->leftJoin('x.tags', 'tags')
		    ->addSelect('tags')
		    ->leftJoin('x.category', 'category')
		    ->addSelect('category')
		->where('x.category = :cat')
		->setParameter('cat', $category)
		->setFirstResult($page*$batch)
		->setMaxResults($batch)
		->orderBy('x.datePublication', 'DESC')
		->getQuery()
		->getResult();
    }

}
