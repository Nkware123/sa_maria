<?php
namespace App\Controllers\Depense;

use App\Controllers\BaseController;
use App\Models\My_Model;
class Depense extends BaseController
{
  public function __construct()
  {
    // $this->My_Model = new My_Model();
  }
  
  public function get_view()
  {
    $data=$this->urichk();
		$db=\Config\Database::connect();
    $types = $db->query("SELECT ID_TYPE_DEPENSE, DESC_TYPE_DEPENSE FROM type_depense WHERE EST_ACTIVE=1");
    $data['types'] = $types->getResult();

		$depenses = $db->query("SELECT d.ID_DEPENSE, td.DESC_TYPE_DEPENSE, d.MONTANT, d.DATE_DEPENSE, u.NOM_USER,u.PRENOM_USER,DATE_INSERTION FROM depenses d JOIN type_depense td ON d.ID_TYPE_DEPENSE=td.ID_TYPE_DEPENSE JOIN users u ON d.ID_USER=u.ID_USER ORDER BY d.DATE_INSERTION DESC");
		$data['depense'] = $depenses->getResult();
    return view("Depense/Depense_List_View",$data);
  }

  function save_depense()
  {
    $data=$this->urichk();
    $db=\Config\Database::connect();
    $ID_TYPE_DEPENSE=$this->request->getPost("ID_TYPE_DEPENSE");
    $MONTANT=$this->request->getPost("MONTANT");
    $DATE_DEPENSE=$this->request->getPost("DATE_DEPENSE");
    $ID_USER=session()->get("user_id");

    $data = [
      "ID_TYPE_DEPENSE"=>$ID_TYPE_DEPENSE,
      "MONTANT"=>$MONTANT,
      "DATE_DEPENSE"=>$DATE_DEPENSE,
      "ID_USER"=>$ID_USER,
      "DATE_INSERTION"=>date("Y-m-d H:i:s")
    ];

    $this->save("depenses",$data);
    return json_encode(["status"=>true,"message"=>"Dépense enregistrée avec succès"]);
	}
}