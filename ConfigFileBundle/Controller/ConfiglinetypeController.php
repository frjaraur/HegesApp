<?php

namespace HegesApp\ConfigFileBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use HegesApp\ConfigFileBundle\Entity\Configlinetype;

use HegesApp\ConfigFileBundle\Form\ConfiglinetypeType;
use HegesApp\ConfigFileBundle\Entity\Configfield;
use HegesApp\ConfigFileBundle\Form\ConfigfieldType;
use HegesApp\MonitorBundle\Entity\Monitor;
use HegesApp\MonitorBundle\Form\MonitorType;

/**
 * Configlinetype controller.
 *
 */
class ConfiglinetypeController extends Controller
{
    /**
     * Lists all Configlinetype entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('HegesAppConfigFileBundle:Configlinetype')->findAll();

        return $this->render('HegesAppConfigFileBundle:Configlinetype:index.html.twig', array(
            'entities' => $entities
        ));
    }

    /**
     * Finds and displays a Configlinetype entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('HegesAppConfigFileBundle:Configlinetype')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('ConfiglinetypeController :: showAction :: No existe un tipo de linea con id '.$id);
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('HegesAppConfigFileBundle:Configlinetype:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),

        ));
    }

    /**
     * Displays a form to create a new Configlinetype entity.
     *
     */
    public function newAction()
    {
        $entity = new Configlinetype();
        $form   = $this->createForm(new ConfiglinetypeType(), $entity);

        return $this->render('HegesAppConfigFileBundle:Configlinetype:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Creates a new Configlinetype entity.
     *
     */
    public function createAction()
    {
        $entity  = new Configlinetype();
        $request = $this->getRequest();
        $form    = $this->createForm(new ConfiglinetypeType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->setFlash('notice', 'Los cambios se realizaron correctamente.');
            return $this->redirect($this->generateUrl('configlinetype_show', array('id' => $entity->getId())));
            
        }

        return $this->render('HegesAppConfigFileBundle:Configlinetype:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing Configlinetype entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('HegesAppConfigFileBundle:Configlinetype')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('ConfiglinetypeController :: editAction :: No existe un tipo de linea con id '.$id);
        }

        $editForm = $this->createForm(new ConfiglinetypeType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('HegesAppConfigFileBundle:Configlinetype:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Configlinetype entity.
     *
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('HegesAppConfigFileBundle:Configlinetype')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('ConfiglinetypeController :: updateAction :: No existe un tipo de linea con id '.$id);
        }

        $editForm   = $this->createForm(new ConfiglinetypeType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            $this->get('session')->setFlash('notice', 'Los cambios se realizaron correctamente.');
            return $this->redirect($this->generateUrl('configlinetype_edit', array('id' => $id)));
        }

        return $this->render('HegesAppConfigFileBundle:Configlinetype:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Configlinetype entity.
     *
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('HegesAppConfigFileBundle:Configlinetype')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('ConfiglinetypeController :: deleteAction :: No existe un tipo de linea con id '.$id);
            }

            $em->remove($entity);
            $em->flush();
            $this->get('session')->setFlash('notice', 'Los cambios se realizaron correctamente.');
        }

        return $this->redirect($this->generateUrl('configlinetype'));
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
    	
    	$original_entity = $em->getRepository('HegesAppConfigFileBundle:Configlinetype')->findOneById($id);
    	
    	if (!$original_entity) {
    		throw $this->createNotFoundException('ConfiglinetypeController :: CopyAction :: No existe un tipo de linea con id '.$id);
    	}

    	$copy_entity  = new Configlinetype();
    	$request = $this->getRequest();
    	$form    = $this->createForm(new ConfiglinetypeType(), $copy_entity);
    	$form->bindRequest($request);

    	//cargamos las propiedades del tipo de linea original
    	
    	$em = $this->getDoctrine()->getEntityManager();
    		
    	$copy_entity->setName('Copy of '.$original_entity->getName());
    	$copy_entity->setFieldsnumber($original_entity->getFieldsnumber());
    	$copy_entity->setDelimiter($original_entity->getDelimiter());

    	
    	// Creacion de monitor DUMMY para evitar errores de lineas-monitores reales duplicados

    	
    	$dummy_monitor_name="MONITOR_PLANTILLA";
    	
    	$dummy_monitor= $em->getRepository('HegesAppMonitorBundle:Monitor')->findOneByName($dummy_monitor_name);   
    	
    	if (!$dummy_monitor) {

    		$dummy_monitor=new Monitor();
    		
    		$dummy_monitor->setName($dummy_monitor_name);
    		
    		$dummy_monitor->setExecname('');
    		$dummy_monitor->setParams('');
    		$dummy_monitor->setDescription('Monitor Plantilla para la duplicación de lineas de configuración');
    		$dummy_monitor->setLastversion('');
    		$em->persist($dummy_monitor);
    	
    	}
    	    	
    		//$copy_entity->setFkMonitor($original_entity->getFkMonitor());
    		$copy_entity->setFkMonitor($dummy_monitor);
    	

    		
    	//Guardamos el tipo de linea nueva
    		
    	$em->persist($copy_entity);
    		
    	//cargamos todas las entidades de tipo campo de este tipo de linea
    		
    	$original_linefields=$em->getRepository('HegesAppConfigFileBundle:Configfield')->findByFkConfiglinetype($id);
    		
    	if (!$original_linefields) {
    		//throw $this->createNotFoundException('ConfiglinetypeController :: CopyAction :: No existen campos con id de linea '.$id.' crea primero los campos para poder copiar la linea completa, con todos sus campos.');
    		$this->get('session')->setFlash('error', 'No existen campos con id de linea '.$id.', crea primero los campos para poder copiar la linea completa, con todos sus campos.');
    		return $this->redirect($this->generateUrl('configlinetype_show', array('id' => $id)));
    		
    	}

    	
    		
    	foreach ($original_linefields as $original_linefield){
    		$copy_linefield=new Configfield();
    		$copy_linefield->setFieldname($original_linefield->getFieldname());
    		$copy_linefield->setFieldorder($original_linefield->getFieldorder());
    		$copy_linefield->setFielddesc($original_linefield->getFielddesc());
    		$copy_linefield->setFkConfiglinetype($copy_entity);
    		$em->persist($copy_linefield);    		
    	}
    		$em->flush();
    		$this->get('session')->setFlash('notice', 'Copia de tipo de linea realizada correctamente.');
    		return $this->redirect($this->generateUrl('configlinetype_show', array('id' => $copy_entity->getId())));
    	
    }
    
    private function createCopyForm($id)
    {
    	return $this->createFormBuilder(array('id' => $id))
    	->add('id', 'hidden')
    	->getForm()
    	;
    }
    
    
}
