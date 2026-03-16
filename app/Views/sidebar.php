<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>MUTEC sa</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="<?=base_url()?>assets/img/favicon.png" rel="icon">
  <link href="<?=base_url()?>assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <link href="<?=base_url()?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?=base_url()?>assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="<?=base_url()?>assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="<?=base_url()?>assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="<?=base_url()?>assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="<?=base_url()?>assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="<?=base_url()?>assets/vendor/simple-datatables/style.css" rel="stylesheet">
  <link rel="stylesheet" href="<?=base_url()?>assets/css/jquery.dataTables.min.css">

  <!-- Template Main CSS File -->
  <link href="<?=base_url()?>assets/css/style.css" rel="stylesheet">
</head>
<!-- ======= Sidebar ======= -->
<?php echo view('header.php')?>
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link <?php if($menu != 'dashbord' ) echo 'collapsed' ?>" href="<?=base_url('dashbord/dashbord')?>">
          <i class="bi bi-grid"></i>
          <span>Tableau de bord</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">
        <a class="nav-link <?php if($menu != 'user_liste' ) echo 'collapsed' ?>" href="<?=base_url('user_liste')?>">
          <i class="bi bi-person"></i><span>Utilisateur</span>
        </a>
      </li>
      <!-- End users Nav -->

      <li class="nav-item">
        <a class="nav-link <?php if($menu != 'type_conge' ) echo 'collapsed' ?>" href="<?=base_url('type_conge')?>">
          <i class="bi bi-menu-button-wide"></i><span>Type de congé</span>
        </a>
      </li>
      <!-- End type conge Nav -->

      <li class="nav-item">
        <a class="nav-link <?php if($menu != 'demande' ) echo 'collapsed' ?>" href="<?=base_url('demande/liste')?>">
          <i class="bi bi-pencil-fill"></i><span>Demande</span>
        </a>
      </li>
      <!-- End users Nav -->

      <li class="nav-item">
        <a class="nav-link <?php if($menu != 'branche' ) echo 'collapsed' ?>" href="<?=base_url('branche')?>">
          <i class="bi bi-house"></i><span>Agences</span>
        </a>
      </li>
      <!-- End users Nav -->

      <li class="nav-item">
        <a class="nav-link <?php if($menu != 'Calender_Conge' ) echo 'collapsed' ?>" href="<?=base_url('Calender_Conge')?>">
          <i class="bi bi-calendar"></i><span>Calendrier des congés</span>
        </a>
      </li>
    </ul>

  </aside><!-- End Sidebar-->
  <!-- Vendor JS Files -->
  <script src="<?=base_url()?>assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="<?=base_url()?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?=base_url()?>assets/vendor/chart.js/chart.umd.js"></script>
  <script src="<?=base_url()?>assets/vendor/echarts/echarts.min.js"></script>
  <script src="<?=base_url()?>assets/vendor/quill/quill.js"></script>
  <script src="<?=base_url()?>assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="<?=base_url()?>assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="<?=base_url()?>assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="<?=base_url()?>assets/js/main.js"></script>
  <script src="<?=base_url()?>assets/js/jquery.min.js"></script>
  <script src="<?=base_url()?>assets/js/jquery.dataTables.min.js"></script>