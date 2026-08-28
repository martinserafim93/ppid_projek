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
    // Route admin lainnya akan ditambah di issue berikutnya
});

// === PIMPINAN (dilindungi filter pimpinan) ===
$routes->group('pimpinan', ['filter' => 'pimpinan', 'namespace' => 'App\Controllers\Pimpinan'], static function ($routes) {
    $routes->get('dashboard', 'Dashboard::index');
});

// === PUBLIC ===
$routes->get('/', 'Home::index');
