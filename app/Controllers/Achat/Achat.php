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

  public function save_achat()
  {
    $data = $this->request->getPost('cart');
    // $data = json_decode($data, true);
    $db = \Config\Database::connect();
    foreach ($data as $item) {
      $this->save("produits_lot", [
        "ID_PRODUIT" => $item['produit_id'],
        "QTE" => $item['qte_bouteilles'],
        "QTE_RESTANT" => $item['qte_bouteilles'],
        "PU_ACHAT" => $item['prix_achat'],
        "PU_VENTE" => $item['prix_vente'],
        "DATE_EXPIRATION" => $item['date_expiration'],
        "ID_FOURNISSEUR" => $item['id_fournisseur'],
        "EST_ACTIVE" => 1,
        "DATE_INSERTION" => date("Y-m-d H:i:s"),
        "ID_USER_INSERTION" => session()->get("user_id")
      ]);
    }

    echo json_encode(["true" => "success", "message" => "Achat enregistré avec succès."]);
  }

  public function get_list_view()
  {
    $data=$this->urichk();
    $db = \Config\Database::connect();

    $get_data = $db->query("SELECT pl.ID_PRODUIT_LOT, p.DESC_PRODUIT, pl.QTE, pl.QTE_RESTANT, pl.PU_ACHAT, pl.PU_VENTE, pl.DATE_EXPIRATION, f.NOM_FOURNISSEUR, pl.DATE_INSERTION,p.NBR_BOUTEILLE_PAR_CASIER
    FROM produits_lot pl
    JOIN produits p ON pl.ID_PRODUIT = p.ID_PRODUIT
    JOIN fournisseur f ON pl.ID_FOURNISSEUR = f.ID_FOURNISSEUR
    WHERE pl.EST_ACTIVE = 1");
    $data["get_data"] = $get_data->getResult();

    return view("Achat/Achat_List_view",$data);
  }
}