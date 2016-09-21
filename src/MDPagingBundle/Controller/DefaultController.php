<?php

namespace MDPagingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MDPagingBundle:Default:index.html.twig');
    }
}
