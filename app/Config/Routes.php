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
    $routes->add('deleteUsers', 'User::deleteUsers');
    $routes->add('add', 'User::add');
});
$routes->group('category', function ($routes) {
    $routes->get('', 'Category::index');
});
$routes->group('type', function ($routes) {
    $routes->get('', 'Type::index');
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
