<?php 
namespace App\Controllers\demande;
use App\Controllers\BaseController;
use App\Models\My_Model;

class demande extends BaseController
{
    public function __construct()
    {
        $this->My_Model = new My_Model();
    }
    public function index() 
    {
        $data = $this->urichk();
        $db =\Config\Database::connect();
        $query_type_conge = $db->query("SELECT * FROM type_conge WHERE EST_ACTIVE=1");
        $data['type_conge'] = $query_type_conge->getResult();
        return view('demande\formulaire_demande_conge',$data);
    }

    function get_jours_restants()
    {
        $ID_TYPE_CONGE = $this->request->getPost('ID_TYPE_CONGE');
        $db =\Config\Database::connect();

        $get_conge = $db->query("SELECT HAS_JOURS_BASE, NOMBRE_JOURS_BASE FROM type_conge WHERE ID_TYPE_CONGE=".$ID_TYPE_CONGE);
        $conge = $get_conge->getRow();
        if($conge->HAS_JOURS_BASE==1)
        {
            $query_jours_restants = $db->query("SELECT SUM(NOMBRE_JOURS_RESTANT) AS NB_JOURS, SUM(NOMBRE_JOURS_DEMANDE) AS JOURS_PRIS FROM demande_conge WHERE ID_USER=".session()->get('user_id')." AND STATUS_FINAL=1 AND ID_TYPE_CONGE=".$ID_TYPE_CONGE);
            $result = $query_jours_restants->getRow();
            $jours_restants = $conge->NOMBRE_JOURS_BASE - $result->JOURS_PRIS;
            $jours_pris=!empty($result->JOURS_PRIS) ? $result->JOURS_PRIS : 0;
            echo json_encode(array('jours_restants' => $jours_restants,'total' => $conge->NOMBRE_JOURS_BASE, 'jours_pris' => $jours_pris));
        }
        else
        {
            echo json_encode(array('jours_restants' => 'N/A', 'jours_pris' => 'N/A'));
        }       
    }

    public function liste()
    {
        $data = $this->urichk();
        $db =\Config\Database::connect();
        $query = $db->query("SELECT * FROM demande_conge as demande join users ON users.USER_ID=demande.ID_USER join type_conge typ ON typ.ID_TYPE_CONGE=demande.ID_TYPE_CONGE join etape_validation etap on etap.ID_ETAPE_VALIDATION=demande.ID_ETAPE_VALIDATION WHERE 1");
        $data['donnees'] = $query->getResult();

        $type_decision = $db->query("SELECT * FROM type_decision");
        $data['type_decision'] = $type_decision->getResult();

        return view("App\Views\demande\demande_list",$data);
    }

    public function save_demande()
    {
        $ID_USER=session()->get('user_id');
        $ID_TYPE_CONGE=$this->request->getPost('ID_TYPE_CONGE');
        $DATE_DEBUT=$this->request->getPost('DATE_DEBUT');
        $DATE_FIN=$this->request->getPost('DATE_FIN');
        $NOMBRE_JOURS_RESTANT=$this->request->getPost('jours_restants');
        $NOMBRE_JOURS_DEMANDE=$this->request->getPost('NOMBRE_JOURS_DEMANDE');
        $MOTIF=$this->request->getPost('MOTIF');

        if(empty($NOMBRE_JOURS_RESTANT))
        {
            $NOMBRE_JOURS_RESTANT=0;
        }

        $table='demande_conge';
        $datacolumsinsert = array('ID_USER' => $ID_USER,'ID_TYPE_CONGE'=>$ID_TYPE_CONGE,'ID_ETAPE_VALIDATION' => 3,'NOMBRE_JOURS_DEMANDE'=>$NOMBRE_JOURS_DEMANDE,'NOMBRE_JOURS_RESTANT'=>$NOMBRE_JOURS_RESTANT,'DATE_DEBUT'=>$DATE_DEBUT,'DATE_FIN'=>$DATE_FIN);
        $ID_DEMANDE=$this->save($table,$datacolumsinsert); 

        //insertion dans historique
        $table='historique_demande';
        $datacolumsinsert = array('ID_DEMANDE'=>$ID_DEMANDE,'ID_USER'=>$ID_USER,'ID_ETAPE_VALIDATION' => 1,'OBSERVATION'=>$MOTIF);
        $this->save($table,$datacolumsinsert);

        return redirect('demande/liste');        
    }

    public function view_update($ID_DEMANDE) 
    {
        $data = $this->urichk();
        $db =\Config\Database::connect();
        $query = $db->query("SELECT * FROM demande_conge as demande join users ON users.USER_ID=demande.ID_USER join type_conge type ON type.ID_TYPE_CONGE=demande.ID_TYPE_CONGE where ID_DEMANDE=".$ID_DEMANDE);
        $data['donnees'] = $query->getRow();

        $query_type_conge = $db->query("SELECT * FROM type_conge");
        $data['type_conge'] = $query_type_conge->getResult();
        return view('demande\correction_demande',$data);
    }

