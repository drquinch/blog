<?php

namespace MDTagsBundle\Form;

use MDTagsBundle\Form\DataTransformer\StringToTagTransformer;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TagsSelectorType extends AbstractType
{
	private $manager;
	
	public function __construct(ObjectManager $manager)
	{
		$this->manager = $manager;
	}
	
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$transformer = new StringToTagTransformer($this->manager);
		$builder->addModelTransformer($transformer);
	}
	
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'invalid_message' => 'The selected tag does not exist',
		));
	}
	
	public function getParent()
	{
		return TextType::class;
	}
}