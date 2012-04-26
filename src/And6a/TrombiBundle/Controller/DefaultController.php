<?php

namespace And6a\TrombiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction($name = 'a')
    {
        return $this->render('And6aTrombiBundle:Default:index.html.twig', array('name' => $name));
    }

    public function userAction($user, $style = 'badge', $withLink = true)
    {
    	if( !is_object($user) )
    		$user = array(
    			'id'     => $user,
    			'name'   => 'Olivarès',
    			'fname'  => 'Georges',
    			'class'  => array(
	    			'name' => 'Informatique & Réseaux',
	    			'salt' => 'IR',
	    		),
	    		'year'   => 1,
	    		'promo'  => date('Y'),
    			'avatar' => 'https://secure.gravatar.com/avatar/4d880c313c08c2a03ff877647e9ad770?s=140&d=https://a248.e.akamai.net/assets.github.com%2Fimages%2Fgravatars%2Fgravatar-140.png',
	    	);
    	
    	return $this->render('And6aTrombiBundle:Default:user.html.twig', array(
    		'user'  => $user,
    		'style' => $style,
    		'withLink' => $withLink,
	    ));
    }
}
