<?php

namespace MDArticleBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ArticleRepository extends EntityRepository
{
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
		    ->where('x.published = true')
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
		->where('category.name = :category')
		->setParameter('category', $category)
		->andWhere('x.published = true')
		->setFirstResult($page*$batch)
		->setMaxResults($batch)
		->orderBy('x.datePublication', 'DESC')
		->getQuery()
		->getResult();
    }

}
