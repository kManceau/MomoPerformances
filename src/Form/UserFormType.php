<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'attr' => [
                    'autocomplete' => 'username',
                    'class' => 'form-control',
                ],
                'label' => 'Nom d\'utilisateur',
                'label_attr' => ['class' => 'form-label']
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'autocomplete' => 'email',
                    'class' => 'form-control',
                ],
                'label' => 'Adresse email',
                'label_attr' => ['class' => 'form-label']
            ])
            ->add('avatar', FileType::class, [
                'label' => 'Choisir un avatar',
                'mapped' => false,
                'required' => false,
                'attr' => ['class' => 'form-control my-2'],
                'constraints' => [
                    new File([
                        'maxSize' => '64M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/svg+xml',
                            'image/webp',
                            'image/avif'
                        ],
                        'mimeTypesMessage' => 'Le format de l\'image n\'est pas valide.',
                    ])
                ]
            ])
//            ->add('oldPassword')
//            ->add('newPassword', RepeatedType::class, [
//                'type' => PasswordType::class,
//                'invalid_message' => 'Les mots de passe doivent correspondre.',
//                'options' => ['attr' => ['class' => 'form-control', 'autocomplete' => 'new-password']],
//                'required' => true,
//                'first_options'  => [
//                    'label' => 'Nouveau mot de passe',
//                    'label_attr' => ['class' => 'form-label']
//                ],
//                'second_options' => [
//                    'label' => 'Confirmer le nouveau mot de passe',
//                    'label_attr' => ['class' => 'form-label']
//                ],
//                'mapped' => false,
//                'constraints' => [
//                    new NotBlank([
//                        'message' => 'Veuillez entrer un mot de passe',
//                    ]),
//                    new Length([
//                        'min' => 6,
//                        'minMessage' => 'Le mot de passe doit comporter au moins {{ limit }} caractères',
//                        'max' => 4096,
//                    ])
//                ]
//            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Modifier',
                'attr' => [
                    'class' => 'btn btn-primary',
                ]
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