    public function update_demande()
    {
        $ID_USER=session()->get('user_id');
        $ID_DEMANDE=$this->request->getPost('ID_DEMANDE');
        $ID_TYPE_CONGE=$this->request->getPost('ID_TYPE_CONGE');
        $DATE_DEBUT=$this->request->getPost('DATE_DEBUT');
        $DATE_FIN=$this->request->getPost('DATE_FIN');
        $NOMBRE_JOURS_RESTANT=$this->request->getPost('jours_restants');
        $NOMBRE_JOURS_DEMANDE=$this->request->getPost('NOMBRE_JOURS_DEMANDE');
        $MOTIF=$this->request->getPost('MOTIF');

        if(empty($NOMBRE_JOURS_RESTANT))
        {
            $NOMBRE_JOURS_RESTANT=0;
        }

        $table='demande_conge';
        $condition=array('ID_DEMANDE'=>$ID_DEMANDE);
        $datacolumsinsert = array('ID_USER' => $ID_USER,'ID_TYPE_CONGE'=>$ID_TYPE_CONGE,'ID_ETAPE_VALIDATION' => 3,'DATE_DEBUT'=>$DATE_DEBUT,'DATE_FIN'=>$DATE_FIN,'NOMBRE_JOURS_RESTANT'=>$NOMBRE_JOURS_RESTANT,'NOMBRE_JOURS_DEMANDE'=>$NOMBRE_JOURS_DEMANDE);
        $this->update($table,$condition,$datacolumsinsert);

        //insertion dans historique
        $table='historique_demande';
        $datacolumsinsert = array('ID_DEMANDE'=>$ID_DEMANDE,'ID_USER'=>$ID_USER,'ID_ETAPE_VALIDATION' => 2,'OBSERVATION'=>$MOTIF);
        $this->save($table,$datacolumsinsert); 

        return redirect('demande/liste');
    }

    function checkDemandeCours()
    {
        $db=\Config\Database::connect();
        $nbr_rest=$db->query("SELECT * FROM demande_conge d where ID_ETAPE_VALIDATION in (2,3) AND ID_USER=".session()->get('user_id'))->getRow();
        if(empty($nbr_rest))
        {
           $status=false; 
        }
        else
        {
            $status=true;
        }
        echo json_encode(array("status"=>$status));
    }

    public function decision()
    {
        $db =\Config\Database::connect();
        $ID_DEMANDE=$this->request->getPost('ID_DEMANDE');
        $OBSERVATION=$this->request->getPost('OBSERVATION');
        $ID_USER=session()->get('user_id');
        $ID_TYPE_DECISION=$this->request->getPost('ID_TYPE_DECISION');
        $ID_ETAPE_VALIDATION=$this->request->getPost('ID_ETAPE_VALIDATION');

        $nbr_rest=$db->query("SELECT NOMBRE_JOURS_DEMANDE, t.NOMBRE_JOURS_BASE FROM demande_conge d join type_conge t on d.ID_TYPE_CONGE=t.ID_TYPE_CONGE where ID_DEMANDE=".$ID_DEMANDE)->getRow();

        if($ID_TYPE_DECISION==1 && !empty($nbr_rest->NOMBRE_JOURS_BASE))
        {
            $NOMBRE_JOURS_RESTANT=$nbr_rest->NOMBRE_JOURS_BASE - $nbr_rest->NOMBRE_JOURS_DEMANDE;
        }
        else
        {
            $NOMBRE_JOURS_RESTANT=0;
        }

        if($ID_TYPE_DECISION==2)
        {
            $cond="AND IS_CORRECTION=1";
        }        
        elseif($ID_TYPE_DECISION==3)
        {
            $cond="AND IS_CORRECTION=2";
        }
        else
        {
            $cond="AND IS_CORRECTION=0";
        }

        $query = $db->query("SELECT ID_ETAPE_SUIVANT FROM etape_validation_config where ID_ETAPE_ACTUEL=".$ID_ETAPE_VALIDATION." ".$cond);
        $type_conge = $query->getRow();

        $table='demande_conge';
        $condition=array('ID_DEMANDE'=>$ID_DEMANDE);
        $datacolumsinsert = array('ID_ETAPE_VALIDATION' => $type_conge->ID_ETAPE_SUIVANT,'NOMBRE_JOURS_RESTANT' => $NOMBRE_JOURS_RESTANT);
        $this->update($table,$condition,$datacolumsinsert);

        //insertion dans historique
        $table='historique_demande';
        $datacolumsinsert = array('ID_DEMANDE'=>$ID_DEMANDE,'OBSERVATION'=>$OBSERVATION,'ID_USER'=>$ID_USER,'ID_ETAPE_VALIDATION' => 2);
        $this->save($table,$datacolumsinsert);

        return redirect('demande/liste');
    }
}