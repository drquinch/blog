<?php

namespace MDCoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class NewsBundleController extends Controller
{
	public function viewBatchAction($batch, $page)
	{
		$listNews = $this->container->get('md_articles.batch.news')
				->batchNews($batch, $page);
		$pages = $this->container->get('md_paging.paging')
				->paging($batch, "MDArticlesBundle:News");
		return $this->render('MDCoreBundle:NewsBundle:viewBatch.html.twig',
					 array('listNews' => $listNews, 'pages' => $pages));
	}
	
	public function viewAction($id)
	{
		return $this->render('MDCoreBundle:NewsBundle:view.html.twig', array('id' => $id));
	}

	/**
	 * @Security("has_role('ROLE_WRITTER')")
	 */
	public function createAction()
	{
		return $this->render('MDCoreBundle:NewsBundle:create.html.twig');
	}
	
	/**
	 * @Security("has_role('ROLE_WRITTER')")
	 */
	public function editAction($id)
	{
		return $this->render('MDCoreBundle:NewsBundle:edit.html.twig', array('id' => $id));
	}
	
	/**
	 * @Security("has_role('ROLE_ADMIN')")
	 */
	public function deleteAction($id)
	{
		return $this->render('MDCoreBundle:NewsBundle:delete.html.twig', array('id' => $id));
	}

	public function translationAction($name)
	{
		return $this->render('MDCoreBundle:NewsBundle:translation.html.twig', array('name' => $name  ));
	}
	
}
