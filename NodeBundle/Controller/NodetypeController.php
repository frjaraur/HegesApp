<?php

namespace HegesApp\NodeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use HegesApp\NodeBundle\Entity\Nodetype;
use HegesApp\NodeBundle\Form\NodetypeType;

/**
 * Nodetype controller.
 *
 */
class NodetypeController extends Controller
{
    /**
     * Lists all Nodetype entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('HegesAppNodeBundle:Nodetype')->findAll();

        return $this->render('HegesAppNodeBundle:Nodetype:index.html.twig', array(
            'entities' => $entities
        ));
    }

    /**
     * Finds and displays a Nodetype entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('HegesAppNodeBundle:Nodetype')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('NodetypeController :: showAction :: No existe un tipo de nodo con id '.$id);
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('HegesAppNodeBundle:Nodetype:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),

        ));
    }

    /**
     * Displays a form to create a new Nodetype entity.
     *
     */
    public function newAction()
    {
        $entity = new Nodetype();
        $form   = $this->createForm(new NodetypeType(), $entity);

        return $this->render('HegesAppNodeBundle:Nodetype:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Creates a new Nodetype entity.
     *
     */
    public function createAction()
    {
        $entity  = new Nodetype();
        $request = $this->getRequest();
        $form    = $this->createForm(new NodetypeType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->setFlash('notice', 'Los cambios se realizaron correctamente.');
            return $this->redirect($this->generateUrl('nodetype_show', array('id' => $entity->getId())));
            
        }

        return $this->render('HegesAppNodeBundle:Nodetype:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing Nodetype entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('HegesAppNodeBundle:Nodetype')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('NodetypeController :: editAction :: No existe un tipo de nodo con id '.$id);
        }

        $editForm = $this->createForm(new NodetypeType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('HegesAppNodeBundle:Nodetype:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Nodetype entity.
     *
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('HegesAppNodeBundle:Nodetype')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('NodetypeController :: updateAction :: No existe un tipo de nodo con id '.$id);
        }

        $editForm   = $this->createForm(new NodetypeType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            $this->get('session')->setFlash('notice', 'Los cambios se realizaron correctamente.');
            return $this->redirect($this->generateUrl('nodetype_edit', array('id' => $id)));
        }

        return $this->render('HegesAppNodeBundle:Nodetype:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Nodetype entity.
     *
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('HegesAppNodeBundle:Nodetype')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('NodetypeController :: deleteAction :: No existe un tipo de nodo con id '.$id);
            }

            $em->remove($entity);
            $em->flush();
            $this->get('session')->setFlash('notice', 'Los cambios se realizaron correctamente.');
        }

        return $this->redirect($this->generateUrl('nodetype'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
