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
$routes->get('dashbord/dashbord','dashbord\Dashbord::index');
$routes->get('dashbord/get_data','dashbord\Dashbord::get_data');
$routes->post('dashbord/get_liste','dashbord\Dashbord::get_liste');
$routes->post('dashbord/get_liste_by_type','dashbord\Dashbord::get_liste_by_type');

//routes users
$routes->get('user_liste','users\users::liste');
$routes->post('users/save_user','users\users::save_user');
$routes->post('users/get_data_update/(:any)','users\users::get_data_update/$1');
$routes->post('users/update_user','users\users::update_user');
$routes->post('users/active_desactiver','users\users::active_desactiver');
$routes->get('users/user_profile','users\users::user_profile');
$routes->post('users/update_pwd','users\users::update_pwd');
$routes->get('users/test_username/(:any)','users\users::test_username/$1');

//routes demande
$routes->get('demande/formulaire','demande\demande::index');
$routes->post('demande/save_demande','demande\demande::save_demande');
$routes->get('demande/liste','demande\demande::liste');
$routes->get('demande/view_update/(:any)','demande\demande::view_update/$1');
$routes->post('demande/update_demande','demande\demande::update_demande');
$routes->post('demande/decision','demande\demande::decision');
$routes->post('demande/get_jours_restants','demande\demande::get_jours_restants');
$routes->post('demande/checkDemandeCours','demande\demande::checkDemandeCours');

//type conge
$routes->get('type_conge','type_conge\Type_Conge::liste');
$routes->post('type_conge/save_type_conge','type_conge\Type_Conge::save_type_conge');
$routes->post('type_conge/get_data_update/(:any)','type_conge\Type_Conge::get_data_update/$1');
$routes->post('type_conge/update_type_conge','type_conge\type_conge::update_type_conge');
$routes->post('type_conge/active_desactiver','type_conge\type_conge::active_desactiver');

//branche
$routes->get('branche','branche\branche::liste');
$routes->post('branche/save_branche','branche\branche::save_branche');
$routes->post('branche/get_data_update/(:any)','branche\branche::get_data_update/$1');
$routes->post('branche/update_branche','branche\branche::update_branche');
$routes->post('branche/active_desactiver','branche\branche::active_desactiver');




