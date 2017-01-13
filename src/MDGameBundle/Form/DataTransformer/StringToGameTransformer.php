<?php

namespace MDGameBundle\Form\DataTransformer;

use MDGameBundle\Entity\Game;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Collections\ArrayCollection;

class StringToGameTransformer implements DataTransformerInterface
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
	public function transform($games)
	{
		$string = "";
		if($games != null)
		{
			$i = 0;
			foreach ($games as $game)
			{
				if($i === 0)
				{
					$string = $game->getName();
				} else {
					$string = $string.', '.$game->getName();
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
		$games = new ArrayCollection();
		$game = strtok($string, ', ');
		while($game !== false)
		{
			$tempGame = new Game();
			$tempGame->setName($game);
			if(!$games->contains($tempGame))
			{
				$games[] = $tempGame;
			}
			$game = strtok(', ');
		}
		
		return $games;
	 }
}