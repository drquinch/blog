<?php

namespace MDCoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class DeveloperBundleController extends Controller
{
    public function viewBatchAction($batch, $page)
    {
        $listDeveloper = $this->container->get('md_game.batch')->batchDeveloper($batch, $page);
        $pages = $this->container->get('md_paging.paging')->paging($batch, "MDGameBundle:Developer");
        return $this->render('MDCoreBundle:DeveloperBundle:viewBatch.html.twig', array('listDeveloper' => $listDeveloper, 'pages' => $pages));
    }

    public function viewAction($id)
    {
        return $this->render('MDCoreBundle:DeveloperBundle:view.html.twig', array('id' => $id));
    }

    /**
     * @Security("has_role('ROLE_WRITTER')")
     */
    public function createAction()
    {
        return $this->render('MDCoreBundle:DeveloperBundle:create.html.twig');
    }

    /**
     * @Security("has_role('ROLE_WRITTER')")
     */
    public function editAction($id)
    {
       return $this->render('MDCoreBundle:DeveloperBundle:edit.html.twig', array('id' => $id));
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction($id)
    {
        return $this->render('MDCoreBundle:DeveloperBundle:delete.html.twig', array('id' => $id));
    }
}
