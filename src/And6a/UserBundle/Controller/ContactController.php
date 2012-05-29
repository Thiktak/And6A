<?php

namespace And6a\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use And6a\UserBundle\Entity\Contact;
use And6a\UserBundle\Form\ContactType;

/**
 * Contact controller.
 *
 */
class ContactController extends Controller
{
    /**
     * Lists all Contact entities.
     *
     */
    public function indexAction()
    {
        $User = $this->container->get('security.context')->getToken()->getUser();

        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('And6aUserBundle:Contact')->findByUser($User->getId());

        return $this->render('And6aUserBundle:Contact:index.html.twig', array(
            'entities' => $entities
        ));
    }

    /**
     * Displays a form to create a new Contact entity.
     *
     */
    public function newAction()
    {
        $entity = new Contact();
        $form   = $this->createForm(new ContactType(), $entity);

        return $this->render('And6aUserBundle:Contact:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Creates a new Contact entity.
     *
     */
    public function createAction()
    {
        $User = $this->container->get('security.context')->getToken()->getUser();

        $entity  = new Contact();
        $entity->setUser($User);
        
        $request = $this->getRequest();
        $form    = $this->createForm(new ContactType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('contact'));
            
        }

        return $this->render('And6aUserBundle:Contact:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing Contact entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('And6aUserBundle:Contact')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Contact entity.');
        }

        $editForm = $this->createForm(new ContactType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('And6aUserBundle:Contact:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Contact entity.
     *
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('And6aUserBundle:Contact')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Contact entity.');
        }

        $editForm   = $this->createForm(new ContactType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('contact'));
        }

        return $this->render('And6aUserBundle:Contact:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Contact entity.
     *
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository('And6aUserBundle:Contact')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Contact entity.');
        }
        
        $em->remove($entity);
        $em->flush();
        
        return $this->redirect($this->generateUrl('contact'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
