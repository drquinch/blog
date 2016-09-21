<?php

namespace MDGameBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class LicenceType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('website', TextType::class)
            ->add('publishers', EntityType::class, array('class' => 'MDGameBundle:Publisher', 'choice_label' => 'name', 'multiple' => true, 'expanded' => false))
            ->add('developers', EntityType::class, array('class' => 'MDGameBundle:Developer', 'choice_label' => 'name', 'multiple' => true, 'expanded' => false))
            ->add('plateformes', EntityType::class, array('class' => 'MDGameBundle:Plateforme', 'choice_label' => 'name', 'multiple' => true, 'expanded' => false))
            ->add('genres', EntityType::class, array('class' => 'MDGameBundle:Genre', 'choice_label' => 'name', 'multiple' => true, 'expanded' => false))
            ->add('themes', EntityType::class, array('class' => 'MDGameBundle:Theme', 'choice_label' => 'name', 'multiple' => true, 'expanded' => false))
            ->add('save', SubmitType::class);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'MDGameBundle\Entity\Licence'));
    }
}
