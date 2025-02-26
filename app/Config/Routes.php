<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'User::index');

$routes->group('province', function($routes){
    $routes->get('', 'Province::index');
    $routes->post('add', 'Province::add');
    $routes->get('edit', 'Province::edit');
    $routes->post('update', 'Province::update');
    $routes->post('delete', 'Province::delete');
});
$routes->group('user', function($routes){
    $routes->get('', 'User::index');
});
$routes->group('category', function($routes){
    $routes->get('', 'Category::index');
});
$routes->group('type', function($routes){
    $routes->get('', 'Type::index');
});
$routes->group('city', function($routes){
    $routes->add('', 'City::index');
    $routes->Add('form', 'City::form');
});
$routes->group('ekspedition', function($routes){
    $routes->get('', 'Ekspedition::index');
});
