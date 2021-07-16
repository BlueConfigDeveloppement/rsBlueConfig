<?php

namespace App\Form;

use App\Entity\UserProfil;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Vich\UploaderBundle\Form\Type\VichFileType;

class UserProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'gender', ChoiceType::class, [
                    'attr' => [
                      'class' => 'form-control'
                    ],
                    'label' => 'Civilité :',
                    'choices' => ['Monsieur' => 'Mr.', 'Madame' => 'Mme', 'Mademoiselle' => 'Mlle'],
                    'placeholder' => 'Choisissez la civilitée',
                    'required'   => true,
                ]
            )
            ->add('lastname', TextType::class, [
                'attr' => array(
                    'placeholder' => 'Inscrivez votre nom',
                    'class' => 'form-control',
                ),
                'label' => 'Nom :',
            ])
            ->add('firstname', TextType::class, [
                'attr' => array(
                    'placeholder' => 'Inscrivez votre prénom',
                    'class' => 'form-control',
                ),
                'label' => 'Prénom :',
            ])
            ->add('phone', IntegerType::class, [
                'required' => false,
                'attr' => array(
                    'placeholder' => 'Inscrivez votre numéro de Fixe',
                    'class' => 'form-control',
                ),
                'label' => 'Téléphone Fixe :',
            ])
            ->add('cellphone', IntegerType::class, [
                'required' => false,
                'attr' => array(
                    'placeholder' => 'Inscrivez votre téléphone portable',
                    'class' => 'form-control',
                ),
                'label' => 'Téléphone Portable :',
            ])
            ->add('naissanceAt', BirthdayType::class, [
                'attr' => array(
                    'placeholder' => 'Inscrivez la date de naissance de l\'utilisateur dd/mm/yyyy',
                    'class' => 'form-control',
                    'title' => 'Date de naissance'
                ),
                'widget' => "single_text",
                'label' => 'Date de naissance: ',
                'required' => false
            ])

            ->add('address', TextType::class, [
                'required' => false,
                'attr' => array(
                    'placeholder' => 'Inscrivez votre adresse',
                    'class' => 'form-control',
                ),
                'label' => 'Adresse :',
            ])
            ->add('zipcode', IntegerType::class, [
                'required' => false,
                'attr' => array(
                    'placeholder' => 'Inscrivez votre code postal',
                    'class' => 'form-control',
                ),
                'label' => 'Code Postal :',
            ])
            ->add('city' , TextType::class, [
                'required' => false,
                'attr' => array(
                    'placeholder' => 'Inscrivez votre ville',
                    'class' => 'form-control',
                ),
                'label' => 'Ville :',
            ])
            ->add('imageFile', VichFileType::class, [
                'required' => false,
                'label' => 'Image de profil'
            ])
            ->add('email', TextType::class, [
                'mapped' => false,
                'required' => false,
                'attr' => array(
                    'placeholder' => 'Inscrivez votre email',
                    'class' => 'form-control',
                ),
                'label' => 'Email :',
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'label' => 'Mot de passe :',
                'mapped' => false,
                'attr' => [
                    'autocomplete' => 'new-password',
                     'placeholder' => 'Inscrivez votre mot de passe',
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Votre mot de passe doit comporter au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                    new Regex([
                        'pattern' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/i',
                        'htmlPattern' => '^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$',
                        'message' => 'Votre mot de passe doit comporter au moins une minuscule, une majuscule, un chiffre et un caractère spécial ',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserProfil::class,
        ]);
    }
}
