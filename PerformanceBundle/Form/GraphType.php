<?php
namespace HegesApp\PerformanceBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityRepository;

class GraphType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('graphname','text',array('label' =>'Nombre Gráfica'))
            ->add('graphdescription','text',array('label' =>'Descripción'))
            ->add('graphtemplate','text',array('label' =>'Plantilla (Gráficas Locales)'))
            ->add('graphurl','text',array('label' =>'URL Asociada (Utilizar USERNAME, PASSWORD y HOSTNAME como variables)'))
            ->add('graphurluser','text',array('label' =>'Usuario para la URL Asociada','required'=>false))
            ->add('graphurlpasswd','text',array('label' =>'Passwd para la URL Asociada','required'=>false))
            ->add('graphicon','text',array('label' =>'Icono Asociado'))
            //->add('fknodeid','entity',array('label'=> 'Seleccionar un Nodo si es especifica para él', 'class' => 'HegesAppNodeBundle:Node','empty_value' => '','required'=>false))
        	->add('fkosid','entity',array('label'=> 'Seleccionar un Sistema Operativo  si es genérica', 'class' => 'HegesAppNodeBundle:Os','empty_value' => '','required'=>false))
            ->add('fknodeid','entity',array('label'=> 'Seleccionar un Nodo si es especifica para él', 
            		'class' => 'HegesAppNodeBundle:Node',
            		'empty_value' => '',
            		'required'=>false,
            		'query_builder'=>function(EntityRepository $er){
            			return $er->createQueryBuilder('a')->orderBy('a.name','ASC');
        			}
        			))
            
            
        ;
    }

    public function getName()
    {
        return 'hegesapp_performancebundle_graphtype';
    }
}
