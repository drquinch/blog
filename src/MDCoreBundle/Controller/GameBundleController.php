<?php

namespace MDCoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class GameBundleController extends Controller
{
    public function viewBatchAction($batch, $page)
    {
        $listGame = $this->container->get('md_game.batch')->batchGame($batch, $page);
        $pages = $this->container->get('md_paging.paging')->paging($batch, "MDGameBundle:Game");
        return $this->render('MDCoreBundle:GameBundle:viewBatch.html.twig', array('listGame' => $listGame, 'pages' => $pages));
    }

    public function viewAction($id)
    {
        return $this->render('MDCoreBundle:GameBundle:view.html.twig', array('id' => $id));
    }

    /**
     * @Security("has_role('ROLE_WRITTER')")
     */
    public function createAction()
    {
        return $this->render('MDCoreBundle:GameBundle:create.html.twig');
    }

    /**
     * @Security("has_role('ROLE_WRITTER')")
     */
    public function editAction($id)
    {
       return $this->render('MDCoreBundle:GameBundle:edit.html.twig', array('id' => $id));
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction($id)
    {
        return $this->render('MDCoreBundle:GameBundle:delete.html.twig', array('id' => $id));
    }
}
