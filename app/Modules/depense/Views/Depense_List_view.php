<!DOCTYPE html>
<html lang="en">
  <body>
  <?php echo view('sidebar.php');
  date_default_timezone_set("africa/Bujumbura");
  ?>
  <main id="main" class="main">

    <div class="pagetitle row">
      Dépenses
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-center align-items-center mb-2 bg-light p-2 rounded-4 text-dark shadow-sm mt-3">
                  <div class="card-title mb-0">
                    <h3>Liste des dépenses</h3>
                  </div>
                  <div class="ms-auto">
                    <Button class="btn btn-primary" onclick="openAddModal()"><i class="bi bi-plus"></i> Ajouter</Button>
                  </div>
                </div>
              </div>

                <div class="table-responsive p-3 mt-2 mb-2 rounded border">
                  <table id="mytable" class="table table-striped w-100">
                    <thead class="table-dark">
                      <tr>
                        <th>#</th>
                        <th class="text-white">TYPE DEPENSE</th>
                        <th class="text-white">MONTANT</th>
                        <th class="text-white">UTILISATEUR</th>
                        <th class="text-white">DATE DEPENSE</th>
                        <th class="text-white">DATE CREATION</th>
                        <!-- <th class="text-white">DATE ENTRÉE</th> -->
                        <!-- <th class="text-white">ACTION</th> -->
                      </tr>
                    </thead>
                    <tbody class="table-light">
                      <?php 
                      $i = 1;
                      foreach($depense as $item):?>
                        <tr>
                          <td><?= $i++ ?></td>
                          <td><?= $item->DESC_TYPE_DEPENSE ?></td>

                          <td><span class="badge bg-dark text-white"><?= $item->MONTANT ?></span></td>
                          <td><span class="badge bg-info text-white"><?= $item->NOM_USER. " " . $item->PRENOM_USER ?></span></td>

                          <td><i class="bi bi-calendar"></i> <?= date("d/m/Y", strtotime($item->DATE_DEPENSE)) ?></td>

                          <td><i class="bi bi-calendar"></i> <?= date("d/m/Y", strtotime($item->DATE_INSERTION)) ?></td>

                          <!-- <td><button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button></td> -->
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>            
            </div>
          </div>
        </div>

      </div>
    </section>

  </main><!-- End #main -->

  <?php echo view('footer.php')?>
  <script src="assets/js/main.js"></script>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  
  <script src=<?=base_url("assets/vendor/simple-datatables/simple-datatables.js")?>></script>
  <script src=<?=base_url("assets/vendor/tinymce/tinymce.min.js")?>></script>

</body>
</html>

<div class="modal fade" id="basicModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Nouvelle dépense</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="MyForm" action="<?=base_url('depense/save_depense')?>" enctype='multipart/form-data' method='POST'>
          <input type="hidden" name="ID_DEPENSE" id="ID_DEPENSE">
          <div class="row">
            <div class="col-md-12">
              <label>Description<font color="red">*</font></label>
              <select name="ID_TYPE_DEPENSE" id="ID_TYPE_DEPENSE" class="form-control">
                <option value="">Sélectionner un type de dépense</option>
                <?php foreach($types as $type): ?>
                  <option value="<?= $type->ID_TYPE_DEPENSE ?>"><?= $type->DESC_TYPE_DEPENSE ?></option>
                <?php endforeach; ?>
              </select>
              <font id="error_DESC_DEPENSE" color="red"></font>
              <br>            
            </div>
            <div class="col-md-12">
              <label>Montant<font color="red">*</font></label>
              <input type="number" name="MONTANT" id="MONTANT" class="form-control">
              <font id="error_MONTANT" color="red"></font>
              <br>              
            </div>
            <div class="col-md-12">
              <label>Date de dépense<font color="red">*</font></label>
              <input type="date" name="DATE_DEPENSE" id="DATE_DEPENSE" class="form-control">
              <font id="error_DATE_DEPENSE" color="red"></font>
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

 <script type="text/javascript">
  $(document).ready(function() {
    $('#mytable').DataTable({
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

  function openAddModal()
  {
    $('#MyForm')[0].reset();
    $('#ID_DEPENSE').val("");
    $('#button2').attr("hidden",true);
    $('#button1').attr("hidden",false);
    $('.modal-title').text("Nouvelle dépense");
    $('#basicModal').modal("show");
  }

  function save()
  {
    var ID_TYPE_DEPENSE = $('#ID_TYPE_DEPENSE').val();
    var MONTANT = $('#MONTANT').val();
    var DATE_DEPENSE = $('#DATE_DEPENSE').val();

    $('#error_DESC_DEPENSE, #error_MONTANT, #error_DATE_DEPENSE').text("");

    if(ID_TYPE_DEPENSE == ""){
      $('#error_DESC_DEPENSE').text("Veuillez sélectionner un type de dépense");
      return;
    }

    if(MONTANT == ""){
      $('#error_MONTANT').text("Veuillez entrer un montant");
      return;
    }

    if(DATE_DEPENSE == ""){
      $('#error_DATE_DEPENSE').text("Veuillez sélectionner une date");
      return;
    }

    $.ajax({
      url: $('#MyForm').attr("action"),
      method: "POST",
      data: {
        ID_TYPE_DEPENSE: ID_TYPE_DEPENSE,
        MONTANT: MONTANT,
        DATE_DEPENSE: DATE_DEPENSE
      },
      dataType: "json",
      success: function(response){
        if(response.status){
          location.reload();
        }
        else{
          alert(response.message);
        }
      }
    });
  }
</script>
<!-- End Line Chart -->