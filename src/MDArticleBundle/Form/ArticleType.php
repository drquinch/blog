<?php

namespace MDArticleBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use MDMediaBundle\Form\ImageNestedType;
use MDTagsBundle\Form\TagsSelectorType;
use MDGameBundle\Form\GameSelectorType;
use MDGameBundle\Form\LicenceSelectorType;
use MDGameBundle\Form\DeveloperSelectorType;
use MDGameBundle\Form\PublisherSelectorType;
use Doctrine\Common\Persistence\ObjectManager;

class ArticleType extends AbstractType
{
	
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
	    ->add('category', EntityType::class, array('class' => 'MDCategoryBundle:Category', 'choice_label' => 'name', 'multiple' => false, 'expanded' => false))
            ->add('title', TextType::class)
            ->add('subtitle', TextType::class, array('required' => false))
            ->add('content', CKEditorType::class)
            ->add('published', CheckboxType::class, array('required' => false))
	    //->add('games', EntityType::class, array('class' => 'MDGameBundle:Game', 'choice_label' => 'name', 'multiple' => true, 'expanded' => false, 'required' => false))
	    //->add('licences', EntityType::class, array('class' => 'MDGameBundle:Licence', 'choice_label' => 'name', 'multiple' => true, 'expanded' => false, 'required' => false))
	    //->add('publishers', EntityType::class, array('class' => 'MDGameBundle:Publisher', 'choice_label' => 'name', 'multiple' => true, 'expanded' => false, 'required' => false))
	    //->add('developers', EntityType::class, array('class' => 'MDGameBundle:Developer', 'choice_label' => 'name', 'multiple' => true, 'expanded' => false, 'required' => false))->add('games', EntityType::class, array('class' => 'MDGameBundle:Game', 'choice_label' => 'name', 'multiple' => true, 'expanded' => false, 'required' => false))
		->add('games', GameSelectorType::class)
	    ->add('licences', LicenceSelectorType::class)
	    ->add('publishers', PublisherSelectorType::class)
	    ->add('developers', DeveloperSelectorType::class)
	    ->add('coverimage', ImageNestedType::class )
		->add('tags', TagsSelectorType::class)
	    ->add('save', SubmitType::class)
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MDArticleBundle\Entity\Article'
        ));
    }
}
