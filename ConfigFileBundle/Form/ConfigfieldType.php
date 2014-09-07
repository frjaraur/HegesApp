<?php

namespace HegesApp\ConfigFileBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ConfigfieldType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('fieldorder')
            ->add('fieldname')
            ->add('fielddesc')
            ->add('fkConfiglinetype')
        ;
    }

    public function getName()
    {
        return 'hegesapp_configfilebundle_configfieldtype';
    }
}
