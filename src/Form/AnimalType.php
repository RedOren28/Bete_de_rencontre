<?php

namespace App\Form;

use App\Entity\Animal;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
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
            ->add('sexe', ChoiceType::class, [
                'label' => 'Sexe :',
                'choices' => [
                    'Masculin' => false,
                    'Féminin' => true,
                ],
                'expanded' => true, // Pour afficher des boutons radio à la place de la checkbox
                'multiple' => false, // Un seul choix est possible
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
