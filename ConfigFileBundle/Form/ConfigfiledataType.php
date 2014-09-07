<?php
namespace HegesApp\ConfigFileBundle\Form;
use Doctrine\ORM\EntityRepository;



use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ConfigfiledataType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {

    	$varconfigfieldid=$options['configfieldid'];
    	

            $builder
            ->add('value')
            ->add('creationtime','datetime',array('widget' => 'single_text','read_only' => true))
            ->add('previousvalue','text',array('read_only' => true))
            ->add('updatetime','datetime',array('widget' => 'single_text','read_only' => true))
            ->add('fkConfigfield','entity',array('label'=> 'Field', 'class' => 'HegesAppConfigFileBundle:Configfield'))
            ->add('fkConfigline','hidden')
            ->add('fkCreationuser','entity',array('label'=> 'Creation User', 'class' => 'HegesAppUserBundle:User'))
            ->add('fkUpdateuser','entity',array('label'=> 'Update User', 'class' => 'HegesAppUserBundle:User'))

            //->add('serviceid','hidden',array("property_path" => false,'data'=>))
            ->add('linetypeid','hidden',array("property_path" => false,))
            ->add('numfields','hidden',array("property_path" => false,))
            ->add('configfieldid','hidden',array("property_path" => false,))
            ->add('lineid','hidden',array("property_path" => false,))
            ->add('fieldorder','hidden',array("property_path" => false,))
            ;
            
            
	    	/* DATOS USUARIO */
/* 	    	->add('fkCreationuser','entity',array('label'=> 'Creation User', 'class' => 'HegesAppUserBundle:User'))
            ->add('fkUpdateuser','entity',array('label'=> 'Update User', 'class' => 'HegesAppUserBundle:User')) */
      

        
    }

    public function getName()
    {
        return 'hegesapp_configfilebundle_datatype_form';
    }
    

    public function getDefaultOptions(array $options){
    	return array('data_class'=>'HegesApp\ConfigFileBundle\Entity\Data',);
    	//return array('data_class'=>'HegesApp\ConfigFileBundle\Entity\Data','configfieldid'=>0,'configfieldname'=>null);
    	 
    
    }
    
}
