<?php 
namespace App\Controllers\dashbord;

use App\Controllers\BaseController;
use App\Models\My_Model;
class Dashbord extends BaseController
{
  public function __construct()
  {
    // $this->My_Model = new My_Model();
  }
  public function index()
  {
    $filtre = $this->request->getGet('filtre');
     if(empty($filtre))
     {
       $filtre=3;
     }
    
    $data = $this->urichk();
    $data["data"]=$this->get_data($filtre)[0];

    $data2=$this->get_data($filtre)[1];
    $agences = array();
    $dem = array();

    foreach ($data2 as $demande)
    {
      $agences[] = $demande->DESC_AGENCE;
      $dem[] = $demande->nbr;
    }
    $data["data3"]=str_replace('"','',json_encode($dem));

    $data["data2"]=json_encode($agences);

    $data_rapp_type=$this->get_data($filtre)[2];
    $type_conge = array();
    $nbr_demande = array();
    foreach ($data_rapp_type as $demande_type) {
      $type_conge[] = $demande_type->DESC_TYPE_CONGE;
      $nbr_demande[] = $demande_type->nbr;
    }
    $data["data4"]=str_replace('"','',json_encode($nbr_demande));
    $data["data5"]=json_encode($type_conge);
    $data["filtre"]=$filtre;

    $data["employe"]=$db =\Config\Database::connect()->query("SELECT COUNT(USER_ID) AS NB_EMPLOYE FROM users")->getRow()->NB_EMPLOYE;

    // print_r($data["data3"]." ".$data["data2"]);die();
  	return view("dashbord/Dashbord_view",$data);
  }

  public function get_data($value)
  {
    if($value==1)
    {
      $filtre=" DATE(DATE_INSERTION)=CURDATE()";
    }
    else if($value==2)
    {
      $filtre=" MONTH(DATE_INSERTION)=MONTH(CURDATE()) AND YEAR(DATE_INSERTION)=YEAR(CURDATE())";
    }
    else
    {
      $filtre=" YEAR(DATE_INSERTION)=YEAR(CURDATE())";
    }
    $db =\Config\Database::connect();
    $query_demande = $db->query("SELECT * FROM demande_conge JOIN type_conge ON type_conge.ID_TYPE_CONGE =demande_conge.ID_TYPE_CONGE JOIN users ON users.USER_ID=demande_conge.ID_USER WHERE ".$filtre." ORDER BY ID_DEMANDE DESC");
    $query_demande = $query_demande->getResult();
    
    $query_demande_group = $db->query("SELECT COUNT(ID_DEMANDE) nbr,DESC_AGENCE FROM demande_conge JOIN type_conge ON type_conge.ID_TYPE_CONGE =demande_conge.ID_TYPE_CONGE JOIN users ON users.USER_ID=demande_conge.ID_USER JOIN agence ON agence.ID_AGENCE=users.USER_ID WHERE ".$filtre." GROUP BY users.ID_AGENCE ORDER BY ID_DEMANDE DESC");
    $query_demande_group = $query_demande_group->getResult();

    //get demandes par type de conge
    $query_demande_type_conge = $db->query("SELECT COUNT(ID_DEMANDE) nbr,DESC_TYPE_CONGE FROM demande_conge JOIN type_conge ON type_conge.ID_TYPE_CONGE =demande_conge.ID_TYPE_CONGE JOIN users ON users.USER_ID=demande_conge.ID_USER WHERE ".$filtre." GROUP BY demande_conge.ID_TYPE_CONGE ORDER BY ID_DEMANDE DESC");
    $query_demande_type_conge = $query_demande_type_conge->getResult();
    return [$query_demande,$query_demande_group,$query_demande_type_conge];
  }

  function get_liste()
  {
    $value = $this->request->getPost("value");
    $data = $db =\Config\Database::connect()->query("SELECT * FROM demande_conge JOIN type_conge ON type_conge.ID_TYPE_CONGE =demande_conge.ID_TYPE_CONGE JOIN users ON users.USER_ID=demande_conge.ID_USER JOIN agence a ON a.ID_AGENCE=users.ID_AGENCE WHERE a.DESC_AGENCE ='".$value."' ORDER BY ID_DEMANDE DESC")->getResult();
    $html="";
    $u=0;
    foreach ($data as $demande) {
      $u=$u+1;
      $html.="<tr>
                <td>".$u."</td>
                <td>".$demande->NOM_USER." ".$demande->PRENOM_USER."</td>
                <td>".$demande->DESC_TYPE_CONGE."</td>
                <td>".$demande->DATE_DEBUT."</td>
                <td>".$demande->NOMBRE_JOURS_DEMANDE."</td>
              </tr>";
    }
    echo json_encode(array("html" => $html,"agence" => $value));
  }

  function get_liste_by_type()
  {
    $value = $this->request->getPost("value");
    $data = $db =\Config\Database::connect()->query("SELECT * FROM demande_conge JOIN type_conge ON type_conge.ID_TYPE_CONGE =demande_conge.ID_TYPE_CONGE JOIN users ON users.USER_ID=demande_conge.ID_USER JOIN agence a ON a.ID_AGENCE=users.ID_AGENCE WHERE DESC_TYPE_CONGE ='".$value."' ORDER BY ID_DEMANDE DESC")->getResult();
    $html="";
    $u=0;
    foreach ($data as $demande) {
      $u=$u+1;
      $html.="<tr>
                <td>".$u."</td>
                <td>".$demande->NOM_USER." ".$demande->PRENOM_USER."</td>
                <td>".$demande->DESC_TYPE_CONGE."</td>
                <td>".$demande->DATE_DEBUT."</td>
                <td>".$demande->NOMBRE_JOURS_DEMANDE."</td>
              </tr>";
    }
    echo json_encode(array("html" => $html,"type" => $value));
  }
}

?>