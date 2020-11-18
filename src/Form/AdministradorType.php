<?php

namespace App\Form;

use App\Entity\Administrador;
use App\Entity\Tipo;
use Doctrine\DBAL\Types\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdministradorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('tipo',ChoiceType::class, [
                'choices' => [
                    'Administradores' => [
                        'principal' => 1,
                        'admin' => 2,
                    ],
                    'Empleados' => [
                        'of1' => 3,
                        'of2' => 4,
                    ],
                ],
            ])
            ->add('agregar',SubmitType::class)
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Administrador::class,
        ]);
    }
}
