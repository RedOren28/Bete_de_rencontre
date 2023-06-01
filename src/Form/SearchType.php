<?php

namespace App\Form;

use App\Entity\Poil;
use App\Entity\Race;
use App\Entity\Animal;
use App\Entity\Espece;
use App\Entity\Regime;
use App\Entity\Couleur;
use App\Data\SearchData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class SearchType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('q', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Rechercher'
                ]
            ])
            ->add('sexes', ChoiceType::class, [
                'label' => false,
                'multiple' => true,
                'choices' => [
                    'Masculin' => "1",
                    'Féminin' => "0",
                ],
                'expanded' => true
            ])
            ->add('vaccins', ChoiceType::class, [
                'label' => false,
                'multiple' => true,
                'choices' => [
                    'Oui' => "1",
                    'Non' => "0",
                ],
                'expanded' => true
            ])
            ->add('vermifugations', ChoiceType::class, [
                'label' => false,
                'multiple' => true,
                'choices' => [
                    'Oui' => "1",
                    'Non' => "0",
                ],
                'expanded' => true
            ])
            ->add('especes', EntityType::class, [
                'label' => false,
                'required' => false,
                'class' => Espece::class,
                'expanded' => false,
                'multiple' => true,
            ])
            ->add('races', EntityType::class, [
                'label' => false,
                'required' => false,
                'class' => Race::class,
                'expanded' => false,
                'multiple' => true,
            ])
            ->add('poils', EntityType::class, [
                'label' => false,
                'required' => false,
                'class' => Poil::class,
                'expanded' => false,
                'multiple' => true,
            ])
            ->add('couleurs', EntityType::class, [
                'label' => false,
                'required' => false,
                'class' => Couleur::class,
                'expanded' => false,
                'multiple' => true,
            ])
            ->add('regimes', EntityType::class, [
                'label' => false,
                'required' => false,
                'class' => Regime::class,
                'expanded' => false,
                'multiple' => true,
            ]) 
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchData::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }

}