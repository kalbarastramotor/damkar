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
$routes->get('/data', 'Home::datamaster');



// route page view 
$routes->get('/users', 'User::index');
$routes->get('/menu', 'Menu::index');
$routes->get('/office', 'Office::index');
$routes->get('/role', 'Role::index');
$routes->get('/task', 'Home::datamaster');
$routes->get('/category', 'Category::index');
$routes->get('/dashboard', 'Home::index');
$routes->get('/eventcategory', 'Eventcategory::index');
$routes->get('/officefilter', 'Office::filterOffice');
$routes->get('/eventlist', 'Eventlist::index');
$routes->get('/dashboarddata', 'Home::dataDashboard');
$routes->get('/marker', 'Home::markerEventMapsHome');
$routes->get('/crontab', 'Crontab::index');


// $routes->add('email/compose', 'Email::compose');
$routes->post('email/send-email', 'ReportAll::sendEmailCron');
// $routes->get('email/send-email', 'Email::send_email');



// page report
$routes->group('report', static function ($routes) {
    $routes->get('', 'ReportAll::index');
    $routes->get('detail/(:any)/(:any)/(:any)', 'ReportAll::detailreport/$1/$2/$3');
    $routes->get('btl/(:any)/(:any)', 'Report::btl/$1/$2');

});

$routes->get('/off', 'ReportAll::filterOffice');
$routes->get('/bulan', 'Home::dataBulan');
$routes->get('/eventstatus', 'Home::dataEventStatus');
$routes->get('/categoryoption', 'Eventcategory::selectOption');



//  login page 
$routes->get('/', 'Home::login');
$routes->post('/login', 'User::login');



$routes->post('/register', 'User::register');

$routes->get('/datalist', 'User::datalist');
$routes->post('/saveoffice', 'Office::save');
$routes->post('/saverole', 'Role::save');
$routes->post('/saveeventcategory', 'Eventcategory::save');

$routes->get('/province', 'Province::optionData');
$routes->get('/city', 'City::optionData');
$routes->get('/publish', 'Role::optionData');
$routes->get('/datacategory', 'ReportAll::getCategory');



// $routes->group('/report', static function ($routes) {
// });
$routes->get('/reportbtl', 'Report::data_btl');
$routes->post('/reportbtl', 'Report::data_btl');


$routes->post('/getdatamenu', 'Menu::getMenuNameByID');


$routes->get('lpj_activity/(:any)/(:any)/(:any)/(:any)/(:any)', 'ExcelReport::lpj_activity/$1/$2/$3/$4/$5');

// /$1/$2/$3/$4
/**
 * $1 : office id
 * $2 : status event
 * $3 : category event
 * $4 : tahun event
 * $5 : bulan event 
 */


$routes->group('api', static function ($routes) {

    // export report excel


    // office
    $routes->group('office', static function ($routes) {
        $routes->post('data', 'Office::data');
        $routes->post('save', 'Office::save');
        $routes->post('updatemaps/(:any)', 'Office::updatemaps/$1');
        $routes->post('delete', 'Office::delete');
        $routes->post('lock', 'Office::lock');
        $routes->post('update', 'Office::update');
        $routes->get('option', 'Office::selectOptionOffice');
    });
    $routes->group('category', static function ($routes) {
        $routes->post('data', 'Category::data');
    });



    $routes->group('report', static function ($routes) {
        $routes->post('clickmaps', 'Home::clickMaps');
        $routes->group('doc', static function ($routes) {
            $routes->post('data', 'ReportAll::data');
            $routes->post('save', 'ReportAll::save');
            $routes->post('updatecolumn', 'ReportAll::updatecolumn');
            $routes->group('event', static function ($routes) {
                $routes->post('category', 'ReportAll::by_category');
                $routes->post('running', 'ReportAll::eventRunning');
                $routes->post('cabang', 'Home::listCabang');
                $routes->post('updatecolumn', 'ReportAll::updatecolumnEvent');
                $routes->post('upload', 'ReportAll::uploadFile');
                $routes->post('activity', 'ReportAll::getActivityEvent');
                $routes->post('deletefile', 'ReportAll::deleteFile');
                $routes->post('status', 'ReportAll::status');
                $routes->post('history', 'Home::historyEvent');
            });
        });
        $routes->post('btl', 'Report::data_btl');
    });

    $routes->group('event', static function ($routes) {
        $routes->post('data', 'Home::event');
        $routes->post('delete', 'Eventlist::delete');
        $routes->post('eventbyid', 'Home::GetDataEventByID');

    });

    // Role
    $routes->group('role', static function ($routes) {
        $routes->post('data', 'Role::data');
        $routes->post('save', 'Role::save');
        $routes->post('delete', 'Role::delete');
        $routes->post('update', 'Role::update');
        $routes->get('option', 'Role::selectOptionAccess');
        $routes->post('userarea', 'Role::getAreaUsers');
        
        $routes->group('menu', static function ($routes) {
            $routes->post('data', 'Role::menu_data');
            $routes->post('add', 'Role::add_menu_role');
        });
    });

    // Event Category
    $routes->group('eventcategory', static function ($routes) {
        $routes->post('data', 'Eventcategory::data');
        $routes->post('save', 'Eventcategory::save');
        $routes->post('delete', 'Eventcategory::delete');
        $routes->post('edit', 'Eventcategory::edit');
    });

    // Event List
    $routes->group('eventlist', static function ($routes) {
        $routes->post('data', 'Eventlist::data');
        $routes->post('save', 'Eventlist::save');
        $routes->post('delete', 'Eventlist::delete');
        $routes->post('edit', 'Eventlist::edit');
        $routes->post('update/(:any)', 'Eventlist::update/$1');
        $routes->get('optionpublish', 'Menu::publishMenu');
    });


    // Users
    $routes->group('users', static function ($routes) {
        $routes->post('data', 'User::data');
        $routes->post('lock', 'User::lock');
        $routes->post('setofficeuser', 'User::setofficeuser');
        $routes->post('setroleuser', 'User::setRoleUsers');
        $routes->get('gender', 'User::gender');
        $routes->post('save', 'User::save');
        $routes->post('update', 'User::updateUser');
        $routes->post('changepassword', 'User::updatePassword');
    });

    // role 
    $routes->group('role', static function ($routes) {
        $routes->post('data', 'Role::data');
        $routes->get('optionrole', 'Role::selectOptionAccess');
        $routes->get('optionpublish', 'Menu::publishRole');
    });

    $routes->group('officegroup', static function ($routes) {
        $routes->get('select', 'OfficeGroup::selectOptionOfficeGroup');
    });

    $routes->group('filter', static function ($routes) {
        $routes->get('year', 'ReportAll::filterYear');
        $routes->get('month', 'ReportAll::filterMonth');
    });

    $routes->group('menu', static function ($routes) {
        $routes->post('data', 'Menu::data');
        $routes->post('lock', 'Menu::lock');
        $routes->post('save', 'Menu::save');
        $routes->get('optionparent', 'Menu::parentMenu');
        $routes->get('optionpublish', 'Menu::publishMenu');
    });
    // option data
    $routes->get('province', 'Province::optionData');
    $routes->get('city', 'City::optionData');
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
