<?php

namespace HegesApp\ConfigFileBundle\Controller;
use Symfony\Component\Security\Core\SecurityContext;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\BrowserKit\Response;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use HegesApp\ConfigFileBundle\Entity\Data;
use HegesApp\ConfigFileBundle\Entity\Configline;
use HegesApp\ServiceBundle\Entity\Service;

use HegesApp\ConfigFileBundle\Form\ConfigfiledataType;
use HegesApp\ConfigFileBundle\Form\DataType;


use HegesApp\MainBundle\HegesAppClasses\SMBClient;
use HegesApp\MainBundle\HegesAppClasses\HegesAppLog;

/**
 * Configfield controller.
 *
 */
class ConfigfileController extends Controller
{
    
	public function mainpageAction()
	{

                
		return $this->render('HegesAppConfigFileBundle:Configfile:main.html.twig');
	}
    
    
    
    /**
     * Lists all Configfield entities.
     *
     */
    public function indexAction()
   {
        
    
        $em = $this->getDoctrine()->getEntityManager();
        $entities = $em->getRepository('HegesAppNodeBundle:Node')
        ->getAllNodes();
        
        return $this->render('HegesAppConfigFileBundle:Configfile:index.html.twig', array(
        		'entities' => $entities, 'step'=>1
        ));
        
        
    }

    public function selectednodeidAction($nodeid)
    {
    	$em = $this->getDoctrine()->getEntityManager();
    
    	//$em = $this->getDoctrine()->getManager();
    	//$query = $em->createQuery('select p from HegesAppServiceBundle:Service p where p.fkNode = :nodeid ')->setParameter('nodeid', $nodeid);
    	
    	//$entities = $query->getResult();
        
        $node_entity=$em->getRepository('HegesAppNodeBundle:Node')->findOneById($nodeid);
        
        if (!$node_entity) {
    			
		        $entities = $em->getRepository('HegesAppNodeBundle:Node')->getAllNodes();
		        $this->get('session')->setFlash('error', 'No se encontraron servicios para el nodo.');
		        return $this->render('HegesAppConfigFileBundle:Configfile:index.html.twig', array(
		        		'entities' => $entities, 'step'=>1
		        ));
    			
    		}
        
    	$nodename=$node_entity->getName();
        
    	$entities = $em->getRepository('HegesAppServiceBundle:Service')->findByfkNode($nodeid);
    	
    		if (!$entities) {
    			//throw $this->createNotFoundException('Unable to find Services for this node.');
    			
		        $entities = $em->getRepository('HegesAppNodeBundle:Node')->getAllNodes();
		        $this->get('session')->setFlash('error', 'No se encontraron servicios para el nodo.');
		        return $this->render('HegesAppConfigFileBundle:Configfile:index.html.twig', array(
		        		'entities' => $entities, 'step'=>1
		        ));
    			
    		}
                
        
    		return $this->render('HegesAppConfigFileBundle:Configfile:index.html.twig', 
    				array('entities' => $entities, 
    						'nodeid'=>$nodeid,
                                                'nodename'=>$nodename,
    						'step'=>2
    				));
    }

    public function selectedserviceidAction($serviceid)
    {
    	
    	$em = $this->getDoctrine()->getEntityManager();
    	
        $service_entity = $em->getRepository('HegesAppServiceBundle:Service')->findOneById($serviceid);
	    	 
	    	if (!$service_entity) {
                    throw $this->createNotFoundException('ConfigfileController :: selectedserviceidAction :: No existe el servicio con id '.$serviceid);
	    	
	    	}
        $nodename=$service_entity->getFkNode()->getName();
        $nodeid=$service_entity->getFkNode()->getId();
        
    	$configlinetype_entity = $em->getRepository('HegesAppServiceBundle:Service')
    	->getconfiglinetypefromserviceid($serviceid);
		if (!$configlinetype_entity) {
                    	
                        $entities = $em->getRepository('HegesAppNodeBundle:Node')->getAllNodes();
		        $this->get('session')->setFlash('error', 'No existe fichero de configuración para el servicio.');
		        return $this->render('HegesAppConfigFileBundle:Configfile:index.html.twig', array(
		        		'entities' => $entities, 'step'=>1
		        ));
                    
			throw $this->createNotFoundException('ConfigfileController :: selectedserviceidAction :: No existe ningún tipo de lineas de configuracion para el servicio con id '.$serviceid);
		}
   		
    	$linetypeid=$configlinetype_entity->getId();


		
		
		$configfield_entities = $em->getRepository('HegesAppConfigFileBundle:Configfield')
		->findByfkConfiglinetype($linetypeid);
    
		
		$configdata_entities=$em->getRepository('HegesAppServiceBundle:Service')
		->getdatafromserviceid($serviceid);
		
		/* if (!$configdata_entities) {
			throw $this->createNotFoundException('Unable to find Data for this service'.$serviceid);
		}		 
 */
		
		
		//Comprobacion datos
		//if (!$entities) {
    	//	throw $this->createNotFoundException('Unable to find Configfield entity.');
    	//}
    	

    
    	return $this->render('HegesAppConfigFileBundle:Configfile:index.html.twig', array(
    			'step'=>3,
    			'configlinetype' => $configlinetype_entity,
    			'serviceid' => $serviceid, 
    			'linetypeid'=>$linetypeid,
    			'configfields'=>$configfield_entities,
    			'configdataentries'=>$configdata_entities,
                'nodename'=>$nodename,
                'nodeid'=>$nodeid

    	));
    }
    

   
   public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('HegesAppConfigFileBundle:Configfile')->find($id);
        
