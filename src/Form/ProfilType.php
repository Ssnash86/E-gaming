<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('email')
            
            ->add('ville', TextType::class,[
                'mapped' => false,
                'required'   => false,
            ])
            ->add('cp', NumberType::class,[
                'mapped' => false,
                'required'   => false,
            ])
            ->add('nom', TextType::class,[
                'mapped' => false,
                'required'   => false,
            ])
            ->add('prenom', TextType::class,[
                'mapped' => false,
                'required'   => false,
            ])
            ->add('tel', NumberType::class,[
                'mapped' => false,
                'required'   => false,
            ])
            ->add('adresse', TextType::class,[
                'mapped' => false,
                'required'   => false,
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
