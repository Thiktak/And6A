<?php

namespace And6a\TrombiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use And6a\TrombiBundle\Entity\Groups as Groups;


class GroupController extends Controller
{
  
  public function indexAction($name = 'a')
  {
    return $this->render('And6aTrombiBundle:Default:index.html.twig', array('name' => $name));
  }

  public function showAction($group)
  {
    //$oGroup = $this->getDoctrine()->getRepository('And6aTrombiBundle:Groups')->findOneBySlug($group);
    $oGroup = $this->getDoctrine()->getRepository('And6aTrombiBundle:Groups')->findOneBySlug($group);
    

    $em = $this->getDoctrine()->getEntityManager();

    $oUsers = $em->createQueryBuilder()
           ->select('u.id, u.username')
           ->from('And6aTrombiBundle:GroupsUser', 'gu')
           ->leftJoin('gu.users', 'u')
           ->where('gu.id = :id')
           ->setParameter('id', $oGroup->getID())
           ->getQuery()
           ->getResult();
    
    if( !$oGroup )
      throw $this->createNotFoundException(sprintf('Group `%s` does not exists', $group));
    
    //EntityDump($oUsers);
    
    return $this->render('And6aTrombiBundle:Group:show.html.twig', array(
      'group' => $oGroup,
      'users' => $oUsers, //$oGroup->getUsers(),
    ));
  }

  public function getMenuAction()
  {
    $_Class = array(array(), array());

  	$oClass = $this->getDoctrine()->getRepository('And6aTrombiBundle:Groups')->findAll(null, array('name'));

    # ORDER BY isClass $_Class[0 or 1][] = CLASS
    foreach( $oClass as $item )
      $_Class[$item->getIsclass()][] = $item;

  	return $this->render('And6aTrombiBundle:Group:menu.html.twig', array(
      'groups' => array_merge($_Class[1], $_Class[0])
	  ));
  }

  public function getMenuYearsAction()
  {
    $aYears = array();

    $em = $this->getDoctrine()->getEntityManager();

    $oYears = $em->createQueryBuilder()
           ->select('gu.year')
           ->from('And6aTrombiBundle:GroupsUser', 'gu')
           ->getQuery()
           ->getResult();

    foreach( $oYears as $year )
      $aYears[$year['year']] = array(
        'value' => $year['year']
      );

    return $this->render('And6aTrombiBundle:Group:menuYears.html.twig', array(
      'years' => $aYears,
    ));
  }
}