        if (!$entity) {
            throw $this->createNotFoundException('ConfigfileController :: selectedserviceidAction :: No existen lineas de configuracion');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('HegesAppConfigFileBundle:Configfile:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),

        ));
    }

    /**
     * Displays a form to create a new Configfield entity.
     *
     */
    /**
     * Edits an existing Configfield entity.
     *
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('HegesAppConfigFileBundle:Configfield')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('ConfigfileController :: updateAction :: No existen lineas de configuracion con id '.$id);;
        }

        $editForm   = $this->createForm(new ConfigfieldType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            $this->get('session')->setFlash('notice', 'Los cambios se realizaron correctamente.');

               $logsource="hegesapp_log_app";
                $hegesapplogentry = new HegesAppLog(
                    $this->container->getParameter('hegesapp_log_dir').$this->container->getParameter($logsource),
                    $this->container->get('security.context')->getToken()->getUser(),
                    $logsource);
                
                $hegesapplogentry->HegesAppLogWriteToLog("Se realizaron cambios en la linea ".$id.".");
                
                
            return $this->redirect($this->generateUrl('configfield_edit', array('id' => $id)));
        }

        return $this->render('HegesAppConfigFileBundle:Configfield:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Configfield entity.
     *
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('HegesAppConfigFileBundle:Configfield')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('ConfigfileController :: deleteAction :: No existen lineas de configuracion con id '.$id);;
            }

            $em->remove($entity);
            $em->flush();
            $this->get('session')->setFlash('notice', 'Los cambios se realizaron correctamente.');
            
                $logsource="hegesapp_log_app";
                $hegesapplogentry = new HegesAppLog(
                    $this->container->getParameter('hegesapp_log_dir').$this->container->getParameter($logsource),
                    $this->container->get('security.context')->getToken()->getUser(),
                    $logsource);
                
                $hegesapplogentry->HegesAppLogWriteToLog("Se borro la linea ".$id.".");
        }

        return $this->redirect($this->generateUrl('configfield'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
    
    public function errorAction()
    {
    	$em = $this->getDoctrine()->getEntityManager();
    
    	$entities = $em->getRepository('HegesAppNodeBundle:Node')->findAll();
    	$this->get('session')->setFlash('error', 'No se encontraron datos.');
    	return $this->render('HegesAppConfigFileBundle:Configfile:index.html.twig', array(
    			'entities' => $entities, 'step'=>0
    	));
    }
   
    
    public function newconfigfiledataAction($serviceid=0,$fieldorder=1,$lastdataid=0)
    {
    	//LINEA NUEVA
    	
    	$em = $this->getDoctrine()->getEntityManager();

    	$linetype_entity = $em->getRepository('HegesAppServiceBundle:Service')->getconfiglinetypefromserviceid($serviceid);
    	
    	if (!$linetype_entity) {
    		throw $this->createNotFoundException('ConfigfileController :: newconfigfiledataAction :: No existen tipos de linea para el servicio con id '.$serviceid);
    	}
    		    	
    	 
    	$linetypeid=$linetype_entity->getId();
    	
    	//$numfields=$linetype_entity->getFieldsnumber();
 
/*     	$field_entities = $em->getRepository('HegesAppConfigFileBundle:Configfield')->findByfkConfiglinetype($linetypeid);
    
    	if (!$field_entities) {
    		throw $this->createNotFoundException('NEWCONFIGFILE: Unable to find Configfield entity for LINETYPEID [.'.$linetypeid.']');
    	} */
    	$field_entity=$em->getRepository('HegesAppServiceBundle:Service') ->getfieldfromlinetypeidandfieldorder($linetypeid,$fieldorder);
    	 
    	 
    	$fieldname=$field_entity->getFieldname()." (".$field_entity->getFielddesc().")"; #." [".$fieldorder."]";

    	$data_entity = new Data();
    	
    	$form = $this->createFormBuilder($data_entity)
    	->add('value','text',array('label'=>$fieldname))
    	->add('previousvalue','text',array('read_only' => true))
    	->add('fkConfigfield','hidden')
    	->add('fkConfigline','hidden')
    	//->add('fkCreationuser','entity',array('label'=> 'Creation User', 'class' => 'HegesAppUserBundle:User'))
    	//->add('fkUpdateuser','entity',array('label'=> 'Update User', 'class' => 'HegesAppUserBundle:User'))
    	->add('fkCreationuser','hidden')
    	->add('fkUpdateuser','hidden')
    	->add('creationtime','hidden')
    	    	->add('updatetime','hidden')
	   	->getForm();

    	$this->get('session')->setFlash('notice', 'Los cambios se realizaron correctamente.');
    	
    	return $this->render('HegesAppConfigFileBundle:Configfile:newconfigfiledata.html.twig',
    			array(
    					'form'=>$form->createView(),
    					'data_entity' => $data_entity,
    					'serviceid'=> $serviceid,
    					'fieldorder'=>$fieldorder,
    					'lastdataid'=>$lastdataid
    			)
    	);
    	 
    
    	//($serviceid,$lineid=0,$numfields=0,$configfieldid=0,$fieldorder=1,$linetypeid)
    }
    

    public function createconfigfiledataAction($serviceid=0,$fieldorder=1,$lastdataid=0)
    {
    	$em = $this->getDoctrine()->getEntityManager();
    
    	$data_entity  = new Data();
    
    	$request = $this->getRequest();
        	
    	$session_username=$this->container->get('security.context')->getToken()->getUser();
    	
    	$form = $this->createFormBuilder($data_entity)
    	->add('value')
    	->add('previousvalue','text',array('read_only' => true))
    	->add('fkConfigfield','hidden')
    	->add('fkConfigline','hidden')
    	->add('fkCreationuser','hidden')
    	->add('fkUpdateuser','hidden')
    	//->add('fkCreationuser','entity',array('label'=> 'Creation User', 'class' => 'HegesAppUserBundle:User'))
    	//->add('fkUpdateuser','entity',array('label'=> 'Update User', 'class' => 'HegesAppUserBundle:User'))
    	->add('creationtime','hidden')
    	->add('updatetime','hidden')
    	->getForm();
    
    
    	$form->bindRequest($request);
    
    	$data_entity->setCreationtime(new \Datetime('now'));
    
    	$data_entity->setUpdatetime(new \Datetime('now'));

    	$user_entity = $em->getRepository('HegesAppUserBundle:User')->findOneByUsername($session_username);
    	
    	if (!$user_entity) {
    		throw $this->createNotFoundException('ConfigfileController :: createconfigfiledataAction :: No existe el usuario '.$session_username);
    	}
    	
    	$data_entity->setFkCreationuser($user_entity);
    	$data_entity->setFkUpdateuser($user_entity);
    	
    	
    	if ($form->isValid()) {
			
    		
    		
    		$linetype_entity = $em->getRepository('HegesAppServiceBundle:Service')->getconfiglinetypefromserviceid($serviceid);
    		 
    		if (!$linetype_entity) {
    			throw $this->createNotFoundException('ConfigfileController :: createconfigfiledataAction :: No existen tipos de linea para el servicio con id '.$serviceid);
    		}
    		 
    		$linetypeid=$linetype_entity->getId();
    		
    		$numfields=$linetype_entity->getFieldsnumber();
    		 
    		$field_entity=$em->getRepository('HegesAppServiceBundle:Service') ->getfieldfromlinetypeidandfieldorder($linetypeid,$fieldorder);
    		
    		if (!$field_entity) {
    			throw $this->createNotFoundException('ConfigfileController :: createconfigfiledataAction :: No existen campos de del fichero de configuracion de linea para linetypeid='.$linetypeid.',fieldorder='.$fieldorder);
    		}
    		
    		

    		    		
    		// Linea nueva, datos nuevos y lastdataid=0
    	
	    	if ($lastdataid==0){
	    			    	
		    	$service_entity= $em->getRepository('HegesAppServiceBundle:Service')->find($serviceid);
		    	
		    	$line_entity= new Configline();
		    	
		    	$line_entity->setFkService($service_entity);
		    	
		    	$em->persist($line_entity);
	    
	    	}else{
	    		
	    		$lastdata_entity = $em->getRepository('HegesAppConfigFileBundle:Data')->findOneById($lastdataid);
	    		if (!$lastdata_entity) {
	    			throw $this->createNotFoundException('ConfigfileController :: createconfigfiledataAction :: No existen datos para la linea con id '.$lastdataid);
	    		}
	    		$lineid=$lastdata_entity->getFkConfigline()->getId();

	    		
	    		
	    		//DATOS DUPLICADOS
	    		if ($em->getRepository('HegesAppServiceBundle:Service')->getduplicatelinewithfieldid($lineid,$field_entity->getId())){
	    			
	    			//$lastdataid=$data_entity->getId();
	    			
	    			$fieldorder=$fieldorder + 1 ;
	    			 
	    			$next_field_entity=$em->getRepository('HegesAppServiceBundle:Service') ->getfieldfromlinetypeidandfieldorder($linetypeid,$fieldorder);
	    			 
	    			if (!$next_field_entity) {
	    				throw $this->createNotFoundException('ConfigfileController :: createconfigfiledataAction :: No existen campos de del fichero de configuracion de linea para linetypeid='.$linetypeid.',fieldorder='.$fieldorder);
	    			}
	    			
	    			//$fieldname=$next_field_entity->getFieldname()." ".$next_field_entity->getFielddesc()." [".$fieldorder."]";
	    			$fieldname=$next_field_entity->getFieldname();
	    			
	    			
	    			$data_entity  = new Data();
	    			
	    			$form = $this->createFormBuilder($data_entity)
	    			->add('value','text',array('label'=>$fieldname))
	    			->add('previousvalue','text',array('read_only' => true))
	    			->add('fkConfigfield','hidden')
	    			->add('fkConfigline','hidden')
	    			//->add('fkCreationuser','entity',array('label'=> 'Creation User', 'class' => 'HegesAppUserBundle:User'))
	    			//->add('fkUpdateuser','entity',array('label'=> 'Update User', 'class' => 'HegesAppUserBundle:User'))
	    			->add('fkCreationuser','hidden')
	    			->add('fkUpdateuser','hidden')
	    			->add('creationtime','hidden')
	    			->add('updatetime','hidden')
	    			->getForm();
	    			
	    			//throw $this->createNotFoundException('NEWCONFIGFILE: FIELDORDER ['.$fieldorder.']');
	    			
	    			return $this->render('HegesAppConfigFileBundle:Configfile:duplicateconfigfiledata.html.twig',
	    					array(
	    							'form'=>$form->createView(),
	    							'data_entity' => $data_entity,
	    							'serviceid'=> $serviceid,
	    							'fieldorder'=>$fieldorder,
	    							'lastdataid'=>$lastdataid
	    					)
	    			);
	    			
	    			
	    			throw $this->createNotFoundException('ConfigfileController :: createconfigfiledataAction :: Campo duplicado con id '.$fieldorder.' en la linea con id '.$lineid);
	    		}
	    		 
	    		$line_entity = $em->getRepository('HegesAppConfigFileBundle:Configline')->findOneById($lineid);
	    		 
	    	
	    	}

	    	$data_entity->setFkConfigline($line_entity);
	    	$data_entity->setFkConfigfield($field_entity);
	    	$em->persist($data_entity);
	    	
			// Last data value added
	    	if ($fieldorder == $numfields ){
	    		$line_entity->setLinestatus(1);
    		 	$em->persist($line_entity);
    		 	$em->flush();
				
				//Config File is finished...
				
    		 	return $this->render('HegesAppConfigFileBundle:Configfile:index.html.twig',
    		 			array(
    		 					'step'=>4,
								'serviceid'=> $serviceid
    		 			)
    		 	);
	    	}
	    	$em->flush();
	    	
	    }else{return $this->redirect($this->generateUrl('data_error'));}  	
    
	    $lastdataid=$data_entity->getId();

	    $fieldorder=$fieldorder + 1 ;
	    
	    $next_field_entity=$em->getRepository('HegesAppServiceBundle:Service') ->getfieldfromlinetypeidandfieldorder($linetypeid,$fieldorder);
	    
	    if (!$next_field_entity) {
	    	throw $this->createNotFoundException('ConfigfileController :: createconfigfiledataAction :: No existen campos de del fichero de configuracion de linea para linetypeid='.$linetypeid.',fieldorder='.$fieldorder);
	    }

	    $fieldname=$next_field_entity->getFieldname()." ".$next_field_entity->getFielddesc()." [".$fieldorder."]";

    
    	$data_entity  = new Data();
    
    	$form = $this->createFormBuilder($data_entity)
    	->add('value','text',array('label'=>$fieldname))
    	->add('previousvalue','text',array('read_only' => true))
    	->add('fkConfigfield','hidden')
    	->add('fkConfigline','hidden')
    	//->add('fkCreationuser','entity',array('label'=> 'Creation User', 'class' => 'HegesAppUserBundle:User'))
    	//->add('fkUpdateuser','entity',array('label'=> 'Update User', 'class' => 'HegesAppUserBundle:User'))
    	->add('fkCreationuser','hidden')
    	->add('fkUpdateuser','hidden')
    	->add('creationtime','hidden')
    	->add('updatetime','hidden')
    	->getForm();

    	//throw $this->createNotFoundException('NEWCONFIGFILE: FIELDORDER ['.$fieldorder.']');
    	 
    	return $this->render('HegesAppConfigFileBundle:Configfile:newconfigfiledata.html.twig',
    			array(
    					'form'=>$form->createView(),
    					'data_entity' => $data_entity,
    					'serviceid'=> $serviceid,
    					'fieldorder'=>$fieldorder,
    					'lastdataid'=>$lastdataid
    			)
    	);

    }
    
    public function editconfigfiledataAction($dataid)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('HegesAppConfigFileBundle:Data')->findOneById($dataid);

        if (!$entity) {
            throw $this->createNotFoundException('ConfigfileController :: editconfigfiledataAction :: No existe el campo con id '.$dataid);;
        }

