<?php

namespace App\Form;

use App\Entity\Bureau;
use App\Entity\Personnel;
use App\Entity\Statut;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class PersonnelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class,[
                'label' =>'Nom: '
            ])
            ->add('prenom', TextType::class, [
                'label'=> 'Prénom: '
            ])
            ->add('dateStart', null, [
                'widget' => 'single_text',
                'label'=> "Date d'entrée: "
            ])
            ->add('dateEnd', null, [
                'widget' => 'single_text',
                'label'=> "Date de départ: "
            ])
            ->add('telephone',TextType::class, [
                'label'=> 'téléphone:'
            ])
            ->add('mail',EmailType::class,[
                'label'=> 'Mail:'
            ])
            ->add('statut', EntityType::class, [
                'class' => Statut::class,
                'choice_label' => 'name',
                'label'=> 'Statut: '
            ])
            ->add('bureau', EntityType::class, [
                'class' => Bureau::class,
                'choice_label' => 'num_bureau',
                'label'=> 'Bureau: '
            ])
            ->add('Valider',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Personnel::class,
        ]);
    }
}
