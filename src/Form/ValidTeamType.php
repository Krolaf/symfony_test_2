<?php

namespace App\Form;

use App\Entity\Team;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ValidTeamType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('team', EntityType::class, [
                'class' => Team::class, // Entité Team
                'choice_label' => 'name', // Affiche le champ "name" des équipes
                'placeholder' => 'Choisissez une équipe', // Option par défaut
                'label' => 'Équipe disponible', // Label pour le champ
                'required' => true, // Le champ est obligatoire
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Assigner cette équipe',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null, // Pas besoin de lier à l'entité Team directement
        ]);
    }
}
