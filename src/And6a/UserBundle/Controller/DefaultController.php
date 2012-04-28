<?php

namespace And6a\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use And6a\UserBundle\Entity\User as User;

class DefaultController extends Controller
{
  public function viewAction(User $user)
  {
    foreach( $user->getContacts() as $infos )
    {
      //EntityDump($infos);
    }
    return $this->render('And6aUserBundle:Default:view.html.twig', array(
      'user' => $user
    ));
  }

  public function getBadgeAction($user = null, $style = 'badge', $withLink = true)
  {
    $dataUser = array(
      'id'   => 0,
      'name'   => 'Visitor',
      'fname'  => '',
      'class'  => array(
        'name' => '-',
        'salt' => '0',
      ),
      'year'   => 0,
      'promo'  => date('Y'),
      'avatar' => 'https://secure.gravatar.com/avatar/?s=140&d=https://a248.e.akamai.net/assets.github.com%2Fimages%2Fgravatars%2Fgravatar-140.png',
    );

  	if( !is_object($user) )
  		$user = array(
  			'id'   => is_object($user) ? $user['id'] : $user,
  			'name'   => 'Olivarès',
  			'fname'  => 'Georges',
        'username' => 'georges.olivares',
  			'class'  => array(
	  			'name' => 'Informatique & Réseaux',
	  			'salt' => 'IR',
	  		),
	  		'year'   => 1,
	  		'promo'  => date('Y'),
  			'avatar' => 'https://secure.gravatar.com/avatar/4d880c313c08c2a03ff877647e9ad770?s=140&d=https://a248.e.akamai.net/assets.github.com%2Fimages%2Fgravatars%2Fgravatar-140.png',
	  	);

    //$user['avatar'] = 'bundles/and6auser/images/empty-avatar.png';
    
    return $this->render('And6aUserBundle:Default:badge.html.twig', array(
  		'user'  => $user,
  		'style' => $style,
  		'withLink' => $withLink,
	  ));
  }
}
