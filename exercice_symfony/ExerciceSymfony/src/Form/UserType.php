<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nom', TextType::class, [
            'label' => 'Nom',
            'constraints' => [
                new NotBlank(['message' => 'Le nom ne peut pas être vide.']),
            ],
        ])
        ->add('prenom', TextType::class, [
            'label' => 'Prénom',
            'constraints' => [
                new NotBlank(['message' => 'Le prénom ne peut pas être vide.']),
            ],
        ])
        ->add('email', EmailType::class, [
            'label' => 'Email',
            'constraints' => [
                new NotBlank(['message' => 'L\'email ne peut pas être vide.']),
                new Email(['message' => 'L\'email {{ value }} n\'est pas valide.']),
            ],
        ])
        ->add('adresse', TextareaType::class, [
            'label' => 'Adresse',
            'constraints' => [
                new NotBlank(['message' => 'L\'adresse ne peut pas être vide.']),
            ],
        ])
        ->add('tel', TelType::class, [
            'label' => 'Téléphone',
            'constraints' => [
                new NotBlank(['message' => 'Le numéro de téléphone ne peut pas être vide.']),
            ],
        ])

        ->add('save', SubmitType::class, [
            'label' => 'Envoyer' ,
            'attr' => ['class' => 'btn btn-dark']
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
