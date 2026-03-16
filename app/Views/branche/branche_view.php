<!DOCTYPE html>
<html lang="en">
<body>
<?php echo view('sidebar.php');?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Agence</h1>      
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <div class="row mb-2 mt-2 bg-light rounded border">
                <h5 class="card-title text-center">Liste des agences</h5>
              </div>              
              <!-- Table with stripped rows -->
              <div class="row table-responsive container rounded border mb-1 mt-1 w-auto">
                <button style="float: left;" type="button" class="btn btn-primary col-md-2 mt-2" onclick="showmodal()"><i class="bi bi-person-plus-fill"></i> Nouvelle agence</button><br>
                <table id="myTable" class="table table-striped">
                  <thead class="table-light">
                    <tr>
                      <th>#</th>
                      <th class="text-uppercase">Agence</th>
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
                        $EST_ACTIVE='<a title="désactiver" onclick="active_desactive('.$value->ID_AGENCE.','.$value->EST_ACTIVE.')"><center><i style="color:green;" class="bi bi-check-circle-fill"><i></center></a>';
                      }
                      else
                      {
                        $EST_ACTIVE='<a title="activer" onclick="active_desactive('.$value->ID_AGENCE.','.$value->EST_ACTIVE.')"><center><i style="color:red;" class="bi bi-x-circle-fill"><i></center></a>';
                      }
                      echo'
                      <tr>
                        <td>'.$u++.'</td>
                        <td>'.$value->DESC_AGENCE.'</td>
                        <td>'.$EST_ACTIVE.'</td>
                        <td><a class="btn" title="Modifier" onclick="get_data_update('.$value->ID_AGENCE.')"><i class="bi bi-pencil-square"><i></a></td>
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
        <h5 class="modal-title">Nouvelle agence</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="MyForm" action="<?=base_url('branche/save_branche')?>" enctype='multipart/form-data' method='POST'>
          <input type="hidden" name="ID_AGENCE" id="ID_AGENCE">
          <div class="row">
            <div class="col-md-12">
              <label>Description<font color="red">*</font></label>
              <input type="text" name="DESC_AGENCE" id="DESC_AGENCE" class="form-control">
              <font id="error_DESC_AGENCE" color="red"></font>
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
        <form id="desactive" action="<?=base_url('branche/active_desactiver')?>" enctype='multipart/form-data' method='POST'>
          <input type="hidden" name="ID_AGENCE_DEL" id="ID_AGENCE_DEL">
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
  function save()
  {
    var DESC_AGENCE=$('#DESC_AGENCE').val()

    var statut=1
    $('#error_DESC_AGENCE').html('')

    if(DESC_AGENCE=='')
    {
      $('#error_DESC_AGENCE').html('Ce champ est obligatoire');
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
        url:"<?=base_url()?>/branche/get_data_update/"+id,
        type:"POST",
        dataType:"JSON",
        success: function(data)
        {
          $('#error_DESC_AGENCE').html('')
          $('#ID_AGENCE').val(data.ID_AGENCE)
          $('#DESC_AGENCE').val(data.DESC_AGENCE)
          $('#basicModal').modal("show");
          $('#MyForm').attr("action",'<?=base_url('branche/update_branche')?>');
          $('#button2').attr("hidden",false);
          $('#button1').attr("hidden",true);
          $('.modal-title').text("Modification de l'utilisateur");
          test_username()
        }
      });
  }

  function showmodal()
  {
    $('#ID_AGENCE').val('')
    $('#DESC_AGENCE').val('')
    $('#MyForm').attr("action",'<?=base_url('branche/save_branche')?>');
    $('#basicModal').modal("show");
    $('#button2').attr("hidden",true);
    $('#button1').attr("hidden",false);
    $('.modal-title').text("Nouvelle agence");
    $('.modal-title').text("Nouvelle agence");
  }

  function active_desactive(ID_AGENCE,est_active)
  {
    if (est_active==0)
    {
      $('#del').text("Activer");
      $('#messa').text('Voulez-Vous vraiment activer cette agence')
      $('#icon').html('<i class="bi bi-check-circle" style="color:green;font-size:150% ;"></i>')
    }
    else
    {
      $('#del').text("Désactiver");
      $('#messa').text('Voulez-Vous vraiment désactiver cette agence')
      $('#icon').html('<i class="bi bi-x-circle" style="color:red;font-size:150% ;"></i>')
    }

    $('#ID_AGENCE_DEL').val(ID_AGENCE);
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