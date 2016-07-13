<?php

namespace MDCoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class MarketBundleController extends Controller
{
    public function viewBatchAction($batch, $page)
    {
        $listMarket = $this->container->get('md_game.batch')->batchMarket($batch, $page);
        $pages = $this->container->get('md_paging.paging')->paging($batch, "MDGameBundle:Market");
        return $this->render('MDCoreBundle:MarketBundle:viewBatch.html.twig', array('listMarket' => $listMarket, 'pages' => $pages));
    }

    public function viewAction($id)
    {
        return $this->render('MDCoreBundle:MarketBundle:view.html.twig', array('id' => $id));
    }

    /**
     * @Security("has_role('ROLE_WRITTER')")
     */
    public function createAction()
    {
        return $this->render('MDCoreBundle:MarketBundle:create.html.twig');
    }

    /**
     * @Security("has_role('ROLE_WRITTER')")
     */
    public function editAction($id)
    {
       return $this->render('MDCoreBundle:MarketBundle:edit.html.twig', array('id' => $id));
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction($id)
    {
        return $this->render('MDCoreBundle:MarketBundle:delete.html.twig', array('id' => $id));
    }
}
