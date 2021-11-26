<?php

namespace App\Form;

use App\Entity\Facture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
class LocationVehiculeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nb',IntegerType::class ,[
                'mapped'=> false,
                'required'=> true,
                'constraints' => [
                    new GreaterThan(['value' => 0,
                        'message' => "La quantité doit être supérieure à 0"]
                    )
                ]
            ])
            ->add('DateD', DateType::class, [
                'widget' => 'single_text',
                'required'=> true               
            ])
            ->add('DateF', DateType::class, [
                'widget' => 'single_text',
                'required'=> false,
                'empty_data' => ''
            ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Facture::class,
        ]);
    }
}