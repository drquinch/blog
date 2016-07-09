<?php

namespace MDGameBundle\Controller;

use MDGameBundle\Entity\Plateforme;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use MDGameBundle\Form\PlateformeType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class PlateformeController extends Controller
{

    /**
     * @ParamConverter("plateforme", options={"mapping": {"plateforme_id": "id"}})
     */
    public function viewAction(Plateforme $plateforme)
    {
        if ($plateforme === null)
        {
            throw new NotFoundHttpException('ID "'.$id.'" inexistant!');
        }

        return $this->render('MDGameBundle:Plateforme:view.html.twig', array('plateforme' => $plateforme));

    }

    /**
     * @Security("has_role('ROLE_WRITTER')")
     */
    public function createAction()
    {
        $request = $this->container->get('request_stack')->getMasterRequest();
        $plateforme = new Plateforme();
        $form = $this->get('form.factory')->create(PlateformeType::class, $plateforme);

        if ($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($plateforme);
                $em->flush();

                return $this->render('MDGameBundle:Plateforme:create.html.twig', array('plateforme' => $plateforme));
            }
        }

        return $this->render('MDGameBundle:Plateforme:create.html.twig', array('form' => $form->createView()));

    }

    /**
     * @ParamConverter("plateforme", options={"mapping": {"plateforme_id": "id"}})
     * @Security("has_role('ROLE_WRITTER')")
     */
    public function editAction(Plateforme $plateforme)
    {
        $request = $this->container->get('request_stack')->getMasterRequest();
        $form = $this->get('form.factory')->create(PlateformeType::class, $plateforme);

        if ($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->flush();
                return $this->render('MDGameBundle:Plateforme:edit.html.twig', array('plateforme' => $plateforme));
            }
        }
        if ($plateforme === null)
        {
            throw new NotFoundHttpException('ID "'.$id.'" inexistant!');
        }

        return $this->render('MDGameBundle:Plateforme:edit.html.twig', array('form' => $form->createView()));

    }

    /**
     * @ParamConverter("plateforme", options={"mapping": {"plateforme_id": "id"}})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction(Plateforme $plateforme)
    {
        $request = $this->container->get('request_stack')->getMasterRequest();
        $em = $this->getDoctrine()->getManager();
        
        if (null === $plateforme)
        {
            throw new NotFoundHttpException("ID ".$id." inexistant!");
        }

        $form = $this->get('form.factory')->create();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {
            $em->remove($plateforme);
            $em->flush();
            return $this->render('MDGameBundle:Plateforme:delete.html.twig');
        }

        return $this->render('MDGameBundle:Plateforme:delete.html.twig', array('plateforme' => $plateforme, 'form' => $form->createView()));

    }

}
