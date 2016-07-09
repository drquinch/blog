<?php

namespace MDCoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class Admin extends Controller
{

	public function homeAction()
	{
		return $this->render('MDCoreBundle:Admin:home.html.twig');
	}

}
