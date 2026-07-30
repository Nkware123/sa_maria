<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>Commandes</title>
    <style>
      /* Réduction de l'espace entre les paragraphes */
      .card-text {
        margin-bottom: 0.25rem !important;
        padding: 0.1rem 0 !important;
      }
      .card-body hr {
        margin: 0.3rem 0 !important;
      }
      .card-title {
        margin-bottom: 0.4rem !important;
      }
      .card-body {
        padding: 0.8rem 1rem !important;
      }
    </style>
  </head>
  <body>
    <?php echo view('sidebar_client.php');
    date_default_timezone_set("africa/Bujumbura");
    ?>
    <main id="main" class="main">

      <div class="pagetitle">
        Liste des Commandes
        <div style="float:right;">
          <button onclick="window.location.href='<?=base_url('commande/client')?>'" class="btn btn-outline-primary btn-sm">
            <i class="bi bi-plus-lg"></i>
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
                <?php if(!empty($commandes)) { 
                  $u=1;
                  foreach($commandes as $commande) { 
                    $statut = $commande->STATUT;
                    if($statut == 1) {
                      $statut_text = "En attente";
                      $statut_class = "text-warning";
                    } 
                    elseif ($statut == 2) {
                      $statut_text = "Validée";
                      $statut_class = "text-success";
                    } else {
                      $statut_text = "Annulée";
                      $statut_class = "text-danger";
                    }
                    ?>
                    <div class="row g-1 mt-0">
                      <div class="col-12 col-sm-6 mt-0">
                        <div class="card border-success mt-0">
                          <div class="card-body mt-0">
                            <h5 class="text-primary">Commande -<?=$u++?>
                              <span style="float: right;font-size: 12px" class="<?=$statut_class?>"><?=$statut_text?></span>
                              <span style="float: right;font-size: 11px;margin-top: -7px;" class="text-muted"><?=date("d/m/Y H:i", strtotime($commande->DATE_DEMANDE))?></span>
                            </h5>
                            <hr>
                            <?php
                              $db = \Config\Database::connect();
                              $commandes_det = $db->query("SELECT * FROM commande_client_detail d JOIN commande_client c ON d.ID_COMMANDE=c.ID_COMMANDE JOIN produits p ON d.ID_PRODUIT=p.ID_PRODUIT WHERE d.ID_COMMANDE=".$commande->ID_COMMANDE."");
                              $commandes_det = $commandes_det->getResult();
                              foreach($commandes_det as $value) { ?>
                                <p class="card-text" style="margin-bottom: 0.15rem !important;"><span style="float: left;"><?=$value->DESC_PRODUIT?></span> <span style="margin-left: 20px;">*<?=$value->QTE_DEMANDE?></span> <span style="float: right;"><?=$value->PU*$value->QTE_DEMANDE?> FBU</span></p>
                              <?php } ?>
                              <hr>
                              <p class="card-text" style="margin-bottom: 0 !important;">Total: <span style="float: right;"><?=$commande->PT?> FBU</span></p>
                          </div>
                        </div>
                      </div>
                    </div>
                <?php } } else { ?>
                  <div class="row g-1 mt-1">
                    <div class="col-12 col-sm-12">
                      <div class="card border-danger">
                        <div class="card-body">
                          <h5 class="card-title text-danger">Aucune commande trouvée</h5>
                        </div>
                      </div>
                    </div>             
                  </div>
                <?php } ?>
                           
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
</script>