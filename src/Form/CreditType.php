<?php

namespace App\Form;

use App\Entity\Credit;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Context\ExecutionContextInterface;


class CreditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('montant_credit', null, [
                'constraints' => [
                    new NotBlank(),
                    new GreaterThan(0),
                ],
                'label' => 'Montant Credit',
            ])
            ->add('duree_credit', null, [
                'constraints' => [
                    new NotBlank(),
                    new GreaterThan(0),
                ],
                'label' => 'Durée (month)',
            ])
            ->add('date_credit', DateType::class, [
                'constraints' => [
                    new NotBlank(),
                ],
                'label' => 'Credit Date',
                'widget' => 'single_text',
                'data' => new \DateTime(), // Initialise la date avec la date système
                'html5' => false, // Nécessaire pour utiliser le format de date souhaité
                'format' => 'yyyy-MM-dd', // Format de date ISO 8601
                'attr' => ['class' => 'js-datepicker'], // Ajouter une classe pour utiliser un datepicker JavaScript si nécessaire
            ])
            ->add('taux_credit', null, [
                'constraints' => [
                    new NotBlank(),
                    new GreaterThan(0),
                ],
                'label' => 'Taux de crédit',
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'required' => true,
                'choice_label' => 'nomUser',
                'placeholder' => 'Select a user',
                'label' => 'User',
            ])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'Accepted' => 'Accepted',
                    'Rejected' => 'Rejected',
                ],
                'label' => 'Status',
                'placeholder' => 'Select status',
                'required' => true, // Champs requis
                'constraints' => [
                    new NotBlank(),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Credit::class,
        ]);
    }
}
