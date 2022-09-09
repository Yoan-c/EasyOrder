<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Produit;
use Doctrine\ORM\EntityRepository;
use PhpParser\Node\Stmt\Label;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CategorieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('produits', EntityType::class, [
                'expanded' => false,
                "multiple" => true,
                'required' => true,
                'class' => Produit::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.label', 'ASC');
                },
                'attr' => [
                    'class' => 'select2'
                ]

            ])
            ->add("editer", SubmitType::class, [
                'label' => 'valider'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Categorie::class,
        ]);
    }
}
