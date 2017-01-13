<?php

namespace MDTagsBundle\Form\DataTransformer;

use MDTagsBundle\Entity\Tag;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Collections\ArrayCollection;

class StringToTagTransformer implements DataTransformerInterface
{
	private $manager;
	
	public function __construct(ObjectManager $manager)
	{
		$this->manager = $manager;
	}
	
	/**
	 * Transforms an object (tag) to a string(number).
	 *
	 * @param tag|null $tag
	 * @return string
	 */
	public function transform($tags)
	{
		/*if(null===$tag)
		{
			return '';
		}
		
		return $tag->getName();*/
		$string = "";
		if($tags != null)
		{
			$i = 0;
			foreach ($tags as $tag)
			{
				if($i === 0)
				{
					$string = $tag->getName();
				} else {
					$string = $string.', '.$tag->getName();
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
		 // $name is optional
		/*if(!$name)
		{
			return;
		}
		 
		$tag = $this->manager
					->getRepository('MDTagsBundle:Tag')
					->find($name);
		
		if(null===$game)
		{
			throw new TransformationFailedException(sprintf(
			'A game with name "%s" does not exist!', $name
			));
		}
		
		return $tag;*/
		$tags = new ArrayCollection();
		$tag = strtok($string, ', ');
		while($tag !== false)
		{
			$tempTag = new Tag();
			$tempTag->setName($tag);
			if(!$tags->contains($tempTag))
			{
				$tags[] = $tempTag;
			}
			$tag = strtok(', ');
		}
		
		return $tags;
	 }
}