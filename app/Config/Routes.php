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
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->post('auth', 'Home::auth');
$routes->get('logout', 'Home::logout');
$routes->get('hierarchy', 'Home::setHierarchy');
$routes->get('projects', 'Home::projects');
$routes->get('query', 'Home::query');
$routes->get('refcode', 'Home::refcode');

$routes->get('pending', 'Submissions::pending');
$routes->get('returned', 'Submissions::returned');
$routes->get('approved', 'Submissions::approved');
$routes->get('disapproved', 'Submissions::disapproved');

$routes->get('view/(:any)', 'Views::index/$1');
$routes->get('edit/(:any)', 'Views::edit/$1');
$routes->post('delete', 'Views::removeAttach');
$routes->post('save', 'Views::save');

$routes->get('export', 'Exports::index');
$routes->get('export/approved', 'Exports::approved');
$routes->match(['get', 'post'], 'export/item', 'Exports::item');

$routes->get('download/(:any)', 'Downloads::index/$1');
$routes->post('download/item', 'Downloads::item');

$routes->get('setting/', 'Settings::index');

$routes->get('setting/email', 'Settings::email');
$routes->post('setting/setemail', 'Settings::setemail');

$routes->get('setting/esign', 'Settings::esign');
$routes->post('setting/setesign', 'Settings::setesign');

$routes->get('setting/password', 'Settings::password');
$routes->post('setting/setpassword', 'Settings::setpassword');

$routes->get('setting/hierarchies', 'Settings::hierarchies');
$routes->match(['get', 'post'], 'setting/sethierarchies', 'Settings::sethierarchies');

$routes->get('setting/projects', 'Settings::projects');
$routes->match(['get', 'post'], 'setting/setprojects', 'Settings::setprojects');

$routes->get('setting/categories', 'Settings::categories');
$routes->match(['get', 'post'], 'setting/setcategories', 'Settings::setcategories');

$routes->get('setting/refcode', 'Settings::refcode');
$routes->match(['get', 'post'], 'setting/setrefcode', 'Settings::setrefcode');


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
