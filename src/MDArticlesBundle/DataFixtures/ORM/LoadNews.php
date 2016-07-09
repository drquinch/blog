<?php

namespace MDArticlesBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MDArticlesBundle\Entity\News;

class LoadNews implements FixtureInterface
{
	public function load(ObjectManager $manager)
	{

		$title = array('News Numbeurre Wane',
					'Aller et retour',
					'Substance Mort',
					'Enter the gungeon',
					'Up in the sky',
					'Vanilla sky',
					'Zelda',
					'Doom');
		$content = array('test de news samere! Essais CONCLUANT PUTAIN TI!',
					'Par Bilbo saquet. Mais a-t-il jamais existé? Et quand est il du comté?',
					'Les délires schizophréniques d\'un paranoiaque. Bob Arctor is in da place',
					'C\'est comme donjon mais avec gun et en anglais: gungeon. Tout se tient.',
					'Ca ne veut rien dire, je savais pas quoi dire et encore moins dans le corps de la news',
					'Ou est la réalité? Qui sommes nous? Qu\'est ce qui est réel??',
					'30 ans déjà et on s\'en branle!!! Mais quand arrivera le prochain?',
					'Doom, quand mon cœur fait Doom, blablabla Doom');

		for($i = 0; $i < count($title); $i++)
		{
			$news = new News();
			$news->setDateCreation(new \Datetime());
			$news->setAuthor('DocQuinch');
			$news->setTitle($title[$i]);
			$news->setContent($content[$i]);
			$news->setPublished(false);

			$manager->persist($news);
		}

		$manager->flush();

	}
}
