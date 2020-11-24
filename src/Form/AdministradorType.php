<?php

namespace App\Form;

use App\Entity\Administrador;
use App\Entity\Tipo;
use Doctrine\DBAL\Types\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
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
                'choices' => ['Administradores' => ['principal' => Administrador::PRINCIPAL, 'admin' => Administrador::ADMIN,],
                    'Empleados' => ['of1' => Administrador::OF1, 'of2' => Administrador::OF2,],],])
            ->add('categoria',HiddenType::class)
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
