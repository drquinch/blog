<?php

namespace MDCategoryBundle\Controller;

use MDCategoryBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use MDCategoryBundle\Form\CategoryType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class CategoryController extends Controller
{

    public function batchAction($batch, $page)
    {
	$categorys = $this->getDoctrine()->getManager()->getRepository('MDCategoryBundle:Category')->findLimitedAll($batch, $page);
	return $this->render('MDCategoryBundle:Category:batch.html.twig', array('categorys' => $categorys));
    }

    /**
     * @ParamConverter("category", options={"mapping": {"category_id": "id"}})
     */
    public function viewAction(Category $category)
    {
        if ($category === null)
        {
            throw new NotFoundHttpException('ID "'.$id.'" inexistant!');
        }

        return $this->render('MDCategoryBundle:Category:view.html.twig', array('category' => $category));

    }

    /**
     * @Security("has_role('ROLE_WRITTER')")
     */
    public function createAction()
    {
        $request = $this->container->get('request_stack')->getMasterRequest();
        $category = new Category();
        $form = $this->get('form.factory')->create(CategoryType::class, $category);

        if ($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
		$em->persist($category);
                $em->flush();

                return $this->render('MDCategoryBundle:Category:create.html.twig', array('category' => $category));
            }
        }

        return $this->render('MDCategoryBundle:Category:create.html.twig', array('form' => $form->createView()));

    }

    /**
     * @ParamConverter("category", options={"mapping": {"category_id": "id"}})
     * @Security("has_role('ROLE_WRITTER')")
     */
    public function editAction(Category $category)
    {
        $request = $this->container->get('request_stack')->getMasterRequest();
        $form = $this->get('form.factory')->create(CategoryType::class, $category);

        if ($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->flush();
                return $this->render('MDCategoryBundle:Category:edit.html.twig', array('category' => $category));
            }
        }
        if ($category === null)
        {
            throw new NotFoundHttpException('ID "'.$id.'" inexistant!');
        }

        return $this->render('MDCategoryBundle:Category:edit.html.twig', array('form' => $form->createView()));

    }

    /**
     * @ParamConverter("category", options={"mapping": {"category_id": "id"}})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction(Category $category)
    {
        $request = $this->container->get('request_stack')->getMasterRequest();
        $em = $this->getDoctrine()->getManager();
        
        if (null === $category)
        {
            throw new NotFoundHttpException("ID ".$id." inexistant!");
        }

        $form = $this->get('form.factory')->create();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {
            $em->remove($category);
            $em->flush();
            return $this->render('MDCategoryBundle:Category:delete.html.twig');
        }

        return $this->render('MDCategoryBundle:Category:delete.html.twig', array('category' => $category, 'form' => $form->createView()));

    }

}
