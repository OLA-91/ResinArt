<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MonCompteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('email', EmailType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'E-mail'],
                'label' => false,
            ])
            ->add('lastname', TextType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Nom'],
                'label' => false,
            ])
            ->add('firstname', TextType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Prénom'],
                'label' => false,
            ])
            ->add('address', TextType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Adresse'],
                'label' => false,
            ])
            ->add('zipcode', TextType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Code postal'],
                'label' => false,
            ])
            ->add('city', TextType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Ville'],
                'label' => false,
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
