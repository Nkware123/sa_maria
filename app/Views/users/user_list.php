<!DOCTYPE html>
<html lang="en">
<body>
<?php echo view('sidebar.php');?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Utilisateurs</h1>      
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <div class="row mb-2 mt-2 bg-light rounded border">
                <h5 class="card-title text-center">Liste des utilisateurs</h5>
              </div>              
              <!-- Table with stripped rows -->
              <div class="row table-responsive container rounded border mb-1 mt-1 w-auto">
                <button style="float: left;" type="button" class="btn btn-primary col-md-2 mt-2" onclick="showmodal()"><i class="bi bi-person-plus-fill"></i> Nouvel utilisateur</button><br>
                <table id="myTable" class="table table-striped">
                  <thead class="table-light">
                    <tr>
                      <th>#</th>
                      <th class="text-uppercase">Nom</th>
                      <th class="text-uppercase">Nom&nbsp;d&nbsp;'&nbsp;utilisateur</th>
                      <th class="text-uppercase">Téléphone</th>
                      <th class="text-uppercase">Fonction</th>
                      <th class="text-uppercase">Agence</th>
                      <th class="text-uppercase">Supérieur&nbsp;Hiérarchique</th>
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
                        $EST_ACTIVE='<a title="désactiver" onclick="active_desactive('.$value->USER_ID.','.$value->EST_ACTIVE.')"><center><i style="color:green;" class="bi bi-check-circle-fill"></i></center></a>';
                      }
                      else
                      {
                        $EST_ACTIVE='<a title="activer" onclick="active_desactive('.$value->USER_ID.','.$value->EST_ACTIVE.')"><center><i style="color:red;" class="bi bi-x-circle-fill"></i></center></a>';
                      }
                      echo'
                      <tr>
                        <td>'.$u++.'</td>
                        <td>'.$value->NOM_USER.' '.$value->PRENOM_USER.'</td>
                        <td>'.$value->USERNAME.'</td>
                        <td>'.$value->TELEPHONE.'</td>
                        <td>'.$value->DESC_FONCTION.'</td>
                        <td>'.$value->DESC_AGENCE.'</td>
                        <td>'.$value->NOM_USER_HIERARCHI.' '.$value->PRENOM_USER_HIERARCHI.'</td>
                        <td>'.$EST_ACTIVE.'</td>
                        <td><a class="btn" title="Modifier" onclick="get_data_update('.$value->USER_ID.')"><i class="bi bi-pencil-square"></i></a></td>
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
        <h5 class="modal-title">Nouvel Utilisateur</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="MyForm" action="<?=base_url('users/save_user')?>" enctype='multipart/form-data' method='POST'>
          <input type="hidden" name="USER_ID" id="USER_ID">
          <input type="hidden" name="status_exist" id="status_exist">
          <div class="row">
            <div class="col-md-6">
              <label>Nom<font color="red">*</font></label>
              <input type="text" name="NOM_USER" id="NOM_USER" class="form-control">
              <font id="error_NOM_USER" color="red"></font>
              <br>            
            </div>
            <div class="col-md-6">
              <label>Prénom<font color="red">*</font></label>
              <input type="text" name="PRENOM_USER" id="PRENOM_USER" class="form-control">
              <font id="error_PRENOM_USER" color="red"></font>
              <br>            
            </div>
            <div class="col-md-6">
              <label>Nom d'utilisateur<font color="red">*</font><div id="loading_username"></div></label>
              <input type="text" name="USERNAME" id="USERNAME" class="form-control" oninput="test_username(this.value)">
              <font id="error_USERNAME" color="red"></font>
              <br>            
            </div>
            <div class="col-md-6">
              <label>Mot de passe<font color="red">*</font></label>
              <input type="text" name="PASSWORD" id="PASSWORD" class="form-control">
              <font id="error_PASSWORD" color="red"></font>
              <br>            
            </div>
            <div class="col-md-6">
              <label>Téléphone<font color="red">*</font></label>
              <input type="text" name="TELEPHONE" id="TELEPHONE" class="form-control">
              <font id="error_TELEPHONE" color="red"></font>
              <br>            
            </div>
            <div class="col-md-6">
              <label>Fonction<font color="red">*</font></label>
              <select name="ID_FONCTION" id="ID_FONCTION" class="form-control">
                <option value="">Sélectionner</option>
                <?php
                foreach ($fonction as $value)
                {
                  echo '<option value="'.$value->ID_FONCTION.'">'.$value->DESC_FONCTION.'</option>';
                }
                ?>
              </select>
              <font id="error_ID_FONCTION" color="red"></font>
              <br>
            </div>
            <div class="col-md-6">
              <label>Agence<font color="red">*</font></label>
              <select name="ID_LIEU_AFFECTATION" id="ID_LIEU_AFFECTATION" class="form-control">
                <option value="">Sélectionner</option>
                <?php
                foreach ($affectation as $value)
                {
                  echo '<option value="'.$value->ID_AGENCE.'">'.$value->DESC_AGENCE.'</option>';
                }
                ?>
              </select>
              <font id="error_ID_LIEU_AFFECTATION" color="red"></font>
              <br>
            </div>
            <div class="col-md-6">
              <label>Supérieur hiérarchique</label>
              <select name="USER_ID_HIERARCHI" id="USER_ID_HIERARCHI" class="form-control">
                <option value="">Sélectionner</option>
                <?php
                foreach ($users as $value)
                {
                  echo '<option value="'.$value->USER_ID.'">'.$value->NOM_USER.' '.$value->PRENOM_USER.'</option>';
                }
                ?>
              </select>
              <font id="error_USER_ID_HIERARCHI" color="red"></font>
              <br>
            </div>
            <div class="col-md-12">
              <label>Photo profil</label>
              <input type="file" name="PHOTO_PROFIL" id="PHOTO_PROFIL" class="form-control" accept=".jpeg,.png,.jpg,.JPG">
              <font id="error_PHOTO_PROFIL" color="red"></font>
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
        <form id="desactive" action="<?=base_url('users/active_desactiver')?>" enctype='multipart/form-data' method='POST'>
          <input type="hidden" name="USER_ID_DEL" id="USER_ID_DEL">
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
    var NOM_USER=$('#NOM_USER').val()
    var PRENOM_USER=$('#PRENOM_USER').val()
    var USERNAME=$('#USERNAME').val()
    var PASSWORD=$('#PASSWORD').val()
    var TELEPHONE=$('#TELEPHONE').val()
    var ID_FONCTION=$('#ID_FONCTION').val()
    var ID_LIEU_AFFECTATION=$('#ID_LIEU_AFFECTATION').val()
    var status_exist=$('#status_exist').val()
    var USER_ID=$('#USER_ID').val()

    $('#error_NOM_USER,#error_PRENOM_USER,#error_USERNAME,#error_PASSWORD,#error_TELEPHONE,#error_ID_FONCTION,#error_ID_LIEU_AFFECTATION').html('')

    var statut=1;
    if(status_exist==1)
    {
      $('#error_USERNAME').html('Ce nom d\'utilisateur existe déjà');
      statut=2
    }
    if(NOM_USER=='')
    {
      $('#error_NOM_USER').html('Ce champ est obligatoire');
      statut=2      
    }
    if(PRENOM_USER=='')
    {
      $('#error_PRENOM_USER').html('Ce champ est obligatoire');
      statut=2
    }
    if(USERNAME=='')
    {
      $('#error_USERNAME').html('Ce champ est obligatoire');
      statut=2
    }
    if(PASSWORD=='')
    {
      $('#error_PASSWORD').html('Ce champ est obligatoire');
      statut=2
    }
    if(TELEPHONE=='')
    {
      $('#error_TELEPHONE').html('Ce champ est obligatoire');
      statut=2
    }
    if(ID_FONCTION=='')
    {
      $('#error_ID_FONCTION').html('Ce champ est obligatoire');
      statut=2
    }
    if(ID_LIEU_AFFECTATION=='')
    {
      $('#error_ID_LIEU_AFFECTATION').html('Ce champ est obligatoire');
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
        url:"<?=base_url()?>/users/get_data_update/"+id,
        type:"POST",
        dataType:"JSON",
        success: function(data)
        {
          $('#error_NOM_USER,#error_PRENOM_USER,#error_USERNAME,#error_PASSWORD,#error_TELEPHONE,#error_ID_FONCTION,#error_ID_LIEU_AFFECTATION').html('')
          $('#USER_ID').val(data.USER_ID)
          $('#NOM_USER').val(data.NOM_USER)
          $('#PRENOM_USER').val(data.PRENOM_USER)
          $('#USERNAME').val(data.USERNAME)
          $('#PASSWORD').val(data.PASSWORD)
          $('#TELEPHONE').val(data.TELEPHONE)
          $('#ID_FONCTION').val(data.ID_FONCTION)
          $('#ID_LIEU_AFFECTATION').val(data.ID_AGENCE)
          $('#USER_ID_HIERARCHI').val(data.USER_ID_HIERARCHI)
          $('#basicModal').modal("show");
          $('#MyForm').attr("action",'<?=base_url('users/update_user')?>');
          $('#button2').attr("hidden",false);
          $('#button1').attr("hidden",true);
          $('.modal-title').text("Modification de l'utilisateur");
          test_username()
        }
      });
  }

  function test_username(id)
  {
    var USER_ID=$('#USER_ID').val()
    $.ajax(
      {
        url:"<?=base_url()?>/users/test_username/"+id+"/"+USER_ID,
        type:"GET",
        dataType:"JSON",
        beforeSend:function(){
          $('#loading_username').html('<i class="spinner-border spinner-border-sm"></>')
          if (id=='')
          {
            $('#loading_username').html('')
          }
        },
        success: function(data)
        {
          // alert(data.status_exist)
          $('#loading_username').html('')
          if(data.status_exist==1)
          {
            $('#status_exist').val(1)
            $('#error_USERNAME').html("Ce nom d'utilisateur existe déjà");
          }
          else
          {
            $('#status_exist').val(0)
            $('#error_USERNAME').html('');
          }
        }
      });
  }

  function showmodal()
  {
    $('#USER_ID').val('')
    $('#NOM_USER').val('')
    $('#PRENOM_USER').val('')
    $('#USERNAME').val('')
    $('#PASSWORD').val('')
    $('#TELEPHONE').val('')
    $('#ID_FONCTION').val('')
    $('#ID_LIEU_AFFECTATION').val('')
    $('#MyForm').attr("action",'<?=base_url('users/save_user')?>');
    $('#basicModal').modal("show");
    $('#button2').attr("hidden",true);
    $('#button1').attr("hidden",false);
    $('.modal-title').text("Nouvel utilisateur");
  }

  function active_desactive(USER_ID,est_active)
  {
    if (est_active==0)
    {
      $('#del').text("Activer");
      $('#messa').text('Voulez-Vous vraiment activer cet utilisateur')
      $('#icon').html('<i class="bi bi-check-circle" style="color:green;font-size:150% ;"></i>')
    }
    else
    {
      $('#del').text("Désactiver");
      $('#messa').text('Voulez-Vous vraiment désactiver cet utilisateur')
      $('#icon').html('<i class="bi bi-x-circle" style="color:red;font-size:150% ;"></i>')
    }

    $('#USER_ID_DEL').val(USER_ID);
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