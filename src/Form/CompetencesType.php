<?php

namespace App\Form;

use App\Entity\Competences;
use App\Entity\Mercenheros;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompetencesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de la compétence',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => false,
            ])
            ->add('lvl', IntegerType::class, [
                'label' => 'Niveau',
                'attr' => ['min' => 1, 'max' => 10],
            ])
            ->add('mercenheros', EntityType::class, [
                'class' => Mercenheros::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => false, // Utiliser un select au lieu de checkboxes
                'label' => 'Héros associés',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Competences::class,
        ]);
    }
}
