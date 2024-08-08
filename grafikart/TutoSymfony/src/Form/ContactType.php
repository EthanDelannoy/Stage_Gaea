<?php

namespace App\Form;

use App\DTO\ContactDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'empty_data' => '' // si le nom est vide alors on lui met une chaine de caractère vide
            ])
            ->add('email', EmailType::class, [
                'empty_data' => '' // si le nom est vide alors on lui met une chaine de caractère vide
            ])
            ->add('message', TextareaType::class, [
                'empty_data' => '' // si le nom est vide alors on lui met une chaine de caractère vide
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Envoyer' // le nom du bouton submit
            ])
            ->add('service', ChoiceType::class, [
                'choices' => [ // On lui donne le choix du nom de mail à qui l'envoyer
                    'Compta' => 'compta@demo.fr',
                    'Support' => 'support@demo.fr',
                    'Markerting' => 'markerting@demo.fr',
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ContactDTO::class,
        ]);
    }
}
