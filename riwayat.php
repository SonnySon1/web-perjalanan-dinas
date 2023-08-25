<?php  
// jalankan session
  session_start();

// jika user belum login batalkan akeses login lewat URL ke home 
        if (!isset($_SESSION['login'])) {
          header("Location: login.php");
      }

// panggil halaman functions.php
  require'functions.php';
  
  // query semua data untuk menampilkan data catatan 
  // $data = query("SELECT * FROM catatan");


  
    // cek apakah user menggunakan remember me atau tidak menggunakan remember me
    if(isset($_COOKIE['name'])){
      
      // jika menggunakan remember me maka query berdasarkan nama dari cookie
        $name1 = $_COOKIE['name'];
        $data1 = query("SELECT * FROM users WHERE username = '$name1' ")[0]; 
        $row = $data1['id_user']; 
        $data = query("SELECT * FROM catatan WHERE id_user = '$row' ");
    }
      // jika tidak maka query berdasarkan session yang di bernilai nama dan query berdasarkan nama nya 
    elseif(!isset($_COOKIE['name'])){
        $name2 =  $_SESSION['login'];
        $data2 = query("SELECT * FROM users WHERE username = '$name2' ")[0];
        $row = $data2['id_user']; 
        $data = query("SELECT * FROM catatan WHERE id_user = '$row' ");
      }    
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PEDULI DIRI | Riwayat Perjalanan</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">

  <!-- print -->
  <link rel="stylesheet"  href="css/print.css">
  <!-- Custom fonts for this template -->
  <link href="asset-seet/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"rel="stylesheet">
  <!-- favicon -->
  <link rel="shortcut icon" href="img/ficon.svg" type="image/x-icon">
  <style>img[alt*="www.000webhost.com"]{display:none}</style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Riwayat Perjalanan</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input id="keyword" class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>

      <!-- Messages Dropdown Menu -->
      
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="img/AdminLTELogo.png" alt="Peduli Diri Foto" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Aplikasi Peduli Diri</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <?php if(isset($_COOKIE['name'])) : ?>
            <img src="images/<?= $data1['profile']; ?>" class="img-circle elevation-2" style="min-height: 30px; min-width: 30px;" alt="User Image">
          <?php elseif(!isset($_COOKIE['name'])) : ?>
            <img src="images/<?= $data2['profile']; ?>" class="img-circle elevation-2" style="min-height: 30px; min-width: 30px;" alt="User Image">
          <?php endif; ?>
        </div>
        <div class="info">
        <?php if(isset($_COOKIE['name'])) : ?>
            <a href="#" class="d-block"><?= $_COOKIE['name']; ?></a>
          <?php elseif(!isset($_COOKIE['name'])) : ?>
          <a href="#" class="d-block"><?= $_SESSION['login']; ?></a>
          <?php endif; ?>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="index.php" class="nav-link">
              <i class="nav-icon fas fa-duotone fa-tv"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="tulisCatatan.php" class="nav-link">
              <i class=" nav-icon fas fa-duotone fa-marker"></i>
              <p>
                Tulis Catatan
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-duotone fa-clone"></i>
              <p>
                Riwayat Perjalanan
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="logout.php" class="nav-link" onclick="return confirm('Apakah kamu yakin ingin log-out?')">
              <i class=" nav-icon fas fa-duotone fa-power-off"></i>
              <p>
                Keluar
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Riwayat Perjalanan</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active"><a class="m-0 font-weight-bold color-dark" target="_blank" href="cetak.php">Cetak</a></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold ">Riwayat Data Perjalanan</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="scr" class="table table-bordered" id="dataTable"    cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Jam</th>
                                            <th>Lookasi Berkunjung</th>
                                            <th>Suhu</th>
                                            <th class="noprint">Edit</th>
                                            <th class="noprint">Delete</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Jam</th>
                                            <th>Lookasi Berkunjung</th>
                                            <th>Suhu Tubuh</th>
                                            <th class="noprint">Edit</th>
                                            <th class="noprint">Delete</th>
                                        </tr>
                                    </tfoot>
                                    <?php $i = 1 ?>
                                    <?php foreach($data as $riwayat) : ?>  
                                    <tbody>
                                        <tr>
                                          <td><?= $i++ ?></td>
                                          <td><?= $riwayat['tanggal']; ?></td>
                                          <td><?= $riwayat['jam']; ?></td>
                                          <td><?= $riwayat['lokasi']; ?></td>
                                          <td><?= $riwayat['suhu']; ?>&degC</td>
                                          <td class="noprint">
                                            <a href="edit.php?ede-t=<?= $riwayat['id_catatan'];?>" ">
                                                <img src="img/penn.svg" alt="icon-edit" width="15px" style="cursor:pointer;">
                                            </a>
                                          </td>
                                          <td class="noprint">
                                            <a href="hapus.php?ell-us=<?= $riwayat['id_catatan'];?>" onclick="return confirm('Apakah kamu yakin ingin menghapus catatan ini?') ">
                                                <img src="img/trash.svg" alt="icon-delete" width="15px" style="cursor:pointer;">
                                            </a>
                                          </td>
                                        </tr>
                                    </tbody>
                                    <?php endforeach; ?>
                                </table>
                            </div>
                        </div>
                    </div>
            <!-- /.card -->
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="assets/plugins/jquery/jquery.min.js"></script>
<!-- ajax -->
<script src="jquery/ajxe.js"></script>
<!-- Bootstrap 4 -->
<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->

<!-- AdminLTE App -->
<script src="assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<!-- Page specific script -->

<!-- -------------------------------------------------- -->

 <!-- Bootstrap core JavaScript-->
 <script src="asset-seet/vendor/jquery/jquery.min.js"></script>
 <script src="asset-seet/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
 
 <!-- Core plugin JavaScript-->
 <script src="asset-seet/vendor/jquery-easing/jquery.easing.min.js"></script>
 
 <!-- Custom scripts for all pages-->
 <script src="asset-seet/js/sb-admin-2.min.js"></script>
 
 <!-- Page level plugins -->
    <script src="asset-seet/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="asset-seet/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    
    <!-- Page level custom scripts -->
    <script src="asset-seet/js/demo/datatables-demo.js"></script>



</body>
</html>
