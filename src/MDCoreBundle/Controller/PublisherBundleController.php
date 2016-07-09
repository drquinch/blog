<?php

namespace MDCoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class PublisherBundleController extends Controller
{
    public function viewBatchAction($batch, $page)
    {
        $listPublisher = $this->container->get('md_mdgame.batch')->batchPublisher($batch, $page);
        $pages = $this->container->get('md_paging.paging')->paging($batch, "MDGameBundle:Publisher");
        return $this->render('MDCoreBundle:PublisherBundle:viewBatch.html.twig', array('listPublisher' => $listPublisher, 'pages' => $pages));
    }

    public function viewAction($id)
    {
        return $this->render('MDCoreBundle:PublisherBundle:view.html.twig', array('id' => $id));
    }

    /**
     * @Security("has_role('ROLE_WRITTER')")
     */
    public function createAction()
    {
        return $this->render('MDCoreBundle:PublisherBundle:create.html.twig');
    }

    /**
     * @Security("has_role('ROLE_WRITTER')")
     */
    public function editAction($id)
    {
       return $this->render('MDCoreBundle:PublisherBundle:edit.html.twig', array('id' => $id));
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction($id)
    {
        return $this->render('MDCoreBundle:PublisherBundle:delete.html.twig', array('id' => $id));
    }
}
