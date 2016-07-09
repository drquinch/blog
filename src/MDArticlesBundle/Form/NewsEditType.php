<?php

namespace MDArticlesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use MDArticlesBundle\Form\NewsType;

class NewsEditType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->remove('dateCreation');
    }
    
    public function getParent()
    {
        return NewsType::class;
    }

}
