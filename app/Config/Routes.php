<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// === AUTH ===
$routes->group('auth', static function ($routes) {
    $routes->get('login', 'Auth::login');
    $routes->post('login', 'Auth::login');
    $routes->get('register', 'Auth::register');
    $routes->post('register', 'Auth::register');
    $routes->get('logout', 'Auth::logout');
});

// === ADMIN (dilindungi filter admin) ===
$routes->get('test', function() {
    $request = service('request');
    $collection = service('routes');
    $router = service('router', $collection, $request);
    $router->handle('auth/login');
    $out = "Controller: " . $router->controllerName() . "<br>";
    $out .= "Method: " . $router->methodName() . "<br>";
    return $out;
});

$routes->group('admin', ['filter' => 'admin', 'namespace' => 'App\Controllers\Admin'], static function ($routes) {
    $routes->get('dashboard', 'Dashboard::index');
    
    // Categories
    $routes->get('categories/(:segment)', 'Category::index/$1');
    $routes->get('categories/(:segment)/create', 'Category::create/$1');
    $routes->post('categories/store', 'Category::store');
    $routes->get('categories/edit/(:num)', 'Category::edit/$1');
    $routes->post('categories/update/(:num)', 'Category::update/$1');
    $routes->get('categories/delete/(:num)', 'Category::delete/$1');

    // Pages
    $routes->get('pages', 'Pages::index');
    $routes->get('pages/create', 'Pages::create');
    $routes->post('pages/store', 'Pages::store');
    $routes->get('pages/edit/(:num)', 'Pages::edit/$1');
    $routes->post('pages/update/(:num)', 'Pages::update/$1');
    $routes->get('pages/delete/(:num)', 'Pages::delete/$1');

    // Regulations
    $routes->get('regulations', 'Regulations::index');
    $routes->get('regulations/create', 'Regulations::create');
    $routes->post('regulations/store', 'Regulations::store');
    $routes->get('regulations/edit/(:num)', 'Regulations::edit/$1');
    $routes->post('regulations/update/(:num)', 'Regulations::update/$1');
    $routes->get('regulations/delete/(:num)', 'Regulations::delete/$1');

    // Public Informations
    $routes->get('public-informations', 'PublicInformations::index');
    $routes->get('public-informations/create', 'PublicInformations::create');
    $routes->post('public-informations/store', 'PublicInformations::store');
    $routes->get('public-informations/edit/(:num)', 'PublicInformations::edit/$1');
    $routes->post('public-informations/update/(:num)', 'PublicInformations::update/$1');
    $routes->get('public-informations/delete/(:num)', 'PublicInformations::delete/$1');

    // Infographics
    $routes->get('infographics', 'Infographics::index');
    $routes->get('infographics/create', 'Infographics::create');
    $routes->post('infographics/store', 'Infographics::store');
    $routes->get('infographics/edit/(:num)', 'Infographics::edit/$1');
    $routes->post('infographics/update/(:num)', 'Infographics::update/$1');
    $routes->get('infographics/delete/(:num)', 'Infographics::delete/$1');

    // Documents
    $routes->get('documents', 'Documents::index');
    $routes->get('documents/create', 'Documents::create');
    $routes->post('documents/store', 'Documents::store');
    $routes->get('documents/edit/(:num)', 'Documents::edit/$1');
    $routes->post('documents/update/(:num)', 'Documents::update/$1');
    $routes->get('documents/delete/(:num)', 'Documents::delete/$1');
    $routes->get('documents/download/(:num)', 'Documents::download/$1');

    // Users
    $routes->get('users', 'Users::index');
    $routes->get('users/create', 'Users::create');
    $routes->post('users/store', 'Users::store');
    $routes->get('users/edit/(:num)', 'Users::edit/$1');
    $routes->post('users/update/(:num)', 'Users::update/$1');
    $routes->get('users/toggle/(:num)', 'Users::toggleActive/$1');
    $routes->post('users/reset-password/(:num)', 'Users::resetPassword/$1');

    // Settings
    $routes->get('settings', 'Settings::index');
    $routes->post('settings/update', 'Settings::update');
});

// === PIMPINAN (dilindungi filter pimpinan) ===
$routes->group('pimpinan', ['filter' => 'pimpinan', 'namespace' => 'App\Controllers\Pimpinan'], static function ($routes) {
    $routes->get('dashboard', 'Dashboard::index');
});

// === PUBLIC ===
$routes->get('/', 'Home::index');
$routes->get('profil/(:segment)', 'Profile::show/$1');
$routes->get('regulasi', 'Regulation::index');
$routes->get('layanan/(:segment)', 'Service::show/$1');
$routes->get('informasi/(:segment)', 'Service::show/$1');
$routes->get('informasi-publik', 'Information::index');
$routes->get('informasi-publik/(:segment)', 'Information::category/$1');
$routes->get('infografis', 'Infographic::index');
$routes->get('data', 'Data::index');
