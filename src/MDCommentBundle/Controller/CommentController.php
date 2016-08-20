<?php

namespace MDCommentBundle\Controller;

use MDCommentBundle\Entity\Comment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use MDCommentBundle\Form\CommentType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class CommentController extends Controller
{

    public function batchAction($batch, $page)
    {
	$comments = $this->getDoctrine()->getManager()->getRepository('MDCommentBundle:Comment')->findLimitedAll($batch, $page);
	return $this->render('MDCommentBundle:Comment:batch.html.twig', array('comments' => $comments));
    }

    /**
     * @ParamConverter("comment", options={"mapping": {"comment_id": "id"}})
     */
    public function viewAction(Comment $comment)
    {
        if ($comment === null)
        {
            throw new NotFoundHttpException('ID "'.$id.'" inexistant!');
        }

        return $this->render('MDCommentBundle:Comment:view.html.twig', array('comment' => $comment));

    }

    /**
     * @Security("has_role('ROLE_WRITTER')")
     */
    public function createAction()
    {
        $request = $this->container->get('request_stack')->getMasterRequest();
        $comment = new Comment();
        $form = $this->get('form.factory')->create(CommentType::class, $comment);

        if ($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($comment);
                $em->flush();

                return $this->render('MDCommentBundle:Comment:create.html.twig', array('comment' => $comment));
            }
        }

        return $this->render('MDCommentBundle:Comment:create.html.twig', array('form' => $form->createView()));

    }

    /**
     * @ParamConverter("comment", options={"mapping": {"comment_id": "id"}})
     * @Security("has_role('ROLE_WRITTER')")
     */
    public function editAction(Comment $comment)
    {
        $request = $this->container->get('request_stack')->getMasterRequest();
        $form = $this->get('form.factory')->create(CommentType::class, $comment);

        if ($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->flush();
                return $this->render('MDCommentBundle:Comment:edit.html.twig', array('comment' => $comment));
            }
        }
        if ($comment === null)
        {
            throw new NotFoundHttpException('ID "'.$id.'" inexistant!');
        }

        return $this->render('MDCommentBundle:Comment:edit.html.twig', array('form' => $form->createView()));

    }

    /**
     * @ParamConverter("comment", options={"mapping": {"comment_id": "id"}})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction(Comment $comment)
    {
        $request = $this->container->get('request_stack')->getMasterRequest();
        $em = $this->getDoctrine()->getManager();
        
        if (null === $comment)
        {
            throw new NotFoundHttpException("ID ".$id." inexistant!");
        }

        $form = $this->get('form.factory')->create();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {
            $em->remove($comment);
            $em->flush();
            return $this->render('MDCommentBundle:Comment:delete.html.twig');
        }

        return $this->render('MDCommentBundle:Comment:delete.html.twig', array('comment' => $comment, 'form' => $form->createView()));

    }

}
