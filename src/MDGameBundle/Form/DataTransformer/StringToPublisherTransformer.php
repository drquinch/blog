<?php

namespace MDGameBundle\Form\DataTransformer;

use MDGameBundle\Entity\Publisher;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Collections\ArrayCollection;

class StringToPublisherTransformer implements DataTransformerInterface
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
	public function transform($publishers)
	{
		$string = "";
		if($publishers != null)
		{
			$i = 0;
			foreach ($publishers as $publisher)
			{
				if($i === 0)
				{
					$string = $publisher->getName();
				} else {
					$string = $string.', '.$publisher->getName();
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
		$publishers = new ArrayCollection();
		$publisher = strtok($string, ', ');
		while($publisher !== false)
		{
			$tempPublisher = new Publisher();
			$tempPublisher->setName($publisher);
			if(!$publishers->contains($tempPublisher))
			{
				$publishers[] = $tempPublisher;
			}
			$publisher = strtok(', ');
		}
		
		return $publishers;
	 }
}