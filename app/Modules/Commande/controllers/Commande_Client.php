<?php
namespace App\Modules\Commande\controllers;

use App\Controllers\BaseController;
use App\Models\My_Model;
date_default_timezone_set("africa/Bujumbura");
class Commande_Client extends BaseController
{
  public function __construct()
  {
    // $this->My_Model = new My_Model();
  }
  
  public function get_view()
  {
    $data=$this->urichk();
    $db=\Config\Database::connect();
    return view('App\Modules\Commande\Views\Commande_Client_View',$data);
  }

  function get_product()
  {
    $db=\Config\Database::connect();
    $entree = $db->query("SELECT ID_PRODUIT,DESC_PRODUIT,QTE_MINIMAL,NBR_BOUTEILLE_PAR_CASIER FROM produits WHERE EST_ACTIVE=1");
    $entrees = $entree->getResult();
    $html="<option selected disabled>---</option>";
    foreach ($entrees as $value) {
        $prod = $db->query("SELECT SUM(l.QTE_RESTANT) as qte,l.PU_VENTE FROM produits_lot l WHERE l.EST_ACTIVE=1 AND l.ID_PRODUIT=".$value->ID_PRODUIT."");
        $prod = $prod->getRow();
        
        $data = array(
            'id' => $value->ID_PRODUIT,
            'pv' => $prod->PU_VENTE,
            'nom' => $value->DESC_PRODUIT,
            'qte_dispo'=>$prod->qte,
        );
        $html .= "<option value='" . json_encode($data) . "'>" . $value->DESC_PRODUIT . "</option>";
    }
    return json_encode(["status"=>true,"html"=>$html]);
  }

  public function save_commande()
  {
    $data = $this->request->getPost('cart');
    // $data = json_decode($data, true);
    $db = \Config\Database::connect();
    $pt = 0; 
    $ID=$this->save("commande_client", [
      "ID_ORIGINE_COMMANDE" => 1,
      "TEL" => "62003522",
      "PT" => $pt,
      "STATUT" => 1,
      "DATE_DEMANDE" => date("Y-m-d H:i:s")
    ]);

    foreach ($data as $item) {
      //
      $this->save("commande_client_detail", [
        "ID_COMMANDE" => $ID,
        "ID_PRODUIT" => $item['produit_id'],
        "QTE_DEMANDE" => $item['qte'],
        "QTE_DISTRIBUE" => 0,
        "ID_UNITE_MESURE" => 1,
        "PU" => $item['prix_unitaire'],
      ]);

      $pt += $item['prix_unitaire'] * $item['qte'];
    }

    //update the total price of the order
    $this->update("commande_client",["ID_COMMANDE" => $ID] , ["PT" => $pt]);

    echo json_encode(["true" => "success", "message" => "Achat enregistré avec succès."]);
  }

  public function liste_commande()
  {
    $db = \Config\Database::connect();
    $commandes = $db->query("SELECT * FROM commande_client order by ID_COMMANDE desc");
    $commandes = $commandes->getResult();
    $data = $this->urichk();
    $data['commandes'] = $commandes;
    return view('App\Modules\Commande\Views\Liste_commandes_client_view', $data);
  }
}
        
        