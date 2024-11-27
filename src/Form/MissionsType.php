<?php

namespace App\Form;

use App\Entity\Missions;
use App\Entity\Competences;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MissionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre de la mission',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => false,
            ])
            ->add('location', TextType::class, [
                'label' => 'Lieu',
            ])
      
            ->add('completionTime', IntegerType::class, [
                'label' => 'Temps d\'accomplissement (en minutes)',
                'required' => false,
            ])
            ->add('requiredCompetences', EntityType::class, [
                'class' => Competences::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => false, // true pour afficher des cases à cocher
                'label' => 'Compétences requises',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Missions::class,
        ]);
    }
}
