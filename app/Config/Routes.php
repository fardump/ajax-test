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
    $routes->add('deleteUsers/(:num)', 'User::deleteUsers/$1');
    $routes->add('add', 'User::add');
    $routes->get('loadTable', 'User::loadTable');
    $routes->POST('update', 'User::update');
});
$routes->group('category', function ($routes) {
    $routes->add('', 'Category::index');
    $routes->add('table', 'Category::table');
    $routes->add('add', 'Category::add');
    $routes->add('delete', 'Category::delete');
    $routes->add('updateCheck/(:num)', 'Category::updateCheck/$1');
    $routes->add('updateCategory/(:num)', 'Category::updateCategory/$1');
    $routes->add('search', 'Category::search');
    $routes->add('print', 'Category::print');
});

$routes->group('type', function ($routes) {
    $routes->get('', 'Type::index');
    $routes->post('save', 'Type::save');
    $routes->post('delete/(:num)', 'Type::delete/$1');
    $routes->post('update', 'Type::update');
    $routes->get('loadTable', 'Type::loadTable');
});
$routes->group('city', function ($routes) {
    $routes->add('', 'City::index');
    $routes->add('getAll', 'City::getAll');
    $routes->Add('form', 'City::form');
    $routes->Add('add', 'City::add');
    $routes->Add('delete/(:any)', 'City::delete/$1');
    $routes->Add('update/(:any)', 'City::update/$1');
    $routes->Add('uploadImage', 'City::uploadImage');
    $routes->Add('uploadChunk', 'City::uploadChunk');
    $routes->Add('deleteImage/(:any)', 'City::deleteImage/$1');
});
$routes->group('ekspedition', function ($routes) {
    $routes->add('', 'Ekspedition::index');
    $routes->add('getData', 'Ekspedition::getData');
    $routes->add('add', 'Ekspedition::add');
    $routes->add('delete', 'Ekspedition::deleteExp');
    $routes->add('update/', 'Ekspedition::update');
    $routes->add('export', 'Ekspedition::export');
});
