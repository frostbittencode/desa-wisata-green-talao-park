<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
//$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

$routes->get('/', 'Home::landingPage');
$routes->get('/403', 'Home::error403');
$routes->get('/login', 'Web\Admin::login');
// $routes->get('/register', 'Web\Admin::register');

$routes->group('web', function ($routes) {

    $routes->group('profile', function ($routes) {
        $routes->get('/', 'Home::profile');
        $routes->get('update', 'Home::update');
        $routes->get('changePassword', 'Home::changePassword');
    });
});

// App
$routes->group('web', ['namespace' => 'App\Controllers\Web'], function ($routes) {
    $routes->presenter('gtp');
    $routes->get('/', 'Gtp::index');

    $routes->group('tracking', function ($routes) {
        $routes->presenter('tracking');
        $routes->get('/', 'Tracking::index');
    });

    // $routes->presenter('attraction');

    $routes->group('talao', function ($routes) {
        $routes->presenter('talao');
        $routes->get('/', 'Talao::detail');
    });

    $routes->presenter('event');

    $routes->presenter('package');

    $routes->presenter('ulakan');

    $routes->presenter('homestay');
    $routes->presenter('culinaryPlace');
    $routes->presenter('souvenirPlace');
    $routes->presenter('worshipPlace');

    // Profile
});

// Dashboard
$routes->group('dashboard', ['namespace' => 'App\Controllers\Web', 'filter' => 'role:admin'], function ($routes) {
    $routes->get('/', 'Dashboard::index');
    $routes->get('gtp', 'Dashboard::gtp');
    $routes->get('attraction', 'Dashboard::attraction');
    $routes->get('event', 'Dashboard::event');
    $routes->get('package', 'Dashboard::package');
    $routes->get('facility', 'Dashboard::facility');

    $routes->presenter('gtp');
    $routes->presenter('attraction');
    $routes->presenter('event');
    $routes->presenter('package');
    $routes->presenter('facility');
});

// Upload files
$routes->group('upload', ['namespace' => 'App\Controllers\Web'], function ($routes) {
    $routes->post('photo', 'Upload::photo');
    $routes->post('video', 'Upload::video');
    $routes->delete('photo', 'Upload::remove');
    $routes->delete('video', 'Upload::remove');
});


// API
$routes->group('api', ['namespace' => 'App\Controllers\Api'], function ($routes) {
    $routes->resource('gtp');

    $routes->post('village', 'Village::getData');

    $routes->resource('connection');

    $routes->resource('tracking');

    $routes->resource('attraction');

    $routes->resource('facility');
    $routes->post('facility/findByRadius', 'Facility::findByRadius');
    $routes->post('facility/findByTrack', 'Facility::findByTrack');

    $routes->resource('event');

    $routes->get('package/type', 'Package::type');
    $routes->resource('package');
    $routes->post('package/findByName', 'Package::findByName');
    $routes->post('package/findByType', 'Package::findByType');

    $routes->resource('homestay');
    $routes->post('homestay/findByRadius', 'Homestay::findByRadius');
    $routes->resource('culinaryPlace');
    $routes->post('culinaryPlace/findByRadius', 'CulinaryPlace::findByRadius');
    $routes->resource('souvenirPlace');
    $routes->post('souvenirPlace/findByRadius', 'SouvenirPlace::findByRadius');
    $routes->resource('worshipPlace');
    $routes->post('worshipPlace/findByRadius', 'WorshipPlace::findByRadius');
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
