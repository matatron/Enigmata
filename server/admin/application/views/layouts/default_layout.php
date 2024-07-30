<!DOCTYPE html>
<html lang="en" ng-app="ArcangularApp">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title><?php echo $title; ?></title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="<?php echo base_url(); ?>public/img/favicon.png" rel="icon">
  <link href="<?php echo base_url(); ?>public/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="<?php echo base_url(); ?>public/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>public/vendor/bootstrap/css/bootstrap-grid.min.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>public/vendor/bootstrap/css/bootstrap-utilities.min.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>public/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>public/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>public/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>public/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>public/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>public/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="<?php echo base_url(); ?>public/css/style.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>public/css/arcana.css" rel="stylesheet">


  <script src="<?php echo base_url(); ?>public/js/angular.min.js"></script>
  <script src="<?php echo base_url(); ?>public/js/arcangular.js"></script>

  <!-- =======================================================
  * Template Name: NiceAdmin - v2.5.0
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="/home/" class="logo d-flex align-items-center">
        <img src="<?php echo base_url(); ?>public/img/logo.png" alt="">
        <span class="d-none d-lg-block chancery">Arcana</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->


    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item dropdown">

          <!-- Notidicaciones -->
        </li><!-- End Notification Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link collapsed" href="<?php echo base_url(); ?>">
          <i class="bi bi-grid"></i>
          <span>Inicio</span>
        </a>
      </li><!-- End Dashboard Nav -->


    </ul>

  </aside><!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1><?php echo $title; ?></h1>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <!-- PAGE CONTENT BEGINS -->
        <?php echo $content; ?>
        <!-- PAGE CONTENT ENDS -->
      </div>
    </section>

  </main><!-- End #main -->

  <!-- Vendor JS Files -->
  <script src="<?php echo base_url(); ?>public/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="<?php echo base_url(); ?>public/vendor/bootstrap/js/popper.min.js"></script>
  <script src="<?php echo base_url(); ?>public/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo base_url(); ?>public/vendor/chart.js/chart.umd.js"></script>
  <script src="<?php echo base_url(); ?>public/vendor/echarts/echarts.min.js"></script>
  <script src="<?php echo base_url(); ?>public/vendor/quill/quill.min.js"></script>
  <script src="<?php echo base_url(); ?>public/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="<?php echo base_url(); ?>public/vendor/tinymce/tinymce.min.js"></script>
  <script src="<?php echo base_url(); ?>public/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="<?php echo base_url(); ?>public/js/main.js"></script>

</body>

</html>