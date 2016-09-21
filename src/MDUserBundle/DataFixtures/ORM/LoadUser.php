<?php

namespace MDUserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MDUserBundle\Entity\User;

class LoadUser implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
	$listNames = array('Alicia', 'Alice', 'Anon');
	foreach ($listNames as $name)
	{
	    $user = new User;
	    $user->setUsername($name);
 	    $user->setPassword($name);
	    $user->setSalt('');
	    $user->setRoles(array('ROLE_USER'));

	    $manager->persist($user);
	}

	$manager->flush();
    }
}
