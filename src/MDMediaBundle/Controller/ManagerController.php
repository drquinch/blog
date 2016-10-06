<?php

namespace MDMediaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use MDMediaBundle\Entity\Image;
use MDMediaBundle\Form\ImageType;

class ManagerController extends Controller
{

	public function mainFrameAction()
	{
		$children = $this->selectDirectoryChildren("/../../../web/img/uploads/");
		
		return $this->render('MDMediaBundle:Manager:main_frame_manager.html.twig', array('directories' => $children['0'], 'files' => $children['1']));
	}

	public function findDirectoryChildren($directory)
	{

	}

	public function formUpload()
	{

	}

	public function formManually()
	{

	}
	
	// la fonction va créer un dossier avec le nom fourni ($directory)
	// Seulement si le dossier n'existe pas
	// et ne contient pas autre chose que des lettres (min ou majuscule), des chiffre, tiret ou underscore
	public function createDirectoryAction($currentDir, $directory)
	{
		$request = $this->container->get('request_stack')->getMasterRequest();
		$curdir = str_replace("_", "/", $currentDir);
		$errors = array();
		
		$form = $this->get('form.factory')->create();

		if(file_exists(__DIR__."/../../../".$curdir."/".$directory))
		{
			$errors[] = "file already exist!";
		} else {

			if(preg_match('#^[a-zA-Z0-9_-]+$#', $directory) === 1){
				if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
				{
					if(mkdir(__DIR__."/../../../".$curdir."/".$directory, 0777, true))
					{
						$children = $this->selectDirectoryChildren("/../../../".$curdir);
						return $this->render('MDMediaBundle:Manager:main_frame_manager.html.twig', array('directories' => $children[0], 'files' => $children[1]));
					} else
					{
						$errors[] = "failed to create directory!";
					}
				}	
			} else {
				$errors[] = "Failed to create directory due to forbidden character!";
			}
		}

		if(count($errors) > 0)
		{
			return $this->render('MDMediaBundle:Manager:file_tree_error.html.twig', array('errors' => $errors));
		} else {
			return $this->render('MDMediaBundle:Manager:confirm_form.html.twig', array('form' => $form->createView(), 'currentDir' => $currentDir, 'directory' => $directory));
		}
	}

	public function editDirectoryAction($oldDir, $newDir)
	{
		// 2 comportements possible
		// Soit on traite un dir, auquel cas, on doit renomme le dossier
		// cad remplacer oldDir par newDir après confirmation par un form
		// Soit on traite un file (oldDir)
		// donc on doit renvoyer le form edit
		// puis après confirmation éditer dans la bdd
		// TODO revoir les path donnee pour la methode selectDirectoryChildren
		// TODO extraire le nom du old dir et du new dir
		$request = $this->get('request_stack')->getMasterRequest();

		if (filetype(__DIR__."/../../../".$oldDir) === "dir")
		{
			$form = $this->get('form.factory')->create();
			if($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
				// on change ici le oldDir par le newDir + render file_tree

				$children = $this->selectDirectoryChildren("/../../../".$newDir);
				return $this->render("MDMediaBundle:Manager:file_tree.html.twig", array('directories' => $children[0], 'files' => $children[1]));
			} else {
				return $this->render("MDMediaBundle:Manager:edit_dir_form.html.twig", array('form' => $form->createView()));
			}
		} else {
			// TODO extraire le nom de limage dans oldDir pour la changer plus tard

			$file = new Image();
			$form = $this->get('form.factory')->create(ImageType:class, $file);
			if($request->isMethod('POST') && $form->handleRequest($request)->isValid())
			{
				$em = $this->getDoctrine()->getManager();
				$em->flush();
				$children = $this->selectDirectoryChildren("/../../../".$oldDir);
				return $this->render("MDMediaBundle:Manager:file_tree.html.twig", array('directories' => $children[0], 'files' => $children[1]));
			} else {
				$children = $this->selectDirectoryChildren("/../../../".$oldDir);
				return $this->render("MDMediaBundle:Manager:edit_form.html.twig", array('form' => $form->createView()));
			}
		}
	}

	public function deleteDirectoryAction($currentDir, $directory)
	{
		if ($directory != "." && $directory != "..")
		{
			$request = $this->get('request_stack')->getMasterRequest();
			$form = $this->get('form.factory')->create();

			if($request->isMethod('POST') && $form->handleRequest($request)->isValid())
			{
				//on traite d'abord le string currentDir
				// puis on s'assure d'avoir les droits pour supprimer (TODO a retravailler avec plus de sécurité)
				// ensuite on vérifie si c'est un file ou un dir
				// si c'est un file on va supprimer dans la bdd l'entré
				$curdir = str_replace("_", "/", $currentDir);
				chmod(__DIR__."/../../../".$curdir.$directory, 0777);
				if(filetype(__DIR__."/../../../".$curdir.$directory) === "file")
				{
					$em = $this->getDoctrine()->getManager();
					$file = $em->getRepository("MDMediaBundle:Image")->findOneByName(basename($directory, '.'.pathinfo($directory)['extension']));
					unlink(__DIR__."/../../../".$curdir.$directory);
					if($file != null)
					{
						$em->remove($file);
						$em->flush();
					}
				} else
				{
					rmdir(__DIR__."/../../../".$curdir.$directory);
				}
				$children = $this->selectDirectoryChildren("/../../../".$curdir);
				return $this->render('MDMediaBundle:Manager:file_tree.html.twig', array('directories' => $children[0], 'files' => $children[1]));
			} else {
				return $this->render('MDMediaBundle:Manager:delete_form.html.twig', array('form' => $form->createView()));
			}
		} else {
			return $this->render('MDMediaBundle:Manager:file_tree_error.html.twig', array('errors' => array(". ou .. impossible à supprimer!")));
		}
	}	

	
	private function selectDirectoryChildren($directory)
	{
		$scan = scandir(__DIR__.$directory);

		$directories = array();
		$files = array();
		$max = count($scan);
		
		for($i = 0; $i < $max; $i++)
		{
			if(filetype(__DIR__.$directory.$scan[$i]) === "file")
			{
				$files[] = $scan[$i];
			} else
			{
				$directories[] = $scan[$i];
			}
		}
		
		$result = array( '0' => $directories, '1' => $files);

		return $result;
	}

}
