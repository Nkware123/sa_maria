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
                    <h5 class="card-title mb-0">Ajouter un achat</h5>
                </div>
              <form id="form" class="row g-3">
                <div class="col-md-4">
                  <label for="inputState" class="form-label">Fournisseur</label>
                  <select id="inputState" class="form-select" name="fournisseur" >
                    <option value="" selected disabled>Choisir le fournisseur</option>
                    <?php foreach($fournisseurs as $key): ?>
                      <option value="<?=$key->ID_FOURNISSEUR?>"><?=$key->NOM_FOURNISSEUR?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="col-md-4">
                  <label for="produit" class="form-label">Produit</label>
                  <select id="produit" class="form-select" name="produit"  onchange="updateQteBouteille()">
                    <option value="" selected disabled>Choisir le produit</option>
                    <?php foreach($produits as $key): ?>
                      <option value='<?= json_encode(['id' => $key->ID_PRODUIT, 'nbr_bouteilles' => $key->NBR_BOUTEILLE_PAR_CASIER]) ?>'><?=$key->DESC_PRODUIT?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="col-md-4">
                  <label for="inputEmail4" class="form-label">Date d'expiration <font color="orange">(Par défaut : 6 mois dès aujourd'hui)</font></label>
                  <?php $date = date('m')+6; ?>
                  <input type="date" value="<?= date('Y-'.($date).'-d') ?>" class="form-control" id="inputEmail4" name="date_expiration" >
                </div>
                <div class="col-md-2">
                  <label for="qte_casiers" class="form-label">Nombre de casiers</label>
                  <input type="number" class="form-control" id="qte_casiers" name="qte_casiers" oninput="updateQteBouteille()" >
                </div>

                <div class="col-md-2">
                  <label for="prix_achat" class="form-label">Prix d'achat/bouteille</label>
                  <input type="number" class="form-control" id="prix_achat" name="prix_achat" oninput="updatePt()">
                </div>

                <div class="col-md-2">
                  <label for="prix_vente" class="form-label">Prix de vente/bouteille</label>
                  <input type="number" class="form-control" id="prix_vente" name="prix_vente" oninput="updatePt()">
                </div>

                <div class="col-md-2">
                  <label for="qte_bouteilles" class="form-label">Nombre de bouteilles</label>
                  <input type="number" class="form-control" id="qte_bouteilles" name="qte_bouteilles" readonly value="" >
                </div>

                <div class="col-md-2">
                  <label for="pt_achat" class="form-label">PT-Achat</label>
                  <input type="number" class="form-control" id="pt_achat" name="pt_achat" readonly value="" >
                </div>

                <div class="col-md-2">
                  <label for="pt_vente" class="form-label">PT-Vente</label>
                  <input type="number" class="form-control" id="pt_vente" name="pt_vente" readonly value="" >
                </div>

                <div class="col-12 d-flex justify-content-end">
                    <button onclick="" class="btn btn-outline-success">
                        <i class="bi bi-plus-lg"></i>
                    </button>
                </div>

              </form>
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
    
  });

  function updateQteBouteille() {
    if ($('#produit').val()!='' && $('#qte_casiers').val()!='') {
      var selectedOption = $('#produit').val();
      var data = JSON.parse(selectedOption);
      var nbr_bouteilles = data.nbr_bouteilles;
      var qte_casiers = $('#qte_casiers').val();
      var qte_bouteilles = nbr_bouteilles * qte_casiers;
      $('#qte_bouteilles').val(qte_bouteilles);        
    }
  }

  function updatePt() {
    var prix_achat = $('#prix_achat').val();
    var prix_vente = $('#prix_vente').val();
    var qte_bouteilles = $('#qte_bouteilles').val();
    if(prix_achat != '' && qte_bouteilles != ''){
      $('#pt_achat').val((prix_achat * qte_bouteilles));
    }
    if(prix_vente != '' && qte_bouteilles != ''){
      $('#pt_vente').val((prix_vente * qte_bouteilles));
    }
  }
  
</script>
<!-- End Line Chart -->