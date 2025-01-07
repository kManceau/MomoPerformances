<?php

namespace App\Form;

use App\Entity\Page;
use EmilePerron\TinymceBundle\Form\Type\TinymceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditHomePageFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content', TinymceType::class,[
                'attr' => ['class' => 'my-2',
                    'height' => '100vh',
                    'toolbar' => 'undo redo | bold italic underline fontsizeinput forecolor | bullist numlist | link',
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Modifier la page',
                'attr' => ['class' => 'btn btn-primary button'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Page::class,
        ]);
    }
}
