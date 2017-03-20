<?php

namespace MDArticleBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use MDMediaBundle\Form\ImageNestedType;
use MDTagsBundle\Form\TagsSelectorType;
use MDCategoryBundle\Repository\CategoryRepository;
use MDGameBundle\Form\GameSelectorType;
use MDGameBundle\Form\LicenceSelectorType;
use MDGameBundle\Form\DeveloperSelectorType;
use MDGameBundle\Form\PublisherSelectorType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class ArticleType extends AbstractType
{
	
	/*private $securityContext;
	
	public function __construct(SecurityContext $securityContext)
	{
		$this->securityContext = $securityContext;
	}*/
	
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
	    //->add('category', EntityType::class, array('class' => 'MDCategoryBundle:Category', 'choice_label' => 'name', 'multiple' => false, 'expanded' => false))
	    ->add('category', EntityType::class, 
				array('class' => 'MDCategoryBundle:Category', 
						'choice_label' => 'name', 
						'multiple' => false, 
						'expanded' => false,
						'query_builder' => function(CategoryRepository $repo){
							return $repo->getCategoryQueryBuilder();
						},
						'group_by' => 'parent.name'))
            ->add('title', TextType::class)
            ->add('subtitle', TextType::class, array('required' => false))
            ->add('content', CKEditorType::class)
            ->add('datePublication', DateType::class, array('required' => false))
	    //->add('games', EntityType::class, array('class' => 'MDGameBundle:Game', 'choice_label' => 'name', 'multiple' => true, 'expanded' => false, 'required' => false))
	    //->add('licences', EntityType::class, array('class' => 'MDGameBundle:Licence', 'choice_label' => 'name', 'multiple' => true, 'expanded' => false, 'required' => false))
	    //->add('publishers', EntityType::class, array('class' => 'MDGameBundle:Publisher', 'choice_label' => 'name', 'multiple' => true, 'expanded' => false, 'required' => false))
	    //->add('developers', EntityType::class, array('class' => 'MDGameBundle:Developer', 'choice_label' => 'name', 'multiple' => true, 'expanded' => false, 'required' => false))->add('games', EntityType::class, array('class' => 'MDGameBundle:Game', 'choice_label' => 'name', 'multiple' => true, 'expanded' => false, 'required' => false))
		->add('games', GameSelectorType::class)
	    ->add('licences', LicenceSelectorType::class)
	    ->add('publishers', PublisherSelectorType::class)
	    ->add('developers', DeveloperSelectorType::class)
	    ->add('coverimage', ImageNestedType::class, array('required' => false) )
		->add('tags', TagsSelectorType::class)
	    ->add('save', SubmitType::class)
		->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) use ($options) {
			$formData = $event->getData();
			
			$username = $options['security_token']->getToken()->getUser()->getUsername();
			$categoryArt = $formData->getCategory()->getName();
			$title = $formData->getTitle();
			$title = strtr(utf8_decode($title), utf8_decode("ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ"), "aaaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn");
			$title = strtolower($title);
			$title = trim($title, '-');
			$subtitle = $formData->getSubtitle();
			$subtitle = strtr(utf8_decode($subtitle), utf8_decode("ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ"), "aaaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn");
			$subtitle = strtolower($subtitle);
			$subtitle = trim($subtitle, '-');
			$slug = trim(preg_replace('/[\-]{1,}/', '-', preg_replace('/[^A-Za-z0-9\-]/', '-', $title).'-'.preg_replace('/[^A-Za-z0-9\-]/', '-', $subtitle)), '-');
			$path = 'articles/'.$username.'/'.$categoryArt.'/'.$slug;
			
			$formData->getCoverimage()->setPath($path);
			
		})
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
		$resolver->setRequired('security_token');
    }
}
