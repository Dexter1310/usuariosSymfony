<?php

namespace App\Form;

use App\Entity\Administrador;
use App\Entity\Tipo;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\DependencyInjection\Tests\Compiler\E;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;


class FilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tipo',EntityType::class,['class'=>Tipo::class,'placeholder' => 'seleccione un tipo','required'=>false,'choice_label'=>'nombre','label'=>'Mostrar usuarios por tipo:'])
            ->add('admin',EntityType::class,['class'=>Administrador::class,'placeholder' => 'seleccione un administrador','required'=>false,'choice_label'=>'nombre','label'=>'Mostrar usuarios asociados al administrador:'])
            ->add('codigo',EntityType::class,['class'=>Tipo::class,'placeholder'=>'Selecciona por código','required'=>false,'choice_label'=>'id','label'=>'Mostrar usuarios asciados al código de tipo.'])
            ->add('Filtro',SubmitType::class);
    }
}
