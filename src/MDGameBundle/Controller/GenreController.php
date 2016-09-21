<?php

namespace MDGameBundle\Controller;

use MDGameBundle\Entity\Genre;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use MDGameBundle\Form\GenreType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class GenreController extends Controller
{

    public function batchAction($batch, $page)
    {
	$genres = $this->getDoctrine()->getManager()->getRepository('MDGameBundle:Genre')->findLimitedAll($batch, $page);

	return $this->render('MDGameBundle:Genre:batch.html.twig', array('genres' => $genres));
    }

    /**
     * @ParamConverter("genre", options={"mapping": {"genre_id": "id"}})
     */
    public function viewAction(Genre $genre)
    {
        if ($genre === null)
        {
            throw new NotFoundHttpException('ID "'.$id.'" inexistant!');
        }

        return $this->render('MDGameBundle:Genre:view.html.twig', array('genre' => $genre));

    }

    /**
     * @Security("has_role('ROLE_WRITTER')")
     */
    public function createAction()
    {
        $request = $this->container->get('request_stack')->getMasterRequest();
        $genre = new Genre();
        $form = $this->get('form.factory')->create(GenreType::class, $genre);

        if ($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($genre);
                $em->flush();

                return $this->render('MDGameBundle:Genre:create.html.twig', array('genre' => $genre));
            }
        }

        return $this->render('MDGameBundle:Genre:create.html.twig', array('form' => $form->createView()));

    }

    /**
     * @ParamConverter("genre", options={"mapping": {"genre_id": "id"}})
     * @Security("has_role('ROLE_WRITTER')")
     */
    public function editAction(Genre $genre)
    {
        $request = $this->container->get('request_stack')->getMasterRequest();
        $form = $this->get('form.factory')->create(GenreType::class, $genre);

        if ($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->flush();
                return $this->render('MDGameBundle:Genre:edit.html.twig', array('genre' => $genre));
            }
        }
        if ($genre === null)
        {
            throw new NotFoundHttpException('ID "'.$id.'" inexistant!');
        }

        return $this->render('MDGameBundle:Genre:edit.html.twig', array('form' => $form->createView()));

    }

    /**
     * @ParamConverter("genre", options={"mapping": {"genre_id": "id"}})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction(Genre $genre)
    {
        $request = $this->container->get('request_stack')->getMasterRequest();
        $em = $this->getDoctrine()->getManager();
        
        if (null === $genre)
        {
            throw new NotFoundHttpException("ID ".$id." inexistant!");
        }

        $form = $this->get('form.factory')->create();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {
            $em->remove($genre);
            $em->flush();
            return $this->render('MDGameBundle:Genre:delete.html.twig');
        }

        return $this->render('MDGameBundle:Genre:delete.html.twig', array('genre' => $genre, 'form' => $form->createView()));

    }

}
