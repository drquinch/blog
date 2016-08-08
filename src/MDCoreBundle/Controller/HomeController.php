<?php

namespace MDCoreBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
	public function homeAction()
	{
		return $this->render('MDCoreBundle:Home:home.html.twig');
	}
	
}
