<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Karser\Recaptcha3Bundle\Form\Recaptcha3Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Karser\Recaptcha3Bundle\Validator\Constraints\Recaptcha3;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('nom', TextType::class, [
            'attr' => array(
                'placeholder' => 'Nom',
                'class' => 'form-control mb-3',
            ),
            'label' => false,
            'mapped' => false,
        ])
            ->add('prenom', TextType::class, [
                'attr' => array(
                    'placeholder' => 'Prénom',
                    'class' => 'form-control mb-3',
                ),
                'label' => false,
                'mapped' => false,
            ])
            ->add('objet', TextType::class, [
                'attr' => array(
                    'placeholder' => 'Objet',
                    'class' => 'form-control mb-3',
                ),
                'label' => false,
                'mapped' => false,
            ])
            ->add('email', EmailType::class, [
                'attr' => array(
                    'placeholder' => 'E-mail',
                    'class' => 'form-control mb-3',
                ),
                'label' => false,
                'mapped' => false,
            ])
            ->add('message', TextareaType::class, [
                'attr' => array(
                    'placeholder' => 'Votre texte ici',
                    'class' => 'form-control mb-3',
                ),
                'label' => false,
                'mapped' => false,
            ])
            ->add('captcha', Recaptcha3Type::class, [
                'constraints' => new Recaptcha3(),
                'action_name' => 'contact',
                'script_nonce_csp' => '',
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
