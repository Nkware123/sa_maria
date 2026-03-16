<?php 
namespace App\Controllers\users;

use App\Controllers\BaseController;
use App\Models\My_Model;
class users extends BaseController
{
  public function __construct()
  {
    $this->My_Model = new My_Model();
  }
  public function liste()
  {
    $data = $this->urichk();
    $db =\Config\Database::connect();
    $query = $db->query("SELECT users.*,lieu.*,fonction.*, chef.NOM_USER AS NOM_USER_HIERARCHI, chef.PRENOM_USER AS PRENOM_USER_HIERARCHI FROM users left join users chef ON chef.USER_ID=users.USER_ID_HIERARCHI join agence lieu ON lieu.ID_AGENCE=users.ID_AGENCE join fonction_poste fonction ON fonction.ID_FONCTION=users.ID_FONCTION");
    $data['donnees'] = $query->getResult();

    $fonction = $db->query("SELECT * FROM fonction_poste");
    $data['fonction'] = $fonction->getResult();

    $affectation = $db->query("SELECT * FROM agence WHERE EST_ACTIVE=1");
    $data['affectation'] = $affectation->getResult();

    $users = $db->query("SELECT * FROM users");
    $data['users'] = $users->getResult();

  	return view("App\Views\users\user_list",$data);
  }

  public function save_user()
  {
    $NOM_USER=$this->request->getPost('NOM_USER');
    $PRENOM_USER=$this->request->getPost('PRENOM_USER');
    $USERNAME=$this->request->getPost('USERNAME');
    $PASSWORD=$this->request->getPost('PASSWORD');
    $TELEPHONE=$this->request->getPost('TELEPHONE');
    $ID_FONCTION=$this->request->getPost('ID_FONCTION');
    $ID_LIEU_AFFECTATION=$this->request->getPost('ID_LIEU_AFFECTATION');
    $USER_ID_HIERARCHI=$this->request->getPost('USER_ID_HIERARCHI');

    $table='users';
    $PHOTO_PROFIL=$this->uploadFile('PHOTO_PROFIL','profils','PHOTO_PROFIL');
    $datacolumsinsert = array('NOM_USER' => $NOM_USER,'PRENOM_USER'=>$PRENOM_USER,'USERNAME'=>$USERNAME,'PASSWORD'=>$PASSWORD,'TELEPHONE'=>$TELEPHONE,'ID_FONCTION'=>$ID_FONCTION,'ID_AGENCE'=>$ID_LIEU_AFFECTATION,'USER_ID_HIERARCHI'=>$USER_ID_HIERARCHI,'PHOTO_PROFIL'=>$PHOTO_PROFIL);

    $this->save($table,$datacolumsinsert); 

    return redirect('user_liste');
  }

  public function update_user()
  {
    $USER_ID=$this->request->getPost('USER_ID');
    $NOM_USER=$this->request->getPost('NOM_USER');
    $PRENOM_USER=$this->request->getPost('PRENOM_USER');
    $USERNAME=$this->request->getPost('USERNAME');
    $PASSWORD=$this->request->getPost('PASSWORD');
    $TELEPHONE=$this->request->getPost('TELEPHONE');
    $ID_FONCTION=$this->request->getPost('ID_FONCTION');
    $ID_LIEU_AFFECTATION=$this->request->getPost('ID_LIEU_AFFECTATION');
    $USER_ID_HIERARCHI=$this->request->getPost('USER_ID_HIERARCHI');
    $PHOTO_PROFIL=$this->uploadFile('PHOTO_PROFIL','profils','PHOTO_PROFIL');

    $table='users';
    $critere=array('USER_ID'=>$USER_ID);
    $data = array('NOM_USER' => $NOM_USER,'PRENOM_USER'=>$PRENOM_USER,'USERNAME'=>$USERNAME,'PASSWORD'=>$PASSWORD,'TELEPHONE'=>$TELEPHONE,'ID_FONCTION'=>$ID_FONCTION,'ID_AGENCE'=>$ID_LIEU_AFFECTATION,'USER_ID_HIERARCHI'=>$USER_ID_HIERARCHI,'PHOTO_PROFIL'=>$PHOTO_PROFIL);

    $this->update($table,$critere,$data); 

    return redirect('user_liste');
  }

  public function get_data_update($id)
  {
    $db =\Config\Database::connect();
    $query = $db->query("SELECT * FROM users join agence lieu ON lieu.ID_AGENCE=users.ID_AGENCE join fonction_poste fonction ON fonction.ID_FONCTION=users.ID_FONCTION where USER_ID=".$id);
    $donnees = $query->getRow();

    return json_encode($donnees);
  }

  public function uploadFile($fieldName=NULL, $folder=NULL, $prefix = NULL): string
  {
    $prefix = ($prefix === '') ? uniqid() : $prefix;
    $path = '';

    $file = $this->request->getFile($fieldName);

    if ($file->isValid() && !$file->hasMoved()) {
      $newName = uniqid(). '' . date('ymdhis') . '.' . $file->getExtension();
      $file->move(ROOTPATH . 'public/uploads/' . $folder, $newName);
      $path = 'uploads/' . $folder . '/' . $newName;
    }
    return $path;
  }

  public function active_desactiver($value='')
  {
    $USER_ID_DEL=$this->request->getPost("USER_ID_DEL");
    $EST_ACTIVE  =$this->request->getPost("EST_ACTIVE");
    if($EST_ACTIVE==1)
    {
      $EST_ACTIVE=0;
    }
    else
    {
      $EST_ACTIVE=1;
    }
    $table='users';
    $critere=array('USER_ID'=>$USER_ID_DEL);
    $data = array('EST_ACTIVE' => $EST_ACTIVE);
    $this->update($table,$critere,$data);
    return redirect('user_liste');
  }

  function user_profile()
  {
    $data = $this->urichk();
    $id=session()->get('user_id');
    $db =\Config\Database::connect();
    $query = $db->query("SELECT * FROM users join agence lieu ON lieu.ID_AGENCE=users.ID_AGENCE join fonction_poste fonction ON fonction.ID_FONCTION=users.ID_FONCTION where USER_ID=".$id);
    $data['donnees'] = $query->getRow();
    return view('users\users-profile',$data);
  }

  function update_pwd()
  {
    $USER_ID=$this->request->getPost('USER_ID');
    $newPassword=$this->request->getPost('newpassword');

    $table='users';
    $critere=array('USER_ID'=>$USER_ID);
    $data = array('PASSWORD' => $newPassword);
    $this->update($table,$critere,$data);
    return redirect('logout');
  }

  function test_username($USERNAME,$USER_ID='')
  {
    $db =\Config\Database::connect();
    $query = $db->query("SELECT USERNAME,USER_ID FROM users where USERNAME='".$USERNAME."'");
    $donnees = $query->getRow();

    $status_exist=0;
    if (!empty($donnees->USERNAME)) 
    {
      $status_exist=1;
      if (!empty($USER_ID))
      {
        if ($USER_ID ==$donnees->USER_ID) 
        {
          $status_exist=0;
        }
        else
        {
          $status_exist=1;
        } 
      }
    }
    return json_encode(array('status_exist'=>$status_exist));
  }
}