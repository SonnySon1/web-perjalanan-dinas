<?php  
// jalankan session
  session_start();

    if(isset($_SESSION['login'])){

      if ($_SESSION['login'] === true) {
        header('location: index.php');
      }

  }

// membutuhkan file function
   require'functions.php';

  // cek jika user sudah input semua data jika sudah ambil semua data user
      if(isset($_POST['daftar'])){
        // jalankan function regiser dan dan masukan sekua data yang ada di dalam variable super gelobal $_POST
          if(register($_POST) > 0 ){
                echo'<script>
                    alert("Kamu BERHASIL Daftar");  
                    document.location.href = "login.php"; 
                  </script>';
          }else{
            echo mysqli_error($koneksi);
          }

      }


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PEDULI DIRI | Regiser</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
  <!-- favicon -->
  <link rel="shortcut icon" href="img/ficon.svg" type="image/x-icon">
  <style>img[alt*="www.000webhost.com"]{display:none}</style>
</head>
<body class="hold-transition register-page">
<div class="register-box">
    <div class="register-logo">
    <a href="../../index2.html"></a>
  </div>

  <div class="card">
    <div class="card-body register-card-body">
      <p class="login-box-msg">BUAT AKUN BARU</p>

      <form action="" method="post" enctype="multipart/form-data">
        <div class="input-group mb-3">
          <input name="nama" type="text" maxlength="9" class="form-control" placeholder="Masukan Nama Lengkap">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input name="nik" type="number" class="form-control" placeholder="Masukan Nik Anda">
          <div class="input-group-append">
            <div class="input-group-text">
              <!-- <span class="fas fa-lock"></span> -->
              <span class="fas fa-solid fa-address-card"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input name="gambar" type="file" maxlength="16" class="form">
          <div class="input-group-append">
          </div>
        </div>
        <div class="row">
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" name="daftar" class="btn btn-primary btn-block" style="background-color: #17A2B7;">DAFTAR</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <a href="login.php" class="text-center">Sudah Punya Akun klik disini</a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="assets/dist/js/adminlte.min.js"></script>
</body>
</html>
