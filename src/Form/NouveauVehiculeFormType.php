<?php

namespace App\Form;

use App\Entity\Vehicule;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\Image;

class NouveauVehiculeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type')
            ->add('prix')
            ->add('categorie', ChoiceType::class, [
                'mapped' => false,
                'choices' => [
                    'Citadine' => 'Citadine',
                    'Course' => 'Course',
                    'MuscleCar' => 'MuscleCar',
                    'Berline' => 'Berline',
                    'Break' => 'Break',
                    'Monospace' => 'Monospace',
                    '4x4, SUV, Crossover' => '4x4, SUV, Crossover',
                    'Coupé' => 'Coupe',
                    'Cabriolet' => 'Cabriolet',
                    'Pick-up' => 'Pick-up'
                ]
            ])
            ->add('energie', ChoiceType::class, [
                'mapped' => false,
                'choices' => [
                    'Essence' => 'Essence',
                    'Diesel' => 'Diesel',
                    'GPL' => 'GPL'
                ]
            ])
            ->add('moteur', ChoiceType::class, [
                'mapped' => false,
                'choices' => [
                    'Thermique' => 'Thermique',
                    'Electrique' => 'Electrique',
                    'Hybride' => 'Hybride'
                ]
            ])
            ->add('boite', ChoiceType::class, [
                'mapped' => false,
                'choices' => [
                    'Manuelle' => 'Manuelle',
                    'Automatique' => 'Automatique'
                ]
            ])
            ->add('nb_portes', ChoiceType::class, [
                'mapped' => false,
                'choices' => [
                    '2 portes' => '2 portes',
                    '3 portes' => '3 portes',
                    '4 portes' => '4 portes',
                    '5 portes' => '5 portes'
                ]
            ])
            ->add('nb', IntegerType::class)
            ->add('photo', FileType::class, [
                'mapped' => false,
                'constraints' => [
                    new Image([
                        'maxSize' => '2048k',
                        'mimeTypesMessage' => '.png .jpg .jpeg uniquement',
                    ])
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Vehicule::class
        ]);
    }
}