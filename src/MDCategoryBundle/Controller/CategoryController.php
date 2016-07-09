<?php

namespace MDCategoryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class CategoryController extends Controller
{

	public function viewAction($id)
	{
		$cat = $this->getDoctrine()
				->getManager()
				->getRepository('MDCategoryBundle:Category')
				->find($id);
		if ($cat === null)
		{
			throw new NotFoundHttpException('Category not found with ID: '.$id.' !');
		}

		return $this->render('MDCategoryBundle:Category:view.html.twig', array('category' => $cat));

	}

	/**
	 * 
	 */
	public function createAction()
	{

	}

	public function editAction($id)
	{
	
	}

	public function deleteAction($id)
	{

	}

}

