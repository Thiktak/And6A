<?php

namespace And6a\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use And6a\TrombiBundle\Entity\Groups;
use And6a\UserBundle\Form\GroupsType;

/**
 * Groups controller.
 *
 */
class GroupsController extends Controller
{
    /**
     * Lists all Groups entities.
     *
     */
    public function indexAction()
    {
        $User = $this->container->get('security.context')->getToken()->getUser();

        $em = $this->getDoctrine()->getEntityManager();

        //$entities = $em->getRepository('And6aTrombiBundle:Groups')->findByUsers($User);
        $entities =  $em->createQueryBuilder()
           ->select('g, gu')
           ->from('And6aTrombiBundle:Groups', 'g')
           ->leftJoin('g.users', 'gu')
           ->where('gu.user_id = :id')
           ->setParameter('id', $User->getId())
           ->getQuery()
           ->getResult();

        return $this->render('And6aUserBundle:Groups:index.html.twig', array(
            'entities' => $entities
        ));
    }

    /**
     * Finds and displays a Groups entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('And6aTrombiBundle:Groups')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Groups entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('And6aUserBundle:Groups:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),

        ));
    }

    /**
     * Displays a form to create a new Groups entity.
     *
     */
    public function newAction()
    {
        $entity = new Groups();
        $form   = $this->createForm(new GroupsType(), $entity);

        return $this->render('And6aUserBundle:Groups:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Creates a new Groups entity.
     *
     */
    public function createAction()
    {
        $entity  = new Groups();
        $request = $this->getRequest();
        $form    = $this->createForm(new GroupsType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('groups_show', array('id' => $entity->getId())));
            
        }

        return $this->render('And6aUserBundle:Groups:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing Groups entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('And6aTrombiBundle:Groups')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Groups entity.');
        }

        $editForm = $this->createForm(new GroupsType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('And6aUserBundle:Groups:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Groups entity.
     *
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('And6aTrombiBundle:Groups')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Groups entity.');
        }

        $editForm   = $this->createForm(new GroupsType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('groups_edit', array('id' => $id)));
        }

        return $this->render('And6aUserBundle:Groups:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Groups entity.
     *
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('And6aTrombiBundle:Groups')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Groups entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('groups'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
