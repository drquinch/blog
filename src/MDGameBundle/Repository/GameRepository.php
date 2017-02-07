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
	
	public function findGamesByNameWithSubobject($names)
    {
		//TODO transformer pour $names et sortir array games
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
			->where('g.name = :name')
			->setParameter('name', $names[0]);
		$namesLen = count($names);
		for ($i = 1; $i < $namesLen; $i++)
		{
			$query = $query
			->orWhere('g.name = :name'.$i)
			->setParameter('name'.$i, $names[$i]);
		}
		return $query->getQuery()->getResult();
    }
	
	public function findGamesByLicences($licences)
    {
		//TODO transformer pour $names et sortir array games
		$query = $this->createQueryBuilder('g')
			->leftJoin('g.licence', 'lic')
			->addSelect('lic')
			->where('g.licence = :licence')
			->setParameter('licence', $licences[0]);
		$licLen = count($licences);
		for ($i = 1; $i < $licLen; $i++)
		{
			$query = $query
			->orWhere('g.licence = :licence'.$i)
			->setParameter('licence'.$i, $licences[$i]);
		}
		return $query->getQuery()->getResult();
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
