<!DOCTYPE html>
<html lang="en">
  <body>
  <?php echo view('sidebar.php');
  date_default_timezone_set("africa/Bujumbura");
  ?>
  <main id="main" class="main">

    <div class="pagetitle row">
      <h1>Dashboard</h1>
      <div class="col-md-2">
        <select name="filtre" class="form-control" id="filtre" onchange="filtrer()">
          <option value="1" <?= (isset($filtre) && $filtre == 1) ? 'selected' : '' ?>>Aujourd'hui</option>
          <option value="2" <?= (isset($filtre) && $filtre == 2) ? 'selected' : '' ?>>Ce mois</option>
          <option value="3" <?= (isset($filtre) && $filtre == 3) ? 'selected' : '' ?>>Cette année</option>
        </select>
      </div>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="row">

            <!-- Sales Card -->
            <div class="col-md-6">
              <div class="card info-card sales-card">
                <div class="card-body">
                  <h5 class="card-title">Demandes <a title="Voir plus" style="float: right;" href="<?=base_url()?>demande/liste">...</a></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-cart"></i>
                    </div>
                    <div class="ps-3">
                      <h6 style="float: right;"><?php echo count($data) ?></h6>
                      <!-- <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span> -->
                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Sales Card -->

            <!-- Revenue Card -->
            <div class="col-md-6">
              <div class="card info-card revenue-card">
                <div class="card-body">
                  <h5 class="card-title">Utilisateurs <a style="float: right;" title="Voir plus" href="<?=base_url()?>user_liste">...</a></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-person"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?=$employe?></h6>
                      <!-- <span class="text-success small pt-1 fw-bold">8%</span> <span class="text-muted small pt-2 ps-1">increase</span> -->

                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Revenue Card -->            

            <!-- Reports -->
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Demande par Agence</h5>

                  <!-- Line Chart -->
                  <div id="reportsChart" style="width:100%; height:400px;"></div>
                </div>

              </div>
            </div><!-- End Reports -->       

          </div>
        </div><!-- End Left side columns -->

        <!-- Right side columns -->
        <div class="col-lg-4">

          <!-- Recent Activity -->
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Demande récente</h5>

              <div class="activity">
                <?php 
                // Prendre seulement les 5 premiers éléments
                $limitedData = array_slice($data, 0, 2);
                foreach ($limitedData as $value) {
                  $heureInsertion = date('Y-m-d H:i', strtotime($value->DATE_INSERTION));
                  $heure_actuelle = date('Y-m-d H:i');
                  $diff = strtotime($heure_actuelle) - strtotime($heureInsertion);
                  
                  if ($diff < 60) {
                    $temps_relatif = floor($diff) . " sec";
                  } elseif ($diff < 3600) {
                    $temps_relatif = floor($diff / 60) . " min";
                  } elseif ($diff < 86400) {
                    $temps_relatif = floor($diff / 3600) . " h";
                  } else {
                    $temps_relatif = floor($diff / 86400) . " j";
                  }
                  ?>
                <div class="activity-item d-flex">
                  <div class="activite-label"><?php echo $temps_relatif; ?></div>
                  <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                  <div class="activity-content">
                    <?=$value->NOM_USER." ".$value->PRENOM_USER?> <a href="#" class="fw-bold text-dark"><?=$value->DESC_TYPE_CONGE?></a>
                  </div>
                </div><!-- End activity item-->
                <?php } ?>
                                

              </div>

            </div>

            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Demande par Type de congé</h5>

                  <!-- Line Chart -->
                  <div id="typeCongeChart" style="width:100%; height:370px;"></div>
                </div>

              </div>
            </div>
          </div><!-- End Recent Activity -->         

        </div><!-- End Right side columns -->

      </div>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>Mutec</span></strong>. All Rights Reserved
    </div>
  </footer><!-- End Footer --> 
   <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src=<?=base_url("assets/vendor/highcharts/highcharts.js")?>></script>
  <script src="<?=base_url() ?>assets/vendor/highcharts/modules/exporting.js"></script>
  <script src="<?=base_url() ?>assets/vendor/highcharts/modules/export-data.js"></script>
  <script src="<?=base_url() ?>assets/vendor/highcharts/modules/data.js"></script>

  <!-- <script src=<?=base_url("assets/vendor/apexcharts/apexcharts.min.js")?>></script>
  <script src=<?=base_url("assets/vendor/bootstrap/js/bootstrap.bundle.min.js")?>></script>
  <script src=<?=base_url("assets/vendor/chart.js/chart.umd.js")?>></script>
  <script src=<?=base_url("assets/vendor/echarts/echarts.min.js")?>></script>
  <script src=<?=base_url("assets/vendor/quill/quill.js")?>></script>
  <script src=<?=base_url("assets/vendor/simple-datatables/simple-datatables.js")?>></script>
  <script src=<?=base_url("assets/vendor/tinymce/tinymce.min.js")?>></script>
  <script src=<?=base_url("assets/vendor/php-email-form/validate.js")?>></script> -->



