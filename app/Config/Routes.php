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
    $routes->add('', 'Category::index');
    $routes->add('add', 'Category::add');
    $routes->add('edit/(:num)', 'Category::edit/$1');
    $routes->add('update', 'Category::update');
    $routes->add('delete', 'Category::delete');
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
