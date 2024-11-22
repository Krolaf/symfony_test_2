<?php

namespace App\Form;

use App\Entity\Mercenheros;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MercenheroType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Name',
            ])
            ->add('isAvailable', CheckboxType::class, [
                'label' => 'Disponible',
                'required' => false,
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Biography',
            ])
            ->add('etat', TextType::class, [
                'label' => 'State',
            ])
            ->add('createdAt', DateTimeType::class, [
                'widget' => 'single_text', // Utilise un input HTML5
                'label' => 'Date de création',
                'required' => false, // Facultatif car il est généré automatiquement
            ])
            ->add('munitions', IntegerType::class, [
                'label' => 'Ammunitions',
            ])
            ->add('lifePoints', IntegerType::class, [
                'label' => 'Life Points',
            ])
            ->add('lvl', IntegerType::class, [
                'label' => 'Level',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Mercenheros::class,
        ]);
    }
}
