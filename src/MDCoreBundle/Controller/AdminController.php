<?php

namespace MDCoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{

	public function homeAction()
	{
		return $this->render('MDCoreBundle:Admin:home.html.twig');
	}

	public function listGameFunctionAction()
	{
		return $this->render('MDCoreBundle:Admin:gamefunctions.html.twig');
	}

	public function listNewsAction($batch, $page)
	{
		$news = $this->get("md_articles.batch.news")->batchNews($batch, $page);
		$paging = $this->get("md_paging.paging")->paging($batch, "MDArticlesBundle:News");
		return $this->render('MDCoreBundle:Admin:listnews.html.twig', array('news' => $news, 'paging' => $paging, 'batch' => $batch));
	}

	public function gameGamesAction($batch, $page)
	{
		$games = $this->get("md_game.batch")->batchGame($batch, $page);
		$paging = $this->get("md_paging.paging")->paging($batch, "MDGameBundle:Game");
		return $this->render('MDCoreBundle:Admin:games.html.twig', array('listobjects' => $games, 'paging' => $paging, 'batch' => $batch));
	}

	public function gameGenresAction($batch, $page)
	{
		$genres = $this->get("md_game.batch")->batchGenre($batch, $page);
		$paging = $this->get("md_paging.paging")->paging($batch, "MDGameBundle:Genre");
		return $this->render('MDCoreBundle:Admin:genres.html.twig', array('listobjects' => $genres, 'paging' => $paging, 'batch' => $batch));
	}

	public function gameThemesAction($batch, $page)
	{
		$themes = $this->get("md_game.batch")->batchTheme($batch, $page);
		$paging = $this->get("md_paging.paging")->paging($batch, "MDGameBundle:Theme");
		return $this->render('MDCoreBundle:Admin:themes.html.twig', array('listobjects' => $themes, 'paging' => $paging, 'batch' => $batch));
	}

	public function gameLicencesAction($batch, $page)
	{
		$licences = $this->get("md_game.batch")->batchLicence($batch, $page);
		$paging = $this->get("md_paging.paging")->paging($batch, "MDGameBundle:Licence");
		return $this->render('MDCoreBundle:Admin:licences.html.twig', array('listobjects' => $licences, 'paging' => $paging, 'batch' => $batch));
	}

	public function gameDevelopersAction($batch, $page)
	{
		$developers = $this->get("md_game.batch")->batchDeveloper($batch, $page);
		$paging = $this->get("md_paging.paging")->paging($batch, "MDGameBundle:Developer");
		return $this->render('MDCoreBundle:Admin:developers.html.twig', array('listobjects' => $developers, 'paging' => $paging, 'batch' => $batch));
	}

	public function gamePublishersAction($batch, $page)
	{
		$publishers = $this->get("md_game.batch")->batchPublisher($batch, $page);
		$paging = $this->get("md_paging.paging")->paging($batch, "MDGameBundle:Publisher");
		return $this->render('MDCoreBundle:Admin:publishers.html.twig', array('listobjects' => $publishers, 'paging' => $paging, 'batch' => $batch));
	}

	public function gameMarketsAction($batch, $page)
	{
		$markets = $this->get("md_game.batch")->batchMarket($batch, $page);
		$paging = $this->get("md_paging.paging")->paging($batch, "MDGameBundle:Market");
		return $this->render('MDCoreBundle:Admin:markets.html.twig', array('listobjects' => $markets, 'paging' => $paging, 'batch' => $batch));
	}

	public function gamePlateformesAction($batch, $page)
	{
		$plateformes = $this->get("md_game.batch")->batchPlateforme($batch, $page);
		$paging = $this->get("md_paging.paging")->paging($batch, "MDGameBundle:Plateforme");
		return $this->render('MDCoreBundle:Admin:plateformes.html.twig', array('listobjects' => $plateformes, 'paging' => $paging, 'batch' => $batch));
	}

}
