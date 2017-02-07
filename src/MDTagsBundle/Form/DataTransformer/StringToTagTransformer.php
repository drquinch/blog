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
		
		$tags = new ArrayCollection();
		$tag = strtok($string, ',');
		while($tag !== false)
		{
			$tempTag = $this->manager->getRepository('MDTagsBundle:Tag')
						->findOneByName($tag);
			if(!$tempTag)
			{
				$tempTag = new Tag();
				$tempTag->setName($tag);
			}
			if(!$tags->contains($tempTag))
			{
				$tags[] = $tempTag;
			}
			$tag = strtok(',');
		}
		
		/*$tags = new ArrayCollection();
		$tags = explode(', ', $string);
		$tagsLength = count($tags);
		$finalTags = new ArrayCollection();
		for ($i = 0; $i < $tagsLength; $i++)
		{
			$tempTag = $this->manager->getRepository('MDTagsBundle:Tag')
						->findOneByName($tags[$i]);
			if(!$tempTag)
			{
				$tempTag = new Tag();
				$tempTag->setName($tags[$i]);
			}
			if(!$finalTags->contains($tempTag))
			{
				$finalTags[] = $tempTag;
			}
		}*/
		
		//return $finalTags;
		return $tags;
	 }
}