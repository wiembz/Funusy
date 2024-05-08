<?php
// src/Form/UserLoginFormType.php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserLoginFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('emailUser', EmailType::class, [
                'label' => 'Email',
                'attr' => [
                    'placeholder' => 'Enter your email'
                ]
            ])
            ->add('mdp', PasswordType::class, [
                'label' => 'Password',
                'attr' => [
                    'placeholder' => 'Enter your password'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
