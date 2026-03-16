<!DOCTYPE html>
<html lang="en">
<body>
<?php echo view('sidebar.php');?>

  <main id="main" class="main">

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <div class="row mb-2 mt-2 bg-light rounded border">
                <h5 class="card-title text-center">Liste des types de congés</h5>
              </div>              
              <!-- Table with stripped rows -->
              <div class="row table-responsive container rounded border mb-1 mt-1 w-auto">
                <button style="float: left;" type="button" class="btn btn-primary col-md-2 mt-2" onclick="showmodal()"><i class="bi bi-person-plus-fill"></i> Nouveau</button><br>
                <table id="myTable" class="table table-striped">
                  <thead class="table-light">
                    <tr>
                      <th>#</th>
                      <th class="text-uppercase">Type&nbsp;congé</th>
                      <th class="text-uppercase">S'agit-il&nbsp;de&nbsp;jour&nbsp;de&nbsp;base?</th>
                      <th class="text-uppercase">Jours&nbsp;de&nbsp;base</th>
                      <th class="text-uppercase">Status</th>
                      <th class="text-uppercase">Option</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $u=1;
                    foreach ($donnees as $value)
                    {
                      if($value->EST_ACTIVE==1)
                      {
                        $EST_ACTIVE='<a title="désactiver" onclick="active_desactive('.$value->ID_TYPE_CONGE.','.$value->EST_ACTIVE.')"><center><i style="color:green;" class="bi bi-check-circle-fill"></i></center></a>';
                      }
                      else
                      {
                        $EST_ACTIVE='<a title="activer" onclick="active_desactive('.$value->ID_TYPE_CONGE.','.$value->EST_ACTIVE.')"><center><i style="color:red;" class="bi bi-x-circle-fill"></i></center></a>';
                      }
                      echo'
                      <tr>
                        <td>'.$u++.'</td>
                        <td>'.$value->DESC_TYPE_CONGE.'</td>
                        <td>'.($value->HAS_JOURS_BASE==1 ? 'Oui' : 'Non').'</td>
                        <td>'.($value->HAS_JOURS_BASE==1 ? $value->NOMBRE_JOURS_BASE : '-').'</td>
                        <td>'.$EST_ACTIVE.'</td>
                        <td><a class="btn" title="Modifier" onclick="get_data_update('.$value->ID_TYPE_CONGE.')"><i class="bi bi-pencil-square"><i></a></td>
                      </tr>'; 
                    }
                    ?>
                  </tbody>
                </table>
              </div>
              <!-- End Table with stripped rows -->
            </div>
          </div>

        </div>
      </div>
    </section>

  </main>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>
