<?php

namespace HegesApp\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class UserType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('description')
        ;
    }

    public function getName()
    {
        return 'hegesapp_userbundle_usertype';
    }
}
