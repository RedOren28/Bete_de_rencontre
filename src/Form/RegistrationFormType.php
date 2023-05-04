<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nom', TextType::class,[
                'label' => 'Nom :',
                'attr' => [
                    'placeholder' => 'Pierre'
                ],
            ])
            ->add('Prenom', TextType::class,[
                'label' => 'Prénom :',
                'attr' => [
                    'placeholder' => 'Dupont'
                ],
            ])
            ->add('Adresse', TextType::class,[
                'label' => 'Adresse :',
                'attr' => [
                    'placeholder' => '5 rue de la paix'
                ],
            ])
            ->add('Email', TextType::class,[
                'label' => 'Email :',
                'attr' => [
                    'placeholder' => 'pierre.dupont@gmail.com'
                ],
            ])
            ->add('Password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'label' => 'Mot de Passe',
                    'attr' => [
                        'placeholder' => '*************'
                    ],
                    'mapped' => false,
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Veuillez entrer un mot de passe',
                        ]),
                        new Length([
                            'min' => 8,
                            'minMessage' => 'Votre mot de passe doit comporter au moins {{ limit }} caractères',
                            'max' => 25,
                        ]),
                    ],
                ],
                'second_options' => [
                    'label' => 'Confirmation du Mot de Passe',
                    'attr' => [
                        'placeholder' => '*************'
                    ],
                    'mapped' => false,
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Veuillez entrer à nouveau votre mot de passe',
                        ]),
                    ],
                ],
                'invalid_message' => 'Les mots de passe ne se correspondent pas.'
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'label' => 'J\'accepte les conditions générales ainsi que les politiques de confidentialités.',
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter nos conditions de politiques et de confidentialité.',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
