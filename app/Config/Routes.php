<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'User::index');

$routes->group('province', function ($routes) {
    $routes->get('', 'Province::index');
});
$routes->group('user', function ($routes) {
    $routes->get('', 'User::index');
    $routes->add('deleteUsers', 'User::deleteUsers');
    $routes->add('add', 'User::add');
});
$routes->group('category', function ($routes) {
    $routes->get('', 'Category::index');
});
$routes->group('type', function ($routes) {
    $routes->get('', 'Type::index');
});
<<<<<<< HEAD
$routes->group('city', function ($routes) {
    $routes->get('', 'City::index');
=======
$routes->group('city', function($routes){
    $routes->add('', 'City::index');
    $routes->add('getAll', 'City::getAll');
    $routes->Add('form', 'City::form');
<<<<<<< HEAD
    $routes->Add('add', 'City::add');
    $routes->Add('delete/(:any)', 'City::delete/$1');
    $routes->Add('update/(:any)', 'City::update/$1');
=======
>>>>>>> 9ebfd9fafbc8c939211d27d619f50ab51c04cb3a
>>>>>>> development
});
$routes->group('ekspedition', function ($routes) {
    $routes->get('', 'Ekspedition::index');
});
