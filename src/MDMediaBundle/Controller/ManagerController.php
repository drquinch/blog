<?php

namespace MDMediaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use MDMediaBundle\Entity\Image;
use MDMediaBundle\Form\ImageType;
use MDMediaBundle\Form\ImageEditNestedType;

class ManagerController extends Controller
{

	public function mainFrameAction()
	{
		$children = $this->selectDirectoryChildren("/../../../web/img/uploads/");
		
		return $this->render('MDMediaBundle:Manager:main_frame_manager.html.twig', array('directories' => $children['0'], 'files' => $children['1']));
	}

	// On commence par remplacer les _ du directory par des /
	// selectDirChildren
	// render response
	public function findDirectoryChildrenAction($directory)
	{
		$dir = str_replace("_", "/", $directory);
		$errors = array();

		if (preg_match("/^(web\/img\/uploads\/){1}([a-zA-Z0-9_-]+[\/]{1})*$/", $dir))
		{
			if (file_exists(__DIR__."/../../../".$dir))
			{
				$children = $this->selectDirectoryChildren("/../../../".$dir);
				return $this->render("MDMediaBundle:Manager:file_tree.html.twig", array('directories' => $children['0'], 'files' => $children['1']));
			}
			$errors[] = "Le dossier ".$dir." n'existe pas !";
			return $this->render("MDMediaBundle:Manager:file_tree_error.html.twig", array("errors" => $errors));
		}

		$errors[] = "Le dossier ".$dir." n'existe pas!";
		return $this->render("MDMediaBundle:Manager:file_tree_error.html.twig", array("errors" => $errors));
	}

	private function formUpload()
	{

	}

	private function formManually()
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
						return $this->render('MDMediaBundle:Manager:file_tree.html.twig', array('directories' => $children[0], 'files' => $children[1]));
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
			return $this->render('MDMediaBundle:Manager:confirm_create_form.html.twig', array('form' => $form->createView(), 'currentDir' => $currentDir, 'directory' => $directory));
		}
	}

	// param $oldDir contient tout le path avec également le dir ou file à renommer
	// parma $newDir ne contient uniquement que le nouveaux nom du dir ou file sans le path
	public function editDirectoryAction($oldDir, $newDir)
	{
		// 2 comportements possible
		// Soit on traite un dir, auquel cas, on doit renomme le dossier
		// cad remplacer oldDir par newDir après confirmation par un form
		// Soit on traite un file (oldDir)
		// donc on doit renvoyer le form edit
		// puis après confirmation éditer dans la bdd
		$request = $this->get('request_stack')->getMasterRequest();
		// on extrait ici le nom du dir ou file de oldDir (ce qu'il faudra remplacer par newDir)
		$oldDir = preg_replace("~_~", "/", $oldDir);
		$oldDirExploded = explode("/", $oldDir);
		$toRename = $oldDirExploded[count($oldDirExploded)-1];
		// on construit le chemin sans le oldDir dedans (servira pour le newDir)
		$pathWithoutToRename = "";
		// on evite egalement de prendre le dernier exploded car il correspond à toRename, ce quon ne veut pas avoir dans cette string
		for ($i = 0; $i < count($oldDirExploded)-1; $i++)
		{
			$pathWithoutToRename .= "/".$oldDirExploded[$i];
		}

		// on verifie si on n'essaye pas de modifier . ou ..
		if($this->checkNewName($oldDirExploded[count($oldDirExploded)-1]) !== 1)
		{
			return "c";
		}

		if (filetype(__DIR__."/../../../".$oldDir) === "dir")
		{
			//onverifie d'abord si le newDir ne contient pas de char interdit
			if($this->checkNewName($newDir) !== 1)
			{
				return "b";
			}
			$form = $this->get('form.factory')->create();
			if($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
				// on change ici le oldDir par le newDir + render file_tree
				rename(__DIR__."/../../../".$oldDir, __DIR__."/../../..".$pathWithoutToRename."/".$newDir);
				$children = $this->selectDirectoryChildren("/../../..".$pathWithoutToRename);
				return $this->render("MDMediaBundle:Manager:file_tree.html.twig", array('directories' => $children[0], 'files' => $children[1]));
			}
			return $this->render("MDMediaBundle:Manager:edit_dir_form.html.twig", array('form' => $form->createView()));
		} else {
			$em = $this->getDoctrine()->getManager();
			$file = $em->getRepository("MDMediaBundle:Image")->findOneByName(basename($toRename, '.'.pathinfo($toRename)['extension']));
			$form = $this->get('form.factory')->create(ImageEditNestedType::class, $file);
			if($request->isMethod('POST') && $form->handleRequest($request)->isValid())
			{
				$data = $form->getData();
				// on verifie d'abord si le nouveaux nom ne contient pas de char interdit
				// TODO renvoyer une error, faire view pour gestion erreur et lafficher cote client
				if($this->checkNewName($data->getName()) !== 1)
				{
					return $this->render("MDMediaBundle:Manager:edit_error.html.twig", array("error" => "Le nom du fichier ne peut contenir que des nombres, des lettres, des underscores et/ou des tirets!"));
				}
				$em->flush();
				rename(__DIR__."/../../../".$oldDir, 
					__DIR__."/../../..".$pathWithoutToRename
					."/".$data->getName()."."
					.$file->getExt());
				$children = $this->selectDirectoryChildren("/../../..".$pathWithoutToRename);
				return $this->render("MDMediaBundle:Manager:file_tree.html.twig", array('directories' => $children[0], 'files' => $children[1]));
			}
			return $this->render("MDMediaBundle:Manager:edit_form.html.twig", array('form' => $form->createView()));
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

	// retourne 1 si tout est ok
	// false ou 0 si il contient un char interdit
	private function checkNewName($toCheck)
	{
		return preg_match("/[a-zA-Z0-9\-]+$/", $toCheck);
	}

	private function selectDirectoryChildren($directory)
	{
		$scan = scandir(__DIR__.$directory);

		$directories = array();
		$files = array();
		$max = count($scan);
		
		for($i = 0; $i < $max; $i++)
		{
			if(filetype(__DIR__.$directory."/".$scan[$i]) === "file")
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
