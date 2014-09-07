<?php

namespace HegesApp\AlarmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class AlarmType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('alarmmsgid')
            ->add('alarmnode')
            ->add('alarmowned')
            ->add('alarmfirst')
            ->add('alarmlast')
            ->add('alarmseverity')
            ->add('alarmmsggrp')
            ->add('alarmapp')
            ->add('alarmobj')
            ->add('alarmtext')
            ->add('alarminstructions')
        ;
    }

    public function getName()
    {
        return 'hegesapp_alarmsbundle_alarmtype';
    }
}
