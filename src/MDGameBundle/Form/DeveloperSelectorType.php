<?php

namespace MDGameBundle\Form;

use MDGameBundle\Form\DataTransformer\StringToDeveloperTransformer;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DeveloperSelectorType extends AbstractType
{
	private $manager;
	
	public function __construct(ObjectManager $manager)
	{
		$this->manager = $manager;
	}
	
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$transformer = new StringToDeveloperTransformer($this->manager);
		$builder->addModelTransformer($transformer);
	}
	
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'invalid_message' => 'The selected developer does not exist. Please create a new card game',
		));
	}
	
	public function getParent()
	{
		return TextType::class;
	}
}