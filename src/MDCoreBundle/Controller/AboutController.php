<?php

namespace MDCoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AboutController extends Controller
{
	public function aboutAction()
	{
		return $this->render('MDCoreBundle:About:about.html.twig');
	}
}