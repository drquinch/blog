<?php

namespace MDArticleBundle\Controller;

use MDArticleBundle\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use MDArticleBundle\Form\ArticleType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class ArticleController extends Controller
{

    public function batchAction($batch, $page, $category)
    {
		$articles = array();
		if ($category !== null && $category !== "" && $category !== "all")
		{
			$cat = $this->getDoctrine()->getManager()->getRepository('MDCategoryBundle:Category')->findOneByName($category);
			$articles = $this->getDoctrine()->getManager()->getRepository('MDArticleBundle:Article')->findLimitedAllByCategory($batch, $page, $cat);
		} else {
			$articles = $this->getDoctrine()->getManager()->getRepository('MDArticleBundle:Article')->findLimitedAll($batch, $page);
		}
		return $this->render('MDArticleBundle:Article:batch.html.twig', array('articles' => $articles));
    }

	// return le minimum de html (utilisé via methode ajax)
    public function batchByCategoryAction($batch, $page, $category, $parent)
    {
		$catParent = $this->getDoctrine()
						->getManager()
						->getRepository('MDCategoryBundle:Category')
						->findOneByNameWithParentNull($parent);
		$cat = $this->getDoctrine()
				->getManager()
				->getRepository('MDCategoryBundle:Category')
				->findOneByNameWithParent($category, $catParent);
		$articles = $this->getDoctrine()
			->getManager()
			->getRepository('MDArticleBundle:Article')
			->findLimitedByCategory($batch, $page, $cat);
		
		return $this->render('MDArticleBundle:Article:batchByCategory.html.twig', array('articles' => $articles));

    }

    /**
     * @ParamConverter("article", options={"mapping": {"article_slug": "slug"}})
     */
    public function viewAction(Article $article)
    {
        if ($article === null)
        {
            throw new NotFoundHttpException('ID "'.$id.'" inexistant!');
        }

        return $this->render('MDArticleBundle:Article:view.html.twig', array('article' => $article));

    }

    /**
     * @Security("has_role('ROLE_WRITTER')")
     */
    public function createAction()
    {
        $request = $this->container->get('request_stack')->getMasterRequest();
        $article = new Article();
		$article->setDateCreation(new \DateTime());
        $form = $this->get('form.factory')->create(ArticleType::class, $article, array('security_token' => $this->get('security.token_storage')));

        if ($request->isMethod('POST'))
        {
            $form->handleRequest($request);
			//TODO tester avec $form["nom_champs"] = url du fichier
			/*
			$username = $this->get('security.token_storage')->getToken()->getUser()->getUsername();
			$categoryArt = $form->get('category')->getName();
			$slug = str_replace(' ', '-', $form->get('title')->getData()).'-'.str_replace(' ', '-', $form->get('subtitle')->getData());
			$path = 'articles/'.$username.'/'.$categoryArt.'/'.$slug;
			$form->get('coverimage')->get('path')->setData($path);*/
            if ($form->isValid())
			{
				$article->setAuthor($this->getUser());
                $em = $this->getDoctrine()->getManager();
                $em->persist($article);
                $em->flush();

                return $this->render('MDArticleBundle:Article:create.html.twig', array('article' => $article));
            }
        }

        return $this->render('MDArticleBundle:Article:create.html.twig', array('form' => $form->createView()));

    }

    /**
     * @ParamConverter("article", options={"mapping": {"article_id": "id"}})
     * @Security("has_role('ROLE_WRITTER')")
     */
    public function editAction(Article $article)
    {
        $request = $this->container->get('request_stack')->getMasterRequest();
		$article->setDateLastUpdate(new \DateTime());
        $form = $this->get('form.factory')->create(ArticleType::class, $article, array('security_token' => $this->get('security.token_storage')));

        if ($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->flush();
                return $this->render('MDArticleBundle:Article:edit.html.twig', array('article' => $article));
            }
        }
        if ($article === null)
        {
            throw new NotFoundHttpException('ID "'.$id.'" inexistant!');
        }

        return $this->render('MDArticleBundle:Article:edit.html.twig', array('form' => $form->createView()));

    }

    /**
     * @ParamConverter("article", options={"mapping": {"article_id": "id"}})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction(Article $article)
    {
        $request = $this->container->get('request_stack')->getMasterRequest();
        $em = $this->getDoctrine()->getManager();
        
        if (null === $article)
        {
            throw new NotFoundHttpException("ID ".$id." inexistant!");
        }

        $form = $this->get('form.factory')->create();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {
            $em->remove($article);
            $em->flush();
            return $this->render('MDArticleBundle:Article:delete.html.twig');
        }

        return $this->render('MDArticleBundle:Article:delete.html.twig', array('article' => $article, 'form' => $form->createView()));

    }

}
