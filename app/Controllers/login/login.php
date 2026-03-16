<?php 
namespace App\Controllers\login;

use App\Controllers\BaseController;
use App\Models\My_Model;
class login extends BaseController
{
  public function __construct()
  {
    $this->My_Model = new My_Model();
  }
  public function index()
  {
  	return view("index");
  }
  public function login()
  {
    $data = $this->urichk();
    $username=$this->request->getPost('username');
    $password=$this->request->getPost('password');
    $db =\Config\Database::connect();
    $query = $db->query("SELECT * FROM users AS `user` join `fonction_poste` AS `poste` on poste.ID_FONCTION=user.ID_FONCTION join `agence` AS `ag` ON ag.ID_AGENCE=user.ID_AGENCE where USERNAME='".$username."' AND PASSWORD=".$password." AND user.EST_ACTIVE=1");
    $result = $query->getRow();
    if (!empty($result)) 
    {
      $session=[
        'user_id'=>$result->USER_ID,
        'nom_user'=>$result->NOM_USER,
        'prenom_user'=>$result->PRENOM_USER,
        'nom_fonction'=>$result->DESC_FONCTION,
        'nom_lieu'=>$result->DESC_AGENCE,
        'photo_profil'=>$result->PHOTO_PROFIL,
        'function_id'=>$result->ID_FONCTION,
      ];
      session()->set($session);
      return redirect('dashbord/dashbord');
    }else{
      $data['status']='Nom d\'utilisateur ou mot de passe incorrect.';
      return view('App\Views\index',$data);
    }
  }

  //fonction pour se deconnecte
  public function logout()
  {
    session()->destroy();
    return redirect()->to('login');
  }
  // $table="`users` AS `user` join `fonction_poste` AS `poste` on poste.ID_FONCTION=user.ID_FONCTION join `lieu_affectation` AS `affect` ON affect.ID_LIEU_AFFECTATION=user.ID_LIEU_AFFECTATION";
    // $critere="USERNAME='".$username."' AND PASSWORD=".$password;
    // $My_Model=new My_Model();
    // $result=$My_Model->getOne($table,$critere);
}

?>