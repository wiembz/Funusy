<?php

namespace App\Form;

use App\Entity\Garantie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class GarantieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('idCredit', null, [
                'required' => false,
            ])
            ->add('natureGarantie',ChoiceType::class, [
                'choices' => [
                    'Maison' => 'Maison',
                    'Voiture' => 'Voiture',
                    'Terrain' => 'Terrain',
                    'Local Commercial' => 'Local Commercial',

                ],
                'label' => 'Nature de la garantie',
                'placeholder' => 'Choose an option',
                'required' => false, // Champs requis
            ])
            ->add('valeurGarantie', null, [
                'required' => false,
            ])
            ->add('preuve', FileType::class, [
                'label' => 'Preuve (PDF file)',
                // Le champ n'est pas requis
                'required' => false,
                // Autoriser uniquement les fichiers PDF
                'mapped' => false,
                'attr' => [
                    'accept' => 'application/pdf',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Garantie::class,
        ]);
    }
}
