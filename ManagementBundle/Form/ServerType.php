<?php

namespace HegesApp\ManagementBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ServerType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('name','text',array('label' =>'Nombre del Servidor'))
            ->add('description','text',array('label' =>'Descripción y Rol en el entorno'))
            ->add('ip','text',array('label' =>'IP'))
            ->add('fkNodetype','entity',array('label'=> 'Tipo de nodo', 'class' => 'HegesAppNodeBundle:Nodetype','empty_value' => 'Seleccionar el tipo de nodo',))
            ->add('fkOs','entity',array('label'=> 'Sistema Operativo', 'class' => 'HegesAppNodeBundle:Os','empty_value' => 'Seleccionar Sistema Operativo',))
            ->add('serverurl','text',array('label' =>'URL de Acceso'))
        ;
    }

    public function getName()
    {
        return 'hegesapp_managementbundle_servertype';
    }
}
