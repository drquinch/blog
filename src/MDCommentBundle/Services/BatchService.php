<?php

namespace MDCommentBundle\Services;

use Doctrine\ORM\EntityManager;

class BatchService
{
	private $em;

	public function __construct(EntityManager $em)
	{
		$this->em = $em;
	}

	public function batchComment($articleId)
	{
		$commentRepository = $this->em->getRepository('MDCommentBundle:Comment');
		return $commentRepository->findByArticle($articleId);
	}

}
