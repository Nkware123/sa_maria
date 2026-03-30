<?php
namespace App\Controllers\Ventes;

use App\Controllers\BaseController;
use App\Models\My_Model;
class Ventes extends BaseController
{
  public function __construct()
  {
    // $this->My_Model = new My_Model();
  }
  
  public function get_view()
  {
    $data=$this->urichk();
    $db=\Config\Database::connect();
    $categories = $db->query("SELECT ID_SOUS_CATEGORIE, DESC_SOUS_CATEGORIE FROM categorie_sous_categ WHERE EST_ACTIVE=1");
    $categories = $categories->getResult();
    $data["categories"] = $categories;

    return view("Ventes/Ventes_Add_View",$data);
  }

  function get_product($idCat)
  {
    $db=\Config\Database::connect();
    $entree = $db->query("SELECT ID_PRODUIT,DESC_PRODUIT,QTE_MINIMAL FROM produits WHERE EST_ACTIVE=1 AND ID_SOUS_CATEGORIE={$idCat}");
    $entrees = $entree->getResult();
    $html="";
    foreach ($entrees as $key) {
        $prod = $db->query("SELECT SUM(l.QTE_RESTANT) as qte,l.PU_VENTE FROM produits_lot l WHERE l.EST_ACTIVE=1 AND l.ID_PRODUIT=".$key->ID_PRODUIT);
        $prod = $prod->getRow();
        if($prod->qte <= 0){
             continue; // Ne pas afficher les produits en rupture de stock
        }
        $color_qte = "success";
        if($prod->qte <= $key->QTE_MINIMAL){
          $color_qte = "danger";
        }
        $html .= "<div class=\"col-6 col-md-4 col-lg-3 col-xl-2 user-select-none\" onclick=\"addToCart({$key->ID_PRODUIT}, {$prod->PU_VENTE}, '{$key->DESC_PRODUIT}', {$prod->qte})\">
          <div class=\"card h-auto border-0 shadow-sm rounded-4 hover-scale\" style=\"cursor: pointer; transition: all 0.2s;\" onmouseover=\"this.style.transform='translateY(-5px)';this.style.boxShadow='0 1rem 2rem rgba(0,0,0,.15)';\" onmouseout=\"this.style.transform='';this.style.boxShadow=''\">
              <div class=\"card-body text-center p-3\">
                  <h6 class=\"fw-bold mb-2\">{$key->DESC_PRODUIT}</h6>
                  <h4 class=\"fw-bold mb-2\" style=\"color: #1E3A8A;\">
                      {$prod->PU_VENTE} BIF
                  </h4>
                  <span class=\"badge bg-{$color_qte} bg-opacity-10 text-{$color_qte} rounded-pill\">
                      <i class=\"bi bi-check-circle-fill me-1\"></i> {$prod->qte} en stock
                  </span>
              </div>
          </div>
        </div>";
    }
    return json_encode(["status"=>true,"html"=>$html]);
  }

  function save_commande(){
    $data=$this->urichk();
    $db=\Config\Database::connect();
    $cart=json_decode($this->request->getVar("cart"),true);
    
    foreach($cart as $item){
      
      //trouver le lot correspondant au produit
      $lot = $db->query("SELECT ID_PRODUIT_LOT, QTE_RESTANT FROM produits_lot WHERE ID_PRODUIT={$item["idProduit"]} AND QTE_RESTANT > 0 ORDER BY ID_PRODUIT_LOT DESC");
      $qte=$item["qte"];
      foreach($lot->getResult() as $l){
        if($qte == 0){
          continue; //si la quantité demandée a été satisfaite, on passe au produit suivant
        }
        if($l->QTE_RESTANT >= $qte){
          //mettre à jour la quantité restante du lot
          $qte_restant = $l->QTE_RESTANT - $qte;
          $this->update("produits_lot",["ID_PRODUIT_LOT"=>$l->ID_PRODUIT_LOT],["QTE_RESTANT"=> $qte_restant]);

          //enregistrer dans la table des ventes
          $venteData = [
            "ID_PRODUIT_LOT" => $l->ID_PRODUIT_LOT,
            "QTE" => $qte,
            "ID_RAISON_SORTIE" => 1, //1 pour vente'
            "PU" => $item["puVente"],
            "DATE_INSERTION" => date("Y-m-d H:i:s")
          ];
          $this->save("sortie",$venteData);
          break;
        }
        else{
          //si la quantité du lot est insuffisante, on le vide et on continue avec le lot suivant
          $this->update("produits_lot",["ID_PRODUIT_LOT"=>$l->ID_PRODUIT_LOT],["QTE_RESTANT"=> 0]);
          $qte =$qte-$l->QTE_RESTANT;

          //enregistrer dans la table des ventes
          $venteData = [
            "ID_PRODUIT_LOT" => $l->ID_PRODUIT_LOT,
            "QTE" => $l->QTE_RESTANT,
            "ID_RAISON_SORTIE" => 1, //1 pour vente'
            "PU" => $item["puVente"],
            "DATE_INSERTION" => date("Y-m-d H:i:s")
          ];
          $this->save("sortie",$venteData);
        }
      }
    }
    return json_encode(["status"=>"success","message"=>"Commande enregistrée avec succès!"]);
  }
}
?>