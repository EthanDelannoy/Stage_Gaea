<?php

namespace App\Form;

use App\Entity\Possession;
use App\Entity\user;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PossessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('valeur')
            ->add('type')
            ->add('user', EntityType::class, [
                'class' => user::class,
                'choice_label' => 'prenom',
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
            'data_class' => Possession::class,
        ]);
    }
}
