<?php

namespace And6a\TrombiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction($name = 'a')
    {
        return $this->render('And6aTrombiBundle:Default:index.html.twig', array('name' => $name));
    }
}
