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
$routes->group('city', function ($routes) {
    $routes->get('', 'City::index');
});
$routes->group('ekspedition', function ($routes) {
    $routes->get('', 'Ekspedition::index');
});
