<?php

namespace App\Form;

use App\Entity\Mercenheros;
use App\Entity\Team;
use App\Repository\MercenherosRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TeamType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => 'Nom de l\'équipe',
            ])
            ->add('leader', EntityType::class, [
                'class' => Mercenheros::class,
                'choice_label' => 'name',
                'label' => 'Sélectionner un leader',
                'query_builder' => function (MercenherosRepository $repository) {
                    return $repository->createQueryBuilder('m')
                        ->where('m.munitions > 80');
                },
            ])
            ->add('members', EntityType::class, [
                'class' => Mercenheros::class,
                'choice_label' => 'name',
                'label' => 'Ajouter des membres',
                'multiple' => true,
                'expanded' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Team::class,
        ]);
    }
}
?>