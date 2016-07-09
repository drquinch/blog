<?php

namespace MDCategoryBundle\Services;

use Doctrine\ORM\EntityManager;

class BatchService
{
	private $em;

	public function __construct(EntityManager $em)
	{
		$this->em = $em;
	}

	public function batchAllCategory($batch, $page)
	{
		return $this->em
			->getRepository('MDCategoryBundle:Category')
			->findLimitedAll($batch, $page);
	}
}
