<?php

namespace App\Form;

use App\Entity\Investissement;
use App\Entity\User;
use App\Entity\Projet;
use App\Repository\UserRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;

class Investissement1Type extends AbstractType
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('montant')
            ->add('dateInv', null, [
                'constraints' => [
                    new NotBlank(),
                    new GreaterThanOrEqual(['value' => 'today']),

                ],
                'label' => 'Investment Date',
                'widget' => 'single_text',
            ])
            ->add('periode', ChoiceType::class, [
                'choices' => $this->getPeriodeChoices(),
                'label' => 'Period',
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'required' => false,
                'choice_label' => 'nomUser',
                'placeholder' => 'Select a user',
                'label' => 'User',
            ])
            ->add('projet', EntityType::class, [
                'class' => Projet::class,
                'choice_label' => 'nomProjet',
                'required' => false,
                'placeholder' => 'Select a project',
                'label' => 'Project',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Investissement::class,
        ]);
    }

    private function getPeriodeChoices(): array
    {
        $choices = [];
        $current = 6; // Start from 6 months
        while ($current <= 60) { // Up to 5 years
            $years = floor($current / 12);
            $months = $current % 12;
            $label = '';
            if ($years > 0) {
                $label .= $years . ' year' . ($years > 1 ? 's' : '');
            }
            if ($months > 0) {
                $label .= ($years > 0 ? ' ' : '') . $months . ' month' . ($months > 1 ? 's' : '');
            }
            $choices[$label] = $current;
            $current += 3; // Increment by 3 months
        }
        return $choices;
    }
}
