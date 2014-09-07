<?php

namespace HegesApp\NodeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class NodeType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('name','text',array('label' =>'Nombre del Nodo'))
            ->add('description','text',array('label' =>'Descripción'))
            ->add('ip','text',array('label' =>'IP'))
            ->add('fkNodetype','entity',array('label'=> 'Tipo de Nodo', 'class' => 'HegesAppNodeBundle:Nodetype','empty_value' => 'Seleccionar Tipo de Nodo',))
            ->add('fkOs','entity',array('label'=> 'Sistema Operativo', 'class' => 'HegesAppNodeBundle:Os','empty_value' => 'Seleccionar Sistema Operativo',))
        ;
    }

    public function getName()
    {
        return 'hegesapp_nodebundle_nodetype';
    }
}
