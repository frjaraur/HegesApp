<?php

namespace HegesApp\ConfigFileBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use HegesApp\ConfigFileBundle\Entity\Configfield;
use HegesApp\ConfigFileBundle\Form\ConfigfieldType;

/**
 * Configfield controller.
 *
 */
class ConfigfieldController extends Controller
{
    /**
     * Lists all Configfield entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('HegesAppConfigFileBundle:Configfield')->findAll();

        return $this->render('HegesAppConfigFileBundle:Configfield:index.html.twig', array(
            'entities' => $entities
        ));
    }

    /**
     * Finds and displays a Configfield entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('HegesAppConfigFileBundle:Configfield')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('ConfigfieldController :: showAction :: No existe un campo del fichero de configuracion con id '.$id);
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('HegesAppConfigFileBundle:Configfield:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),

        ));
    }

    /**
     * Displays a form to create a new Configfield entity.
     *
     */
    public function newAction()
    {
        $entity = new Configfield();
        $form   = $this->createForm(new ConfigfieldType(), $entity);

        return $this->render('HegesAppConfigFileBundle:Configfield:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Creates a new Configfield entity.
     *
     */
    public function createAction()
    {
        $entity  = new Configfield();
        $request = $this->getRequest();
        $form    = $this->createForm(new ConfigfieldType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->setFlash('notice', 'Los cambios se realizaron correctamente.');
            return $this->redirect($this->generateUrl('configfield_show', array('id' => $entity->getId())));
            
        }

        return $this->render('HegesAppConfigFileBundle:Configfield:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing Configfield entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('HegesAppConfigFileBundle:Configfield')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('ConfigfieldController :: editAction :: No existe un campo del fichero de configuracion con id '.$id);
        }

        $editForm = $this->createForm(new ConfigfieldType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('HegesAppConfigFileBundle:Configfield:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Configfield entity.
     *
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('HegesAppConfigFileBundle:Configfield')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('ConfigfieldController :: updateAction :: No existe un campo del fichero de configuracion con id '.$id);
        }

        $editForm   = $this->createForm(new ConfigfieldType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            $this->get('session')->setFlash('notice', 'Los cambios se realizaron correctamente.');
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
                throw $this->createNotFoundException('ConfigfieldController :: deleteAction :: No existe un campo del fichero de configuracion con id '.$id);
            }

            $em->remove($entity);
            $em->flush();
            $this->get('session')->setFlash('notice', 'Los cambios se realizaron correctamente.');
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
}
