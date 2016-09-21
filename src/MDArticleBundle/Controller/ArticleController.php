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

    public function batchAction($batch, $page)
    {
	$articles = $this->getDoctrine()->getManager()->getRepository('MDArticleBundle:Article')->findLimitedAll($batch, $page);
	return $this->render('MDArticleBundle:Article:batch.html.twig', array('articles' => $articles));
    }

    public function batchByCategoryAction($batch, $page, $category)
    {

	$articles = $this->getDoctrine()
		->getManager()
		->getRepository('MDArticleBundle:Article')
		->findLimitedByCategory($batch, $page, $category);
	
	return $this->render('MDArticleBundle:Article:batchByCategory.html.twig', array('articles' => $articles));

    }

    /**
     * @ParamConverter("article", options={"mapping": {"article_id": "id"}})
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
        $form = $this->get('form.factory')->create(ArticleType::class, $article);

        if ($request->isMethod('POST'))
        {
            $form->handleRequest($request);
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
        $form = $this->get('form.factory')->create(ArticleType::class, $article);

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
