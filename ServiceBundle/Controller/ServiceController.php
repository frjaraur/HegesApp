<?php

namespace HegesApp\ServiceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use HegesApp\ServiceBundle\Entity\Service;
use HegesApp\ConfigFileBundle\Entity\Data;
use HegesApp\ConfigFileBundle\Entity\Configline;
use HegesApp\ServiceBundle\Form\ServiceType;

/**
 * Service controller.
 *
 */
class ServiceController extends Controller
{
    /**
     * Lists all Service entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

/*         $entities = $em->getRepository('HegesAppServiceBundle:Service')->findAll(); */
        $entities = $em->getRepository('HegesAppServiceBundle:Service')->getAllServicesByNodeName();

        return $this->render('HegesAppServiceBundle:Service:index.html.twig', array(
            'entities' => $entities
        ));
    }

    /**
     * Finds and displays a Service entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('HegesAppServiceBundle:Service')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('ServiceController :: showAction :: No existe un Servicio con id '.$id);
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('HegesAppServiceBundle:Service:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),

        ));
    }

    /**
     * Displays a form to create a new Service entity.
     *
     */
    public function newAction()
    {
        $entity = new Service();
        $form   = $this->createForm(new ServiceType(), $entity);

        return $this->render('HegesAppServiceBundle:Service:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Creates a new Service entity.
     *
     */
    public function createAction()
    {
        $entity  = new Service();
        $request = $this->getRequest();
        $form    = $this->createForm(new ServiceType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->setFlash('notice', 'Los cambios se realizaron correctamente.');
            return $this->redirect($this->generateUrl('service_show', array('id' => $entity->getId())));
            
        }

        return $this->render('HegesAppServiceBundle:Service:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing Service entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('HegesAppServiceBundle:Service')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('ServiceController :: editAction :: No existe un Servicio con id '.$id);
        }

        $editForm = $this->createForm(new ServiceType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('HegesAppServiceBundle:Service:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Service entity.
     *
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('HegesAppServiceBundle:Service')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('ServiceController :: updateAction :: No existe un Servicio con id '.$id);
        }

        $editForm   = $this->createForm(new ServiceType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            $this->get('session')->setFlash('notice', 'Los cambios se realizaron correctamente.');
            return $this->redirect($this->generateUrl('service_edit', array('id' => $id)));
        }

        return $this->render('HegesAppServiceBundle:Service:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Service entity.
     *
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('HegesAppServiceBundle:Service')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('ServiceController :: deleteAction :: No existe un Servicio con id '.$id);
            }

            $em->remove($entity);
            $em->flush();
            $this->get('session')->setFlash('notice', 'Los cambios se realizaron correctamente.');
        }

        return $this->redirect($this->generateUrl('service'));
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
    	
    	$original_entity = $em->getRepository('HegesAppServiceBundle:Service')->findOneById($id);
    	
    	if (!$original_entity) {
    		throw $this->createNotFoundException('ServiceController :: CopyAction :: No existe el servicio con id '.$id);
    	}

    	$copy_entity  = new Service();
    	$request = $this->getRequest();
    	$form    = $this->createForm(new ServiceType(), $copy_entity);
    	$form->bindRequest($request);

    	//cargamos las propiedades del servicio original
    	
    	//$em = $this->getDoctrine()->getEntityManager();
    		
    	$copy_entity->setName('Copy of '.$original_entity->getName());
    	$copy_entity->setDescription($original_entity->getDescription());
    	$copy_entity->setServicetest($original_entity->getServicetest());
        $copy_entity->setfkMonitor($original_entity->getfkMonitor());
        $copy_entity->setConfigfilename($original_entity->getConfigfilename());

    	
    	// Creacion de monitor DUMMY para evitar errores de lineas-monitores reales duplicados

        $editForm = $this->createForm(new ServiceType(), $copy_entity);
        //$deleteForm = $this->createDeleteForm($id);

        return $this->render('HegesAppServiceBundle:Service:copy.html.twig', array(
            'entity'      => $copy_entity,
            'form'   => $editForm->createView(),
            'original_entity' => $original_entity,
            //'delete_form' => $deleteForm->createView(),
        ));    	
    }
    
    private function createCopyForm($id)
    {
    	return $this->createFormBuilder(array('id' => $id))
    	->add('id', 'hidden')
    	->getForm()
    	;
    }
    
 
    public function fullcopyAction($original_service_id)
    {
        $new_service_entity  = new Service();
        $request = $this->getRequest();
        $form    = $this->createForm(new ServiceType(), $new_service_entity);
        $form->bindRequest($request);

        $session_username=$this->container->get('security.context')->getToken()->getUser();
        
        
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($new_service_entity);
            
            //Buscamos las lineas del servicio original para copiarlas...
            $original_configline_entities = $em->getRepository('HegesAppConfigFileBundle:Configline')->findByfkService($original_service_id);
	    
            if (!$original_configline_entities) {   
			//throw $this->createNotFoundException('ServiceController :: fullcopyAction :: No existe ninguna linea de configuracion para el servicio con id '.$original_service_id);
                    $em->flush();
                    $this->get('session')->setFlash('notice', 'Los cambios se realizaron correctamente.');
                    //return $this->redirect($this->generateUrl('service_show', array('id' => $entity->getId())));
                    return $this->redirect($this->generateUrl('service_show', array('id' => $new_service_entity->getId())));
                
                }
   		
                
            foreach ($original_configline_entities as $original_configline_entity){
                $new_configline_entity  = new Configline();	    	
		//$new_configline_entity->setFkService($original_configline_entity->getFkService());
                $new_configline_entity->setFkService($new_service_entity);
                $new_configline_entity->setLinestatus($original_configline_entity->getLinestatus());

                $original_configline_id=$original_configline_entity->getId();
                
                $original_data_entities = $em->getRepository('HegesAppConfigFileBundle:Data')->findByfkConfigline($original_configline_id);
	    
                //print "<p>>>".$original_configline_id."\n";
                //foreach ($original_data_entities as $original_data_entity){print "<<>>".$original_data_entity->getId();}
                
                //continue;          
               
                if ($original_data_entities) {   
			#throw $this->createNotFoundException('select * from DATA where FK_CONFIGLINE_ID=\''.$original_configline_id.'\' 
                         #   ServiceController :: fullcopyAction :: No existen datos para la linea de configuracion con id '.$original_configline_id);
                            
                
                    $em->persist($new_configline_entity);

                    foreach ($original_data_entities as $original_data_entity){
                                               
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
       
             
            $em->flush();
            $this->get('session')->setFlash('notice', 'Los cambios se realizaron correctamente.');
            //return $this->redirect($this->generateUrl('service_show', array('id' => $entity->getId())));
            return $this->redirect($this->generateUrl('service_show', array('id' => $new_service_entity->getId())));
//                	return $this->render('HegesAppConfigFileBundle:Configfile:index.html.twig', array(
//    			'step'=>3,
//    			'configlinetype' => $configlinetype_entity,
//    			'serviceid' => $serviceid, 
//    			'linetypeid'=>$linetypeid,
//    			'configfields'=>$configfield_entities,
//    			'configdataentries'=>$configdata_entities
//
//    	));
            
        }

//        return $this->render('HegesAppServiceBundle:Service:new.html.twig', array(
//            'entity' => $entity,
//            'form'   => $form->createView()
//        ));
    }    
    
    
    
}
