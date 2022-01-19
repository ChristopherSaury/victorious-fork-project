<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('lastname', TextType::class,[
            'label' => 'Nom* :',
            'attr' => ['placeholder' => 'Entrer votre nom']
        ])
        ->add('firstname', TextType::class,[
            'label' => 'Prénom* :',
            'attr' => ['placeholder' => 'Entrer votre prénom']
        ])
        ->add('phone', TextType::class,['label' => 'numéro de téléphone (facultatif):',
        'required' => false,
                'attr' => ['placeholder' => 'Entrer votre numéro de téléphone']])
        ->add('email', TextType::class,[ 'label' => 'Email* :', 'attr' => ['placeholder' => 'Entrer votre adresse email']])
        ->add('useTerms', CheckboxType::class, [
            'label' => 'J\'ai lu et j\'accepte les conditions générales d\'utilisations',
            'required' => true,
            'constraints' => [
                new IsTrue([
                    'message' => 'Vous devez accepter les conditions d\'utilisation.',
                ]),
            ],
        ])
        ->add('plainPassword', RepeatedType::class, [
            'type' => PasswordType::class,
            'invalid_message' => 'Les champs mot de passe et confirmation doivent être identique',
            'options' => ['attr' => ['class' => 'password-field', 'placeholder' => 'Votre mot de passe']],
            'required' => true,
            'first_options'  => ['label' => 'Mot de passe* :',],
            'second_options' => ['label' => 'Confirmer mot de passe* :'],
            'mapped' => false,
            'attr' => ['autocomplete' => 'new-password'],
            'constraints' => [
                new NotBlank([
                    'message' => 'Veuillez entrer un mot de passe',
                ]),
                new Length([
                    'min' => 6,
                    'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} caractères',
                    // max length allowed by Symfony for security reasons
                    'max' => 20,
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
