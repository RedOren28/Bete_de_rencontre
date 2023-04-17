<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nom', TextType::class, Type::getConfiguration("Nom","Nom"))
            ->add('Prenom', TextType::class, Type::getConfiguration("Prenom","Prenom"))
            ->add('Date_Naissance', DateType::class, [
                'format' => 'dd / MM / yyyy',
                'years' => range(1920,2005),
                'placeholder' => [
                    'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
                ],
                'label' => 'Date de Naissance',
            ])
            ->add('Adresse', TextType::class, Type::getConfiguration("Adresse","Adresse"))
            ->add('Email', TextType::class, Type::getConfiguration("Email","Email"))
            ->add('Password', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'label' => 'Mot de Passe',
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password','placeholder' => "Mot de passe"],
                
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])

            /** AgreeTerms (CheckBox)
             * 
             * ->add('agreeTerms', CheckboxType::class, [
             *  'mapped' => false,
             *   'constraints' => [
             *       new IsTrue([
             *           'message' => 'You should agree to our terms.',
             *       ]),
             *   ],
             *])
             */
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}