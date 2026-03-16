<!DOCTYPE html>
<html lang="en">
<?php echo view('sidebar.php');?>

<body>
  <main id="main" class="main">
<!-- 
    <div class="pagetitle">
      <h1>Profile</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Users</li>
          <li class="breadcrumb-item active">Profile</li>
        </ol>
      </nav>
    </div><!-- End Page Title --> 

    <section class="section profile">
      <div class="row">
        <div class="col-xl-4">

          <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

              <img src="<?=base_url($donnees->PHOTO_PROFIL)?>" alt="Profile" class="rounded-circle">
              <h2><?=$donnees->NOM_USER?></h2>
              <h3><?=$donnees->DESC_FONCTION?></h3>
            </div>
          </div>

        </div>

        <div class="col-xl-8">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Information Personnelle</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Modifier le mot de passe</button>
                </li>

              </ul>
              <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                  <h5 class="card-title">Details du profil</h5>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Nom et Prénom</div>
                    <div class="col-lg-9 col-md-8"><?=$donnees->NOM_USER.' '.$donnees->PRENOM_USER?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Profil</div>
                    <div class="col-lg-9 col-md-8"><?=$donnees->DESC_FONCTION?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Tel</div>
                    <div class="col-lg-9 col-md-8"><?=$donnees->TELEPHONE?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Lieu d'affectation</div>
                    <div class="col-lg-9 col-md-8"><?=$donnees->DESC_AGENCE?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Nom d'utilisateur</div>
                    <div class="col-lg-9 col-md-8"><?=$donnees->USERNAME?></div>
                  </div>
                </div>

                <div class="tab-pane fade pt-3" id="profile-change-password">
                  <!-- Change Password Form -->
                  <form id="MyForm" action="<?=base_url('users/update_pwd')?>" enctype='multipart/form-data' method='POST'>
                    <input type="hidden" name="USER_ID" id="USER_ID" value="<?=$donnees->USER_ID?>">
                    <input type="hidden" name="pwdact" id="pwdact" value="<?=$donnees->PASSWORD?>">
                    <div class="row mb-3">
                      <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Mot de passe actuel</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="password" type="password" class="form-control" id="currentPassword">
                        <font id="error_currentPassword" color="red"></font>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">Nouveau mot de passe</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="newpassword" type="password" class="form-control" id="newPassword">
                        <font id="error_newPassword" color="red"></font>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Comfirmer le mot de passe</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="renewpassword" type="password" class="form-control" id="renewPassword">
                        <font id="error_renewPassword" color="red"></font>
                      </div>
                    </div>
                    
                  </form>
                  <div class="text-center">
                      <button onclick="save()" class="btn btn-primary">Modifier</button>
                    </div><!-- End Change Password Form -->

                </div>

              </div><!-- End Bordered Tabs -->

            </div>
          </div>

        </div>
      </div>
    </section>

  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>
<script>
  function save()
  {
    var currentPassword=$('#currentPassword').val()
    var newPassword=$('#newPassword').val()
    var renewPassword=$('#renewPassword').val()
    var pwdact=$('#pwdact').val()

    $('#error_currentPassword,#error_newPassword,#error_renewPassword').html('')
    var statut=1;
    if(currentPassword=='')
    {
      $('#error_currentPassword').html('Ce champ est obligatoire');
      statut=2      
    }
    if(newPassword=='')
    {
      $('#error_newPassword').html('Ce champ est obligatoire');
      statut=2
    }
    if(renewPassword=='')
    {
      $('#error_renewPassword').html('Ce champ est obligatoire');
      statut=2
    }

    if(pwdact!=currentPassword && pwdact!='' && currentPassword!='')
    {
      $('#error_currentPassword').html('Encien mot de passe incorrect');
      statut=2
    }

    if(newPassword==currentPassword && newPassword!='' && currentPassword!='')
    {
      $('#error_newPassword').html('Encien mot de passe semblable au nouveau');
      statut=2
    }

    if(newPassword!=renewPassword && newPassword!='' && renewPassword!='')
    {
      $('#error_renewPassword').html('Mot de passe de comfirmation doit être semblable au nouveau');
      statut=2
    }

    if (statut==1)
    {
      $('#MyForm').submit();
    }   
  }
</script>