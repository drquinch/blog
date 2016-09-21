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
		$highlightedArticles = $repo->findHighlightedLimitedAll($batchHighlight);

		return $this->render('MDCoreBundle:Home:home.html.twig', array('articles' => $articles, 'highlightedArticles' => $highlightedArticles));
	}
	
}
