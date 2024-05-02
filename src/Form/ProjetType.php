<?php

namespace App\Form;

use App\Entity\Projet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomProjet')
            ->add('montantReq')
            ->add('longitude')
            ->add('latitude')
            ->add('typeProjet', ChoiceType::class, [
                'choices' => [
                    'AGRICULTURE' => 'AGRICULTURE',
                    'BOURSE' => 'BOURSE',
                    'IMMOBILIER' => 'IMMOBILIER',
                    'TECHNOLOGIQUE' => 'TECHNOLOGIQUE',
                ],
            ])            ->add('description')
            ->add('user')
        ;   
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Projet::class,
        ]);
    }
}