<div class="modal fade" id="basicModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Nouveau type de conge</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="MyForm" action="<?=base_url('type_conge/save_type_conge')?>" enctype='multipart/form-data' method='POST'>
          <input type="hidden" name="ID_TYPE_CONGE" id="ID_TYPE_CONGE">
          <div class="row">
            <div class="col-md-12">
              <label>Type congé<font color="red">*</font></label>
              <input type="text" name="DESC_TYPE_CONGE" id="DESC_TYPE_CONGE" class="form-control">
              <font id="error_DESC_TYPE_CONGE" color="red"></font>
              <br>            
            </div>
            <div class="col-md-12">
              <label>S'agit-il de jour de base?<font color="red">*</font></label>
              <select name="HAS_JOURS_BASE" id="HAS_JOURS_BASE" class="form-control" onchange="get_jours_base()">
                <option value="">Sélectionner</option>
                <option value="1">Oui</option>
                <option value="0">Non</option>
              </select>
              <font id="error_HAS_JOURS_BASE" color="red"></font>
              <br>
            </div>
            <div class="col-md-12" id="div_jours_base" style="display: none;">
              <label>Jours de base<font color="red">*</font></label>
              <input type="number" name="NOMBRE_JOURS_BASE" id="NOMBRE_JOURS_BASE" class="form-control">
              <font id="error_NOMBRE_JOURS_BASE" color="red"></font>
              <br>
            </div>
          </div>
        </form>        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
        <button id='button1' type="button" class="btn btn-primary" onclick="save()">Enregistrer</button>
        <button id='button2' hidden="true" type="button" class="btn btn-primary" onclick="save()">Modifier</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="active_desactive" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="desactive" action="<?=base_url('type_conge/active_desactiver')?>" enctype='multipart/form-data' method='POST'>
          <input type="hidden" name="ID_TYPE_CONGE_DEL" id="ID_TYPE_CONGE_DEL">
          <input type="hidden" name="EST_ACTIVE" id="EST_ACTIVE">
          <div>
            <div class="row">
              <div id="icon" class="col-md-1"></div>
              <div style="font-size: 115%;" id="messa" class="col-md-11"></div>
            </div>
          </div>
        </form>        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
        <button id='del' type="button" class="btn btn-primary"></button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  function get_jours_base()
  {
    if($('#HAS_JOURS_BASE').val()==1)
    {
      $('#div_jours_base').show();
    }
    else
    {
      $('#div_jours_base').hide();
    }
  }

  function save()
  {
    var DESC_TYPE_CONGE=$('#DESC_TYPE_CONGE').val()
    var HAS_JOURS_BASE=$('#HAS_JOURS_BASE').val()
    var NOMBRE_JOURS_BASE=$('#NOMBRE_JOURS_BASE').val()

    var statut=1
    $('#error_DESC_TYPE_CONGE').html('')

    if(HAS_JOURS_BASE=='')
    {
      $('#error_HAS_JOURS_BASE').html('Ce champ est obligatoire');
      statut=2      
    }
    else
    {
      $('#error_HAS_JOURS_BASE').html('');
      if(HAS_JOURS_BASE==1 && NOMBRE_JOURS_BASE=='')
      {
        $('#error_NOMBRE_JOURS_BASE').html('Ce champ est obligatoire');
        statut=2 
      }
      else
      {
        $('#error_NOMBRE_JOURS_BASE').html('');
      }
    }

    if(DESC_TYPE_CONGE=='')
    {
      $('#error_DESC_TYPE_CONGE').html('Ce champ est obligatoire');
      statut=2      
    }    

    if (statut==1)
    {
      $('#MyForm').submit();
    }   
  }

  function get_data_update(id)
  {
    $.ajax(
      {
        url:"<?=base_url()?>/type_conge/get_data_update/"+id,
        type:"POST",
        dataType:"JSON",
        success: function(data)
        {
          $('#error_DESC_TYPE_CONGE').html('')
          $('#ID_TYPE_CONGE').val(data.ID_TYPE_CONGE)
          $('#DESC_TYPE_CONGE').val(data.DESC_TYPE_CONGE)
          $('#HAS_JOURS_BASE').val(data.HAS_JOURS_BASE)
          if(data.HAS_JOURS_BASE==1)
          {
            $('#div_jours_base').show();
            $('#NOMBRE_JOURS_BASE').val(data.NOMBRE_JOURS_BASE)
          }
          else
          {
            $('#div_jours_base').hide();
            $('#NOMBRE_JOURS_BASE').val('')
          }
          $('#basicModal').modal("show");
          $('#MyForm').attr("action",'<?=base_url('type_conge/update_type_conge')?>');
          $('#button2').attr("hidden",false);
          $('#button1').attr("hidden",true);
          $('.modal-title').text("Modification du type de conge");
        }
      });
  }

  function showmodal()
  {
    $('#ID_TYPE_CONGE').val('')
    $('#DESC_TYPE_CONGE').val('')
    $('#MyForm').attr("action",'<?=base_url('type_conge/save_type_conge')?>');
    $('#basicModal').modal("show");
    $('#button2').attr("hidden",true);
    $('#button1').attr("hidden",false);
    $('.modal-title').text("Nouveau type de conge");
  }

  function active_desactive(ID_TYPE_CONGE,est_active)
  {
    if (est_active==0)
    {
      $('#del').text("Activer");
      $('#messa').text('Voulez-Vous vraiment activer ce type de conge')
      $('#icon').html('<i class="bi bi-check-circle" style="color:green;font-size:150% ;"></i>')
    }
    else
    {
      $('#del').text("Désactiver");
      $('#messa').text('Voulez-Vous vraiment désactiver ce type de conge')
      $('#icon').html('<i class="bi bi-x-circle" style="color:red;font-size:150% ;"></i>')
    }

    $('#ID_TYPE_CONGE_DEL').val(ID_TYPE_CONGE);
    $('#EST_ACTIVE').val(est_active);
    $('#active_desactive').modal("show");
    $('#del').click(function delet(){
      $('#desactive').submit()
    });
  }

   $(document).ready(function() {
    $('#myTable').DataTable({
      // columnDefs: [
      //     { targets: [3], orderable: false } // Désactiver la possibilité de trier la colonne d'action
      //   ],
     
     dom: 'Bfrtlip',
      language: {
      "sProcessing":     "Traitement en cours...",
      "sSearch":         "Rechercher&nbsp;:",
      "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
      "sInfo":           "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
      "sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
      "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
      "sInfoPostFix":    "",
      "sLoadingRecords": "Chargement en cours...",
      "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
      "sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
      "oPaginate": {
        "sFirst":      "Premier",
        "sPrevious":   "Pr&eacute;c&eacute;dent",
        "sNext":       "Suivant",
        "sLast":       "Dernier"
      },
      "oAria": {
        "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
        "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
      }
    }
    });

  });
</script>