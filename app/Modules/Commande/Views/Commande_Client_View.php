<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>Commande</title>
  </head>
  <body>
    <?php echo view('sidebar_client.php');
    date_default_timezone_set("africa/Bujumbura");
    ?>
    <main id="main" class="main">

      <div class="pagetitle">
        Commande
        <div style="float:right;">
          <button onclick="window.location.href='<?=base_url('commande/liste_commandes_client')?>'" class="btn btn-outline-primary btn-sm">
            <i class="bi bi-list"></i> Mes commandes
          </button>
        </div>
      </div><!-- End Page Title -->

      <section class="section dashboard">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                <!-- <div hidden class="d-flex justify-content-center align-items-center mb-2 bg-light p-1 rounded-4 text-dark shadow-sm mt-2">
                  <h3 class="">Commande</h3>
                </div> -->
                <form id="form" class="row g-2 g-sm-3 mt-2">               
                  <fieldset class="border rounded-3 position-relative" style="padding: 0.25rem 0 0 0; height: 58px;">
                    <legend class="float-none w-auto px-2 fs-6 fw-bold text-primary ms-3 mb-0" style="font-size: 0.75rem !important;">Choisir le produit</legend>
                    <select id="produit" class="form-select border-0" name="produit" style="background: transparent; box-shadow: none; padding: 0 1rem; height: 32px; width: 100%; margin-top: -0.2rem;">
                      <option value="" selected disabled>---</option>
                    </select>
                    <span class="text-danger px-3" id="produit_error"></span>
                  </fieldset>

                  <fieldset class="border rounded-3 position-relative mt-3" style="padding: 0.25rem 0 0 0; height: 58px;">
                    <legend class="float-none w-auto px-2 fs-6 fw-bold text-primary ms-3 mb-0" style="font-size: 0.75rem !important;">Quantité</legend>
                    <input type="number" class="form-control border-0" id="qte" name="qte" placeholder="Ex: 10" inputmode="numeric" style="background: transparent; box-shadow: none; padding: 0 1rem; height: 32px; width: 100%; margin-top: -0.2rem;">
                    <span class="text-danger px-3" id="qte_error"></span>
                  </fieldset>
                </form>

                <div class="row g-2 mt-2">
                  <div class="col-6 col-sm-3">
                    <button onclick="addTocart()" class="btn btn-outline-success w-100">
                      <i class="bi bi-plus-lg"></i> Ajouter
                    </button>
                  </div>
                  <div class="col-6 col-sm-3">
                    <button onclick='if(confirm("Voulez-vous vraiment supprimer tous les éléments du panier ?")) { localStorage.clear(); get_liste(); }' class="btn btn-outline-danger w-100">
                      <i class="bi bi-trash"></i> Vider
                    </button>
                  </div>
                </div>

                <hr class="mt-3">

                <div class="table-responsive mt-3" id="cart_table_container" hidden="true">
                  <table class="table table-hover table-sm border-top w-100">
                    <thead class="table-dark">
                      <tr>
                        <th class="text-white">PRODUIT</th>
                        <th class="text-white text-center">QTE</th>
                        <th class="text-white text-end">PRIX</th>
                      </tr>
                    </thead>
                    <tbody id="cart_table_body">
                    </tbody>
                  </table>
                  <div class="row mt-2">
                    <div class="col-12 col-sm-6 offset-sm-6">
                      <button class="btn btn-primary w-100" onclick="save()">
                        <i class="bi bi-check2"></i> Valider
                      </button>
                    </div>
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
      get_product();
      get_liste()   
  });

  function get_product(idCategorie)
  {
      $.ajax({
          url: '/commande/get_product',
          method: 'GET',
          datatype: 'json',
          success: function(response){
              let res=JSON.parse(response);
              if(res.status === true){
                  $('#produit').html(res.html);
              }
          },
          error: function(){
              alert("Une erreur est survenue lors du chargement des produits.");
          }
      });
  }

  function addTocart() {
    
    var produit = JSON.parse($('#produit').val());
    var produit_id = produit.id;
    var pv = produit.pv;
    var nom = produit.nom;
    var qte = parseInt($('#qte').val()) || 0;
    var qte_dispo = produit.qte_dispo || 0;
    
    $('#produit_error, #qte_error').text('');
    
    if (!produit_id) {
        $('#produit_error').text('Veuillez choisir un produit');
        return;
    }
    if (qte <= 0) {
        $('#qte_error').text('Veuillez entrer une quantité valide');
        return;
    }
    if (qte > qte_dispo) {
        $('#qte_error').text('Quantité en stock insuffisante (Stock: ' + qte_dispo + ')');
        return;
    }
    
    var cart = JSON.parse(localStorage.getItem('cart')) || [];

    var existingItemIndex = cart.findIndex(item => item.produit_id === produit_id);
    
    if (existingItemIndex !== -1) {
        // Produit existe déjà - Mettre à jour la quantité
        var newQte = cart[existingItemIndex].qte + qte;
        
        if (newQte > qte_dispo) {
            alert("Quantité en stock insuffisante ! Stock disponible: " + qte_dispo);
            return;
        }
        
        cart[existingItemIndex].qte = newQte;
        cart[existingItemIndex].prix_achat = newQte * pv;
    } else {
        // Nouveau produit
        cart.push({
            produit_id: produit_id,
            nom: nom,
            qte: qte,
            prix_unitaire: pv,
            prix_achat: qte * pv
        });
    }

    localStorage.setItem('cart', JSON.stringify(cart));
    
    get_liste();
    // Réinitialiser le champ quantité
    $('#qte').val('');
  }

  function get_liste() {
    if (localStorage.getItem('cart')== null || JSON.parse(localStorage.getItem('cart')).length == 0) {
      $('#cart_table_container').attr('hidden', true);
      return
    } 
    $('#cart_table_container').attr('hidden', false);
    var cart = JSON.parse(localStorage.getItem('cart')) || [];
    var html = '';
    var prix_tot=0;
    cart.forEach(function(item, index) {
      html += '<tr>';
      html += '<td>' + item.nom + '</td>';
      html += '<td class="text-center">' + item.qte + '</td>';
      html += '<td class="text-end">' + Number(item.prix_achat).toLocaleString() + '</td>';
      html += '</tr>';
      prix_tot +=item.prix_achat;
    });
    html += '<tr class="table-active fw-bold"><td colspan="2" class="text-end">Total</td><td class="text-end">'+Number(prix_tot).toLocaleString()+'</td></tr>';
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
      url: '<?= base_url("commande/save_commande") ?>',
      method: 'POST',
      data: {cart: cart},
      datatype: 'json',
      success: function(response) {
        localStorage.removeItem('cart');
        get_liste();
        alert('Commande enregistrée avec succès');
      },
      error: function() {
        alert('Une erreur est survenue lors de l\'enregistrement de la commande');
      }
    });
  }
</script>