/*         $field_entity=$em->getRepository('HegesAppConfigFileBundle:Configfield')->findOneById($entity->getfkConfigfield());
         
        if (!$field_entity) {
        	throw $this->createNotFoundException('EDITCONFIGFILEDATA: Unable to find Configfield entity');
        } */
        
        $fieldname=$entity->getfkConfigfield()->getFieldname()." ".$entity->getfkConfigfield()->getFielddesc();
        
        
     //   $editForm = $this->createForm(new DataType(), $entity);
        $deleteForm = $this->createDeleteForm($dataid);

       // $data_entity = new Data();
         
        $form = $this->createFormBuilder($entity)
        ->add('value','text',array('label'=>$fieldname))
        ->add('previousvalue','text',array('read_only' => true))
        ->add('fkConfigfield','hidden')
        ->add('fkConfigline','hidden')
        ->add('fkCreationuser','entity',array('label'=> 'Creation User', 'class' => 'HegesAppUserBundle:User'))
        ->add('fkUpdateuser','entity',array('label'=> 'Update User', 'class' => 'HegesAppUserBundle:User'))
        ->add('creationtime','hidden')
        ->add('updatetime','hidden')
        ->getForm();
        
        
        return $this->render('HegesAppConfigFileBundle:Configfile:editconfigfiledata.html.twig', array(
            'entity'      => $entity,
            'form'   => $form->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }    

    public function editconfigfileAction($lineid)
    {
    	$em = $this->getDoctrine()->getEntityManager();
    
    	$data_entities = $em->getRepository('HegesAppConfigFileBundle:Data')->findByfkConfigline($lineid);
    
    	if (!$data_entities) {
    		throw $this->createNotFoundException('ConfigfileController :: editconfigfileAction :: No existe una linea con id '.$lineid);;
    	}
    
    	$deleteForm = $this->createDeleteForm($lineid);
    
    	return $this->render('HegesAppConfigFileBundle:Configfile:edit.html.twig', array(
    			'entities'      => $data_entities,
    			'delete_form' => $deleteForm->createView(),
    			'lineid'=>$lineid
    
    	));
    }
    
    
    public function export2csvAction($serviceid)
	{   
    
	    $em = $this->getDoctrine()->getEntityManager();
	    $configlinetype_entity = $em->getRepository('HegesAppServiceBundle:Service')
	    ->getconfiglinetypefromserviceid($serviceid);
	    
	    
	    $service_entity = $em->getRepository('HegesAppServiceBundle:Service')->findOneById($serviceid);
	     
	    if (!$service_entity) {
	    	throw $this->createNotFoundException('ConfigfileController :: export2csvAction :: No existe el servicio con id '.$serviceid);
	    	 
	    }
	    
	    $service_name=$service_entity->getName();
	    $service_node=$service_entity->getFkNode();
	     
	    $linetypeid=$configlinetype_entity->getId();
	    
	    if (!$configlinetype_entity) {
	    	throw $this->createNotFoundException('ConfigfileController :: export2csvAction :: No existe para el servicio con id '.$serviceid.' un tipo de linea con id '.$linetypeid);;
	    }
	    
	    
	    $configfield_entities = $em->getRepository('HegesAppConfigFileBundle:Configfield')
	    ->findByfkConfiglinetype($linetypeid);
	    
	    
	    $configdata_entities=$em->getRepository('HegesAppServiceBundle:Service')->getdatafromserviceid($serviceid);
    
    
	    
//     	$repository = $this->getDoctrine()->getRepository('AcmeTestBundle:Test');
//     	$query = $repository->createQueryBuilder('s');
//     	$query->orderBy('s.id', 'DESC');
    	
//     	$data = $query->getQuery()->getResult(); 
    	
    	
    	
    	//$filename = "export_".date("Y_m_d_His").".csv";
    	#$current_username=getenv('username');
    	
	    
    	$filename = "export_".$service_name.".".$service_node.".csv";
    	
//     	$response = $this->render('HegesAppConfigFileBundle:Configfile:export2csv.html.twig', 
//     		array('configdataentities' => $configdata_entities,
//     			'configfields'=>$configfield_entities,));
//     	$response->headers->set('Content-Type', 'text/csv');
    	
//     	$response->headers->set('Content-Disposition', 'attachment; filename='.$filename);
//     	return $response;
    	
	    $line_configfieldnames="";
 	    foreach ($configfield_entities as $configfield_entity)
	    {
	    	if ($line_configfieldnames == ""){
	    		$line_configfieldnames=$configfield_entity->getFieldname();
	    	}else{
	    		$line_configfieldnames=$line_configfieldnames.";".$configfield_entity->getFieldname();
	    	}
	    }
	    
	    
	    $line_configdatavalues_OLD="";
	    $data_lines=array();$oldlineid="";
	    foreach ($configdata_entities as $configdata_entity)
	    {
	    	$configdata_values_per_line=$em->getRepository('HegesAppConfigFileBundle:Data')
	    ->findByfkConfiglineorderbyfield($configdata_entity->getFkConfigline()->getId());
	    	
	    	$line_configdatavalues="";

	    	if (!$configdata_values_per_line) {
	    		throw $this->createNotFoundException('ConfigfileController :: export2csvAction :: No existen datos para el servicio con id '.$serviceid.' un tipo de linea con id '.$linetypeid);;
	    	}
		    foreach ($configdata_values_per_line as $configdata_value)
		    {
		    	if ($line_configdatavalues == ""){
		    		$line_configdatavalues=$configdata_value->getValue();
		    	}else{
		    		$line_configdatavalues=$line_configdatavalues.";".$configdata_value->getValue();
		    	}
		    	 
		    }
		    
		    #CUTRERADA
		    if ($line_configdatavalues_OLD != $line_configdatavalues){array_push($data_lines,$line_configdatavalues);}
		    $line_configdatavalues_OLD=$line_configdatavalues;
		    
	    }	    
	    
	  //  throw $this->createNotFoundException("[".$line_configfieldnames."] - ".$data_lines);
	    
/*     	$response=$this->render('HegesAppConfigFileBundle:Configfile:export2csv.html.twig', array(
    			'configfields'=>$configfield_entities,
    			'configdataentries'=>$configdata_entities,
    			'service_name'=>$service_name,
    			'service_node'=>$service_node,
    	
    	)); */
    	
    	
    	$response=$this->render('HegesAppConfigFileBundle:Configfile:export2csv.html.twig', array(
    			'configfields'=>$line_configfieldnames,
    			'configdatalines'=>$data_lines,
    			'service_name'=>$service_name,
    			'service_node'=>$service_node,
    			 
    	));
    	
    	$response->headers->set('Content-Type', 'text/csv');
    	 
    	$response->headers->set('Content-Disposition', 'attachment; filename='.$filename);
    	
    	$response->setCharset('utf-8');
    	
    	$this->get('session')->setFlash('notice', 'Exportación de datos correcta.');
        
        
        $logsource="hegesapp_log_app";
        $hegesapplogentry = new HegesAppLog(
                    $this->container->getParameter('hegesapp_log_dir').$this->container->getParameter($logsource),
                    $this->container->get('security.context')->getToken()->getUser(),
                    $logsource);
                
       $hegesapplogentry->HegesAppLogWriteToLog("Exportacion del fichero ".$filename.".");
        
    	
    	return $response;
    	 
    	
    	}



    	public function dumpfileAction($serviceid)
    	{
    		
    		
    		
    		############################ PREVIO VOLCADO EN DISCO
    		
    		$OUTDIR="/opt/nagios/output/";
    	
    		if (!is_dir($OUTDIR)){
    			throw $this->createNotFoundException('ConfigfileController :: dumpfileAction :: No existe el directorio de salida '.$OUTDIR);
   			
    		}
    		
    		$em = $this->getDoctrine()->getEntityManager();
    		$configlinetype_entity = $em->getRepository('HegesAppServiceBundle:Service')
    		->getconfiglinetypefromserviceid($serviceid);
    		 
    		 
    		$service_entity = $em->getRepository('HegesAppServiceBundle:Service')->findOneById($serviceid);
    	
    		if (!$service_entity) {
    			throw $this->createNotFoundException('ConfigfileController :: dumpfileAction :: No existe el servicio con id '.$serviceid);
    			 
    		}
    		
    		$dumpfilename=$service_entity->getConfigfilename();
    		
    		$nodename=$service_entity->getFkNode()->getName();
    		
                $nodeaccess=$service_entity->getFkNode()->getFkOs()->getAccess();
                
    		$service_name=$service_entity->getName();
    		
    		$service_node=$service_entity->getFkNode();
    	
    		$linetypeid=$configlinetype_entity->getId();
    		 
    		if (!$configlinetype_entity) {
    			throw $this->createNotFoundException('ConfigfileController :: dumpfileAction :: No existe para el servicio con id '.$serviceid.' un tipo de linea con id '.$linetypeid);;
    		}
    		 
    		$delimiter=$configlinetype_entity->getDelimiter();
    		 
    		$configfield_entities = $em->getRepository('HegesAppConfigFileBundle:Configfield')
    		->findByfkConfiglinetype($linetypeid);
    		 
    		 
    		$configdata_entities=$em->getRepository('HegesAppServiceBundle:Service')->getdatafromserviceid($serviceid);
    		 

    		$line_configfieldnames="";
    		foreach ($configfield_entities as $configfield_entity)
    		{
    			if ($line_configfieldnames == ""){
    				$line_configfieldnames="#".$configfield_entity->getFieldname();
    			}else{
    				$line_configfieldnames=$line_configfieldnames.$delimiter.$configfield_entity->getFieldname();
    			}
    		}
    		 
    		 
    		$line_configdatavalues_OLD="";
    		$data_lines=array();$oldlineid="";
    		foreach ($configdata_entities as $configdata_entity)
    		{
                        
                    //print "<p>LINEA DE CONFIGURACION: ".$configdata_entity->getFkConfigline()->getId();
    			
                        $configdata_values_per_line=$em->getRepository('HegesAppConfigFileBundle:Data')
    			->findByfkConfiglineorderbyfield($configdata_entity->getFkConfigline()->getId());
    	
    			$line_configdatavalues="";
    	
    		//	if (!$configdata_values_per_line) {
    		//		throw $this->createNotFoundException('ConfigfileController :: dumpfileAction :: No existen datos para el servicio con id '.$serviceid.' un tipo de linea con id '.$linetypeid);;
    		//	}
    			foreach ($configdata_values_per_line as $configdata_value)
    			{
    				if ($line_configdatavalues == ""){
    					$line_configdatavalues=$configdata_value->getValue();
    				}else{
    					$line_configdatavalues=$line_configdatavalues.$delimiter.$configdata_value->getValue();
    				}
    	
    			}
    	
    			#CUTRERADA
    			if ($line_configdatavalues_OLD != $line_configdatavalues){
    			array_push($data_lines,$line_configdatavalues);
    			}
    			$line_configdatavalues_OLD=$line_configdatavalues;
    	
    		}
    			   			
    			$OUTDIR=$OUTDIR.$nodename."/";

    			if (!is_dir($OUTDIR)){
    				mkdir($OUTDIR,0755);
    			
    			}
    		
    			if (file_exists($OUTDIR.$dumpfilename)){unlink($OUTDIR.$dumpfilename);}
    			
    			$filehandle=fopen($OUTDIR.$dumpfilename,"a");

    			fwrite($filehandle,$line_configfieldnames."\n");
    			
    			foreach ( $data_lines as $line ){
    				
    				fwrite($filehandle,$line."\n");
    				
    			}
    			


    			
    			if (file_exists($OUTDIR.$dumpfilename)){
    				
    				//$sshcon=ssh2_connect('172.31.207.100',22);
    				//ssh2_auth_password($sshcon,'nagios','2o1oNagios'); #/'.$nodename.'
    				//ssh2_scp_send($sshcon,$OUTDIR.$dumpfilename, '/ovoscripts/nagios/NAG_AGENTS/TEST/'.$dumpfilename,0644);
    				
                                    $param_file_repository_host = $this->container->getParameter('file_repository_host');
                                    $param_file_repository_user = $this->container->getParameter('file_repository_user');
                                    $param_file_repository_passwd = $this->container->getParameter('file_repository_passwd');
                                    $param_file_repository_directory = $this->container->getParameter('file_repository_directory');
                                    $sshcon=ssh2_connect($param_file_repository_host,22);

                                    if ($nodeaccess == "SSH"){
                                        $param_file_repository_directory=$param_file_repository_directory."UNIX/".$nodename."/";
                                    }else{
                                        $param_file_repository_directory=$param_file_repository_directory."WINDOWS/".$nodename."/";
                                    }
                                    
                                    
                                    ssh2_auth_password($sshcon,$param_file_repository_user,$param_file_repository_passwd);
                            
                                    if (ssh2_scp_send($sshcon,$OUTDIR.$dumpfilename, $param_file_repository_directory.$dumpfilename,0644)){
                                        $this->get('session')->setFlash('notice', 'Se envió el fichero al repositorio central "'.$param_file_repository_directory.$dumpfilename.'".');
                                        
                                        $logsource="hegesapp_log_distrib";
                                        $hegesapplogentry = new HegesAppLog(
                                                    $this->container->getParameter('hegesapp_log_dir').$this->container->getParameter($logsource),
                                                    $this->container->get('security.context')->getToken()->getUser(),
                                                    $logsource);

                                       $hegesapplogentry->HegesAppLogWriteToLog("Distribucion del fichero ".$dumpfilename.". al repositorio central.l");
                                        
                                        
                                        
                                    }else{
                                        $this->get('session')->setFlash('error', 'No se pudo crear el fichero "'.$OUTDIR.$dumpfilename.'"');
                                    }
    			
    			}
                       
    			
    			return $this->render('HegesAppConfigFileBundle:Configfile:index.html.twig', array(
    					'step'=>3,
    					'configlinetype' => $configlinetype_entity,
    					'serviceid' => $serviceid,
    					'linetypeid'=>$linetypeid,
    					'configfields'=>$configfield_entities,
    					'configdataentries'=>$configdata_entities
    			
    			));
    			 

    	
    			 
    	}

    public function dumpmultiplefilesAction($nodeid)
    {
    	
    	
    	
    	############################ PREVIO VOLCADO EN DISCO
    	
    	$OUTDIR="/opt/nagios/output/";
    	 
    	if (!is_dir($OUTDIR)){
    			throw $this->createNotFoundException('ConfigfileController :: dumpfile :: No existe el directorio de salida '.$OUTDIR);
    	
    	}
    	
    	
    	$em = $this->getDoctrine()->getEntityManager();
    	
    	$service_entities = $em->getRepository('HegesAppServiceBundle:Service')->findByfkNode($nodeid);
    	 
    	if (!$service_entities) {
    		//throw $this->createNotFoundException('Unable to find Services for this node.');
    		$this->get('session')->setFlash('error', 'ERROR: No existen cominitorizaciones para el nodo.');
    		$service_entities = $em->getRepository('HegesAppNodeBundle:Node')->getAllNodes();
    		//$this->get('session')->setFlash('error', 'No se encontraron servicios para el nodo.');
    		return $this->render('HegesAppConfigFileBundle:Configfile:index.html.twig', array(
    				'entities' => $entities, 'step'=>1
    		));
    		 
    	}
    	
    	 
    	
    	#### BUCLE DE SERVICIOS
    	
    	foreach ($service_entities as $service_entity )
    	{
    	
    		$serviceid=$service_entity->getId();
	    	$configlinetype_entity = $em->getRepository('HegesAppServiceBundle:Service')
	    	->getconfiglinetypefromserviceid($serviceid);
	    	 
	    	 
                

                
	    	$service_entity = $em->getRepository('HegesAppServiceBundle:Service')->findOneById($serviceid);
	    	 
	    	if (!$service_entity) {
                    throw $this->createNotFoundException('ConfigfileController :: dumpmultiplefilesAction :: No existe el servicio con id '.$serviceid);
	    	
	    	}
	    	
	    	$dumpfilename=$service_entity->getConfigfilename();
	    	
	    	$nodename=$service_entity->getFkNode()->getName();
	    	
                $nodeaccess=$service_entity->getFkNode()->getFkOs()->getAccess();
                                
	    	$service_name=$service_entity->getName();
	                    
	    	$service_node=$service_entity->getFkNode();
	    	if (!$configlinetype_entity){continue;}
	    	$linetypeid=$configlinetype_entity->getId();
	    	 
	    	//if (!$configlinetype_entity) {
	    	//throw $this->createNotFoundException('ConfigfileController :: dumpmultiplefilesAction :: No existe para el servicio con id '.$serviceid.' un tipo de linea con id '.$linetypeid);;
	    	//}
	    	 
	    	$delimiter=$configlinetype_entity->getDelimiter();
	    	 
	    	$configfield_entities = $em->getRepository('HegesAppConfigFileBundle:Configfield')
	    			->findByfkConfiglinetype($linetypeid);
	        if (!$configfield_entities) {
                    throw $this->createNotFoundException('ConfigfileController :: dumpmultiplefilesAction :: No existen entradas.');
	    	}			 

	    	$configdata_entities=$em->getRepository('HegesAppServiceBundle:Service')->getdatafromserviceid($serviceid);
                
                if ($configdata_entities) {
                   
	    	
                                
                    $line_configfieldnames="";
                    foreach ($configfield_entities as $configfield_entity)
                    {
                        if ($line_configfieldnames == ""){
                            $line_configfieldnames="#".$configfield_entity->getFieldname();
                        }else{
                            $line_configfieldnames=$line_configfieldnames.$delimiter.$configfield_entity->getFieldname();
                        }
                    }


                    $line_configdatavalues_OLD="";
                    $data_lines=array();$oldlineid="";
                    
                    $param_file_repository_host = $this->container->getParameter('file_repository_host');
                                        $param_file_repository_user = $this->container->getParameter('file_repository_user');
                                        $param_file_repository_passwd = $this->container->getParameter('file_repository_passwd');
                                        $param_file_repository_directory = $this->container->getParameter('file_repository_directory');
                                        
                    
                    if ($nodeaccess == "SSH"){
                        $param_file_repository_directory=$param_file_repository_directory."UNIX/".$nodename."/";
                    }else{
                        $param_file_repository_directory=$param_file_repository_directory."WINDOWS/".$nodename."/";
                    }
                    
                    
                    foreach ($configdata_entities as $configdata_entity)
                    {

                            $configdata_values_per_line=$em->getRepository('HegesAppConfigFileBundle:Data')
                            ->findByfkConfiglineorderbyfield($configdata_entity->getFkConfigline()->getId());

                            $line_configdatavalues="";

                            //if (!$configdata_values_per_line) {
                            //throw $this->createNotFoundException('ConfigfileController :: dumpmultiplefilesAction :: No existen datos para el servicio con id '.$serviceid.' un tipo de linea con id '.$linetypeid);;
                            //}
                            foreach ($configdata_values_per_line as $configdata_value)
                            {
                                if ($line_configdatavalues == ""){
                                $line_configdatavalues=$configdata_value->getValue();
                                }else{
                                $line_configdatavalues=$line_configdatavalues.$delimiter.$configdata_value->getValue();
                                }
                                //print "$line_configdatavalues\n";
                            }

                            #CUTRERADA
                            if ($line_configdatavalues_OLD != $line_configdatavalues){
                            array_push($data_lines,$line_configdatavalues);
                            }
                            $line_configdatavalues_OLD=$line_configdatavalues;

                    }

                            $OUTDIR=$OUTDIR.$nodename."/";

                                    if (!is_dir($OUTDIR)){
                                    mkdir($OUTDIR,0755);

                                    }

                                    if (file_exists($OUTDIR.$dumpfilename)){
                                    unlink($OUTDIR.$dumpfilename);
                                    }

                                    $filehandle=fopen($OUTDIR.$dumpfilename,"a");

                                    fwrite($filehandle,$line_configfieldnames."\n");

                                    foreach ( $data_lines as $line ){

                                    fwrite($filehandle,$line."\n");

                                    }



                                    if (file_exists($OUTDIR.$dumpfilename)){
                                        $sshcon=ssh2_connect($param_file_repository_host,22);

                                    ssh2_auth_password($sshcon,$param_file_repository_user,$param_file_repository_passwd);
                                    if (! ssh2_exec($sshcon,'mkdir -p '.$param_file_repository_directory)){
                                        $this->get('session')->setFlash('error', 'No se pudo crear el directorio "'.$param_file_repository_directory.'"');
                                        
                                        }
                                    if (ssh2_scp_send($sshcon,$OUTDIR.$dumpfilename, $param_file_repository_directory.$dumpfilename,0644)){                                        if (ssh2_scp_send($sshcon,$OUTDIR.$dumpfilename, $param_file_repository_directory.$dumpfilename,0644)){
                                            $this->get('session')->setFlash('notice', 'Se llevaron los ficheros al repositorio central "'.$param_file_repository_directory.'."');
                                            $logsource="hegesapp_log_distrib";
                                            $hegesapplogentry = new HegesAppLog(
                                                        $this->container->getParameter('hegesapp_log_dir').$this->container->getParameter($logsource),
                                                        $this->container->get('security.context')->getToken()->getUser(),
                                                        $logsource);

                                           $hegesapplogentry->HegesAppLogWriteToLog("Distribucion del fichero ".$dumpfilename.". al repositorio central.l");

                                        }else{
                                            $this->get('session')->setFlash('error', 'No se pudo crear el fichero "'.$OUTDIR.$dumpfilename.'"');
                                        }


                                    }
                                
                                }
                }
                           
    			
    	} #FIN BUCLE DE SERVICIOS		
    			
    	return $this->render('HegesAppConfigFileBundle:Configfile:index.html.twig', array(
    		'step'=>2,
    		'configlinetype' => $configlinetype_entity,
    		'serviceid' => $serviceid,
    		'linetypeid'=>$linetypeid,
    		'configfields'=>$configfield_entities,
    		'configdataentries'=>$configdata_entities,
    		'entities' =>$service_entities,
    		'nodeid'=>$nodeid
    					 
    		));
    	
    	
    					 
    	
	}
public function applyfileAction($serviceid)
{
    		
    		
    		
    		############################ PREVIO VOLCADO EN DISCO
    		
    		$OUTDIR="/opt/nagios/output/";
    	
    		if (!is_dir($OUTDIR)){
    			throw $this->createNotFoundException('ConfigfileController :: applyfileAction :: No existe el directorio de salida '.$OUTDIR);
   			
    		}
    		 		
    	
    		
    		
    		
    		$em = $this->getDoctrine()->getEntityManager();
    		$configlinetype_entity = $em->getRepository('HegesAppServiceBundle:Service')
    		->getconfiglinetypefromserviceid($serviceid);
    		 
    		 
    		$service_entity = $em->getRepository('HegesAppServiceBundle:Service')->findOneById($serviceid);
    	
    		if (!$service_entity) {
    			throw $this->createNotFoundException('ConfigfileController :: applyfileAction :: No existe el servicio con id '.$serviceid);
    			 
    		}
    		
    		$dumpfilename=$service_entity->getConfigfilename();
    		
    		$nodename=$service_entity->getFkNode()->getName();
                $nodeip=$service_entity->getFkNode()->getIp();
    		
    		$service_name=$service_entity->getName();
    		
    		$service_node=$service_entity->getFkNode();
    	
    		$linetypeid=$configlinetype_entity->getId();
    		 
    		if (!$configlinetype_entity) {
    			throw $this->createNotFoundException('ConfigfileController :: applyfileAction :: No existe para el servicio con id '.$serviceid.' un tipo de linea con id '.$linetypeid);;
    		}
    		 
    		$delimiter=$configlinetype_entity->getDelimiter();
    		
                
                
                //---------------------------------
    		$configfield_entities = $em->getRepository('HegesAppConfigFileBundle:Configfield')
    		->findByfkConfiglinetype($linetypeid);
    		
                $line_configfieldnames="";
    		foreach ($configfield_entities as $configfield_entity)
    		{
    			if ($line_configfieldnames == ""){
    				$line_configfieldnames="#".$configfield_entity->getFieldname();
    			}else{
    				$line_configfieldnames=$line_configfieldnames.$delimiter.$configfield_entity->getFieldname();
    			}
    		}
                
                //---------------------------------
                
                
                
    		 
    		$configdata_entities=$em->getRepository('HegesAppServiceBundle:Service')->getdatafromserviceid($serviceid);
    		 

    		 
    		$line_configdatavalues_OLD="";
    		$data_lines=array();$oldlineid="";
    		foreach ($configdata_entities as $configdata_entity)
    		{
                        $lineid=$configdata_entity->getFkConfigline()->getId();
                        //print "<p>LINEID: ".$lineid;
    			$configdata_values_per_line=$em->getRepository('HegesAppConfigFileBundle:Data')
    			->findByfkConfiglineorderbyfield($lineid);
    	
    			$line_configdatavalues="";
                        
    			//if (!$configdata_values_per_line) {
                          //  continue;
                            //throw $this->createNotFoundException('ConfigfileController :: applyfileAction :: No existen datos para el servicio con id '.$serviceid.' un tipo de linea con id '.$linetypeid);;
    			//}
    			foreach ($configdata_values_per_line as $configdata_value)
    			{
                                //print "<p> - ".$configdata_value->getValue();
                                
    				if ($line_configdatavalues == ""){
    					$line_configdatavalues=$configdata_value->getValue();
    				}else{
    					$line_configdatavalues=$line_configdatavalues.$delimiter.$configdata_value->getValue();
    				}
    	
    			}
    	
    			#CUTRERADA
    			if ($line_configdatavalues_OLD != $line_configdatavalues){
    			array_push($data_lines,$line_configdatavalues);
    			}
    			$line_configdatavalues_OLD=$line_configdatavalues;
                        
                        

    	
    		}
    			   			
    			$OUTDIR=$OUTDIR.$nodename."/";

    			if (!is_dir($OUTDIR)){
    				mkdir($OUTDIR,0755);
    			
    			}
    		
    			if (file_exists($OUTDIR.$dumpfilename)){unlink($OUTDIR.$dumpfilename);}
    			
    			$filehandle=fopen($OUTDIR.$dumpfilename,"a");

    			fwrite($filehandle,$line_configfieldnames."\n");
    			//print "<p>".$line_configfieldnames;
    			foreach ( $data_lines as $line ){
    				
    				fwrite($filehandle,$line."\n");
    				
    			}
    			
    			//throw $this->createNotFoundException('EXIT');

                        
                        
                        $nodeaccess=$service_entity->getFkNode()->getFkOs()->getAccess();
                        
                        
                        
    			
    			if (file_exists($OUTDIR.$dumpfilename)){
    				
                                ### SSH
                            if ( $nodeaccess == "SSH"){
                                    $param_file_distrib_user = $this->container->getParameter('file_distrib_user');
                                    $param_file_distrib_passwd = $this->container->getParameter('file_distrib_passwd');
                                    $param_file_distrib_directory = $this->container->getParameter('file_distrib_directory');
                                    //print $nodename.' '.$nodeip;
                                    $sshcon=ssh2_connect($nodeip,22);

                                    ssh2_auth_password($sshcon,$param_file_distrib_user,$param_file_distrib_passwd);
                                    if (! ssh2_exec($sshcon,'mkdir -p '.$param_file_repository_directory)){
                                        $this->get('session')->setFlash('error', 'No se pudo crear el directorio "'.$param_file_distrib_directory.'"');
                                        
                                    }
                                    if (ssh2_scp_send($sshcon,$OUTDIR.$dumpfilename, $param_file_distrib_directory.$dumpfilename,0644)){
                                        $this->get('session')->setFlash('notice', 'Se aplicó el fichero "'.$dumpfilename.'" en el nodo '.$nodename.'('.$nodeip.')');
                                        $logsource="hegesapp_log_distrib";
                                        $hegesapplogentry = new HegesAppLog(
                                                $this->container->getParameter('hegesapp_log_dir').$this->container->getParameter($logsource),
                                                $this->container->get('security.context')->getToken()->getUser(),
                                                $logsource);

                                       $hegesapplogentry->HegesAppLogWriteToLog("Distribucion del fichero ".$dumpfilename.". al nodo ".$nodename);
                                        
                                        
                                        
                                    }else{
                                        $this->get('session')->setFlash('error', 'No se pudo distribuir el fichero "'.$OUTDIR.$dumpfilename.'" al nodo '.$nodename.'('.$nodeip.')');
                                    }
                            }elseif ( $nodeaccess == "SMB"){  
                        
                                 
                        
                                $param_smb_user=$this->container->getParameter('smb_user');
                                $param_smb_domain=$this->container->getParameter('smb_domain');
                                $param_smb_passwd=$this->container->getParameter('smb_passwd');
                                
                                $mysmbclient = new SMBClient ('//'.$nodename.'/C$', $param_smb_user,$param_smb_domain, $param_smb_passwd);
                              // throw $this->createNotFoundException('SMB'.$param_smb_user.' '.$param_smb_domain.' '.$param_smb_passwd);
                                if (!$mysmbclient){ $this->get('session')->setFlash('error', 'NO se creó la clase');}
                                //if (!$mysmbclient->execute ('md TEST;exit;'))
                                
                                    $original_dir=getcwd();
                                    chdir($OUTDIR);
                                    
                                    $mysmbclient->execute ('cd "Program Files";cd "NSClient++";md conf;exit;');
                                    
                                if (!$mysmbclient->execute ('cd "Program Files";cd "NSClient++";cd conf;prompt;put '.$dumpfilename.';exit;'))
                                {
                                    //if (!$mysmbclient->execute ('cd "Archivos de Programa";cd "NSClient++";mput $OUTDIR.$dumpfilename;exit')){
                                    //print "Ejecucion erronea.\n";
                                        $this->get('session')->setFlash('error', 'No se distribuyó el fichero "'.$OUTDIR.$dumpfilename.'"');
                                    //}
                                }else{
  
                                    //print "<p>NEWDIR ".getcwd();
                                    //throw $this->createNotFoundException('cd "Program Files";cd "NSClient++";md conf;prompt;mput '.$OUTDIR.$dumpfilename.';exit;');
                                    //print "Ejecucion correcta....TOMA!!!!.\n";
                                     $this->get('session')->setFlash('notice', 'Se distribuyó el fichero "'.$OUTDIR.$dumpfilename.'"');
                                                                            $logsource="hegesapp_log_distrib";
                                        $hegesapplogentry = new HegesAppLog(
                                                    $this->container->getParameter('hegesapp_log_dir').$this->container->getParameter($logsource),
                                                    $this->container->get('security.context')->getToken()->getUser(),
                                                    $logsource);

                                       $hegesapplogentry->HegesAppLogWriteToLog("Distribucion del fichero ".$dumpfilename.". al nodo ".$nodename);
                                }
                                

                                chdir($original_dir);
                                
                            }else{
                                $this->get('session')->setFlash('error', 'El sistema operativo del nodo no tiene definido el acceso. No es posible distribuirle ficheros.');
                            }
                                
                        }
    			
    			return $this->render('HegesAppConfigFileBundle:Configfile:index.html.twig', array(
    					'step'=>3,
    					'configlinetype' => $configlinetype_entity,
    					'serviceid' => $serviceid,
    					'linetypeid'=>$linetypeid,
    					'configfields'=>$configfield_entities,
    					'configdataentries'=>$configdata_entities
    			
    			));
    			 

    	
    			 
    	}    	
    	 
    	
    public function applymultiplefilesAction($nodeid)
    {
    	
    	
    	
    	############################ PREVIO VOLCADO EN DISCO
    	
    	$OUTDIR="/opt/nagios/output/";
    	 
    	if (!is_dir($OUTDIR)){
    			throw $this->createNotFoundException('ConfigfileController :: applymultiplefilesAction :: No existe el directorio de salida '.$OUTDIR);
    	
    	}
    		
    	 
    	
    	
    	
    	$em = $this->getDoctrine()->getEntityManager();
    	
    	$service_entities = $em->getRepository('HegesAppServiceBundle:Service')->findByfkNode($nodeid);
    	 
    	if (!$service_entities) {
    		//throw $this->createNotFoundException('Unable to find Services for this node.');
    		$this->get('session')->setFlash('error', 'ERROR: No existen cominitorizaciones para el nodo.');
    		$service_entities = $em->getRepository('HegesAppNodeBundle:Node')->getAllNodes();
    		//$this->get('session')->setFlash('error', 'No se encontraron servicios para el nodo.');
    		return $this->render('HegesAppConfigFileBundle:Configfile:index.html.twig', array(
    				'entities' => $entities, 'step'=>1
    		));
    		 
    	}
    	
    	 
    	
    	#### BUCLE DE SERVICIOS
    	$distrib_error=0;
    	foreach ($service_entities as $service_entity )
    	{
    	
    		$serviceid=$service_entity->getId();
	    	$configlinetype_entity = $em->getRepository('HegesAppServiceBundle:Service')
	    	->getconfiglinetypefromserviceid($serviceid);
	    	 
	    	 
	    	$service_entity = $em->getRepository('HegesAppServiceBundle:Service')->findOneById($serviceid);
	    	 
	    	if (!$service_entity) {
	    	throw $this->createNotFoundException('ConfigfileController :: applymultiplefilesAction :: No existe el servicio con id '.$serviceid);
	    	
	    	}
	    	
	    	$dumpfilename=$service_entity->getConfigfilename();
	    	
    		$nodename=$service_entity->getFkNode()->getName();
                $nodeip=$service_entity->getFkNode()->getIp();
    		
	    	
                $nodeaccess=$service_entity->getFkNode()->getFkOs()->getAccess();
                
                
	    	$service_name=$service_entity->getName();
	    	
	    	$service_node=$service_entity->getFkNode();
	    	
                if (!$configlinetype_entity){continue;}
	    	$linetypeid=$configlinetype_entity->getId();
                
	    	//$linetypeid=$configlinetype_entity->getId();
	    	 
	    	if (!$configlinetype_entity) {
	    	throw $this->createNotFoundException('ConfigfileController :: applymultiplefilesAction :: No existe para el servicio con id '.$serviceid.' un tipo de linea con id '.$linetypeid);;
	    	}
	    	 
	    	$delimiter=$configlinetype_entity->getDelimiter();
	    	 
	    	$configfield_entities = $em->getRepository('HegesAppConfigFileBundle:Configfield')
	    			->findByfkConfiglinetype($linetypeid);
	    			 
	    			 
	    			$configdata_entities=$em->getRepository('HegesAppServiceBundle:Service')->getdatafromserviceid($serviceid);
	    			 
	    	
	    			$line_configfieldnames="";
	    			foreach ($configfield_entities as $configfield_entity)
	    			{
                                    if ($line_configfieldnames == ""){
	    				$line_configfieldnames="#".$configfield_entity->getFieldname();
                                    }else{
                                        $line_configfieldnames=$line_configfieldnames.$delimiter.$configfield_entity->getFieldname();
                                    }
                                }
	    	 
	    	 
	    	$line_configdatavalues_OLD="";
	    	$data_lines=array();$oldlineid="";
	    	foreach ($configdata_entities as $configdata_entity)
	    	{
	    		$configdata_values_per_line=$em->getRepository('HegesAppConfigFileBundle:Data')
	    		->findByfkConfiglineorderbyfield($configdata_entity->getFkConfigline()->getId());
	    		 
	    		$line_configdatavalues="";
	    		 
	    		if (!$configdata_values_per_line) {
	    		throw $this->createNotFoundException('ConfigfileController :: applymultiplefilesAction :: No existen datos para el servicio con id '.$serviceid.' y el tipo de linea con id '.$linetypeid);;
	    		}
	    		foreach ($configdata_values_per_line as $configdata_value)
	    		{
	    		if ($line_configdatavalues == ""){
	    		$line_configdatavalues=$configdata_value->getValue();
	    		}else{
	    		$line_configdatavalues=$line_configdatavalues.$delimiter.$configdata_value->getValue();
	    		}
	    		 
	    		}
	    		 
	    		#CUTRERADA
	    		if ($line_configdatavalues_OLD != $line_configdatavalues){
	    		array_push($data_lines,$line_configdatavalues);
	    		}
	    		$line_configdatavalues_OLD=$line_configdatavalues;
	    		 
	    	}
	    			
	    		$OUTDIR=$OUTDIR.$nodename."/";
	    	
                        if (!is_dir($OUTDIR)){
                            mkdir($OUTDIR,0755);
	    		}
	    	
	    		if (file_exists($OUTDIR.$dumpfilename)){
                            unlink($OUTDIR.$dumpfilename);
	    		}
	    			 
	    		$filehandle=fopen($OUTDIR.$dumpfilename,"a");
	    	
	    		fwrite($filehandle,$line_configfieldnames."\n");
	    			 
	    		foreach ( $data_lines as $line ){
                            fwrite($filehandle,$line."\n");
                        }
	    			 
	    	
	    			 
	    		if (file_exists($OUTDIR.$dumpfilename)){
                        

        
                            ### SSH
                           if ( $nodeaccess == "SSH"){
                                    $param_file_distrib_user = $this->container->getParameter('file_distrib_user');
                                    $param_file_distrib_passwd = $this->container->getParameter('file_distrib_passwd');
                                    $param_file_distrib_directory = $this->container->getParameter('file_distrib_directory');
                                    //print $nodename.' '.$nodeip;
                                    $sshcon=ssh2_connect($nodeip,22);

                                    ssh2_auth_password($sshcon,$param_file_distrib_user,$param_file_distrib_passwd);
                                    if (! ssh2_exec($sshcon,'mkdir -p '.$param_file_distrib_directory)){
                                        $this->get('session')->setFlash('error', 'No se pudo crear el directorio "'.$param_file_distrib_directory.'"');
                                        $distrib_error=$distrib_error + 1;
                                    }
                                    if (ssh2_scp_send($sshcon,$OUTDIR.$dumpfilename, $param_file_distrib_directory.$dumpfilename,0644)){
                                        $this->get('session')->setFlash('notice', 'Se aplicó el fichero "'.$dumpfilename.'" en el nodo '.$nodename.'('.$nodeip.')');
                                        $logsource="hegesapp_log_distrib";
                                        $hegesapplogentry = new HegesAppLog(
                                                $this->container->getParameter('hegesapp_log_dir').$this->container->getParameter($logsource),
                                                $this->container->get('security.context')->getToken()->getUser(),
                                                $logsource);

                                       $hegesapplogentry->HegesAppLogWriteToLog("Distribucion del fichero ".$dumpfilename.". al nodo ".$nodename);
                                        
                                        
                                        
                                    }else{
                                        $this->get('session')->setFlash('error', 'No se pudo distribuir el fichero "'.$OUTDIR.$dumpfilename.'" al nodo '.$nodename.'('.$nodeip.')');
                                        $distrib_error=$distrib_error + 1;
                                    }
                            }elseif ( $nodeaccess == "SMB"){                                
                                $param_smb_user=$this->container->getParameter('smb_user');
                                $param_smb_domain=$this->container->getParameter('smb_domain');
                                $param_smb_passwd=$this->container->getParameter('smb_passwd');
                                
                                $mysmbclient = new SMBClient ('//'.$nodename.'/C$', $param_smb_user,$param_smb_domain, $param_smb_passwd);
                              // throw $this->createNotFoundException('SMB'.$param_smb_user.' '.$param_smb_domain.' '.$param_smb_passwd);
                                if (!$mysmbclient){ $this->get('session')->setFlash('error', 'NO se creó la clase');}
                                //if (!$mysmbclient->execute ('md TEST;exit;'))
                                
                                    $original_dir=getcwd();
                                    chdir($OUTDIR);
                                    
                                    $mysmbclient->execute ('cd "Program Files";cd "NSClient++";md conf;exit;');
                                    
                                if (!$mysmbclient->execute ('cd "Program Files";cd "NSClient++";cd conf;prompt;put '.$dumpfilename.';exit;'))
                                {
                                    //if (!$mysmbclient->execute ('cd "Archivos de Programa";cd "NSClient++";mput $OUTDIR.$dumpfilename;exit')){
                                    //print "Ejecucion erronea.\n";
                                        $this->get('session')->setFlash('error', 'No se distribuyó el fichero "'.$OUTDIR.$dumpfilename.'"');
                                        $distrib_error=$distrib_error + 1;
                                    //}
                                }else{
  
                                    //print "<p>NEWDIR ".getcwd();
                                    //throw $this->createNotFoundException('cd "Program Files";cd "NSClient++";md conf;prompt;mput '.$OUTDIR.$dumpfilename.';exit;');
                                    //print "Ejecucion correcta....TOMA!!!!.\n";
                                     $this->get('session')->setFlash('notice', 'Se distribuyó el fichero "'.$OUTDIR.$dumpfilename.'"');
                                                                            $logsource="hegesapp_log_distrib";
                                        $hegesapplogentry = new HegesAppLog(
                                                    $this->container->getParameter('hegesapp_log_dir').$this->container->getParameter($logsource),
                                                    $this->container->get('security.context')->getToken()->getUser(),
                                                    $logsource);

                                       $hegesapplogentry->HegesAppLogWriteToLog("Distribucion del fichero ".$dumpfilename.". al nodo ".$nodename);
                                }                       
                                
                            }else{
                                $this->get('session')->setFlash('error', 'El sistema operativo del nodo no tiene definido el acceso. No es posible distribuirle ficheros.');
                                $distrib_error=$distrib_error + 1;
                            }
	
                        }else{$distrib_error=$distrib_error + 1;}
                        
    			
    	} #FIN BUCLE DE SERVICIOS		
    	
        if ($distrib_error == 0){$this->get('session')->setFlash('notice', 'Distribucion correcta al nodo "'.$nodename.'".');
        }else{
            $this->get('session')->setFlash('error', 'Se encontraron errores en la distribucion.');
        }
    	return $this->render('HegesAppConfigFileBundle:Configfile:index.html.twig', array(
    		'step'=>2,
    		'configlinetype' => $configlinetype_entity,
    		'serviceid' => $serviceid,
    		'linetypeid'=>$linetypeid,
    		'configfields'=>$configfield_entities,
    		'configdataentries'=>$configdata_entities,
    		'entities' =>$service_entities,
    		'nodeid'=>$nodeid
    					 
    		));
    	
    	
    					 
    	
	}    	
    	
    	
    	
}
