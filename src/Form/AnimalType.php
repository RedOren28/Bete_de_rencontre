<?php

namespace App\Form;

use App\Entity\Poil;
use App\Entity\Animal;
use App\Entity\Couleur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AnimalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom :',
                'attr' => [
                    'placeholder' => 'Nom'
                ],
            ])
            ->add('Date_Naissance', DateType::class, [
                'format' => 'dd MM yyyy',
                'years' => range(2000, 2023),
                'placeholder' => [
                    'day' => 'Jour', 'month' => 'Mois', 'year' => 'Année',
                ],
                'label' => 'Date de Naissance',
            ])
            ->add('couleur', EntityType::class, [
                'label' => 'Couleur :',
                'class' => Couleur::class,
                'choice_label' => 'nom',
                'placeholder' => 'Sélectionnez une couleur',
            ])  
            ->add('poil', EntityType::class, [
                'label' => 'Type de poil :',
                'class' => Poil::class,
                'choice_label' => 'type',
                'placeholder' => 'Sélectionnez un type de poil',
            ])          
            ->add('vermifugation', ChoiceType::class, [
                'label' => 'Vermifugation à jour :',
                'choices' => [
                    'Oui' => true,
                    'Non' => false,
                ],
                'expanded' => true, // Pour afficher des boutons radio à la place de la checkbox
                'multiple' => false, // Un seul choix est possible
            ])
            ->add('vaccin', ChoiceType::class, [
                'label' => 'Vaccin à jour :',
                'choices' => [
                    'Oui' => true,
                    'Non' => false,
                ],
                'expanded' => true, // Pour afficher des boutons radio à la place de la checkbox
                'multiple' => false, // Un seul choix est possible
            ])
            ->add('puce_tatouage', TextType::class, [
                'label' => 'Numéro de puce / tatouage :',
                'attr' => [
                    'placeholder' => 'Puce / Tatouage'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Animal::class,
        ]);
    }
}
