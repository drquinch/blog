<?php

namespace MDGameBundle\Form\DataTransformer;

use MDGameBundle\Entity\Developer;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Collections\ArrayCollection;

class StringToDeveloperTransformer implements DataTransformerInterface
{
	private $manager;
	
	public function __construct(ObjectManager $manager)
	{
		$this->manager = $manager;
	}
	
	/**
	 * Transforms an object to a string.
	 *
	 * @param game|null $game
	 * @return string
	 */
	public function transform($developers)
	{
		$string = "";
		if($developers != null)
		{
			$i = 0;
			foreach ($developers as $developer)
			{
				if($i === 0)
				{
					$string = $developer->getName();
				} else {
					$string = $string.', '.$developer->getName();
				}
				$i++;
			}
		}
		return $string;
	}
	
	/**
	 * Transforms a string (name) to an object (tag)
	 * @param string $name
	 * @return Tag|null
	 * @throws TransformationFailedException if object (tag) is not found
	 */
	 public function reverseTransform($string)
	 {
		$developers = new ArrayCollection();
		$developer = strtok($string, ', ');
		while($developer !== false)
		{
			$tempDeveloper = new Developer();
			$tempDeveloper->setName($developer);
			if(!$developers->contains($tempDeveloper))
			{
				$developers[] = $tempDeveloper;
			}
			$developer = strtok(', ');
		}
		
		return $developers;
	 }
}