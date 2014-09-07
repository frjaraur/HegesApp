<?php

namespace HegesApp\MonitorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class MonitorType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
        	->add('name','text',array('label' =>'Nombre del Monitor'))
            ->add('execname','text',array('label' =>'Ejecutable o Script Asociado'))
            ->add('params','text',array('label' =>'Parámetros'))
            ->add('description','text',array('label' =>'Descripción'))
            ->add('lastversion','text',array('label' =>'Última Versión Disponible'))
        ;
    }

    public function getName()
    {
        return 'hegesapp_monitorbundle_monitortype';
    }
}
