<?php

namespace MDGameBundle\Controller;

use MDGameBundle\Entity\Theme;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use MDGameBundle\Form\ThemeType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class ThemeController extends Controller
{

    /**
     * @ParamConverter("theme", options={"mapping": {"theme_id": "id"}})
     */
    public function viewAction(Theme $theme)
    {
        if ($theme === null)
        {
            throw new NotFoundHttpException('ID "'.$id.'" inexistant!');
        }

        return $this->render('MDGameBundle:Theme:view.html.twig', array('theme' => $theme));

    }

    /**
     * @Security("has_role('ROLE_WRITTER')")
     */
    public function createAction()
    {
        $request = $this->container->get('request_stack')->getMasterRequest();
        $theme = new Theme();
        $form = $this->get('form.factory')->create(ThemeType::class, $theme);

        if ($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($theme);
                $em->flush();

                return $this->render('MDGameBundle:Theme:create.html.twig', array('theme' => $theme));
            }
        }

        return $this->render('MDGameBundle:Theme:create.html.twig', array('form' => $form->createView()));

    }

    /**
     * @ParamConverter("theme", options={"mapping": {"theme_id": "id"}})
     * @Security("has_role('ROLE_WRITTER')")
     */
    public function editAction(Theme $theme)
    {
        $request = $this->container->get('request_stack')->getMasterRequest();
        $form = $this->get('form.factory')->create(ThemeType::class, $theme);

        if ($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->flush();
                return $this->render('MDGameBundle:Theme:edit.html.twig', array('theme' => $theme));
            }
        }
        if ($theme === null)
        {
            throw new NotFoundHttpException('ID "'.$id.'" inexistant!');
        }

        return $this->render('MDGameBundle:Theme:edit.html.twig', array('form' => $form->createView()));

    }

    /**
     * @ParamConverter("theme", options={"mapping": {"theme_id": "id"}})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction(Theme $theme)
    {
        $request = $this->container->get('request_stack')->getMasterRequest();
        $em = $this->getDoctrine()->getManager();
        
        if (null === $theme)
        {
            throw new NotFoundHttpException("ID ".$id." inexistant!");
        }

        $form = $this->get('form.factory')->create();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {
            $em->remove($theme);
            $em->flush();
            return $this->render('MDGameBundle:Theme:delete.html.twig');
        }

        return $this->render('MDGameBundle:Theme:delete.html.twig', array('theme' => $theme, 'form' => $form->createView()));

    }

}
