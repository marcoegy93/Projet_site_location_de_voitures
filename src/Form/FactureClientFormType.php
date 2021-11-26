<?php


namespace App\Form;

use App\Entity\Utilisateur;
use App\Entity\DonneesFactureClient;
use App\Repository\UtilisateurRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FactureClientFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('utilisateur', EntityType::class, [
                'class' => Utilisateur::class,
                'query_builder' => function (UtilisateurRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.prenom', 'ASC');
                },
                'choice_label' => function($utilisateur){
                    return $utilisateur->getPrenom()." ". $utilisateur->getNom();
                },
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DonneesFactureClient::class,
            'csrf_protection' => false
        ]);
    }

}