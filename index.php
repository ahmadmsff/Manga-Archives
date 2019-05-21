<?php
session_start();
if(@$_SESSION['user'] != "logged") {
    header('Location: login.php');
} else {
    require_once('config/db.php');
    $email = $_SESSION['email'];
    $query = "SELECT * FROM users WHERE email='$email'";
    $sql = mysqli_query($connect, $query);
    if ($sql) {
        $data = mysqli_fetch_assoc($sql);
    }
    $page = @$_GET['page'];
    $act = @$_GET['act'];
    
    $content = "";
    $title = "";
    $content_header = "";
    $content_subheader = "";
    $breadcrumb = '';
    $activeHome = "";
    $activeManga = "";
    $activeTransaksi = "";
    $activeUkuran = "";
    $css = "";
    $js = "";

    if($page == "") {
      $content = "pages/home.php";
      $title = "Halaman Utama";
      $content_header = "Dashboard";
      $breadcrumb = '
      <li class="active"><i class="fas fa-home"></i><span class="icon">Home</span></li>';
      $activeHome = "active";
      $activeManga = "";
      $js='<script src="dist/this/home.js"></script>';
    } elseif($page == "manga") {
      $content = "pages/manga.php";
      $title = "Daftar Manga";
      $content_header = "Manga";
      $content_subheader = "Daftar Manga";
      $breadcrumb = '
      <li><a href="#"><i class="fas fa-home"></i><span class="icon">Home</span></a></li>
      <li class="active">manga</li>';
      $activeManga = "active";
      $css = '<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">';
      $js = '<script src="dist/SweetAlert/sweetalert2.min.js"></script>
      <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
      <script src="dist/this/manga.js"></script>';
    } elseif($page == "kategori") {
      $content = "pages/kategori/kategori.php";
      $title = "Management kategori";
      $content_header = "Kategori";
      $content_subheader = "Management Karang";
      $breadcrumb = '
      <li><a href="#"><i class="fas fa-home"></i><span class="icon">Home</span></a></li>
      <li class="active">Kategori</li>';
      $activekategori = "active";
      $css = '<link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
      <!-- Select2 -->
      <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />';
      $js = '<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
      <script src="dist/this/kategori.js"></script>';
    } else {
      $content = "pages/404.php";
      $title = "404 Page Not Found";
      $content_header = "404";
      $content_subheader = "Page not found";
      $breadcrumb = '
      <li><a href="#"><i class="fas fa-home"></i><span class="icon">Home</span></a></li>
      <li class="active">404</li>';
    }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $title ?> - MangaArchives</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap -->
  <link rel="stylesheet" href="dist/Bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="dist/FontAwesome/css/all.min.css">
  <?php echo $css; ?>
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/AdminLTE/css/AdminLTE.min.css">
  <link rel="stylesheet" href="dist/AdminLTE/css/skins/skin-blue.min.css">
  <!-- Style -->
  <link rel="stylesheet" href="dist/this/style.css">
  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <!-- Main Header -->
  <?php include('component/navbar.php'); ?>
  <!-- /.Main Header -->
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <?php include('component/sidebar.php'); ?>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo $content_header; ?>
        <small><?php echo $content_subheader; ?></small>
      </h1>
      <ol class="breadcrumb">
        <?php echo $breadcrumb; ?>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <?php include($content); ?>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2019 <a href="#">Achmad Musyaffa</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 3 -->
<script src="dist/jQuery/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="dist/Bootstrap/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/AdminLTE/js/adminlte.min.js"></script>
<?php echo $js; ?>
</body>
</html>
<?php
}
?>