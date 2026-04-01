<?php 
namespace App\Controllers\Achat;

use App\Controllers\BaseController;
use App\Models\My_Model;
class Achat extends BaseController
{
  public function __construct()
  {
    // $this->My_Model = new My_Model();
  }
  
  public function get_view()
  {
    $data=$this->urichk();
    $db = \Config\Database::connect();

    $fournisseurs = $db->query("SELECT ID_FOURNISSEUR, NOM_FOURNISSEUR FROM fournisseur WHERE EST_ACTIVE=1");
    $data["fournisseurs"] = $fournisseurs->getResult();

    $produits = $db->query("SELECT ID_PRODUIT, DESC_PRODUIT,NBR_BOUTEILLE_PAR_CASIER FROM produits WHERE EST_ACTIVE=1");
    $data["produits"] = $produits->getResult();

    return view("Achat/Achat_Add_view",$data);
  }
}