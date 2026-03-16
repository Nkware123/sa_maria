<?php 
namespace App\Controllers\Type_Conge;

use App\Controllers\BaseController;
use App\Models\My_Model;
class Type_Conge extends BaseController
{
  public function __construct()
  {
    $this->My_Model = new My_Model();
  }
  public function liste()
  {
    $data = $this->urichk();
    $db =\Config\Database::connect();
    $query = $db->query("SELECT * FROM `type_conge`");
    $data['donnees'] = $query->getResult();

  	return view('App\Views\type_conge\Type_Conge_View',$data);
  }

  public function save_type_conge()
  {
    $DESC_TYPE_CONGE=$this->request->getPost('DESC_TYPE_CONGE');
    $ID_TYPE_CONGE=$this->request->getPost('ID_TYPE_CONGE');
    $HAS_JOURS_BASE=$this->request->getPost('HAS_JOURS_BASE');
    $NOMBRE_JOURS_BASE=$this->request->getPost('NOMBRE_JOURS_BASE');
    if($HAS_JOURS_BASE==0)
    {
      $NOMBRE_JOURS_BASE=0;
    }
      
    $table='type_conge';
     $datacolumsinsert = array('DESC_TYPE_CONGE' => $DESC_TYPE_CONGE,'HAS_JOURS_BASE' => $HAS_JOURS_BASE,'NOMBRE_JOURS_BASE' => $NOMBRE_JOURS_BASE);
    $datacolumsinsert = array('DESC_TYPE_CONGE' => $DESC_TYPE_CONGE);
    if (!empty($ID_TYPE_CONGE)) {
      $where="ID_TYPE_CONGE=".$ID_TYPE_CONGE;
      $this->update($table,$where,$datacolumsinsert);
    }
    else
    {
      $this->save($table,$datacolumsinsert); 
    }

    return redirect('type_conge');
  }

  public function update_type_conge()
  {
    $DESC_TYPE_CONGE=addslashes($this->request->getPost('DESC_TYPE_CONGE'));
    $ID_TYPE_CONGE=$this->request->getPost('ID_TYPE_CONGE');

    $table='type_conge';
    $data = array('DESC_TYPE_CONGE' => $DESC_TYPE_CONGE);
    $critere=array('ID_TYPE_CONGE'=>$ID_TYPE_CONGE);

    $this->update($table,$critere,$data); 

    return redirect('type_conge');
  }

  public function active_desactiver($value='')
  {
    $ID_TYPE_CONGE_DEL=$this->request->getPost("ID_TYPE_CONGE_DEL");
    $EST_ACTIVE  =$this->request->getPost("EST_ACTIVE");
    if($EST_ACTIVE==1)
    {
      $EST_ACTIVE=0;
    }
    else
    {
      $EST_ACTIVE=1;
    }
    $table='type_conge';
    $critere=array('ID_TYPE_CONGE'=>$ID_TYPE_CONGE_DEL);
    $data = array('EST_ACTIVE' => $EST_ACTIVE);
    $this->update($table,$critere,$data);
    return redirect('type_conge');
  }
  public function get_data_update($ID_TYPE_CONGE)
  {
    $db =\Config\Database::connect();
    $query = $db->query("SELECT * FROM `type_conge` where ID_TYPE_CONGE=".$ID_TYPE_CONGE);
    $donnees = $query->getRow();
    return json_encode($donnees);
  }

}