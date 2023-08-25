<?php  
// jalankan session
    session_start();
      // jika user belum login batalkan akeses login lewat URL ke home 
      if (!isset($_SESSION['login'])) {
        header("Location: login.php");
      }

// ambil file functions.php
    require 'functions.php';

// cek apakah tombol submit sudah di tekan atau belum
    if (isset($_POST['simpan'])) {

      // jalankan function tambah catatan serta kirimkan semua data user dan cek hasil dari affected rows 1 / 0
        if (tambahCatatan($_POST) > 0) {
          echo"<script>
                  alert('data BERHASIL disimpan');
              </script>";  
        }
        
        // jika gagal maa tampilkan letak error
        else{
          echo mysqli_error($koneksi);
        }

    }



// cek apakah user menggunakan remember me atau tidak menggunakan remember me
if(isset($_COOKIE['name'])){
  
  // jika menggunakan remember me maka query berdasarkan nama dari cookie
    $name1 = $_COOKIE['name'];
    $data1 = query("SELECT * FROM users WHERE username = '$name1' ")[0];  
    $row = $data1['id_user'];
}
  // jika tidak maka query berdasarkan session yang di bernilai nama dan query berdasarkan nama nya 
elseif(!isset($_COOKIE['name'])){
    $name2 =  $_SESSION['login'];
    $data2 = query("SELECT * FROM users WHERE username = '$name2' ")[0];
    $row = $data2['id_user']; 
}





?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PEDULI DIRI | Tulis Catatan</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
  <!-- favicon -->
  <link rel="shortcut icon" href="img/ficon.svg" type="image/x-icon">
  <style>img[alt*="www.000webhost.com"]{display:none}</style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#html" class="nav-link">Tulis Catatan</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
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
            <a href="#" class="nav-link">
              <i class=" nav-icon fas fa-duotone fa-marker"></i>
              <p>
                  Tulis Catatan
                </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="riwayat.php" class="nav-link">
              <i class="nav-icon fas fa-duotone fa-clone"></i>
              <p>
                Riwayat Perjalanan
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="logout.php" class="nav-link" onclick="return confirm('Apakah kamu yakin ingin log-out?')" >
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
            <h1>Isi Catatan Kamu</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- Default box -->
              <div class="card-body">
                <!-- ____________________________________________________________________ -->
                
                <!-- Input addon -->
                <div class="card card-info">
                  <div class="card-header">
                    <h3 class="card-title">Tulis Catatan</h3>
                  </div>
                    <form action="" method="post">
                      <input type="hidden" name="us_di" value="<?= $row ?>">
                      <div class="card-body">
                        <div class="input-group mb-3">
                          <!-- <div class="input-group-prepend">
                            <span class="input-group-text">Pilih Tanggal</span>
                          </div> -->
                          <input name="tanggal" type="date" class="form-control">
                        </div>
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <!-- <span class="input-group-text">Pilih Jam</span> -->
                          </div>
                          <input name="waktu" type="time" class="form-control">
                        </div>
                        <div class="input-group mb-3">
                          <!-- <div class="input-group-prepend">
                            <span class="input-group-text">Lokasi</span>
                          </div> -->
                          <input name="lokasi" type="txt" class="form-control" placeholder="Lokasi Berkunjung">
                        </div>
                        <div class="input-group mb-3">
                          <!-- <div class="input-group-prepend">
                            <span class="input-group-text">Suhu Tubuh</span>
                          </div> -->
                          <input name="suhu" type="text" class="form-control" placeholder="Suhu Tubuh">
                        </div>    
                        <!-- /input-group -->
                      </div>
                      <!-- /.card-body -->
                      </div>
                      <!-- /.card -->
                      <div class=" d-flex position-absolute" style="right:0; margin-right:20px;">
                      <div class=" m-2 ">
                          <button class=" bg-gradient-yellow border-0 p-1 " style="border-radius:5px;" type="reset">Kosongkan</button>
                      </div>
                      <div class=" m-2">
                          <button name="simpan" class=" bg-gradient-green border-0 p-1" type="submit" style="border-radius:5px;">Simpan</button>
                      </div>
                     </div>
                      <!-- /button submit -->
                   </form>
                     <!-- button subit -->
            <!-- ___________________________________________________________________ -->
              </div>
            <!-- /.card -->
          </div>
        </div>
      </div>
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
<!-- Bootstrap 4 -->
<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="assets/dist/js/demo.js"></script>

</body>
</html>
