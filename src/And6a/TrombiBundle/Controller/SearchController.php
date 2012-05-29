<?php

namespace And6a\TrombiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use And6a\UserBundle\Entity\User as User;


class SearchController extends Controller
{
  public function indexAction($q = '')
  {
    $em = $this->getDoctrine()->getEntityManager();

    $oUsers = $em->createQueryBuilder()
           ->select('u, gu')
           ->from('And6aUserBundle:User', 'u')
           ->leftJoin('u.class_groups', 'gu')
           ->leftJoin('u.contacts', 'c');

    foreach( explode(' ', $q) as $i => $string )
      $oUsers = $oUsers
           ->andWhere('u.username LIKE :q' . $i . ' OR u.email LIKE :q' . $i . ' OR c.value LIKE :q' . $i)
           ->setParameter('q' . $i, '%' . $string . '%');

    $oUsers = $oUsers
           ->orderBy('u.fname, u.name, u.username')
           ->getQuery()
           ->getResult();

    return $this->render('And6aTrombiBundle:Search:index.html.twig', array(
      'users' => $oUsers,
      'q'     => htmlspecialchars($q),
    ));
  }
  
  public function redirectAction()
  {
    return $this->redirect($this->generateUrl('And6aTrombiBundle_search', array('q' => $_GET['q'])));
  }
}
