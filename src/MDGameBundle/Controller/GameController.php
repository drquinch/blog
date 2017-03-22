<?php

namespace MDGameBundle\Controller;

use MDGameBundle\Entity\Game;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use MDGameBundle\Form\GameType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class GameController extends Controller
{

    public function batchAction($batch, $page)
    {
	$games = $this->getDoctrine()->getManager()->getRepository('MDGameBundle:Game')->findLimitedAll($batch, $page);

	return $this->render('MDGameBundle:Game:batch.html.twig', array('games' => $games));
    }
	
	public function jsonAllAction()
	{
		$games = $this->getDoctrine()->getManager()->getRepository('MDGameBundle:Game')->findAll();
		//$response = new Response(json_encode($tags));
		$response = $this->get('templating')->renderResponse('MDGameBundle:Game:jsonAll.json.twig', array('games' => $games));
		$response->headers->set('Content-Type', 'application/json');
		//return $this->render('MDTagsBundle:Tag:jsonAll.json.twig', array('tags' => $tags));
		return $response;
	}

    public function viewAction($game_id)
    {

	$game = $this->getDoctrine()->getManager()->getRepository('MDGameBundle:Game')->findGameWithSubobject($game_id);

        if ($game === null)
        {
            throw new NotFoundHttpException('ID "'.$id.'" inexistant!');
        }

        return $this->render('MDGameBundle:Game:view.html.twig', array('game' => $game));

    }

    /**
     * @Security("has_role('ROLE_WRITTER')")
     */
    public function createAction()
    {
        $request = $this->container->get('request_stack')->getMasterRequest();
        $game = new Game();
        $form = $this->get('form.factory')->create(GameType::class, $game);

        if ($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($game);
                $em->flush();

                return $this->render('MDGameBundle:Game:create.html.twig', array('game' => $game));
            }
        }

        return $this->render('MDGameBundle:Game:create.html.twig', array('form' => $form->createView()));

    }

    /**
     * @ParamConverter("game", options={"mapping": {"game_id": "id"}})
     * @Security("has_role('ROLE_WRITTER')")
     */
    public function editAction(Game $game)
    {
        $request = $this->container->get('request_stack')->getMasterRequest();
        $form = $this->get('form.factory')->create(GameType::class, $game);

        if ($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->flush();
                return $this->render('MDGameBundle:Game:edit.html.twig', array('game' => $game));
            }
        }
        if ($game === null)
        {
            throw new NotFoundHttpException('ID "'.$id.'" inexistant!');
        }

        return $this->render('MDGameBundle:Game:edit.html.twig', array('form' => $form->createView()));

    }

    /**
     * @ParamConverter("game", options={"mapping": {"game_id": "id"}})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction(Game $game)
    {
        $request = $this->container->get('request_stack')->getMasterRequest();
        $em = $this->getDoctrine()->getManager();
        
        if (null === $game)
        {
            throw new NotFoundHttpException("ID ".$id." inexistant!");
        }

        $form = $this->get('form.factory')->create();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {
            $em->remove($game);
            $em->flush();
            return $this->render('MDGameBundle:Game:delete.html.twig');
        }

        return $this->render('MDGameBundle:Game:delete.html.twig', array('game' => $game, 'form' => $form->createView()));

    }
	
	public function jsonBatchAction($names, $delimiter)
	{
		// séparer les names en array, aller les rechercher ds bdd (p-e faire une nvl req), les passer à la vue
		$games = array();
		$repo = $this->getDoctrine()->getManager()->getRepository('MDGameBundle:Game');
		$name = strtok($names, $delimiter);
		$namesArray = array();
		while ($name != false)
		{
			$namesArray[] = trim($name);
			$name = strtok($delimiter);
		}
		$games = $repo->findGamesByNameWithSubobject($namesArray);
		
		$response = $this->get('templating')->renderResponse('MDGameBundle:Game:gameJson.json.twig', array('games' =>$games));
		$response->headers->set('Content-Type', 'application/json');
		
		return $response;
	}
	
}
