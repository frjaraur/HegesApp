<?php

namespace HegesApp\NodeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use HegesApp\NodeBundle\Entity\Node;
use HegesApp\ServiceBundle\Entity\Service;
use HegesApp\ConfigFileBundle\Entity\Data;
use HegesApp\ConfigFileBundle\Entity\Configline;
use HegesApp\NodeBundle\Form\NodeType;

use HegesApp\MainBundle\HegesAppClasses\HegesAppLog;

/**
 * Node controller.
 *
 */
class NodeController extends Controller
{
	public function mainpageAction()
	{
		return $this->render('HegesAppNodeBundle:Node:main.html.twig');
	}
	
	
    /**
     * Lists all Node entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entities = $em->getRepository('HegesAppNodeBundle:Node')
        ->getAllNodes();
        
        return $this->render('HegesAppNodeBundle:Node:index.html.twig', array(
        		'entities' => $entities
        ));
        
    }

    /**
     * Finds and displays a Node entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('HegesAppNodeBundle:Node')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('NodeController :: showAction :: No existe un nodo con id '.$id);
        }
        
        #$nodename=$entity->getName();
        
        $nodestatus=$em->getRepository('HegesAppNodeBundle:Node')->getovonodestatus($entity->getName());
        $entity->setOvostatus($nodestatus);
        
        //$graph_path="http://heges03.ono.es/pnp4nagios/graph?host=".$entity->getName()."&srv=GBL_COLLECT_UNIX&view=0&source=1&start=-7days";
        #http://heges03.ono.es/pnp4nagios/image?host=am01&srv=GBL_COLLECT_UNIX&view=0&source=1&start=-7days
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('HegesAppNodeBundle:Node:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),

        ));
    }

    /**
     * Displays a form to create a new Node entity.
     *
     */
    public function newAction()
    {
        $entity = new Node();
        $form   = $this->createForm(new NodeType(), $entity);

        return $this->render('HegesAppNodeBundle:Node:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Creates a new Node entity.
     *
     */
    public function createAction()
    {
        $entity  = new Node();
        $request = $this->getRequest();
        $form    = $this->createForm(new NodeType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->setFlash('notice', 'Los cambios se realizaron correctamente.');
            return $this->redirect($this->generateUrl('node_show', array('id' => $entity->getId())));
            
        }

        return $this->render('HegesAppNodeBundle:Node:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing Node entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('HegesAppNodeBundle:Node')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('NodeController :: editAction :: No existe un nodo con id '.$id);
        }
        $nodestatus=$em->getRepository('HegesAppNodeBundle:Node')->getovonodestatus($entity->getName());
        $entity->setOvostatus($nodestatus);
        $editForm = $this->createForm(new NodeType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('HegesAppNodeBundle:Node:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Node entity.
     *
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('HegesAppNodeBundle:Node')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('NodeController :: updateAction :: No existe un nodo con id '.$id);
        }
        
        $nodename=$entity->getName();
        
        $editForm   = $this->createForm(new NodeType(), $entity);
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
                
                $hegesapplogentry->HegesAppLogWriteToLog("El nodo ".$nodename." ha sido modificado.");
            return $this->redirect($this->generateUrl('node_edit', array('id' => $id)));
        }

        return $this->render('HegesAppNodeBundle:Node:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Node entity.
     *
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('HegesAppNodeBundle:Node')->find($id);

            
            $nodename=$entity->getName();
            
            if (!$entity) {
                throw $this->createNotFoundException('NodeController :: deleteAction :: No existe un nodo con id '.$id);
            }

            $em->remove($entity);
            $em->flush();
            $this->get('session')->setFlash('notice', 'Los cambios se realizaron correctamente.');

                $logsource="hegesapp_log_app";
                $hegesapplogentry = new HegesAppLog(
                    $this->container->getParameter('hegesapp_log_dir').$this->container->getParameter($logsource),
                    $this->container->get('security.context')->getToken()->getUser(),
                    $logsource);
                
                $hegesapplogentry->HegesAppLogWriteToLog("El nodo ".$nodename." ha sido borrado.");
            
            
        }

        return $this->redirect($this->generateUrl('node'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
    
    
    public function CopyAction($id)
    {
    	
    	$em = $this->getDoctrine()->getEntityManager();
    	
    	$original_node_entity = $em->getRepository('HegesAppNodeBundle:Node')->findOneById($id);
    	
    	if (!$original_node_entity) {
    		throw $this->createNotFoundException('NodeController :: CopyAction :: No existe el nodo con id '.$id);
    	}

    	$copy_node_entity  = new Node();
    	$request = $this->getRequest();
    	$form    = $this->createForm(new NodeType(), $copy_node_entity);
    	$form->bindRequest($request);

    	//cargamos las propiedades del nodo original
    	
    	
        
        
        
    	$copy_node_entity->setName('Copy of '.$original_node_entity->getName());
    	$copy_node_entity->setDescription($original_node_entity->getDescription());
    	$copy_node_entity->setIp('0.0.0.0');
        $copy_node_entity->setFkNodetype($original_node_entity->getFkNodetype());
        $copy_node_entity->setFkOs($original_node_entity->getFkOs());
        $copy_node_entity->setOvostatus('');

       $editForm = $this->createForm(new NodeType(), $copy_node_entity);
        //$deleteForm = $this->createDeleteForm($id);

        return $this->render('HegesAppNodeBundle:Node:copy.html.twig', array(
            'copy_node_entity'      => $copy_node_entity,
            'form'   => $editForm->createView(),
            'original_node_entity' => $original_node_entity,
            //'delete_form' => $deleteForm->createView(),
        ));    	
    }
    
    private function createCopyForm($id)
    {
    	return $this->createFormBuilder(array('id' => $id))
    	->add('id', 'hidden')
        ->add('fkNodetype','hidden')
        ->add('fkOs','hidden')

    	->getForm()
    	;

//                ->add('fkNodetype','entity',array('label'=> 'Tipo de Nodo', 'class' => 'HegesAppNodeBundle:Nodetype','empty_value' => 'Seleccionar Tipo de Nodo','readonly'=>'true',))
  //      ->add('fkOs','entity',array('label'=> 'Sistema Operativo', 'class' => 'HegesAppNodeBundle:Os','readonly'=>'true',))

    }
    
    
 
    public function fullcopyAction($original_node_id)
    {
        
        // COPIA DE NODO
        
        $new_node_entity = new Node();
        $request = $this->getRequest();
        $form    = $this->createForm(new NodeType(), $new_node_entity);
        $form->bindRequest($request);
        
        $session_username=$this->container->get('security.context')->getToken()->getUser();

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
        
            $em->persist($new_node_entity);
        
        
            //Buscamos los servicios del nodo original para copiarlos.
            
            $original_service_entities=$em->getRepository('HegesAppServiceBundle:Service')->findByfkNode($original_node_id);

             
            if (!$original_service_entities) {   
			throw $this->createNotFoundException('NodeController :: fullcopyAction :: No existe ningun servicio para el nodo con id '.$original_node_id);
		}
        

            foreach ($original_service_entities as $original_service_entity){
                $new_service_entity  = new Service();

                $new_service_entity->setName($original_service_entity->getName());
                $new_service_entity->setFkNode($new_node_entity);
                $new_service_entity->setDescription($original_service_entity->getDescription());
                $new_service_entity->setServicetest($original_service_entity->getServicetest());
                $new_service_entity->setfkMonitor($original_service_entity->getfkMonitor());
                $new_service_entity->setConfigfilename($original_service_entity->getConfigfilename());

                
                
                
                $em->persist($new_service_entity);

                $original_service_id=$original_service_entity->getId();
        
                
            
                //Buscamos las lineas del servicio original para copiarlas...
                $original_configline_entities = $em->getRepository('HegesAppConfigFileBundle:Configline')->findByfkService($original_service_id);

                //if (!$original_configline_entities) {   
                //          throw $this->createNotFoundException('ServiceController :: fullcopyAction :: No existe ninguna linea de configuracion para el servicio con id '.$original_service_id);
                //    }

                if ($original_configline_entities) {
                    foreach ($original_configline_entities as $original_configline_entity){
                        $new_configline_entity  = new Configline();	    	
                        //$new_configline_entity->setFkService($original_configline_entity->getFkService());
                        $new_configline_entity->setFkService($new_service_entity);
                        $new_configline_entity->setLinestatus($original_configline_entity->getLinestatus());

                        $original_configline_id=$original_configline_entity->getId();

                        $original_data_entities = $em->getRepository('HegesAppConfigFileBundle:Data')->findByfkConfigline($original_configline_id);


                        //foreach ($original_data_entities as $original_data_entity){print "<<>>".$original_data_entity->getId();}

                        //continue;          

                        if ($original_data_entities) {   
                                #throw $this->createNotFoundException('select * from DATA where FK_CONFIGLINE_ID=\''.$original_configline_id.'\' 
                                 #   ServiceController :: fullcopyAction :: No existen datos para la linea de configuracion con id '.$original_configline_id);


                            $em->persist($new_configline_entity);

                            foreach ($original_data_entities as $original_data_entity){
                                //print "<p>>> ORIGINAL SERVICE ID: ".$original_service_id;
                                //print " ORIGINAL LINE ID: ".$original_configline_id;
                                //print " ORIGINAL DATA ID: ".$original_data_entity->getId();
                                $new_data_entity = new Data();
                                $new_data_entity->setValue($original_data_entity->getvalue());
                                //$new_data_entity->setFkConfigline($original_data_entity->getfkConfigline());
                                $new_data_entity->setFkConfigline($new_configline_entity);
                                $new_data_entity->setfkConfigfield($original_data_entity->getfkConfigfield());    

                                $new_data_entity->setCreationtime(new \Datetime('now'));

                                $new_data_entity->setUpdatetime(new \Datetime('now'));

                                $new_data_user_entity = $em->getRepository('HegesAppUserBundle:User')->findOneByUsername($session_username);

                                if (!$new_data_user_entity) {
                                        throw $this->createNotFoundException('ServiceController :: fullcopyAction :: No existe el usuario '.$session_username);
                                }

                                $new_data_entity->setFkCreationuser($new_data_user_entity);
                                $new_data_entity->setFkUpdateuser($new_data_user_entity);              
                                $em->persist($new_data_entity);        


                            }

                        }else{continue;}
                    }
                }

            }
                $em->flush();
                //print "<p>>>NEW NODE ID: ".$new_node_entity->getId();
                //throw $this->createNotFoundException('debug');
                $this->get('session')->setFlash('notice', 'Los cambios se realizaron correctamente.');
                return $this->redirect($this->generateUrl('node_show', array('id' => $new_node_entity->getId())));
            

        }    
    
        
    }
    
    
}
