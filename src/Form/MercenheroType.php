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
                'attr' => [
                    'placeholder' => 'Nom du Mercenhero',
                    'class' => 'form-control',
                ],
            ])
            ->add('isAvailable', CheckboxType::class, [
                'label' => 'Disponible',
                'required' => false,
                'attr' => [
                    'class' => 'form-check-input',
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Biography',
                'attr' => [
                    'placeholder' => 'Biographie du Mercenhero',
                    'rows' => 5,
                    'class' => 'form-control',
                ],
            ])
            ->add('etat', TextType::class, [
                'label' => 'State',
                'attr' => [
                    'placeholder' => 'État (ex. : prêt, blessé)',
                    'class' => 'form-control',
                ],
            ])
            ->add('createdAt', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Date de création',
                'required' => false,
                'attr' => [
                    'readonly' => true,
                    'class' => 'form-control',
                ],
            ])
            ->add('munitions', IntegerType::class, [
                'label' => 'Ammunitions',
                'attr' => [
                    'placeholder' => 'Quantité de munitions',
                    'class' => 'form-control',
                ],
            ])
            ->add('lifePoints', IntegerType::class, [
                'label' => 'Life Points',
                'attr' => [
                    'placeholder' => 'Points de vie',
                    'class' => 'form-control',
                ],
            ])
            ->add('lvl', IntegerType::class, [
                'label' => 'Level',
                'attr' => [
                    'placeholder' => 'Niveau du Mercenhero',
                    'class' => 'form-control',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Mercenheros::class,
        ]);
    }
}