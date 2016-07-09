<?php

namespace MDCategory\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MDCategoryBundle\Entity\Category;

class LoadCategory implements FixtureInterface
{
	public function load(ObjectManager $manager)
	{
		$names = array('jeux-video',
				'comics',
				'livres',
				'jeux',
				'film',
				'nawak');
		$type = 'general';

		for($i = 0; $i < count($names); $i++)
		{
			$cat = new Category();
			$cat->setName($names[$i]);
			$cat->setType($type);
			$manager->persist($cat);
		}

		$manager->flush();

	}
}
