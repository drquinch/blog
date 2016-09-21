<?php

namespace MDGameBundle\Controller;

use MDGameBundle\Entity\Publisher;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use MDGameBundle\Form\PublisherType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class PublisherController extends Controller
{

    public function batchAction($batch, $page)
    {
	$publishers = $this->getDoctrine()->getManager()->getRepository('MDGameBundle:Publisher')->findLimitedAll($batch, $page);

	return $this->render('MDGameBundle:Publisher:batch.html.twig', array('publishers' => $publishers));
    }

    /**
     * @ParamConverter("publisher", options={"mapping": {"publisher_id": "id"}})
     */
    public function viewAction(Publisher $publisher)
    {
        if ($publisher === null)
        {
            throw new NotFoundHttpException('ID "'.$id.'" inexistant!');
        }

        return $this->render('MDGameBundle:Publisher:view.html.twig', array('publisher' => $publisher));

    }

    /**
     * @Security("has_role('ROLE_WRITTER')")
     */
    public function createAction()
    {
        $request = $this->container->get('request_stack')->getMasterRequest();
        $publisher = new Publisher();
        $form = $this->get('form.factory')->create(PublisherType::class, $publisher);

        if ($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($publisher);
                $em->flush();

                return $this->render('MDGameBundle:Publisher:create.html.twig', array('publisher' => $publisher));
            }
        }

        return $this->render('MDGameBundle:Publisher:create.html.twig', array('form' => $form->createView()));

    }

    /**
     * @ParamConverter("publisher", options={"mapping": {"publisher_id": "id"}})
     * @Security("has_role('ROLE_WRITTER')")
     */
    public function editAction(Publisher $publisher)
    {
        $request = $this->container->get('request_stack')->getMasterRequest();
        $form = $this->get('form.factory')->create(PublisherType::class, $publisher);

        if ($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->flush();
                return $this->render('MDGameBundle:Publisher:edit.html.twig', array('publisher' => $publisher));
            }
        }
        if ($publisher === null)
        {
            throw new NotFoundHttpException('ID "'.$id.'" inexistant!');
        }

        return $this->render('MDGameBundle:Publisher:edit.html.twig', array('form' => $form->createView()));

    }

    /**
     * @ParamConverter("publisher", options={"mapping": {"publisher_id": "id"}})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction(Publisher $publisher)
    {
        $request = $this->container->get('request_stack')->getMasterRequest();
        $em = $this->getDoctrine()->getManager();
        
        if (null === $publisher)
        {
            throw new NotFoundHttpException("ID ".$id." inexistant!");
        }

        $form = $this->get('form.factory')->create();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {
            $em->remove($publisher);
            $em->flush();
            return $this->render('MDGameBundle:Publisher:delete.html.twig');
        }

        return $this->render('MDGameBundle:Publisher:delete.html.twig', array('publisher' => $publisher, 'form' => $form->createView()));

    }

}
