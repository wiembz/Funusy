<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('emailUser', EmailType::class, [
                'label' => 'Email',
                'attr' => [
                    'class' => 'form-control-input',
                    'id' => 'emailUser',
                    'required' => true,
                ],
            ])
            ->add('mdp', PasswordType::class, [
                'label' => 'Password',
                'attr' => [
                    'class' => 'form-control-input',
                    'id' => 'mdp',
                    'required' => true,
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Login',
                'attr' => [
                    'class' => 'btn btn-primary',
                ],
            ]);
           
 
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}