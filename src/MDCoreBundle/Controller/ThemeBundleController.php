<?php

namespace MDCoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class ThemeBundleController extends Controller
{
    public function viewBatchAction($batch, $page)
    {
        $listTheme = $this->container->get('md_mdgame.batch')->batchTheme($batch, $page);
        $pages = $this->container->get('md_paging.paging')->paging($batch, "MDGameBundle:Theme");
        return $this->render('MDCoreBundle:ThemeBundle:viewBatch.html.twig', array('listTheme' => $listTheme, 'pages' => $pages));
    }

    public function viewAction($id)
    {
        return $this->render('MDCoreBundle:ThemeBundle:view.html.twig', array('id' => $id));
    }

    /**
     * @Security("has_role('ROLE_WRITTER')")
     */
    public function createAction()
    {
        return $this->render('MDCoreBundle:ThemeBundle:create.html.twig');
    }

    /**
     * @Security("has_role('ROLE_WRITTER')")
     */
    public function editAction($id)
    {
       return $this->render('MDCoreBundle:ThemeBundle:edit.html.twig', array('id' => $id));
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction($id)
    {
        return $this->render('MDCoreBundle:ThemeBundle:delete.html.twig', array('id' => $id));
    }
}
