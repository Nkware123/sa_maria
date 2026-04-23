<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;

$routes = Services::routes();
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}
//$routes->get('/', 'UserController::do_login');


$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('login');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes('false');
//$routes->set404verride();
$routes->setAutoRoute('true');

//routes pour login------------------------------------------------------------
$routes->match(['get', 'post'], '/', 'login\login::index');
$routes->get('Calender_Conge','dashbord\Calender_Conge::index');
$routes->post('login/login','login\login::login');
$routes->get('logout','login\login::logout');

//routes dashbord
$routes->group('dashbord',['namespace' => 'App\Modules\Dashbord\controllers'], function($routes){
    $routes->get('dashbord','Dashbord::get_view');
    $routes->post('get_rapport','Dashbord::get_rapport');
});

//routes ventes
$routes->group('/',['namespace' => 'App\Modules\Ventes\controllers'], function($routes){
    $routes->get('ventes/vente-add','Ventes::get_view');
    $routes->get('ventes/vente-list','Ventes::getListe');
    $routes->get('ventes/get_product/(:num)','Ventes::get_product/$1');
    $routes->post('ventes/save_commande','Ventes::save_commande');
});

//routes achat
$routes->group('/',['namespace' => 'App\Modules\Achat\controllers'], function($routes){
    $routes->get('achat/achat-add','Achat::get_view');
    $routes->get('achat/achat-list','Achat::get_list_view');
    $routes->post('achat/save_achat','Achat::save_achat');
});

//routes depense
$routes->group('/',['namespace' => 'App\Modules\Depense\controllers'], function($routes){
    $routes->get('depense/depense-list','Depense::get_view');
    $routes->post('depense/save_depense','Depense::save_depense');
});

//qr code
$routes->get('generate_qr_code','Generate_qrcode::generate_qr_code');
