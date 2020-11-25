<?php

namespace App\Form;

use App\Entity\Administrador;
use App\Entity\Usuario;
use App\Entity\Tipo;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;


class UsuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre',TextType::class,['label'=>'Nombre','required'=>true,'constraints' => [new Length(['min' => 3])]])
            ->add('mail')
            ->add('adress')
            ->add('phone')
            ->add('tipo',EntityType::class,['class'=>Tipo::class,'choice_label'=>'nombre','required'=>true,'constraints' =>[new NotBlank()]])
            ->add('admin',EntityType::class,['class'=>Administrador::class,'choice_label'=>'nombre','label'=>'Administrador'])
            ->add('enviar',SubmitType::class)
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Usuario::class,
        ]);
    }
}
