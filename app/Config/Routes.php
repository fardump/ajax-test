<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'User::index');

$routes->group('province', function ($routes) {
    $routes->add('', 'Province::index');
    $routes->add('getdata', 'Province::getdata');
    $routes->add('add', 'Province::add');
    $routes->add('delete/(:any)', 'Province::delete/$1');
    $routes->add('updateAddress/(:any)', 'Province::updateAddress/$1');
});
$routes->group('user', function ($routes) {
    $routes->get('', 'User::index');
    $routes->add('deleteUsers', 'User::deleteUsers');
    $routes->add('add', 'User::add');
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
    $routes->post('delete', 'Type::delete');
});

$routes->group('city', function ($routes) {
    $routes->add('', 'City::index');
    $routes->add('getAll', 'City::getAll');
    $routes->Add('form', 'City::form');
    $routes->Add('add', 'City::add');
    $routes->Add('delete/(:any)', 'City::delete/$1');
    $routes->Add('update/(:any)', 'City::update/$1');
});
$routes->group('ekspedition', function ($routes) {
    $routes->get('', 'Ekspedition::index');
});
