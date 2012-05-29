<?php

namespace And6a\TrombiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use And6a\TrombiBundle\Entity\Groups as Groups;


class GroupController extends Controller
{
  public function showAction($group, $year = null)
  {
    //$oGroup = $this->getDoctrine()->getRepository('And6aTrombiBundle:Groups')->findOneBySlug($group);
    $oGroup = $this->getDoctrine()->getRepository('And6aTrombiBundle:Groups')->findOneBySlug($group);
    
    if( !$oGroup )
      throw $this->createNotFoundException(sprintf('Group `%s` does not exists', $group));

    $em = $this->getDoctrine()->getEntityManager();

    $oUsers = $em->createQueryBuilder()
           /*->select('u.id, u.username, gu')
           ->from('And6aTrombiBundle:GroupsUser', 'gu')
           //->from('And6aTrombiBundle:Groups', 'g')
           ->leftJoin('gu.users', 'u')
           ->leftJoin('gu.groups', 'g')*/
           //->select('u.id, u.username, u.name, u.fname, u.email')
           ->select('u, gu')
           ->from('And6aUserBundle:User', 'u')
           ->leftJoin('u.class_groups', 'gu')
           //->setMaxResults(75)
           ->where('gu.group_id = :id')
           ->orderBy('u.name, u.fname')
           ->groupBy('u.id')
           ->setParameter('id', $oGroup->getID());

    if( $year )
      $oUsers = $oUsers
           ->andWhere('gu.year = :year')
           ->setParameter('year', $year);
    else
      $oUsers = $oUsers
           ->andWhere('gu.year > :year')
           ->setParameter('year', date('Y')-2);
    
    $oUsers = $oUsers
           ->getQuery()
           ->getResult();
    
    return $this->render('And6aTrombiBundle:Group:show.html.twig', array(
      'group' => $oGroup,
      'users' => $oUsers, //$oGroup->getUsers(),
      'user'  => $this->get("security.context")->getToken()->getUser(),
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
      'groups' => $_Class,//array_merge($_Class[1], $_Class[0])
	  ));
  }

  public function getMenuYearsAction()
  {
    $aYears = array();

    $em = $this->getDoctrine()->getEntityManager();

    $oYears = $em->createQueryBuilder()
           ->select('gu.year')
           ->from('And6aTrombiBundle:GroupsUser', 'gu')
           ->orderBy('gu.year')
           ->getQuery()
           ->getResult();

    foreach( $oYears as $year )
      $aYears[$year['year']] = array(
        'value' => $year['year'],
        'group' => $this->getRequest()->query->get('group')
      );
    
    //EntityDump($this->container->parameters);
    list($group) = explode('/', trim($this->getRequest()->getPathInfo(), '/'));

    return $this->render('And6aTrombiBundle:Group:menuYears.html.twig', array(
      'years' => $aYears,
      'group' => $group,
      'isIn'  => array_key_exists($group, $this->getAllGroups()),
      'max'   => max(array_keys($aYears))
    ));
  }

  protected function getAllGroups() {
    $aGroups = array();
    $oGroups = $this->getDoctrine()->getRepository('And6aTrombiBundle:Groups')->findAll(null, array('name'));
    foreach( $oGroups as $group )
      $aGroups[$group->getSlug()] = $group;

    return $aGroups;
  }
}
