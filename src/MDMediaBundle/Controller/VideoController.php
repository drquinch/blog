<?php

namespace MDMediaBundle\Controller;

use MDMediaBundle\Entity\Video;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use MDMediaBundle\Form\VideoType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class VideoController extends Controller
{

    public function batchAction($batch, $page)
    {
	$videos = $this->getDoctrine()->getManager()->getRepository('MDMediaBundle:Video')->findLimitedAll($batch, $page);
	return $this->render('MDMediaBundle:Video:batch.html.twig', array('videos' => $videos));
    }

    /**
     * @ParamConverter("video", options={"mapping": {"video_id": "id"}})
     */
    public function viewAction(Video $video)
    {
        if ($video === null)
        {
            throw new NotFoundHttpException('ID "'.$id.'" inexistant!');
        }

        return $this->render('MDMediaBundle:Video:view.html.twig', array('video' => $video));

    }

    /**
     * @Security("has_role('ROLE_WRITTER')")
     */
    public function createAction()
    {
        $request = $this->container->get('request_stack')->getMasterRequest();
        $video = new Video();
        $form = $this->get('form.factory')->create(VideoType::class, $video);

        if ($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($video);
                $em->flush();

                return $this->render('MDMediaBundle:Video:create.html.twig', array('video' => $video));
            }
        }

        return $this->render('MDMediaBundle:Video:create.html.twig', array('form' => $form->createView()));

    }

    /**
     * @ParamConverter("video", options={"mapping": {"video_id": "id"}})
     * @Security("has_role('ROLE_WRITTER')")
     */
    public function editAction(Video $video)
    {
        $request = $this->container->get('request_stack')->getMasterRequest();
        $form = $this->get('form.factory')->create(VideoType::class, $video);

        if ($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->flush();
                return $this->render('MDMediaBundle:Video:edit.html.twig', array('video' => $video));
            }
        }
        if ($video === null)
        {
            throw new NotFoundHttpException('ID "'.$id.'" inexistant!');
        }

        return $this->render('MDMediaBundle:Video:edit.html.twig', array('form' => $form->createView()));

    }

    /**
     * @ParamConverter("video", options={"mapping": {"video_id": "id"}})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction(Video $video)
    {
        $request = $this->container->get('request_stack')->getMasterRequest();
        $em = $this->getDoctrine()->getManager();
        
        if (null === $video)
        {
            throw new NotFoundHttpException("ID ".$id." inexistant!");
        }

        $form = $this->get('form.factory')->create();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {
            $em->remove($video);
            $em->flush();
            return $this->render('MDMediaBundle:Video:delete.html.twig');
        }

        return $this->render('MDMediaBundle:Video:delete.html.twig', array('video' => $video, 'form' => $form->createView()));

    }

}
