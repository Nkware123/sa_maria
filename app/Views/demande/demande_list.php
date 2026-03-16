<!DOCTYPE html>
<html lang="en">
<body>
<?php echo view('sidebar.php');?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Demande</h1>      
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <div class="row mb-2 mt-2 bg-light rounded border">
                <h5 class="card-title text-center">Liste des demandes</h5>
              </div>              
              <!-- Table with stripped rows -->
              <div class="row table-responsive rounded border mb-1 mt-1 w-auto">
                <button style="float: left;" type="button" class="btn btn-primary col-md-2 mt-2" onclick="checkDemandeCours()"><i class="bi bi-person-plus-fill"></i> Nouvelle demande</button><br>
                <table id="myTable" class="table table-striped">
                  <thead class="table-light">
                    <tr>
                      <th>#</th>
                      <th class="text-uppercase">Nom</th>
                      <th class="text-uppercase">Type&nbsp;de&nbsp;congé</th>
                      <th class="text-uppercase">Etape</th>
                      <th class="text-uppercase">Date&nbsp;debut</th>
                      <th class="text-uppercase">date&nbsp;fin</th>
                      <th class="text-uppercase">Date&nbsp;demande</th>
                      <th class="text-uppercase">Option</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $u=1;
                    foreach ($donnees as $value)
                    {
                      echo'
                      <tr>
                        <td>'.$u++.'</td>
                        <td>'.$value->NOM_USER.' '.$value->PRENOM_USER.'</td>
                        <td>'.$value->DESC_TYPE_CONGE.'</td>
                        <td>'.$value->DESC_ETAPE.'</td>
                        <td>'.date('d/m/Y',strtotime($value->DATE_DEBUT)).'</td>
                        <td>'.date('d/m/Y',strtotime($value->DATE_FIN)).'</td>
                        <td>'.date('d/m/Y',strtotime($value->DATE_INSERTION)).'</td>';
                        ?>
                        <td>
                        <div class="nav-item dropdown pe-3 btn btn-secondary">
                          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                            <span class="d-none d-md-block dropdown-toggle ps-2">Options</span>
                          </a>

                          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                            <?php
                            if(in_array($value->ID_ETAPE_VALIDATION, [2,3]) && session()->get('user_id')==$value->USER_ID)
                            {?>
                              <li>
                                <a class="dropdown-item d-flex align-items-center" title="Modifier" href="<?=base_url('demande/view_update').'/'.$value->ID_DEMANDE?>">
                                  <i class="bi bi-pencil-square"></i>
                                  <span>Modifier</span>
                                </a>
                              </li>
                              <li>
                                <hr class="dropdown-divider">
                              </li>
                            <?php
                            }
                            if($value->ID_ETAPE_VALIDATION==2 && session()->get('user_id')==$value->USER_ID_HIERARCHI)
                            {?>
                              <li>
                                <a class="dropdown-item d-flex align-items-center" href="#" onclick="decision(<?=$value->ID_DEMANDE?>,<?=$value->ID_ETAPE_VALIDATION?>)">
                                  <i class="bi bi-box-arrow-right"></i>
                                  <span>Décision</span>
                                </a>
                              </li>
                            <?php
                            }
                            ?>
                          </ul>
                        </div></td>
                      </tr>
                    <?php
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
<div class="modal fade" id="decision" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="Myform" action="<?=base_url('demande/decision')?>" enctype='multipart/form-data' method='POST'>
          <input type="hidden" name="ID_DEMANDE" id="ID_DEMANDE">
          <input type="hidden" name="ID_ETAPE_VALIDATION" id="ID_ETAPE_VALIDATION">
          <div>
            <div class="row">
              <div class="col-md-6">
                <label>Décision<font color="red">*</font></label>
                <select name="ID_TYPE_DECISION" id="ID_TYPE_DECISION" class="form-control" onchange="get_type()">
                  <option value="">Sélectionner</option>
                  <?php
                  foreach ($type_decision as $key)
                  {
                    echo '<option value="'.$key->ID_TYPE_DECISION .'">'.$key->DESCR_TYPE_DECISION.'</option>';
                  }
                  ?>
                </select>
                <font id="error_ID_TYPE_DECISION" color="red"></font>
              </div>
              <div class="col-md-6">
                <label>Observation<font id="obs" color="red"></font></label>
                <textarea name="OBSERVATION" id="OBSERVATION" class="form-control"></textarea>
                <font id="error_OBSERVATION" color="red"></font>
              </div>
            </div>
          </div>
        </form>        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
        <button onclick="save()" class="btn btn-primary">Envoyer</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="dem_en_cour" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body bg-light borderered rounded">
        <center><h4 id="message" class="text-danger"></h4></center>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  function checkDemandeCours()
  {
    $.ajax({
      url:"<?=base_url()?>/demande/checkDemandeCours",
      type:"POST",
      dataType:"JSON",
      success:function(data)
      {
        if(data.status)
        {
          $("#message").html("Une autre demande est en cours!!!")
          $("#dem_en_cour").modal("show")
        }
        else
        {
          window.location.href="<?=base_url()?>/demande/formulaire"
        }
      }
    })
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

  function decision(id_demande,ID_ETAPE_VALIDATION)
  {
    $('#ID_DEMANDE').val(id_demande)
    $('#ID_ETAPE_VALIDATION').val(ID_ETAPE_VALIDATION)
    $('#decision').modal("show")
  }

  function save()
  {
    var statut=true

    $('#error_ID_TYPE_DECISION').text('')
    $('#error_OBSERVATION').text('')

    var ID_TYPE_DECISION=$('#ID_TYPE_DECISION').val()
    if (ID_TYPE_DECISION=='')
    {
      statut=false
      $('#error_ID_TYPE_DECISION').text('Ce champ est obligatoire')
    }

    var OBSERVATION=$('#OBSERVATION').val()
    if(ID_TYPE_DECISION ==2 || ID_TYPE_DECISION==3)
    {
      if (OBSERVATION=='')
      {
        statut=false
        $('#error_OBSERVATION').text('Ce champ est obligatoire')
      }
    }    

    if(statut)
    {
      $('#Myform').submit()
    }    
  }

  function get_type()
  {
    var ID_TYPE_DECISION=$('#ID_TYPE_DECISION').val()

    if(ID_TYPE_DECISION ==2 || ID_TYPE_DECISION==3)
    {
      $('#obs').text('*')
    }
    else
    {
      $('#obs').text('')
    }
  }
</script>