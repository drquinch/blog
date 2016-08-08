<?php

namespace MCommentBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MDCommentBundle\Entity\Comment;
use MDArticlesBundle\Entity\News;

class LoadComment implements FixtureInterface
{
	public function load(ObjectManager $manager)
	{
		$news = new News();
		$news->setDateCreation(new \Datetime());
		$news->setTitle('Rola Senor');
		$news->setContent('esta bieng? mue bieng!');
		$news->setAuthor('DocQuinch');
		$news->setPublished(false);

		$manager->persist($news);

		$cContent = array('trop de la balle ce jeu',
				'à fond bordel cest de la tuerie',
				'bof pas mal',
				'quoi pas mal?? tu rigoles ou quoi?');

		for($i = 0; $i < count($cContent); $i++)
		{
			$comment = new Comment();
			$comment->setDate(new \Datetime());
			$comment->setContent($cContent[$i]);
			$comment->setArticle($news);

			$manager->persist($comment);
		}

		$manager->flush();

	}
}
