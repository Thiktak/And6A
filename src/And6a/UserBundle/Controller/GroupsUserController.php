<?php

namespace And6a\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use And6a\TrombiBundle\Entity\GroupsUser;
use And6a\UserBundle\Entity\User;
use And6a\UserBundle\Form\GroupsUserType;

/**
 * GroupsUser controller.
 *
 */
class GroupsUserController extends Controller
{
    /**
     * Lists all GroupsUser entities.
     *
     */
    public function indexAction()
    {
        $User = $this->container->get('security.context')->getToken()->getUser();

        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('And6aTrombiBundle:GroupsUser')->findBy(
            array('user_id' => $User->getID()),
            array(
                'year' => 'asc',
                'group_id' => 'asc',
            )
        );

        return $this->render('And6aUserBundle:GroupsUser:index.html.twig', array(
            'entities' => $entities
        ));
    }

    /**
     * Finds and displays a GroupsUser entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('And6aTrombiBundle:GroupsUser')->findById($id, 'year');

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find GroupsUser entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('And6aUserBundle:GroupsUser:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),

        ));
    }

    /**
     * Displays a form to create a new GroupsUser entity.
     *
     */
    public function newAction($type = null, $slug = null)
    {
        $entity = new GroupsUser();

        if( $slug ) {
            $em = $this->getDoctrine()->getEntityManager();
            $group = $em->getRepository('And6aTrombiBundle:Groups')->findOneBySlug($slug);
            if (!$group) {
                throw $this->createNotFoundException('Unable to find Groups entity.');
            }
            $entity->setGroups($group);
        }


        $form   = $this->createForm(new GroupsUserType($type), $entity);

        return $this->render('And6aUserBundle:GroupsUser:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'type'   => $type,
        ));
    }

    /**
     * Creates a new GroupsUser entity.
     *
     */
    public function createAction()
    {
        $User = $this->container->get('security.context')->getToken()->getUser();

        $entity  = new GroupsUser();
        $entity->setUsers($User);
        $request = $this->getRequest();
        $form    = $this->createForm(new GroupsUserType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('groups'));
            
        }

        return $this->render('And6aUserBundle:GroupsUser:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing GroupsUser entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('And6aTrombiBundle:GroupsUser')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find GroupsUser entity.');
        }

        $isClass = $entity->getGroups()->getIsclass();
        $editForm = $this->createForm(new GroupsUserType($isClass + 1), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('And6aUserBundle:GroupsUser:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing GroupsUser entity.
     *
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('And6aTrombiBundle:GroupsUser')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find GroupsUser entity.');
        }

        $editForm   = $this->createForm(new GroupsUserType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('groups'));
        }

        return $this->render('And6aUserBundle:GroupsUser:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a GroupsUser entity.
     *
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository('And6aTrombiBundle:GroupsUser')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find GroupsUser entity.');
        }

        $em->remove($entity);
        $em->flush();

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
