<!DOCTYPE html>
<html lang="en">
  <body>
  <?php echo view('sidebar.php');
  date_default_timezone_set("africa/Bujumbura");
  ?>
  <main id="main" class="main">

    <div class="pagetitle row">
      Achats
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-center align-items-center mb-2 bg-light p-2 rounded-4 text-dark shadow-sm mt-3">
                  <div class="card-title mb-0">
                    <h3>Liste des achats</h3>
                  </div>
                  <div class="ms-auto">
                    <Button class="btn btn-primary" onclick="window.location.href='<?=base_url('achat/achat-add')?>'"><i class="bi bi-plus"></i> Ajouter</Button>
                  </div>
                </div>
              </div>

                <div class="table-responsive p-3 mt-2 mb-2 rounded border">
                  <table id="mytable" class="table table-striped w-100">
                    <thead class="table-dark">
                      <tr>
                        <th>#</th>
                        <th class="text-white">PRODUIT</th>
                        <th class="text-white">QTE</th>
                        <th class="text-white">PRIX</th>
                        <th class="text-white">TOTAL</th>
                        <th class="text-white">DATE EXPIRATION</th>
                        <th class="text-white">DATE ENTRÉE</th>
                        <th class="text-white">ACTION</th>
                      </tr>
                    </thead>
                    <tbody class="table-light">
                      <?php 
                      $i = 1;
                      foreach($get_data as $item): ?>
                        <tr>
                          <td><?= $i++ ?></td>
                          <td><?= $item->DESC_PRODUIT ?></td>
                          <td><span class="badge bg-primary text-white"><?= $item->QTE ?></span></td>
                          <td><small class="text-primary">Achat : </small><?= number_format($item->PU_ACHAT, 2, ',', ' ') ?> Fbu<br> <small class="text-success">Vente : </small><?= number_format($item->PU_VENTE, 2, ',', ' ') ?> Fbu</td>
                          <td><?= number_format($item->PU_ACHAT * $item->QTE, 2, ',', ' ') ?> Fbu</td>
                          <td><i class="bi bi-calendar"></i> <?= date("d/m/Y", strtotime($item->DATE_EXPIRATION)) ?></td>
                          <td><i class="bi bi-calendar"></i> <?= date("d/m/Y", strtotime($item->DATE_INSERTION)) ?></td>
                          <td><button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button></td>
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
</script>
<!-- End Line Chart -->