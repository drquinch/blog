<?php

namespace MDArticlesBundle\Controller;

use MDArticlesBundle\Entity\News;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use MDArticlesBundle\Form\NewsType;
use MDArticlesBundle\Form\NewsEditType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class NewsController extends Controller
{

	/**
	 * @ParamConverter("news", options={"mapping": {"news_id": "id"}})
	 */
	public function viewAction(News $news)
	{
		$em = $this->getDoctrine()->getManager();
		//$news = $em->getRepository('MDArticlesBundle:News')->find($id);

		$listComments = $em->getRepository('MDCommentBundle:Comment')->findBy(array('article' => $news));

		if ($news === null)
		{
			throw new NotFoundHttpException('ID "'.$news->getId().'" inexistant.');
		}

		return $this->render('MDArticlesBundle:News:view.html.twig', array('news' => $news, 'listComments' => $listComments));

	}

	/**
	 * @Security("has_role('ROLE_WRITTER')")
	 */
	public function createAction()
	{
		$request = $this->container->get('request_stack')->getMasterRequest();
		$news = new News();
		$news->setAuthor($this->getUser());
		$form = $this->get('form.factory')->create(NewsType::class, $news);

		if($request->isMethod('POST'))
		{
			$form->handleRequest($request);
			if($form->isValid())
			{
				$em = $this->getDoctrine()->getManager();
				$em->persist($news);
				$em->flush();

				return $this->render('MDArticlesBundle:News:create.html.twig', array('news' => $news));
			}
		}
		return $this->render('MDArticlesBundle:News:create.html.twig', array('form' => $form->createView()));
	}
	
	/**
	 * @Security("has_role('ROLE_WRITTER')")
	 */
	public function editAction($id, Request $request)
	{
		$request = $this->container->get('request_stack')->getMasterRequest();
		$news = $this->getDoctrine()->getManager()->getRepository('MDArticlesBundle:News')->findOneById($id);
		$form = $this->get('form.factory')->create(NewsEditType::class, $news);
	
		if ($request->isMethod('POST'))
		{
			$form->handleRequest($request);
			if($form->isValid())
			{
				$em = $this->getDoctrine()->getManager();
				$em->persist($news);
				$em->flush();
				return $this->render('MDArticlesBundle:News:edit.html.twig', array('news' => $news));
			}
		}
		else if ($id < 1)
		{
			throw new NotFoundHttpException('id "'.$id.'" inexistant');
		}
		else
		{
			return $this->render('MDArticlesBundle:News:edit.html.twig', array('form' => $form->createView()));
		}
	}
	
	/**
	 * @Security("has_role('ROLE_ADMIN')")
	 */
	public function deleteAction($id)
	{
		$request = $this->container->get('request_stack')->getMasterRequest();
		$em = $this->getDoctrine()->getManager();
		$news = $em->getRepository('MDArticlesBundle:News')->find($id);
		if (null === $news)
		{
			throw new NotFoundHttpException("ID ".$id." inexistant!");
		}

		$form = $this->get('form.factory')->create();

		if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
		{
			$em->remove($news);
			$em->flush();
			return $this->render('MDArticlesBundle:News:delete.html.twig');
		}

		return $this->render('MDArticlesBundle:News:delete.html.twig', array('news' => $news, 'form' => $form->createView()));

	}
	
}
