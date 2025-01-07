<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ConfigUploadFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('config', FileType::class, [
                'label' => 'Fichier de configuration (format Zip ou RAR, max 500 Mo)',
                'mapped' => false,
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                ],
                'label_attr' => ['class' => 'form-label'],
                'constraints' => [
                    new File([
                        'maxSize' => '500M',
                        'mimeTypes' => [
                            'application/zip',
                            'application/vnd.rar',
                        ],
                        'mimeTypesMessage' => 'Veuillez uploader un fichier zip ou rar',
                    ])
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer',
                'attr' => [
                    'class' => 'btn btn-primary',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
