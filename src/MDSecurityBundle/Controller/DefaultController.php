<?php

namespace MDSecurityBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MDSecurityBundle:Default:index.html.twig');
    }
}
