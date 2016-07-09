<?php

namespace MDCoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CategoryBundleController extends Controller
{
	public function viewBatchAction($batch, $page)
	{
		$listCat = $this->container->get('md_category.batch.category')
				->batchAllCategory($batch, $page);
		$page = $this->container->get('md_paging.paging')
				->paging($batch, "MDCategoryBundle:Category");
		return $this->render('MDCoreBundle:CategoryBundle:viewBatch.html.twig',
					array('listCat' => $listCat, 'pages' => $page));
	}

	public function viewAction($id)
	{
		return $this->render('MDCoreBundle:CategoryBundle:view.html.twig', array('id' => $id));
	}

	public function createAction()
	{
		return $this->render('MDCoreBundle:CategoryBundle:create.html.twig');
	}

	public function editAction($id)
	{
		return $this->render('MDCoreBundle:CategoryBundle:edit.html.twig', array('id' => $id));
	}

	public function deleteAction($id)
	{
		return $this->render('MDCoreBundle:CategoryBundle:delete.html.twig', array('id' => $id));
	}

}
