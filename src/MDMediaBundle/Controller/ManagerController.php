<?php

namespace MDMediaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class ManagerController extends Controller
{

	public function mainFrameAction()
	{
		$children = $this->selectDirectoryChildren("/../../../web/img/uploads");
		
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

	public function createDirectory($currentDir, $directory)
	{
		if(mkdir(__DIR__."/../../../".$currentDir."/".$directory))
		{
			return $this->render('MDMediaBundle:Manager:directoryCreated.html.twig', array('newDir' => $directory, 'dir' => $currentDir));
		} else
		{

		}	
	}

	public function editDirectory($oldDir, $newDir)
	{

	}

	public function deleteDirectory($directory)
	{

	}	

	
	private function selectDirectoryChildren($directory)
	{
		$scan = scandir(__DIR__.$directory);

		$directories = array();
		$files = array();

		for($i = 0; $i < count($scan); $i++)
		{
			if(is_dir($scan[$i]))
			{
				array_push($directories, $scan[$i]);
			} else if (is_file($scan[$i]))
			{
				array_push($files, $scan[$i]);
			}
		}
		
		$result = array( '0' => $directories, '1' => $files);

		return $result;
	}

}
