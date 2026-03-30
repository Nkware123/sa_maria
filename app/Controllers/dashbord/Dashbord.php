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
  
  public function get_view()
  {
    $data=$this->urichk();
    $db = \Config\Database::connect();

    $entree = $db->query("SELECT SUM(QTE) * SUM(PU_ACHAT) as tot_ach, SUM(QTE_RESTANT) * SUM(PU_ACHAT) as tot_rest FROM produits_lot WHERE EST_ACTIVE=1");
    $entrees = $entree->getRow();
    $data['entrees']=(empty( $entrees->tot_ach))?0: $entrees->tot_ach;
    $data['rest']=(empty( $entrees->tot_rest))?0: $entrees->tot_rest;

    $sorties = $db->query("SELECT SUM(QTE) * SUM(PU) as tot_sortie FROM sortie WHERE ID_RAISON_SORTIE=1");
    $data['sorties'] = $sorties->getRow()->tot_sortie;
    $data['sorties']=(empty( $data['sorties']))?0: $data['sorties'];
    
    $dep = $db->query("SELECT SUM(MONTANT) as tot_dep FROM depenses WHERE 1");
    $data['dep'] = $dep->getRow()->tot_dep;
    $data['dep']=(empty( $data['dep']))?0: $data['dep'];
    return view("dashbord/Dashbord_view",$data);
  }

    public function get_rapport()
    {
        $value = $this->request->getGet('filtre');
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

        $db = \Config\Database::connect();
        $query_produit = $db->query("SELECT ID_PRODUIT, DESC_PRODUIT FROM produits WHERE EST_ACTIVE=1 ORDER BY DESC_PRODUIT ASC");
        $query_produit = $query_produit->getResult();

        $MONTANT_TOTAL = 0;
        $categories = [];
        $series_data = [];
        $lot_counter = 1;

        // D'abord les catégories (produits)
        foreach ($query_produit as $key)
        {
            $categories[] = $key->DESC_PRODUIT;
        }

        // Ensuite construire les séries (lots)
        foreach ($query_produit as $key)
        {
            $query_produit_lot = $db->query("SELECT ID_PRODUIT_LOT, QTE, PU_ACHAT FROM produits_lot WHERE EST_ACTIVE=1 AND ID_PRODUIT=".$key->ID_PRODUIT." ORDER BY ID_PRODUIT_LOT DESC");
            $query_produit_lot = $query_produit_lot->getResult();
            
            $index = array_search($key->DESC_PRODUIT, $categories);
            
            foreach ($query_produit_lot as $value)
            {
                $MONTANT_TOTAL += $value->QTE * $value->PU_ACHAT;
                
                // Créer un tableau de données avec des 0 partout
                $data = array_fill(0, count($categories), 0);
                $data[$index] = (int)$value->QTE;
                
                $series_data[] = [
                    'name' => 'Lot ' . $lot_counter++,
                    'data' => $data
                ];
            }
        }

        $categories_json = json_encode($categories);
        $series_json = json_encode($series_data);

        $rapp1 = "<script type=\"text/javascript\">
            Highcharts.chart('container', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: '<b class=\"card-title\">Stock par produit et par lot</b>',
                    align: 'center'
                },
                subtitle: {
                    text: 'Total: " . number_format($MONTANT_TOTAL, 0, ',', ' ') . " FBU',
                    align: 'left'
                },
                legend: {
                    enabled: false
                },
                xAxis: {
                    categories: $categories_json,
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Nombre de bouteilles'
                    },
                    stackLabels: {
                        enabled: true,
                        format: '{total} btl'
                    }
                },
                
                tooltip: {
                    headerFormat: '<b>{category}</b><br/>',
                    pointFormat: '{series.name}: {point.y} bouteilles<br/>Prix: {point.prix} FBU<br/>Valeur: {point.valeur} FBU'
                },
                plotOptions: {
                    column: {
                        stacking: 'normal',
                        dataLabels: {
                            enabled: true,
                            format: '{point.y}'
                        },
                        point: {
                            events: {
                                click: function() {
                                    if (this.y > 0) {
                                        window.open(
                                            '" . base_url('dashboard/Dashboard_Airtimes/get_pdf/') . "' + this.series.options.lot_id,
                                            '_blank'
                                        );
                                    }
                                }
                            }
                        }
                    }
                },
                credits: {
                    enabled: true,
                    href: \"\",
                    text: \"sa-maria\"
                },
                series: $series_json
            });
        </script>";

        $query_all_produit = $db->query("SELECT l.ID_PRODUIT,DESC_PRODUIT, SUM(QTE) tot_qte, SUM(PU_ACHAT) tot_ach FROM produits_lot l JOIN produits p ON p.ID_PRODUIT=l.ID_PRODUIT WHERE l.EST_ACTIVE=1  GROUP BY ID_PRODUIT");
        $query_all_produit = $query_all_produit->getResult();

        $ventes='';
        $stock='';

        $color='#50b5d6';
        $color1='#3d61e5';

        foreach ($query_all_produit as $value) {
            $get_vente= $db->query("SELECT ID_PRODUIT, SUM(l.QTE) tot_qte, SUM(PU) tot_ach FROM sortie l join produits_lot p ON p.ID_PRODUIT_LOT=l.ID_PRODUIT_LOT WHERE ID_RAISON_SORTIE=1 AND p.ID_PRODUIT=".$value->ID_PRODUIT);
            $get_vente = $get_vente->getRow();

            $stock.="{name:'".str_replace(array("'", "\"", "\\","\n","\r","\t", "&"), "", $value->DESC_PRODUIT)."',y:".$value->tot_qte.",key:'".$value->ID_PRODUIT."',color: '".$color."' },"; 
            $ventes.="{name:'".str_replace(array("'", "\"", "\\","\n","\r","\t", "&"), "", $value->DESC_PRODUIT)."',y:".$get_vente->tot_qte.",key:'".$value->ID_PRODUIT."',color: '".$color1."' },"; 
        }

        $rapp2="<script type=\"text/javascript\">
        Highcharts.chart('container1', {
            chart: {
                type: 'column'  
            },
            title: {
                text: '<b>Stock vs Vente</b>'
            },
            subtitle: {
                text: '<b></b><b></br><br>".date('d-m-Y')."</b>'
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                allowDecimals: false,
                min: 0,
                title: {
                    text: ''
                }
            },
            tooltip: {
            headerFormat: '<span style=\"font-size:10px\">{point.key}</span><table>',
            pointFormat: '<tr><td style=\"color:{series.color};padding:0\">{series.name}: </td>' +
            '<td style=\"padding:0\"><b>{point.y:.f} </b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
                      
            },
            plotOptions: {
                column: {
                         cursor:'pointer',
              point:{
                events: {
                 click: function()
                 {
                    windowObjectReference = window.open(
                     \"".base_url('dashboard/Dashboard_Airtimes/get_pdf/')."\"+this.key+'/'+this.key2,
                     \"_blank\",
                   \"toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=1200,height=4000\");
                }
            }
          },
          dataLabels: {
           enabled: true,
           format: '{point.y:,f} '
          },
          showInLegend: true
          }
          },
          credits: {
            enabled: true,
            href: \"\",
            text: \"sa-maria\"
          },
            series: [{
                color:'".$color."',
                name:'Stock',
                data: [".$stock."]
            },
            {
                color:'".$color1."',
                name:'Vente',
                data: [".$ventes."]
            }]
        });
         </script>";

        echo json_encode(array('rapp1'=>$rapp1,'rapp2'=>$rapp2));
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