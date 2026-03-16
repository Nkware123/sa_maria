<?php 
namespace App\Controllers\dashbord;
use App\Controllers\BaseController;
use App\Models\My_Model;

class Calender_Conge extends BaseController
{
    public function index() 
    {
        $data = $this->urichk();
        $db =\Config\Database::connect();
        $query_type_conge = $db->query("SELECT * FROM demande_conge JOIN type_conge ON type_conge.ID_TYPE_CONGE =demande_conge.ID_TYPE_CONGE JOIN users ON users.USER_ID=demande_conge.ID_USER");
        $donnees = $query_type_conge->getResult();
        foreach ($donnees as $key => $value) 
        {
            $data['data'][$key]['title'] = $value->NOM_USER.' : '.$value->DESC_TYPE_CONGE;
            $data['data'][$key]['start'] = date('Y-m-d',strtotime($value->DATE_DEBUT));
            $data['data'][$key]['end'] = date('Y-m-d',strtotime($value->DATE_FIN));
            $data['data'][$key]['backgroundColor'] = "#00a65a";
        }
        return view('dashbord\Calender_Conge_View',$data);
    }
}