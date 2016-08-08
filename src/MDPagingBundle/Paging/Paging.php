<?php

namespace MDPagingBundle\Paging;

use Doctrine\ORM\EntityManager;

class Paging
{
	private $em;

	public function __construct(EntityManager $em)
	{
		$this->em = $em;
	}

	public function paging($batch, $repName)
	{
		//on récupère le repository et calcul le nombre d'entrée
		$repository = $this->em->getRepository($repName);
		$total = $repository->getCount();

		//calcule de la pagination
		$paging = ceil($total/$batch);

		//on crée l'array de page
		//il suffira de passer l'array à la page et boucler dessus
		$pages = array();
		for($i = 0; $i < $paging; $i++)
		{
			array_push($pages, $i);
		}

		return $pages;
	}
}
