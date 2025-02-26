<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'User::index');

$routes->group('province', function($routes){
    $routes->get('', 'Province::index');
});
$routes->group('user', function($routes){
    $routes->get('', 'User::index');
});
$routes->group('category', function($routes){
    $routes->get('', 'Category::index');
});
$routes->group('type', function($routes){
    $routes->get('', 'Type::index');
    $routes->post('save', 'Type::save');
    $routes->post('delete/(:any)', 'Type::delete/$1');
    $routes->post('update', 'Type::update');
});
$routes->group('city', function($routes){
    $routes->get('', 'City::index');
});
$routes->group('ekspedition', function($routes){
    $routes->get('', 'Ekspedition::index');
});
