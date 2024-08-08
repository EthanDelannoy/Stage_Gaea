<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Recipe;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Event\PreSubmitEvent;
use Symfony\Component\Form\Event\PostSubmitEvent;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;


class RecipeType extends AbstractType
{

    public function __construct(private FormListenerFactory $listenerFactory) {

    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'empty_data' => '' // si le nom est vide alors on lui met une chaine de caractère vide
            ])
            ->add('slug', TextType::class, [
                'required' => false, // pas obligatoire d'être remplis 
            ])
            ->add('thumbnailFile', FileType::class) // champs image 
            
            ->add('category', EntityType::class,[
                'class' => Category::class, //On lui ajouter une categorie qui viens de la class category 
                'choice_label' => 'name', // On décide dans quel catégorie le mettre 
            ])
            ->add('content', TextareaType::class, [
                'empty_data' => '' // si le nom est vide alors on lui met une chaine de caractère vide
            ])
            ->add('duration')
            ->add('save', SubmitType::class)
            ->addEventListener(FormEvents::PRE_SUBMIT, $this->listenerFactory->autoSlug('title')) // remplis le slug en fonction du titre (FormListenerFactory)
            ->addEventListener(FormEvents::POST_SUBMIT, $this->listenerFactory->timestamps())//remplis le change created tout seul en fonction du jour/heure actuelle (FormListenerFactory)        
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recipe::class,
        ]);
    }
}
