<?php

namespace HegesApp\ConfigFileBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ConfiglineType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('fkService')
            ->add('Data','collection',
            		array('type'=>new DataType(),'prototype'=>true,
            				'allow_add'=>true,
            				'allow_delete'=>true,
            		)
            		)
            		;
            		
           /*  		,
            		'prototype'=>true,

            		'options'=> array('data_class'=>'HegesApp\ConfigFileBundle\Entity\Data'), */
    }

    public function getName()
    {
        return 'hegesapp_configfilebundle_configlinetype';
    }
    
    public function getDefaultOptions(array $options)
    {
    	return array('data_class'=>'HegesApp\ConfigFileBundle\Entity\Configline',);
    }
}
