<?php

namespace MDArticlesBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MDArticlesBundle\Entity\Tag;

class LoadTag implements FixtureInterface
{
	public function load(ObjectManager $manager)
	{
	  $names= array(
	    'Horreur',
	    'jeux-video',
	    'indépendant',
	    'AAA');

	  foreach ($names as $name)
	  {
	    $tag = new Tag();
	    $tag->setName($name);

	    $manager->persist($tag);
	  }

	  $manager->flush();
	}
}
