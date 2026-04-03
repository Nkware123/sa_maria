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
                    <h3 class="card-title mb-0">Ajouter un achat</h3>
                </div>
              <form id="form" class="row g-3">
                <div class="col-md-4">
                  <label for="fournisseur" class="form-label">Fournisseur</label>
                  <select id="fournisseur" class="form-select" name="fournisseur" >
                    <option value="" selected disabled>Choisir le fournisseur</option>
                    <?php foreach($fournisseurs as $key): ?>
                      <option value="<?=$key->ID_FOURNISSEUR?>"><?=$key->NOM_FOURNISSEUR?></option>
                    <?php endforeach; ?>
                  </select>
                  <span class="text-danger" id="fournisseur_error"></span>
                </div>
                <div class="col-md-3">
                  <label for="produit" class="form-label">Produit</label>
                  <select id="produit" class="form-select" name="produit"  onchange="updateQteBouteille()">
                    <option value="" selected disabled>Choisir le produit</option>
                    <?php foreach($produits as $key): ?>
                      <option value='<?= json_encode(['id' => $key->ID_PRODUIT, 'nbr_bouteilles' => $key->NBR_BOUTEILLE_PAR_CASIER, 'nom' => $key->DESC_PRODUIT]) ?>'><?=$key->DESC_PRODUIT?></option>
                    <?php endforeach; ?>
                  </select>
                  <span class="text-danger" id="produit_error"></span>
                </div>
                <div class="col-md-3">
                  <label for="date_expiration" class="form-label">Expiration <font color="orange">(Par défaut : D'ici 6 mois)</font></label>
                  <?php $date = date('m')+6; ?>
                  <input type="date" value="<?= date('Y-'.($date).'-d') ?>" class="form-control" id="date_expiration" name="date_expiration" >
                  <span class="text-danger" id="date_expiration_error"></span>
                </div>
                <div class="col-md-2">
                  <label for="qte_casiers" class="form-label">Nombre de casiers</label>
                  <input type="number" class="form-control" id="qte_casiers" name="qte_casiers" oninput="updateQteBouteille()" >
                  <span class="text-danger" id="qte_casiers_error"></span>
                </div>

                <div class="col-md-2">
                  <label for="prix_achat_casier" class="form-label">Prix d'achat/casier</label>
                  <input type="number" class="form-control" id="prix_achat_casier" name="prix_achat_casier" oninput="updatePt()">
                  <span class="text-danger" id="prix_achat_casier_error"></span>
                </div>

                <div class="col-md-2">
                  <label for="prix_vente" class="form-label">Prix de vente/bouteille</label>
                  <input type="number" class="form-control" id="prix_vente" name="prix_vente" oninput="updatePt()">
                  <span class="text-danger" id="prix_vente_error"></span>
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
                  <label for="prix_achat" class="form-label">Prix d'achat/bouteille</label>
                  <input type="number" class="form-control" id="prix_achat" name="prix_achat" readonly value="">
                  <span class="text-danger" id="prix_achat_error"></span>
                </div>               

                <div class="col-md-2">
                  <label for="pt_vente" class="form-label">PT-Vente</label>
                  <input type="number" class="form-control" id="pt_vente" name="pt_vente" readonly value="" >
                </div>
              </form>

              <div class="col-12 d-flex p-2 justify-content-end">
                <button onclick="addTocart()" class="btn btn-outline-success">
                  <i class="bi bi-plus-lg"></i>
                </button>

                <button onclick='if(confirm("Voulez-vous vraiment supprimer tous les éléments du panier ?")) { localStorage.clear(); get_liste(); }' class="btn btn-outline-danger ms-2">
                  <i class="bi bi-trash"></i>
                </button>
              </div>

                <div class="table-responsive" id="cart_table_container" hidden="true">
                  <table id="" class="table table-hover border-top w-100">
                    <thead class="table-dark">
                      <tr>
                        <th class="text-white">PRODUIT</th>
                        <th class="text-white">QUANTITÉ</th>
                        <th class="text-white">PRIX ACHAT</th>
                        <th class="text-white">PRIX VENTE</th>
                        <th class="text-white">TOTAL</th>
                        <th class="text-white">DATE EXPIRATION</th>
                        <th class="text-white">ACTION</th>
                      </tr>
                    </thead>
                    <tbody id="cart_table_body">
                    </tbody>
                  </table>
                  <div class="d-flex justify-content-end align-items-center mb-2 bg-light p-2 rounded-4 text-dark shadow-sm mt-3">
                    <button class="btn btn-primary" onclick="save()"><i class="bi bi-check2"></i> Valider</button>
                  </div>
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
      get_liste();
  });

  function updateQteBouteille() {
    if ($('#produit').val()!='' && $('#qte_casiers').val()!='') {
      var selectedOption = $('#produit').val();
      var data = JSON.parse(selectedOption);
      var nbr_bouteilles = data.nbr_bouteilles;
      var qte_casiers = $('#qte_casiers').val();
      var qte_bouteilles = nbr_bouteilles * qte_casiers;
      $('#qte_bouteilles').val(qte_bouteilles); 
      updatePt();       
    }
  }

  function updatePt() {
    var prix_achat_casier = $('#prix_achat_casier').val();
    var prix_vente = $('#prix_vente').val();
    var qte_casiers = $('#qte_casiers').val();
    var qte_bouteilles = $('#qte_bouteilles').val();
    var pt_achat = $('#pt_achat').val();

    if(prix_achat_casier != '' && qte_casiers != ''){
      $('#pt_achat').val((prix_achat_casier * qte_casiers));
      $('#prix_achat').val((prix_achat_casier * qte_casiers / qte_bouteilles));
    }
    if(prix_vente != '' && qte_bouteilles != ''){
      $('#pt_vente').val((prix_vente * qte_bouteilles));
    }
  }

  function addTocart() {

    var fournisseur = $('#fournisseur').val();
    var produit = $('#produit').val();
    // alert(produit+" "+fournisseur);
    if(produit != '' && produit != null){
      var data = JSON.parse(produit);
      var produit_id = data.id;
      var produit_nom = data.nom;
    }
    var qte_casiers = $('#qte_casiers').val();
    var prix_achat_casier = $('#prix_achat_casier').val();
    var prix_vente = $('#prix_vente').val();
    var date_expiration = $('#date_expiration').val();
    var prix_achat = $('#prix_achat').val();

    $('#fournisseur_error, #produit_error, #date_expiration_error, #qte_casiers_error, #prix_achat_casier_error, #prix_vente_error').text('');

    if(fournisseur == '' || fournisseur == null){
      $('#fournisseur_error').text('Veuillez choisir un fournisseur');
      return;
    }
    if(produit_id == '' || produit_id == null){
      $('#produit_error').text('Veuillez choisir un produit');
      return;
    }
    if(qte_casiers == ''){
      $('#qte_casiers_error').text('Veuillez entrer une quantité');
      return;
    }
    if(prix_achat_casier == ''){
      $('#prix_achat_casier_error').text('Veuillez entrer un prix d\'achat');
      return;
    }
    if(prix_vente == ''){
      $('#prix_vente_error').text('Veuillez entrer un prix de vente');
      return;
    }
    if(date_expiration == ''){
      $('#date_expiration_error').text('Veuillez entrer une date d\'expiration');
      return;
    }

    //insertion du produit dans le panier avec localStorage
    var cart = JSON.parse(localStorage.getItem('cart')) || [];
    cart.push({
      produit_id: produit_id,
      produit_nom: produit_nom,      
      qte_casiers: qte_casiers,
      qte_bouteilles: $('#qte_bouteilles').val(),
      prix_achat: prix_achat_casier,
      prix_vente: prix_vente,
      date_expiration: date_expiration
    });
    

    localStorage.setItem('cart', JSON.stringify(cart));
    
    get_liste();
  }

  function get_liste() {
    if (localStorage.getItem('cart')== null || JSON.parse(localStorage.getItem('cart')).length == 0) {
      $('#cart_table_container').attr('hidden', true);
      return
    } 
    $('#cart_table_container').attr('hidden', false);
    var cart = JSON.parse(localStorage.getItem('cart')) || [];
    var html = '';
    cart.forEach(function(item, index) {
      html += '<tr>';
      html += '<td>' + item.produit_nom + '</td>';
      html += '<td>' + item.qte_casiers + '</td>';
      html += '<td>' + item.prix_achat + '</td>';
      html += '<td>' + item.prix_vente + '</td>';
      html += '<td>' + (item.qte_casiers * item.prix_achat) + '</td>';
      html += '<td>' + item.date_expiration + '</td>';
      html += '<td><button class="btn btn-danger" onclick="removeFromCart(' + index + ')"><i class="bi bi-trash"></i></button> <button class="btn btn-outline-primary" onclick="editFromCart(' + index + ')"><i class="bi bi-pen"></i></button></td>';
      html += '</tr>';
    });
    $('#cart_table_body').html(html);
  }  

  function removeFromCart(index) {
    var cart = JSON.parse(localStorage.getItem('cart')) || [];
    cart.splice(index, 1);
    localStorage.setItem('cart', JSON.stringify(cart));
    get_liste();
  }

  function save() {
    var cart = JSON.parse(localStorage.getItem('cart')) || [];
    if(cart.length == 0){
      alert('Le panier est vide');
      return;
    }
    $.ajax({
      url: '<?= base_url("achat/save_achat") ?>',
      method: 'POST',
      data: {cart: cart},
      datatype: 'json',
      success: function(response) {
        localStorage.removeItem('cart');
        get_liste();
        alert('Achat enregistré avec succès');
      },
      error: function() {
        alert('Une erreur est survenue lors de l\'enregistrement de l\'achat');
      }
    });
  }
</script>
<!-- End Line Chart -->