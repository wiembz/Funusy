<?php

namespace App\Form;

use App\Entity\Commentaire;
use App\Entity\Projet;
use Symfony\Component\Form\Extension\Core\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('contenue')
            ->add('dateCommentaire')
            ->add('idProjet', EntityType::class, [
                'class' => Projet::class,
                'choice_label' => 'nomProjet',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commentaire::class,
        ]);
    }
}
