<?php

namespace HegesApp\NodeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use HegesApp\NodeBundle\Entity\Os;
use HegesApp\NodeBundle\Form\OsType;

/**
 * Os controller.
 *
 */
class OsController extends Controller
{
    /**
     * Lists all Os entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('HegesAppNodeBundle:Os')->findAll();

        return $this->render('HegesAppNodeBundle:Os:index.html.twig', array(
            'entities' => $entities
        ));
    }

    /**
     * Finds and displays a Os entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('HegesAppNodeBundle:Os')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('OSController :: showAction :: No existe un Sistema Operativo con id '.$id);
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('HegesAppNodeBundle:Os:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),

        ));
    }

    /**
     * Displays a form to create a new Os entity.
     *
     */
    public function newAction()
    {
        $entity = new Os();
        $form   = $this->createForm(new OsType(), $entity);

        return $this->render('HegesAppNodeBundle:Os:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Creates a new Os entity.
     *
     */
    public function createAction()
    {
        $entity  = new Os();
        $request = $this->getRequest();
        $form    = $this->createForm(new OsType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->setFlash('notice', 'Los cambios se realizaron correctamente.');
            return $this->redirect($this->generateUrl('os_show', array('id' => $entity->getId())));
            
        }

        return $this->render('HegesAppNodeBundle:Os:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing Os entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('HegesAppNodeBundle:Os')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('OSController :: editAction :: No existe un Sistema Operativo con id '.$id);
        }

        $editForm = $this->createForm(new OsType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('HegesAppNodeBundle:Os:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Os entity.
     *
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('HegesAppNodeBundle:Os')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('OSController :: updateAction :: No existe un Sistema Operativo con id '.$id);
        }

        $editForm   = $this->createForm(new OsType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            $this->get('session')->setFlash('notice', 'Los cambios se realizaron correctamente.');
            return $this->redirect($this->generateUrl('os_edit', array('id' => $id)));
        }

        return $this->render('HegesAppNodeBundle:Os:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Os entity.
     *
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('HegesAppNodeBundle:Os')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('OSController :: deleteAction :: No existe un Sistema Operativo con id '.$id);
            }

            $em->remove($entity);
            $em->flush();
            $this->get('session')->setFlash('notice', 'Los cambios se realizaron correctamente.');
        }

        return $this->redirect($this->generateUrl('os'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
