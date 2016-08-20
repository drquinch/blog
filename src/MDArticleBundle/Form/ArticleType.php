<?php

namespace MDArticleBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use MDMediaBundle\Form\ImageNestedType;

class ArticleType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
	    ->add('category', EntityType::class, array('class' => 'MDCategoryBundle:Category', 'choice_label' => 'name', 'multiple' => true, 'expanded' => false))
            ->add('title', TextType::class)
            ->add('subtitle', TextType::class)
            ->add('content', TextareaType::class)
            ->add('published', CheckboxType::class)
	    ->add('note', IntegerType::class)
	    ->add('games', EntityType::class, array('class' => 'MDGameBundle:Game', 'choice_label' => 'name', 'multiple' => true, 'expanded' => false))
	    ->add('licences', EntityType::class, array('class' => 'MDGameBundle:Licence', 'choice_label' => 'name', 'multiple' => true, 'expanded' => false))
	    ->add('publishers', EntityType::class, array('class' => 'MDGameBundle:Publisher', 'choice_label' => 'name', 'multiple' => true, 'expanded' => false))
	    ->add('developers', EntityType::class, array('class' => 'MDGameBundle:Developer', 'choice_label' => 'name', 'multiple' => true, 'expanded' => false))
	    ->add('coverimage', ImageNestedType::class )
	    ->add('tags', EntityType::class, array('class' => 'MDTagsBundle:Tag', 'choice_label' => 'name', 'multiple' => true, 'expanded' => false))
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
