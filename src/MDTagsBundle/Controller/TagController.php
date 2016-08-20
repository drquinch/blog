<?php

namespace MDTagsBundle\Controller;

use MDTagsBundle\Entity\Tag;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use MDTagsBundle\Form\TagType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class TagController extends Controller
{

    public function batchAction($batch, $page)
    {
	$tags = $this->getDoctrine()->getManager()->getRepository('MDTagsBundle:Tag')->findLimitedAll($batch, $page);
	return $this->render('MDTagsBundle:Tag:batch.html.twig', array('tags' => $tags));
    }

    /**
     * @ParamConverter("tag", options={"mapping": {"tag_id": "id"}})
     */
    public function viewAction(Tag $tag)
    {
        if ($tag === null)
        {
            throw new NotFoundHttpException('ID "'.$id.'" inexistant!');
        }

        return $this->render('MDTagsBundle:Tag:view.html.twig', array('tag' => $tag));

    }

    /**
     * @Security("has_role('ROLE_WRITTER')")
     */
    public function createAction()
    {
        $request = $this->container->get('request_stack')->getMasterRequest();
        $tag = new Tag();
        $form = $this->get('form.factory')->create(TagType::class, $tag);

        if ($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($tag);
                $em->flush();

                return $this->render('MDTagsBundle:Tag:create.html.twig', array('tag' => $tag));
            }
        }

        return $this->render('MDTagsBundle:Tag:create.html.twig', array('form' => $form->createView()));

    }

    /**
     * @ParamConverter("tag", options={"mapping": {"tag_id": "id"}})
     * @Security("has_role('ROLE_WRITTER')")
     */
    public function editAction(Tag $tag)
    {
        $request = $this->container->get('request_stack')->getMasterRequest();
        $form = $this->get('form.factory')->create(TagType::class, $tag);

        if ($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->flush();
                return $this->render('MDTagsBundle:Tag:edit.html.twig', array('tag' => $tag));
            }
        }
        if ($tag === null)
        {
            throw new NotFoundHttpException('ID "'.$id.'" inexistant!');
        }

        return $this->render('MDTagsBundle:Tag:edit.html.twig', array('form' => $form->createView()));

    }

    /**
     * @ParamConverter("tag", options={"mapping": {"tag_id": "id"}})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction(Tag $tag)
    {
        $request = $this->container->get('request_stack')->getMasterRequest();
        $em = $this->getDoctrine()->getManager();
        
        if (null === $tag)
        {
            throw new NotFoundHttpException("ID ".$id." inexistant!");
        }

        $form = $this->get('form.factory')->create();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {
            $em->remove($tag);
            $em->flush();
            return $this->render('MDTagsBundle:Tag:delete.html.twig');
        }

        return $this->render('MDTagsBundle:Tag:delete.html.twig', array('tag' => $tag, 'form' => $form->createView()));

    }

}
