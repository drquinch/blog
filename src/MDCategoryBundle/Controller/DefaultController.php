<?php

namespace MDCategoryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MDCategoryBundle:Default:index.html.twig');
    }
}
