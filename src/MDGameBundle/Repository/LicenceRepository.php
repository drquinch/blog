<?php

namespace MDGameBundle\Repository;

use Doctrine\ORM\EntityRepository;

class LicenceRepository extends EntityRepository
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
	
	 public function findLicencesByName($names)
    {
		//TODO transformer pour $names et sortir array games
		$query = $this->createQueryBuilder('l')
			->leftJoin('l.publishers', 'publ')
			->addSelect('publ')
			->leftJoin('l.developers', 'dev')
			->addSelect('dev')
			->leftJoin('l.plateformes', 'plat')
			->addSelect('plat')
			->leftJoin('l.genres', 'gen')
			->addSelect('gen')
			->leftJoin('l.themes', 'the')
			->addSelect('the')
			->where('l.name = :name')
			->setParameter('name', $names[0]);
		$namesLen = count($names);
		for ($i = 1; $i < $namesLen; $i++)
		{
			$query = $query
			->orWhere('l.name = :name'.$i)
			->setParameter('name'.$i, $names[$i]);
		}
		return $query->getQuery()->getResult();
    }
}
