<?php

namespace MDGameBundle\Controller;

use MDGameBundle\Entity\Developer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use MDGameBundle\Form\DeveloperType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class DeveloperController extends Controller
{

    /**
     * @ParamConverter("developer", options={"mapping": {"developer_id": "id"}})
     */
    public function viewAction(Developer $developer)
    {
        if ($developer === null)
        {
            throw new NotFoundHttpException('ID "'.$id.'" inexistant!');
        }

        return $this->render('MDGameBundle:Developer:view.html.twig', array('developer' => $developer));

    }

    /**
     * @Security("has_role('ROLE_WRITTER')")
     */
    public function createAction()
    {
        $request = $this->container->get('request_stack')->getMasterRequest();
        $developer = new Developer();
        $form = $this->get('form.factory')->create(DeveloperType::class, $developer);

        if ($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($developer);
                $em->flush();

                return $this->render('MDGameBundle:Developer:create.html.twig', array('developer' => $developer));
            }
        }

        return $this->render('MDGameBundle:Developer:create.html.twig', array('form' => $form->createView()));

    }

    /**
     * @ParamConverter("developer", options={"mapping": {"developer_id": "id"}})
     * @Security("has_role('ROLE_WRITTER')")
     */
    public function editAction(Developer $developer)
    {
        $request = $this->container->get('request_stack')->getMasterRequest();
        $form = $this->get('form.factory')->create(DeveloperType::class, $developer);

        if ($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->flush();
                return $this->render('MDGameBundle:Developer:edit.html.twig', array('developer' => $developer));
            }
        }
        if ($developer === null)
        {
            throw new NotFoundHttpException('ID "'.$id.'" inexistant!');
        }

        return $this->render('MDGameBundle:Developer:edit.html.twig', array('form' => $form->createView()));

    }

    /**
     * @ParamConverter("developer", options={"mapping": {"developer_id": "id"}})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction(Developer $developer)
    {
        $request = $this->container->get('request_stack')->getMasterRequest();
        $em = $this->getDoctrine()->getManager();
        
        if (null === $developer)
        {
            throw new NotFoundHttpException("ID ".$id." inexistant!");
        }

        $form = $this->get('form.factory')->create();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {
            $em->remove($developer);
            $em->flush();
            return $this->render('MDGameBundle:Developer:delete.html.twig');
        }

        return $this->render('MDGameBundle:Developer:delete.html.twig', array('developer' => $developer, 'form' => $form->createView()));

    }

}
