<?php

namespace MDGameBundle\Repository;

use Doctrine\ORM\EntityRepository;

class GameRepository extends EntityRepository
{

    public function findGameWithSubobject($id)
    {
	$query = $this->createQueryBuilder('g')
		->leftJoin('g.publishers', 'publ')
		->addSelect('publ')
		->leftJoin('g.developers', 'dev')
		->addSelect('dev')
		->leftJoin('g.licence', 'lic')
		->addSelect('lic')
		->leftJoin('g.plateformes', 'plat')
		->addSelect('plat')
		->leftJoin('g.genres', 'gen')
		->addSelect('gen')
		->leftJoin('g.themes', 'the')
		->addSelect('the')
		->where('g.id = :id')
		->setParameter('id', $id);

	return $query->getQuery()->getSingleResult();

    }

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
}
