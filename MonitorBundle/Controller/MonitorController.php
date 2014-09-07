<?php

namespace HegesApp\MonitorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use HegesApp\MonitorBundle\Entity\Monitor;
use HegesApp\MonitorBundle\Form\MonitorType;

/**
 * Monitor controller.
 *
 */
class MonitorController extends Controller
{
    /**
     * Lists all Monitor entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('HegesAppMonitorBundle:Monitor')->findAll();

        return $this->render('HegesAppMonitorBundle:Monitor:index.html.twig', array(
            'entities' => $entities
        ));
    }

    /**
     * Finds and displays a Monitor entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('HegesAppMonitorBundle:Monitor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('MonitorController:: showAction :: No existe un monitor con id '.$id);
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('HegesAppMonitorBundle:Monitor:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),

        ));
    }

    /**
     * Displays a form to create a new Monitor entity.
     *
     */
    public function newAction()
    {
        $entity = new Monitor();
        $form   = $this->createForm(new MonitorType(), $entity);

        return $this->render('HegesAppMonitorBundle:Monitor:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Creates a new Monitor entity.
     *
     */
    public function createAction()
    {
        $entity  = new Monitor();
        $request = $this->getRequest();
        $form    = $this->createForm(new MonitorType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->setFlash('notice', 'Los cambios se realizaron correctamente.');
            return $this->redirect($this->generateUrl('monitor_show', array('id' => $entity->getId())));
            
        }

        return $this->render('HegesAppMonitorBundle:Monitor:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing Monitor entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('HegesAppMonitorBundle:Monitor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('MonitorController:: editAction :: No existe un monitor con id '.$id);
        }

        $editForm = $this->createForm(new MonitorType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('HegesAppMonitorBundle:Monitor:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Monitor entity.
     *
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('HegesAppMonitorBundle:Monitor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('MonitorController:: updateAction :: No existe un monitor con id '.$id);
        }

        $editForm   = $this->createForm(new MonitorType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            $this->get('session')->setFlash('notice', 'Los cambios se realizaron correctamente.');
            return $this->redirect($this->generateUrl('monitor_edit', array('id' => $id)));
        }

        return $this->render('HegesAppMonitorBundle:Monitor:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Monitor entity.
     *
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('HegesAppMonitorBundle:Monitor')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('MonitorController:: deleteAction :: No existe un monitor con id '.$id);
            }

            $em->remove($entity);
            $em->flush();
            $this->get('session')->setFlash('notice', 'Los cambios se realizaron correctamente.');
        }

        return $this->redirect($this->generateUrl('monitor'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
