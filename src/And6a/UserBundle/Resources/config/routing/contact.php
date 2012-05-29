<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('contact', new Route('/', array(
    '_controller' => 'And6aUserBundle:Contact:index',
)));

$collection->add('contact_new', new Route('/new', array(
    '_controller' => 'And6aUserBundle:Contact:new',
)));

$collection->add('contact_create', new Route(
    '/create',
    array('_controller' => 'And6aUserBundle:Contact:create'),
    array('_method' => 'post')
));

$collection->add('contact_edit', new Route('/{id}/edit', array(
    '_controller' => 'And6aUserBundle:Contact:edit',
)));

$collection->add('contact_update', new Route(
    '/{id}/update',
    array('_controller' => 'And6aUserBundle:Contact:update'),
    array('_method' => 'post')
));

$collection->add('contact_delete', new Route(
    '/{id}/delete',
    array('_controller' => 'And6aUserBundle:Contact:delete')//,
    //array('_method' => 'post')
));

return $collection;
