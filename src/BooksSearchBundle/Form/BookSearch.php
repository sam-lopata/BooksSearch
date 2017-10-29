<?php

// src/AppBundle/Form/TaskType.php
namespace BooksSearchBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookSearch extends AbstractType
{
    const SEARCH_EVERYWHERE = 'everywhere';
    const SEARCH_TITLE = 'title';
    const SEARCH_AUTHOR = 'author';
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod('GET')
            ->add('key', SearchType::class, array(
                'label' => 'Search'))
            ->add('where', ChoiceType::class, array(
                'label' => 'Where to search',
                'choices'  => array(
                    'Everywhere' => self::SEARCH_EVERYWHERE,
                    'By title' => self::SEARCH_TITLE,
                    'By author' => self::SEARCH_AUTHOR,
                ),
                'expanded' => true,
                'multiple' => false,
                'data' => self::SEARCH_EVERYWHERE
            ))
//            ->add('search', SubmitType::class)
            ->setAction('/search')
        ;
    }
    
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('key', new NotBlank());
        $metadata->addPropertyConstraint('key', new NotNull());

        $metadata->addPropertyConstraint(
            'where', 
            new Assert\Choice(array(self::SEARCH_EVERYWHERE, self::SEARCH_AUTHOR, self::SEARCH_TITLE)
            )
        );
    }
    
    public function getBlockPrefix(){
        return '';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
        ]);
    }
}
