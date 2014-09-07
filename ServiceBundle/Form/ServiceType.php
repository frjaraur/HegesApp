<?php

namespace HegesApp\ServiceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ServiceType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('name','text',array('label' =>'Service Name'))
            ->add('description','text',array('label' =>'Service Description','required'=>'false'))
            ->add('servicetest','text',array('label' =>'Service TEST'))
            ->add('configfilename','text',array('label' =>'Configuration File Name','required'=>'false'))
            ->add('fkNode','entity',array('label'=> 'Node Service Owner', 'class' => 'HegesAppNodeBundle:Node','empty_value' => 'Select Node Name',))
            ->add('fkMonitor','entity',array('label'=> 'Monitor Name', 'class' => 'HegesAppMonitorBundle:Monitor','empty_value' => 'Select Monitor Name',))
        ;
    }

    public function getName()
    {
        return 'hegesapp_servicebundle_servicetype';
    }
}
