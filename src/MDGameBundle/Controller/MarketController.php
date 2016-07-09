<?php

namespace MDGameBundle\Controller;

use MDGameBundle\Entity\Market;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use MDGameBundle\Form\MarketType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class MarketController extends Controller
{

    /**
     * @ParamConverter("market", options={"mapping": {"market_id": "id"}})
     */
    public function viewAction(Market $market)
    {
        if ($market === null)
        {
            throw new NotFoundHttpException('ID "'.$id.'" inexistant!');
        }

        return $this->render('MDGameBundle:Market:view.html.twig', array('market' => $market));

    }

    /**
     * @Security("has_role('ROLE_WRITTER')")
     */
    public function createAction()
    {
        $request = $this->container->get('request_stack')->getMasterRequest();
        $market = new Market();
        $form = $this->get('form.factory')->create(MarketType::class, $market);

        if ($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($market);
                $em->flush();

                return $this->render('MDGameBundle:Market:create.html.twig', array('market' => $market));
            }
        }

        return $this->render('MDGameBundle:Market:create.html.twig', array('form' => $form->createView()));

    }

    /**
     * @ParamConverter("market", options={"mapping": {"market_id": "id"}})
     * @Security("has_role('ROLE_WRITTER')")
     */
    public function editAction(Market $market)
    {
        $request = $this->container->get('request_stack')->getMasterRequest();
        $form = $this->get('form.factory')->create(MarketType::class, $market);

        if ($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->flush();
                return $this->render('MDGameBundle:Market:edit.html.twig', array('market' => $market));
            }
        }
        if ($market === null)
        {
            throw new NotFoundHttpException('ID "'.$id.'" inexistant!');
        }

        return $this->render('MDGameBundle:Market:edit.html.twig', array('form' => $form->createView()));

    }

    /**
     * @ParamConverter("market", options={"mapping": {"market_id": "id"}})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction(Market $market)
    {
        $request = $this->container->get('request_stack')->getMasterRequest();
        $em = $this->getDoctrine()->getManager();
        
        if (null === $market)
        {
            throw new NotFoundHttpException("ID ".$id." inexistant!");
        }

        $form = $this->get('form.factory')->create();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {
            $em->remove($market);
            $em->flush();
            return $this->render('MDGameBundle:Market:delete.html.twig');
        }

        return $this->render('MDGameBundle:Market:delete.html.twig', array('market' => $market, 'form' => $form->createView()));

    }

}
