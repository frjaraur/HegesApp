<?php

namespace HegesApp\AlarmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use HegesApp\AlarmsBundle\Entity\Alarm;
use HegesApp\AlarmsBundle\Form\AlarmType;

/**
 * Alarm controller.
 *
 */
class AlarmController extends Controller
{

	public function indexAction()
	{
		return $this->render('HegesAppAlarmsBundle:Alarm:main.html.twig');

	}
	
    public function ovoalarmsAction($ovoprofile)
    {


    	
    	$em = $this->getDoctrine()->getEntityManager();
        
                        
                $param_ovo_db_host = $this->container->getParameter('ovo_db_host');
                $param_ovo_db_instance = $this->container->getParameter('ovo_db_instance');
                $param_ovo_db_user = $this->container->getParameter('ovo_db_user');
                $param_ovo_db_passwd = $this->container->getParameter('ovo_db_passwd');
        
    	$msg_entities = $em->getRepository('HegesAppAlarmsBundle:Alarm')
    	->getOvoalarms($param_ovo_db_host,$param_ovo_db_instance,$param_ovo_db_user,$param_ovo_db_passwd,$ovoprofile);
	  
    		 return $this->render('HegesAppAlarmsBundle:Alarm:opealarms.html.twig',
    		 		 array('entities'=> $msg_entities,));
    	
    }
    
    public function ovonodeactalarmsAction($nodename)
    {
    	$param_ovo_db_host = $this->container->getParameter('ovo_db_host');
        $param_ovo_db_instance = $this->container->getParameter('ovo_db_instance');
        $param_ovo_db_user = $this->container->getParameter('ovo_db_user');
        $param_ovo_db_passwd = $this->container->getParameter('ovo_db_passwd');
    	$em = $this->getDoctrine()->getEntityManager();
    	$msg_entities = $em->getRepository('HegesAppAlarmsBundle:Alarm')
    	->getOvonodeactalarms($param_ovo_db_host,$param_ovo_db_instance,$param_ovo_db_user,$param_ovo_db_passwd,$nodename);
    
    	if (!$msg_entities){
    		
    		$this->get('session')->setFlash('error', 'No existen alarmas activas para el nodo '.$nodename);

    		$node_entity = $em->getRepository('HegesAppNodeBundle:Node')->findOneByName($nodename);
    		
    		if (!$node_entity){throw $this->createNotFoundException('AlarmController :: ovonodeactalarmsAction :: No existe un nodo con nombre '.$nodename);}
    		
    		return $this->forward('HegesAppAlarmsBundle:Alarm:ovonodeindex');

    	}	
    	
    	return $this->render('HegesAppAlarmsBundle:Alarm:nodeactalarms.html.twig',
    			array('entities'=> $msg_entities,));
    	 
    }
    
    public function ovonodehistalarmsAction($nodename)
    {
    	$param_ovo_db_host = $this->container->getParameter('ovo_db_host');
        $param_ovo_db_instance = $this->container->getParameter('ovo_db_instance');
        $param_ovo_db_user = $this->container->getParameter('ovo_db_user');
        $param_ovo_db_passwd = $this->container->getParameter('ovo_db_passwd');
    	$em = $this->getDoctrine()->getEntityManager();
    	$msg_entities = $em->getRepository('HegesAppAlarmsBundle:Alarm')
    	->getOvonodehistalarms($param_ovo_db_host,$param_ovo_db_instance,$param_ovo_db_user,$param_ovo_db_passwd,$nodename);
    
    	if (!$msg_entities){
    
    		$this->get('session')->setFlash('error', 'No existen alarmas históricas para el nodo '.$nodename);
    
    		$node_entity = $em->getRepository('HegesAppNodeBundle:Node')->findOneByName($nodename);
    
    		if (!$node_entity){
    			throw $this->createNotFoundException('AlarmController :: ovonodehistalarmsAction :: No existe un nodo con nombre '.$nodename);
    		}
    
    		return $this->forward('HegesAppAlarmsBundle:Alarm:ovonodeindex');
    
    	}
    	 
    	return $this->render('HegesAppAlarmsBundle:Alarm:nodehistalarms.html.twig',
    			array('entities'=> $msg_entities,));
    
    }
    
    public function ovonodeindexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entities = $em->getRepository('HegesAppNodeBundle:Node')
        ->getAllNodes();
        
        return $this->render('HegesAppAlarmsBundle:Alarm:nodeindex.html.twig', array(
        		'entities' => $entities
        ));
    }
    
}