</body>

</html>

 <script type="text/javascript">
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
  function get_liste(value)
  {
    $.ajax({
      url:"<?=base_url()?>/dashbord/get_liste",
      type:"POST",
      dataType:"JSON",
      data:{value},
      success: function(data)
      {
        $("#my_modal").modal("show");
        $("#liste").html(data.html);
        $("#modal-title").text(data.agence);
      }
    });
  }

  function get_liste_by_type(value)
  {
    $.ajax({
      url:"<?=base_url()?>/dashbord/get_liste_by_type",
      type:"POST",
      dataType:"JSON",
      data:{value},
      success: function(data)
      {
        $("#my_modal").modal("show");
        $("#liste").html(data.html);
        $("#modal-title").text(data.type);
      }
    });
  }

  function filtrer() {
    var filtre = document.getElementById("filtre").value;
    var url = "";
    if (filtre == "1") {
      url = "<?=base_url('dashbord/dashbord?filtre=1')?>";
    } else if (filtre == "2") {
      url = "<?=base_url('dashbord/dashbord?filtre=2')?>";
    } else if (filtre == "3") {
      url = "<?=base_url('dashbord/dashbord?filtre=3')?>";
    }
    window.location.href = url;
  }
  var agences = <?=$data2?>;
  var demandes = <?=$data3?>;
  var total = <?=count($data)?>; 

  // Créer le graphique
  Highcharts.chart('reportsChart', {
    chart: {
      type: 'column'
    },
    title: {
      text: '<b></b>'
    },
    subtitle: {
      text: '<b>Total = ' + total + ' demande(s)</b>'
    },
    xAxis: {
      categories: agences,
      title: {
        text: 'Agences'
      },
      labels: {
        style: {
          fontSize: '12px',
          fontWeight: 'normal'
        }
      }
    },
    yAxis: {
      allowDecimals: false,
      min: 0,
      title: {
        text: 'Nombre de demandes'
      }
    },
    tooltip: {
      headerFormat: '<b>{point.key}</b><br/>',
      pointFormat: 'Demandes: {point.y}'
    },
    plotOptions: {
      column: {
        dataLabels: {
          enabled: true,
          format: '{y}',
          style: {
            fontSize: '11px',
            fontWeight: 'bold',
            color: '#333'
          }
        },
        showInLegend: false,
        borderRadius: 5,
        borderWidth: 0,
        point: {
          events: {
            click: function() {
              get_liste(this.category)
            }
          }
        }
      }
    },
    colors: [
      '#4154f1', '#2ecc71', '#e74c3c', '#f39c12', '#9b59b6'
    ],
    credits: {
      enabled: true,
      href: '',
      text: 'Mutec'
    },
    series: [{
      name: 'Demandes',
      colorByPoint: true,
      data: demandes
    }]
  });

  // Créer le graphique par type de congé
  var colors = ['#ea7a6e', '#e3ae58', '#d4a9e5','#4c99e2', '#77bb2f'];
  
  var type_conge = <?=$data5?>;
  var nbr_demande = <?=$data4?>;
  Highcharts.chart('typeCongeChart', {
    chart: {
      type: 'pie'
    },
    title: {
      text: '<b></b>'
    },
    subtitle: {
      text: '<b>Total = ' + total + ' demande(s)</b>'
    },
    tooltip: {
      pointFormat: '{series.name}: <b>{point.y}</b> ({point.percentage:.1f}%)'
    },
    plotOptions: {
      pie: {
        allowPointSelect: true,
        cursor: 'pointer',
        dataLabels: {
          enabled: true,
          format: '<b>{point.name}</b>: {point.y} ({point.percentage:.1f}%)',
          style: {
            fontSize: '11px',
            fontWeight: 'bold',
            color: '#333'
          }
        },
        showInLegend: true,
        borderWidth: 0
      },
      series: {
        point: {
          events: {
            click: function() {
              get_liste_by_type(this.name);
            }
          }
        }
      }
    },
    colors: colors,
    credits: {
      enabled: true,
      href: '',
      text: 'Mutec'
    },
    series: [{
      name: 'Demandes',
      colorByPoint: true,
      data: type_conge.map(function(type, index) {
        return { name: type, y: nbr_demande[index] };
      })
    }]
  });
</script>
<!-- End Line Chart -->

<div class="modal fade" id="my_modal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Demades : <span id="modal-title" class="fw-bold"></span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="USER_ID_DEL" id="USER_ID_DEL">
        <div class="table-responsive container">
          <table id="myTable" class="table table-striped">
            <thead class="table-light">
              <tr>
                <th>#</th>
                <th class="text-uppercase">Nom</th>
                <th class="text-uppercase">Type&nbsp;de&nbsp;congé</th>
                <th class="text-uppercase">Date&nbsp;debut</th>
                <th class="text-uppercase">Nombre&nbsp;de&nbsp;jours</th>
              </tr>
            </thead>
            <tbody id="liste">
            </tbody>
          </table>          
        </div> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>