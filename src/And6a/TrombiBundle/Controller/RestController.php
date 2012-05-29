<?php

namespace And6a\TrombiBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


class RestController extends Controller
{


 /**
  * @Route("/login/{username}/{password}", defaults={"password" = 0})
  */
  public function getLogin($username, $password = null) {
    $user = $this->getDoctrine()->getRepository('And6aUserBundle:User')->findOneByUsername($username);

    if( !$user )
      return new Response(json_encode(array('error' => 'bad_login')));

    $factory = $this->get('security.encoder_factory');
    $encoder = $factory->getEncoder($user);
    $encodedPassword = $encoder->encodePassword($password, $user->getSalt());

    if( $user->getPassword() != $encodedPassword )
      return new Response(json_encode(array('error' => 'bad_password')));

    return new Response(json_encode(array(
      'id'   => $user->getId(),
      'salt' => $user->getSalt(),
    )));
  }
  
 /**
  * @Route("/{salt}/users/get")
  */
  public function getUsersAction($salt, $q = null)
  {
    $em = $this->getDoctrine()->getEntityManager();

    if( !$this->getDoctrine()->getRepository('And6aUserBundle:User')->findOneBySalt($salt) )
      return new Response(json_encode(array('error' => 'bad_login')));


    $oUsers = $em->createQueryBuilder()
           ->select('u')
           ->from('And6aUserBundle:User', 'u')
           ->leftJoin('u.class_groups', 'gu')
           //->where('gu.group_id = :id')
           ->orderBy('u.name, u.fname')
           ->groupBy('u.id')
           //->setParameter('id', $oGroup->getID())
           ->andWhere('gu.year > :year')
           ->setParameter('year', date('Y')-2)
           ->getQuery()
           ->getResult();

    $aUsers = array();
    foreach( $oUsers as $user ) {
      $_user['id']       = $user->getID();
      $_user['name']     = $user->getName();
      $_user['lastName'] = $user->getFname();
      $_user['promo']    = ( $user->getCurrent() ) ? $user->getCurrent()->getYear() : 0;
      $_user['class']    = ( $user->getCurrent() ) ? $user->getCurrent()->getGroups()->getSlug() : 0;
      $_user['year']     = ( $user->getCurrent() ) ? $user->getCurrent()->getLevel() : 0;;
      $_user['email']    = $user->getEmail();
      $_user['tel']      = '';

      $aUsers[] = $_user;
    }

    return new Response(json_encode($aUsers));
  }

  /**
  * @Route("/{salt}/users/get/{id}")
  */
  public function getUserAction($salt, $id)
  {
    $em = $this->getDoctrine()->getEntityManager();

    if( !$this->getDoctrine()->getRepository('And6aUserBundle:User')->findOneBySalt($salt) )
      return new Response(json_encode(array('error' => 'bad_login')));


    $user = $this->getDoctrine()->getRepository('And6aUserBundle:User')->findOneById($id);

      $_user['id']       = $user->getID();
      $_user['name']     = $user->getName();
      $_user['lastName'] = $user->getFname();
      $_user['promo']    = ( $user->getCurrent() ) ? $user->getCurrent()->getYear() : 0;
      $_user['class']    = ( $user->getCurrent() ) ? $user->getCurrent()->getGroups()->getSlug() : 0;
      $_user['year']     = ( $user->getCurrent() ) ? $user->getCurrent()->getLevel() : 0;;
      $_user['email']    = $user->getEmail();
      $_user['tel']      = '';

    return new Response(json_encode($_user));
  }

 /**
  * @Route("/{salt}/groups/get")
  */
  public function getGroupsAction($salt, $q = null)
  {
    $em = $this->getDoctrine()->getEntityManager();

    if( !$this->getDoctrine()->getRepository('And6aUserBundle:User')->findOneBySalt($salt) )
      return new Response(json_encode(array('error' => 'bad_login')));


    $oUsers = $em->createQueryBuilder()
           ->select('g')
           ->from('And6aTrombiBundle:Groups', 'g')
           ->getQuery()
           ->getResult();

    $aUsers = array();
    foreach( $oUsers as $user ) {
      $_user['id']       = $user->getID();
      $_user['title']    = $user->getName();
      $_user['slug']     = $user->getSlug();
      //$_user['users']    = count($user->getUsers());
      $aUsers[] = $_user;
    }

    return new Response(json_encode($aUsers));
  }
}