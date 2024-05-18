<?php

namespace App\Form;

use App\Entity\Admin;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class AdminFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('login',EmailType::class, [

                'attr' => ['class' => 'form-control', 'placeholder' => 'email addr'],
            ])
            ->add('password',PasswordType::class, ['attr' => ['class' => 'form-control', 'placeholder' => 'password']])
            ->add('submit', SubmitType::class, [
                'label' => 'Connexion',
                'attr' => ['class' => 'btn btn-primary'],
            ])
        ->add('reset', ResetType::class, [
        'label' => 'Effacer',
        'attr' => ['class' => 'btn btn-danger'],
    ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Admin::class,
        ]);
    }
}
