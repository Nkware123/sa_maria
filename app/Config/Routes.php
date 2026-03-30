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
$routes->get('dashbord/dashbord','dashbord\Dashbord::get_view');
$routes->post('dashbord/get_rapport','dashbord\Dashbord::get_rapport');

//routes ventes
$routes->get('ventes/add','Ventes\Ventes::get_view');
$routes->get('ventes/get_product/(:num)','Ventes\Ventes::get_product/$1');
$routes->post('ventes/save_commande','Ventes\Ventes::save_commande');
