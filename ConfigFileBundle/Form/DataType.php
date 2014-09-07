<?php

namespace HegesApp\ConfigFileBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class DataType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('value')
            ->add('creationtime','datetime',array('widget' => 'single_text','read_only' => true)) 
            ->add('previousvalue','text',array('read_only' => true))
            ->add('updatetime','datetime',array('widget' => 'single_text','read_only' => true))
           ->add('fkConfigfield','entity',array('label'=> 'Field', 'class' => 'HegesAppConfigFileBundle:Configfield','read_only' => true))
          //  ->add('fkConfigline','entity',array('label'=> 'Configline', 'class' => 'HegesAppConfigFileBundle:Configline'))
	    	->add('fkCreationuser','entity',array('label'=> 'Creation User', 'class' => 'HegesAppUserBundle:User','read_only' => true))
            ->add('fkUpdateuser','entity',array('label'=> 'Update User', 'class' => 'HegesAppUserBundle:User','read_only' => true))
        ;
        

    }

    public function getName()
    {
        return 'hegesapp_configfilebundle_datatype';
    }
    

    public function getDefaultOptions(array $options){
    	return array('data_class'=>'HegesApp\ConfigFileBundle\Entity\Data',);
    }
}
