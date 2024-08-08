<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Recipe;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvents;


class CategoryType extends AbstractType
{

    public function __construct(private FormListenerFactory $listenerFactory) {

    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [ 
                'empty_data' => ''  // si le nom est vide alors on lui met une chaine de caractère vide
            ])
            ->add('slug', TextType::class, [ 
                'required' => false, // pas obligatoire
                'empty_data' => '' // si le nom est vide alors on lui met une chaine de caractère vide
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Enregistrer' // Changer le nom du bouton 
            ])
            ->addEventListener(FormEvents::PRE_SUBMIT, $this->listenerFactory->autoSlug('name')) // remplis le slug en fonction du titre (FormListenerFactory)
            ->addEventListener(FormEvents::POST_SUBMIT, $this->listenerFactory->timestamps()) //remplis le change created tout seul en fonction du jour/heure actuelle (FormListenerFactory)        
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
