<?php 
namespace App\Controllers\branche;

use App\Controllers\BaseController;
use App\Models\My_Model;
class branche extends BaseController
{
  public function __construct()
  {
    $this->My_Model = new My_Model();
  }
  public function liste()
  {
    $data = $this->urichk();
    $db =\Config\Database::connect();
    $query = $db->query("SELECT * FROM agence");
    $data['donnees'] = $query->getResult();

  	return view("App\Views\branche\branche_view",$data);
  }

  public function save_branche()
  {
    $DESC_AGENCE=addslashes($this->request->getPost('DESC_AGENCE'));

    $table='agence';
    $datacolumsinsert = array('DESC_AGENCE' => $DESC_AGENCE);

    $this->save($table,$datacolumsinsert); 

    return redirect('branche');
  }

  public function update_branche()
  {
    $DESC_AGENCE=addslashes($this->request->getPost('DESC_AGENCE'));
    $ID_AGENCE=$this->request->getPost('ID_AGENCE');

    $table='agence';
    $data = array('DESC_AGENCE' => $DESC_AGENCE);
    $critere=array('ID_AGENCE'=>$ID_AGENCE);

    $this->update($table,$critere,$data); 

    return redirect('branche');
  }

  public function get_data_update($id)
  {
    $db =\Config\Database::connect();
    $query = $db->query("SELECT * FROM agence where ID_AGENCE=".$id);
    $donnees = $query->getRow();

    return json_encode($donnees);
  }

  public function active_desactiver($value='')
  {
    $ID_AGENCE_DEL=$this->request->getPost("ID_AGENCE_DEL");
    $EST_ACTIVE  =$this->request->getPost("EST_ACTIVE");
    if($EST_ACTIVE==1)
    {
      $EST_ACTIVE=0;
    }
    else
    {
      $EST_ACTIVE=1;
    }
    $table='agence';
    $critere=array('ID_AGENCE'=>$ID_AGENCE_DEL);
    $data = array('EST_ACTIVE' => $EST_ACTIVE);
    $this->update($table,$critere,$data);
    return redirect('branche');
  }
}