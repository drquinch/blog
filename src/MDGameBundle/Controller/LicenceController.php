<?php

namespace MDGameBundle\Controller;

use MDGameBundle\Entity\Licence;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use MDGameBundle\Form\LicenceType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class LicenceController extends Controller
{

    public function batchAction($batch, $page)
    {
	$licences = $this->getDoctrine()->getManager()->getRepository('MDGameBundle:Licence')->findLimitedAll($batch, $page);

	return $this->render('MDGameBundle:Licence:batch.html.twig', array('licences' => $licences));
    }
	
	public function jsonAllAction()
	{
		$licences = $this->getDoctrine()->getManager()->getRepository('MDGameBundle:Licence')->findAll();
		$response = $this->get('templating')->renderResponse('MDGameBundle:Licence:jsonAll.json.twig', array('licences' => $licences));
		$response->headers->set('Content-Type', 'application/json');
		return $response;
	}

    /**
     * @ParamConverter("licence", options={"mapping": {"licence_id": "id"}})
     */
    public function viewAction(Licence $licence)
    {
        if ($licence === null)
        {
            throw new NotFoundHttpException('ID "'.$id.'" inexistant!');
        }

        return $this->render('MDGameBundle:Licence:view.html.twig', array('licence' => $licence));

    }

    /**
     * @Security("has_role('ROLE_WRITTER')")
     */
    public function createAction()
    {
        $request = $this->container->get('request_stack')->getMasterRequest();
        $licence = new Licence();
        $form = $this->get('form.factory')->create(LicenceType::class, $licence);

        if ($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($licence);
                $em->flush();

                return $this->render('MDGameBundle:Licence:create.html.twig', array('licence' => $licence));
            }
        }

        return $this->render('MDGameBundle:Licence:create.html.twig', array('form' => $form->createView()));

    }

    /**
     * @ParamConverter("licence", options={"mapping": {"licence_id": "id"}})
     * @Security("has_role('ROLE_WRITTER')")
     */
    public function editAction(Licence $licence)
    {
        $request = $this->container->get('request_stack')->getMasterRequest();
        $form = $this->get('form.factory')->create(LicenceType::class, $licence);

        if ($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->flush();
                return $this->render('MDGameBundle:Licence:edit.html.twig', array('licence' => $licence));
            }
        }
        if ($licence === null)
        {
            throw new NotFoundHttpException('ID "'.$id.'" inexistant!');
        }

        return $this->render('MDGameBundle:Licence:edit.html.twig', array('form' => $form->createView()));

    }

    /**
     * @ParamConverter("licence", options={"mapping": {"licence_id": "id"}})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction(Licence $licence)
    {
        $request = $this->container->get('request_stack')->getMasterRequest();
        $em = $this->getDoctrine()->getManager();
        
        if (null === $licence)
        {
            throw new NotFoundHttpException("ID ".$id." inexistant!");
        }

        $form = $this->get('form.factory')->create();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {
            $em->remove($licence);
            $em->flush();
            return $this->render('MDGameBundle:Licence:delete.html.twig');
        }

        return $this->render('MDGameBundle:Licence:delete.html.twig', array('licence' => $licence, 'form' => $form->createView()));

    }

}
