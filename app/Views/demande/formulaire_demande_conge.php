<!DOCTYPE html>
<html lang="en">
<body>
<?php echo view('sidebar.php');?>

  <main id="main" class="main">

    <div class="pagetitle row">
      <div class="col-md-10">
        <h1>Demande</h1>
      </div>
      <div class="col-md-2">
        <a style="float: left;" href="<?=base_url('demande/liste')?>" class="btn btn-primary" ><i class="bi bi-person-plus-fill"></i>Retour</a>
      </div> 
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <div class="row mb-2 mt-2 bg-light rounded border">
                <h5 class="card-title text-center">Formulaire de demande de congé</h5>
              </div>
              <form id="MyForm" action="<?=base_url('demande/save_demande')?>" class="form-horizontal mt-3 border rounded mb-3 row" enctype='multipart/form-data' method='POST'>
                <div class="row mt-3">
                  <div class="col-md-6">
                    <label>Type de congé</label><font color="red">*</font>
                    <select name="ID_TYPE_CONGE" id="ID_TYPE_CONGE" class="form-control" onchange="get_jours_restants()">
                      <option value="">Sélectionner</option>
                      <?php
                        foreach ($type_conge as $key)
                        {
                          echo '<option value='.$key->ID_TYPE_CONGE.'>'.$key->DESC_TYPE_CONGE.'</option>';
                        }
                      ?>
                    </select>
                    <font id="error_ID_TYPE_CONGE" color="red"></font>
                    <br>
                  </div>
                  <div class="col-md-3">
                    <label>Jours restants <span style="color: #88ed6c;" id="total_jours"></span"></label>
                    <input type="text" class="form-control" id="jours_restants" readonly>
                    <br>
                  </div>

                  <div class="col-md-3">
                    <label>Jours déjà pris</label>
                    <input type="text" class="form-control" id="jours_pris" readonly>
                    <br>
                  </div>

                  <div class="col-md-6">
                    <label>Motif</label>
                    <input type="text" name="MOTIF" id="MOTIF" class="form-control">
                    <br>
                  </div>
                  <div class="col-md-6">
                    <label>Date début</label><font color="red">*</font>
                    <input type="Date" min="<?=date('Y-m-d')?>" name="DATE_DEBUT" id="DATE_DEBUT" class="form-control" onchange="get_date()">
                    <font id="error_DATE_DEBUT" color="red"></font>
                    <br>
                  </div>
                  <div class="col-md-6">
                    <label>Date fin</label><font color="red">*</font>
                    <input type="Date" min="<?=date('Y-m-d')?>" name="DATE_FIN" id="DATE_FIN" class="form-control" onchange="get_date()">
                    <font id="error_DATE_FIN" color="red"></font>
                    <br>
                  </div>

                  <div class="col-md-6">
                    <label>Nombre de jours</label>
                    <input type="text" id="NB_JOURS" class="form-control" name="NOMBRE_JOURS_DEMANDE" readonly>
                    <br>
                  </div>
                </div>
              </form>
              <button style="float:right;" id="btnsave" class="btn btn-primary" onclick="save()">Enregistrer</button>             
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
  <script src="assets/js/main.js"></script>
</body>
</html>
<script>
  function get_jours_restants()
  {
    var ID_TYPE_CONGE = $('#ID_TYPE_CONGE').val();
      $.ajax({
          url: "<?=base_url('demande/get_jours_restants')?>",
          method: "POST",
          data: { ID_TYPE_CONGE: ID_TYPE_CONGE },
          success: function(data) {
            data = JSON.parse(data);
            $('#jours_restants').val(data.jours_restants);
            $('#total_jours').text(data.total ? ' / ' + data.total : '');
            $('#jours_pris').val(data.jours_pris);
            if($('#DATE_DEBUT').val() && data.jours_restants>0) {
              get_date();
            }
          }
      });
  }
  function get_date() {
    if($('#DATE_DEBUT').val() && $('#DATE_FIN').val()) {
        var start = new Date($('#DATE_DEBUT').val());
        var end = new Date($('#DATE_FIN').val());
        var diffTime = Math.abs(end - start);
        var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
        $('#NB_JOURS').val(diffDays);
    }

    if($('#DATE_DEBUT').val() && !$('#DATE_FIN').val() && $('#jours_restants').val()>0) {
      let dateDebut = $('#DATE_DEBUT').val();
      let joursRestants = parseInt($('#jours_restants').val());
      let dateMax = new Date(dateDebut);
      dateMax.setDate(dateMax.getDate() + joursRestants - 1);
      
      // Formater la date max en YYYY-MM-DD pour l'attribut max
      let annee = dateMax.getFullYear();
      let mois = String(dateMax.getMonth() + 1).padStart(2, '0');
      let jour = String(dateMax.getDate()).padStart(2, '0');
      let dateMaxStr = `${annee}-${mois}-${jour}`;
      $('#DATE_FIN').attr('max', dateMaxStr);
    }
    else {
      $('#DATE_FIN').removeAttr('max');
    }
  };

  function save()
  {
    var statut = 1;
    $('#error_DATE_FIN').text('')
    $('#error_ID_TYPE_CONGE').text('')
    $('#error_DATE_DEBUT').text('')
    if($('#DATE_FIN').val()=='')
    {
      statut = 2;
      $('#error_DATE_FIN').text('Ce champ est obligatoire')
    }

    if($('#DATE_DEBUT').val() && $('#DATE_FIN').val()) {
      if($('#DATE_FIN').val() < $('#DATE_DEBUT').val()) {
          statut = 2;
          $('#error_DATE_FIN').text('La date de fin doit être postérieure à la date de début');
      }
    }

    if($('#ID_TYPE_CONGE').val()=='')
    {
      statut = 2;
      $('#error_ID_TYPE_CONGE').text('Ce champ est obligatoire')
    }

    if($('#DATE_DEBUT').val()=='')
    {
      statut = 2;
      $('#error_DATE_DEBUT').text('Ce champ est obligatoire')
    }

    if(statut == 1)
    {
      $('#MyForm').submit();
    }
  }
</script>