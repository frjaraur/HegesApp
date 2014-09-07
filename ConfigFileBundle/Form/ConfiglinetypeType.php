<?php

namespace HegesApp\ConfigFileBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ConfiglinetypeType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('fieldsnumber')
            ->add('delimiter')
            ->add('fkMonitor')
        ;
    }

    public function getName()
    {
        return 'hegesapp_configfilebundle_configlinetypetype';
    }
}
