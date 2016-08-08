<?php

namespace MDCommentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttKernel\Exception\NotFoundHttpException;
use MDCommentBundle\Entity\Comment;
use MDArticlesBundle\Entity\News;
use Doctrine\ORM\EntityRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class CommentController extends Controller
{
	private $repository;

	/**
	 * @Security("has_role('ROLE_USER')")
	 */
	public function addAction()
	{
		$news = new News();
		$news->setTitle('Comment taire des Terres');
		$news->setContent('News sur les Comment Taire des Terres!');
		$news->setAuthor('DocQuinch');
		$news->setDateCreation(new \Datetime());
		$news->setPublished(false);
		$comment = new Comment();
		$comment->setDate(new \Datetime());
		$comment->setContent('Comment taire un idiot :p!');
		$comment->setArticle($news);

		$em = $this->getDoctrine()->getManager();
		$em->persist($news);
		$em->persist($comment);
		$em->flush();

		return $this->render('MDCommentBundle:Comment:add.html.twig');
	}

	public function viewBatchAction($batch)
	{
		return $this->render('MDCommentBundle:Comment:batch.html.twig');
	}

	public function viewAction($id)
	{
		$comment = $this->findComment($id);

		if($comment === null)
		{
			throw new NotFoundHttpException('Comment '.$id.' not found!');
		}

		return $this->render('MDCommentBundle:Comment:view.html.twig');
	}

	/**
	 * @Security("has_role('ROLE_USER')")
	 */
	public function editAction($id)
	{
		$comment = $this->findComment($id);

		if ($comment === null)
		{
			throw new NotFoundHttException('Comment '.$id.' not found!');
		}

		return $this->render('MDCommentBundle:Comment:edit.html.twig');
	}

	/**
	 * @Security("has_role('ROLE_ADMIN')")
	 */
	public function deleteAction($id)
	{
		if ($id < 1)
		{
			throw new NotFoundHttpException('Comment '.$id.' not found!');
		}
		return $this->render('MDCommentBundle:Comment:delete.html.twig');
	}
	
	protected function findComment($id)
	{
		if ($this->repository === null)
		{
			$this->repository = $this->getDoctrine()->getManager()->getRepository('MDCommentBundle:Comment');
		}

		return $this->repository->find($id);

	}

}
