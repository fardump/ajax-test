<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'User::index');

$routes->group('province', function ($routes) {
    $routes->get('', 'Province::index');
    $routes->post('add', 'Province::add');
    $routes->get('edit', 'Province::edit');
    $routes->post('update/(:any)', 'Province::update/$1');
    $routes->post('delete/(:any)', 'Province::delete/$1');
    $routes->get('updatenama/(:any)', 'Province::updatenama/$1');
});
$routes->group('user', function ($routes) {
    $routes->get('', 'User::index');
    $routes->add('deleteUsers/(:num)', 'User::deleteUsers/$1');
    $routes->add('add', 'User::add');
    $routes->get('loadTable', 'User::loadTable');
    $routes->POST('update/(:num)', 'User::edit/$1');
});
$routes->group('category', function ($routes) {
    $routes->add('', 'Category::index');
    $routes->add('add', 'Category::add');
    $routes->add('edit/(:num)', 'Category::edit/$1');
    $routes->add('update', 'Category::update');
    $routes->add('delete', 'Category::delete');
});
$routes->group('type', function ($routes) {
    $routes->get('', 'Type::index');
    $routes->post('save', 'Type::save');
    $routes->post('delete/(:any)', 'Type::delete/$1');
    $routes->post('update', 'Type::update');
});
<<<<<<< HEAD
=======

>>>>>>> eb475ff7df5b5c9b388c9bc3850dc6d1cb710e4c
$routes->group('city', function ($routes) {
    $routes->add('', 'City::index');
    $routes->add('getAll', 'City::getAll');
    $routes->Add('form', 'City::form');
<<<<<<< HEAD
=======
    $routes->Add('add', 'City::add');
    $routes->Add('delete/(:any)', 'City::delete/$1');
    $routes->Add('update/(:any)', 'City::update/$1');
>>>>>>> eb475ff7df5b5c9b388c9bc3850dc6d1cb710e4c
});
$routes->group('ekspedition', function ($routes) {
    $routes->get('', 'Ekspedition::index');
});
