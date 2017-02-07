<?php

namespace MDGameBundle\Form\DataTransformer;

use MDGameBundle\Entity\Licence;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Collections\ArrayCollection;

class StringToLicenceTransformer implements DataTransformerInterface
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
	public function transform($licences)
	{
		$string = "";
		if($licences != null)
		{
			$i = 0;
			foreach ($licences as $licence)
			{
				if($i === 0)
				{
					$string = $licence->getName();
				} else {
					$string = $string.', '.$licence->getName();
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
		$licences = new ArrayCollection();
		$licence = strtok($string, ', ');
		while($licence !== false)
		{
			$tempLicence = $this->manager->getRepository('MDGameBundle:Licence')
							->findOneByName($licence);
			if(!$tempLicence)
			{
				$tempLicence = new Licence();
				$tempLicence->setName($licence);
			}
			if(!$licences->contains($tempLicence))
			{
				$licences[] = $tempLicence;
			}
			$licence = strtok(', ');
		}
		
		return $licences;
	 }
}