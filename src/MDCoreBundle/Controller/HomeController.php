<?php

namespace MDCoreBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
	public function homeAction($batch, $page, $batchHighlight)
	{
		$repo = $this->getDoctrine()->getManager()->getRepository('MDArticleBundle:Article');
		$articles = $repo->findPublishedLimitedAll($batch, $page);
		//$highlightedArticles = $repo->findHighlightedLimitedAll($batchHighlight);
		$pages = $this->get('md_paging.paging')->paging($batch, 'MDArticleBundle:Article');

		return $this->render('MDCoreBundle:Home:home.html.twig', array('articles' => $articles, 'pages' => $pages));//, 'highlightedArticles' => $highlightedArticles));
	}
	
	public function pagingByCatAction($batch, $page, $category, $catParent, $repName)
	{
		$cat = null;
		$categoryParent = null;
		if ($catParent !== "null")
		{
			$categoryParent = $this->getDoctrine()->getManager()->getRepository('MDCategoryBundle:Category')->findOneByNameWithParentNull($catParent);
			$cat = $this->getDoctrine()->getManager()->getRepository('MDCategoryBundle:Category')->findOneByNameWithParent($category, $categoryParent);
		} else {
			$cat = $categoryParent = $this->getDoctrine()->getManager()->getRepository('MDCategoryBundle:Category')->findOneByNameWithParentNull($category);
		}
		
		$pages = $this->get('md_paging.paging')->pagingByCategory($batch, 'MDArticleBundle:Article', $cat);
		return $this->render('MDCoreBundle:Home:pagingByCat.html.twig', array('pages' => $pages, 'category' => $category, 'catParent' => $catParent));
	}
	
}
