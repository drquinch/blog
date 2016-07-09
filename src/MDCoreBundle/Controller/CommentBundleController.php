<?php

namespace MDCoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class CommentBundleController extends Controller
{
	public function viewBatchAction($batch, $articleId)
	{
		$listComment = $this->get('md_comment.comment.batch')
				->batchComment($articleId);
		$pages = $this->get('md_paging.paging')
				->paging($batch, "MDCommentBundle:Comment");
		return $this->render('MDCoreBundle:CommentBundle:viewBatch.html.twig',
					 array('listComment' => $listComment, 'pages' => $pages));
	}
}
