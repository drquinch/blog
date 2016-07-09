<?php

namespace MDCoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ContactController extends Controller
{
	public function contactAction()
	{
		return $this->render('MDCoreBundle:Contact:contact.html.twig');
	}
}
