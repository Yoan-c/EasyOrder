<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('nom')
            ->add('prenom')
            ->add('adresse')
            ->add('ville')
            ->add('codePostal')
            ->add('Pays')
            ->add('dateNaissance', DateType::class, [
                'widget' => 'choice',
                'days' => range(1, 31),
                'years' => range(date("Y") - 100, date("Y") - 18)
            ])
            ->add('administrateur', ChoiceType::class, [
                'mapped' => false,
                'choices'  => [
                    'Maybe' => null,
                    'Yes' => true,
                    'No' => false,
                ]
            ])
            ->add("editer", SubmitType::class, [
                'label' => 'valider'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
