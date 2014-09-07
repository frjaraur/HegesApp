<?php

namespace HegesApp\ConfigFileBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use HegesApp\ConfigFileBundle\Entity\Configline;
use HegesApp\ConfigFileBundle\Entity\Data;
use HegesApp\ServiceBundle\Entity\Service;
use HegesApp\ConfigFileBundle\Form\ConfiglineType;

/**
 * Configline controller.
 *
 */
class ConfiglineController extends Controller
{
    /**
     * Lists all Configline entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('HegesAppConfigFileBundle:Configline')->findAll();

        return $this->render('HegesAppConfigFileBundle:Configline:index.html.twig', array(
            'entities' => $entities
        ));
    }

    /**
     * Finds and displays a Configline entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('HegesAppConfigFileBundle:Configline')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('ConfiglineController :: showAction :: No existe una linea con id '.$id);
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('HegesAppConfigFileBundle:Configline:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),

        ));
    }

    /**
     * Displays a form to create a new Configline entity.
     *
     */
    public function newAction()
    {
/*     	$numfields = $this->getDoctrine()
    	->getRepository('HegesAppConfigBundle:Configlinetype')
    	->find($fieldsnumber);
 */
    	
    	
        $entity = new Configline();
        $form   = $this->createForm(new ConfiglineType(), $entity);

        return $this->render('HegesAppConfigFileBundle:Configline:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Creates a new Configline entity.
     *
     */
    public function createAction()
    {
        $entity  = new Configline();
        $request = $this->getRequest();
        $form    = $this->createForm(new ConfiglineType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->setFlash('notice', 'Los cambios se realizaron correctamente.');
            return $this->redirect($this->generateUrl('configline_show', array('id' => $entity->getId())));
            
        }

        return $this->render('HegesAppConfigFileBundle:Configline:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing Configline entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('HegesAppConfigFileBundle:Configline')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('ConfiglineController :: editAction :: No existe una linea con id '.$id);
        }

        $editForm = $this->createForm(new ConfiglineType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('HegesAppConfigFileBundle:Configline:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Configline entity.
     *
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('HegesAppConfigFileBundle:Configline')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('ConfiglineController :: updateAction :: No existe una linea con id '.$id);
        }

        $editForm   = $this->createForm(new ConfiglineType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            $this->get('session')->setFlash('notice', 'Los cambios se realizaron correctamente.');

            return $this->redirect($this->generateUrl('configline_edit', array('id' => $id)));
        }

        return $this->render('HegesAppConfigFileBundle:Configline:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Configline entity.
     *
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('HegesAppConfigFileBundle:Configline')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('ConfiglineController :: deleteAction :: No existe una linea con id '.$id);
            }

            $serviceid=$entity->getFkService()->getId();
			
			//$service_entity = $em->getRepository('HegesAppServiceBundle:Service')->find($serviceid);
						
			//$nodeid=$service_entity->getFkNode()->getId();
			
			$nodeid=$entity->getFkService()->getFkNode()->getId();
            
            $em->remove($entity);
            $em->flush();

            $this->get('session')->setFlash('notice', 'Los cambios se realizaron correctamente.');
            
            $configlinetype_entity = $em->getRepository('HegesAppServiceBundle:Service')
            ->getconfiglinetypefromserviceid($serviceid);
            
            $linetypeid=$configlinetype_entity->getId();
            
            if (!$configlinetype_entity) {
            	throw $this->createNotFoundException('ConfiglineController :: deleteAction :: No existen una lineas de configuración validas');
            }
            
            
            $configfield_entities = $em->getRepository('HegesAppConfigFileBundle:Configfield')
            ->findByfkConfiglinetype($linetypeid);
            
            
            $configdata_entities=$em->getRepository('HegesAppServiceBundle:Service')
            ->getdatafromserviceid($serviceid);
            
            
            return $this->render('HegesAppConfigFileBundle:Configfile:index.html.twig', array(
            		'step'=>3,
            		'configlinetype' => $configlinetype_entity,
            		'serviceid' => $serviceid,
            		'linetypeid'=>$linetypeid,
            		'configfields'=>$configfield_entities,
            		'configdataentries'=>$configdata_entities,
					'nodeid'=>$nodeid
            
            ));

            
            
            
        }

        //return $this->redirect($this->generateUrl('configline'));
        throw $this->createNotFoundException('ConfiglineController :: deleteAction :: No pudo borrarse la linea con id '.$id);;
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
    
    
    
    
    
    
    
    public function copyAction($id)
    {
       $original_configline_id=$id;
        $new_configline_entity  = new Configline();
        $request = $this->getRequest();
        //$form    = $this->createForm(new ConfiglineType(), $new_configline_entity);
        //$form->bindRequest($request);

        $session_username=$this->container->get('security.context')->getToken()->getUser();
        
        
        
        //if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            
            //Buscamos la linea original para copiarla...
            $original_configline_entity = $em->getRepository('HegesAppConfigFileBundle:Configline')->findOneById($original_configline_id);
	    
            if (!$original_configline_entity) {   
			throw $this->createNotFoundException('ConfiglineController :: fullcopyAction :: No existe ninguna linea de configuracion con id '.$original_configline_id);                   
                }   		
            
            $new_configline_entity  = new Configline();	    	
            $new_configline_entity->setFkService($original_configline_entity->getFkService());
            $new_configline_entity->setLinestatus($original_configline_entity->getLinestatus());

                
                
            $original_data_entities = $em->getRepository('HegesAppConfigFileBundle:Data')->findByfkConfigline($original_configline_id);
            
            
            //throw $this->createNotFoundException('ConfiglineController :: fullcopyAction :: EXIT');                   
            
            
            if ($original_data_entities) {   
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

                }else{
                    $this->get('session')->setFlash('error', 'No se realizaron los cambios.');
                    return $this->redirect($this->generateUrl('configfile_editconfigfile', array('lineid' => $original_configline_id)));
                }
        //    }else{
          //          $this->get('session')->setFlash('error', 'KAKA No se realizaron los cambios.');
            //        return $this->redirect($this->generateUrl('configfile_editconfigfile', array('lineid' => $original_configline_id)));
             //   }           
             
            $em->flush();
            $this->get('session')->setFlash('notice', 'Los cambios se realizaron correctamente.');
             return $this->redirect($this->generateUrl('configfile_editconfigfile', array('lineid' => $new_configline_entity->getId())));
       
        
        }
    
}
