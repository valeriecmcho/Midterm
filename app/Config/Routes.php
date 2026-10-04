<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Public routes (no auth required)
$routes->get('/', 'Auth::login');
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::doLogin');
$routes->get('/logout', 'Auth::logout');

// Protected routes (require auth filter)
$routes->group('', ['filter' => 'auth'], function ($routes) {
    $routes->get('/dashboard', 'Dashboard::index');

    // Products CRUD
    $routes->get('/products', 'Products::index');
    $routes->post('/products/store', 'Products::store');
    $routes->get('/products/edit/(:num)', 'Products::edit/$1');
    $routes->post('/products/update/(:num)', 'Products::update/$1');
    $routes->post('/products/delete/(:num)', 'Products::delete/$1');

    // Customers CRUD
    $routes->get('/customers', 'Customers::index');
    $routes->post('/customers/store', 'Customers::store');
    $routes->get('/customers/edit/(:num)', 'Customers::edit/$1');
    $routes->post('/customers/update/(:num)', 'Customers::update/$1');
    $routes->post('/customers/delete/(:num)', 'Customers::delete/$1');

    // Staff (users) CRUD
    $routes->get('/staff', 'Staff::index');
    $routes->post('/staff/store', 'Staff::store');
    $routes->get('/staff/edit/(:num)', 'Staff::edit/$1');
    $routes->post('/staff/update/(:num)', 'Staff::update/$1');
    $routes->post('/staff/delete/(:num)', 'Staff::delete/$1');

    // Record Sale
    $routes->get('/record-sale', 'RecordSale::index');
    $routes->post('/record-sale/store', 'RecordSale::store');

    // Sales History
    $routes->get('/sales-history', 'SalesHistory::index');
});
