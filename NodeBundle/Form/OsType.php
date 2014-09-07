<?php

namespace HegesApp\NodeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class OsType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder            
            ->add('name','text',array('label' =>'Nombre del Sistema Operativo'))
            ->add('longname','text',array('label' =>'Descriptción/Nomenclatura'))
            ->add('access','choice',array('label' =>'Tipo de Acceso', 'choices' => array('SSH'=>'SSH','SMB'=>'SMB')))
        ;

    }

    public function getName()
    {
        return 'hegesapp_nodebundle_ostype';
    }
}
