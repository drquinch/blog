<?php

namespace MDMediaBundle\Controller;

use MDMediaBundle\Entity\Image;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use MDMediaBundle\Form\ImageType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class ImageController extends Controller
{

    public function batchAction($batch, $page)
    {
	$images = $this->getDoctrine()->getManager()->getRepository('MDMediaBundle:Image')->findLimitedAll($batch, $page);
	return $this->render('MDMediaBundle:Image:batch.html.twig', array('images' => $images));
    }

    /**
     * @ParamConverter("image", options={"mapping": {"image_id": "id"}})
     */
    public function viewAction(Image $image)
    {
        if ($image === null)
        {
            throw new NotFoundHttpException('ID "'.$id.'" inexistant!');
        }

        return $this->render('MDMediaBundle:Image:view.html.twig', array('image' => $image));

    }

    /**
     * @Security("has_role('ROLE_WRITTER')")
     */
    public function createAction()
    {
        $request = $this->container->get('request_stack')->getMasterRequest();
        $image = new Image();
        $form = $this->get('form.factory')->create(ImageType::class, $image);

        if ($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            if ($form->isValid())
            {
		$image->upload();
		
                $em = $this->getDoctrine()->getManager();
                $em->persist($image);
                $em->flush();

                return $this->render('MDMediaBundle:Image:create.html.twig', array('image' => $image));
            }
        }

        return $this->render('MDMediaBundle:Image:create.html.twig', array('form' => $form->createView()));

    }

    /**
     * @ParamConverter("image", options={"mapping": {"image_id": "id"}})
     * @Security("has_role('ROLE_WRITTER')")
     */
    public function editAction(Image $image)
    {
        $request = $this->container->get('request_stack')->getMasterRequest();
        $form = $this->get('form.factory')->create(ImageType::class, $image);

        if ($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->flush();
                return $this->render('MDMediaBundle:Image:edit.html.twig', array('image' => $image));
            }
        }
        if ($image === null)
        {
            throw new NotFoundHttpException('ID "'.$id.'" inexistant!');
        }

        return $this->render('MDMediaBundle:Image:edit.html.twig', array('form' => $form->createView()));

    }

    /**
     * @ParamConverter("image", options={"mapping": {"image_id": "id"}})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction(Image $image)
    {
        $request = $this->container->get('request_stack')->getMasterRequest();
        $em = $this->getDoctrine()->getManager();
        
        if (null === $image)
        {
            throw new NotFoundHttpException("ID ".$id." inexistant!");
        }

        $form = $this->get('form.factory')->create();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {
            $em->remove($image);
            $em->flush();
            return $this->render('MDMediaBundle:Image:delete.html.twig');
        }

        return $this->render('MDMediaBundle:Image:delete.html.twig', array('image' => $image, 'form' => $form->createView()));

    }

}
