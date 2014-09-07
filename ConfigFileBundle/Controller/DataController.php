<?php

namespace HegesApp\ConfigFileBundle\Controller;

use HegesApp\ConfigFileBundle\Entity\Configline;
use HegesApp\ServiceBundle\Entity\Service;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use HegesApp\ConfigFileBundle\Entity\Data;
use HegesApp\ConfigFileBundle\Form\DataType;

/**
 * Data controller.
 *
 */
class DataController extends Controller
{
	
	

    /**
     * Lists all Data entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('HegesAppConfigFileBundle:Data')->findAll();

        return $this->render('HegesAppConfigFileBundle:Data:index.html.twig', array(
            'entities' => $entities
        ));
    }

    /**
     * Finds and displays a Data entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('HegesAppConfigFileBundle:Data')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Data entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('HegesAppConfigFileBundle:Data:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView()

        ));
    }

    /**
     * Displays a form to create a new Data entity.
     *
     */
    public function newAction($serviceid)
    {  	

    	
    	$entity = new Data();
        $form   = $this->createForm(new DataType(), $entity);
/*         $form   = $this->createForm($entity)
        				->add('creationtime','date')
        				->getForm();
         */
        return $this->render('HegesAppConfigFileBundle:Data:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        	'serviceid'=> $serviceid
        ));

    }

    
    
   
    
    
    
    /**
     * Creates a new Data entity.
     *
     */
    public function createAction($serviceid)
    {
    	$em = $this->getDoctrine()->getEntityManager();
        $entity  = new Data();
        
        
        
        
        
        $request = $this->getRequest();
        $form    = $this->createForm(new DataType(), $entity);
        $form->bindRequest($request);
        $entity->setCreationtime(new \Datetime('now'));
        $entity->setUpdatetime(new \Datetime('now'));

        if ($form->isValid()) {
        	
        	$linea= new Configline();
        	
        	
        	$serviceentity= $em->getRepository('HegesAppServiceBundle:Service')->find($serviceid);
        	$linea->setFkService($serviceentity);
        	$entity->setFkConfigline($linea);
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($linea);
            
            
            
            $em->persist($entity);
            
            
            
            
            $em->flush();
            $this->get('session')->setFlash('notice', 'Los cambios se realizaron correctamente.');
            return $this->redirect($this->generateUrl('data_show', array('id' => $entity->getId())));
            
        }

        return $this->render('HegesAppConfigFileBundle:Data:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing Data entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('HegesAppConfigFileBundle:Data')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Data entity.');
        }

 /*        $configlineid=$entity->getfkConfigline()->getId();
        
        if (!$configline_entity) {
        	throw $this->createNotFoundException('Unable to find Configline entity.');
        }        
        
        $service_entity=$em->getRepository('HegesAppServiceBundle:Configline')->findOneById($configlineid);
        
        $serviceid=$service_entity->getId(); */
        
        $editForm = $this->createForm(new DataType(), $entity);       
        
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('HegesAppConfigFileBundle:Data:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        	/* 'serviceid' => $serviceid */
        ));
    }

    /**
     * Edits an existing Data entity.
     *
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('HegesAppConfigFileBundle:Data')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('DataController:: updateAction :: No existe el dato.');
        }
		
        $entity_previous_value=$entity->getValue();
        
        $editForm   = $this->createForm(new DataType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        $session_username=$this->container->get('security.context')->getToken()->getUser();
        
        $user_entity = $em->getRepository('HegesAppUserBundle:User')->findOneByUsername($session_username);
         
        if (!$user_entity) {
        	throw $this->createNotFoundException('DataController :: updateAction :: No existe el usuario '.$session_username);
        }
         
        $entity->setFkUpdateuser($user_entity);
        
        $entity->setUpdatetime(new \Datetime('now'));
        
       // $lineid=$entity->getFkConfigline()->getId();
        
        $entity->setFkConfigline($entity->getFkConfigline());
                
        if ($editForm->isValid()) {
        	
        	if ($entity_previous_value != $entity->getValue()){
        		$entity->setPreviousvalue($entity_previous_value);
	            $em->persist($entity);
	            $em->flush();
	            $this->get('session')->setFlash('notice', 'Los cambios se realizaron correctamente.');
        	}

            //return $this->redirect($this->generateUrl('data_edit', array('id' => $id)));
        }

/*         return $this->render('HegesAppConfigFileBundle:Data:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        )); */
        
        $lineid=$entity->getFkConfigline()->getId();
        $data_entities = $em->getRepository('HegesAppConfigFileBundle:Data')->findByfkConfigline($lineid);
        
        if (!$data_entities) {
        	throw $this->createNotFoundException('DataController:: updateAction :: No existe el fichero de configuracion indicado.');
        }
        return $this->render('HegesAppConfigFileBundle:Configfile:edit.html.twig', array(
        		'entities'      => $data_entities,
        		'delete_form' => $deleteForm->createView(),
        		'lineid'=>$lineid
        			)
        		);
        
    }

    /**
     * Deletes a Data entity.
     *
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('HegesAppConfigFileBundle:Data')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Data entity.');
            }

            $em->remove($entity);
            $em->flush();
            $this->get('session')->setFlash('notice', 'Los cambios se realizaron correctamente.');
        }

        return $this->redirect($this->generateUrl('data'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
