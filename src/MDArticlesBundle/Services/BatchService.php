<?php

namespace MDArticlesBundle\Services;

use Doctrine\ORM\EntityManager;

class BatchService
{

	private $em;

	public function __construct(EntityManager $em)
	{
		$this->em = $em;
	}

	public function batchNews($batch, $page)
	{
		$newsRepository = $this->em->getRepository('MDArticlesBundle:News');
		return $newsRepository->findLimitedAll($batch, $page);
	}

}
