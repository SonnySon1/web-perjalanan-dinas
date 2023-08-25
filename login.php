<?php  
// jelankan session
  session_start();
  
  // membutuhkan file function untuk koneksi database
  require'functions.php';

// batalkan user mengakses halaman home lewat URL jika sudah login
  if (isset($_COOKIE['us_di'])  && isset($_COOKIE['su_n'])  ) {
    
    // ambil value dari maing masing cookie
         $id = $_COOKIE['us_di'];
        $username = $_COOKIE['su_n'];

      // query data dari database apakah ada cookie dengan value dari masing masing 
          $ress = query("SELECT * FROM users WHERE id_user ='$id' ")[0];


          if ($username === hash('sha256', $ress['username'])) {

            $_SESSION['login']=true;
          
          }
    
  }
  if(isset($_SESSION['login'])){

      if ($_SESSION['login'] === true) {
        header('location: index.php');
      }

  }
  
  
  
  // cek apakah user menekan tombol masuk atau tidak jika di tekan maka jalankan function login
  if (isset($_POST['masuk'])) {
    // tangkap nik untuk query
      $nama = htmlspecialchars($_POST['nama']);
  
    // query untuk mengambil data user yang akan di gunakan untuk  Remember Me
    $data = mysqli_query($koneksi, "SELECT * FROM users WHERE username = '$nama' ");

    if (!$data) {
        echo'<script>
              alert("Akun ");  
              document.loaction.href="login.php";
          </script>';

    } 
    else{
      $baris_data = mysqli_fetch_assoc($data);
    // jalankan function login
            if(login($_POST) > 0){    
              // set session untuk login
                  $_SESSION['login'] = $_POST['nama'];

                // cek apakah user menekan tombol ingat saya atau tidak 
                  if (isset($_POST['ingatsaya'])) {

                    // set cookie login untuk mengingat nama user 
                       setcookie('name', $_POST['nama'], time()+(60*60*8760*1));

                    // set cookie login untuk Re Member Me
                        setcookie('us_di', $baris_data['id_user'], time()+(60*60*8760*1));
                        setcookie('su_n', hash('sha256', $baris_data['username']), time()+(60*60*8760*1));

                      
                    }
                   header('Location: index.php'); 
            }else{
              echo mysqli_error($koneksi);
            }

      }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PEDULI DIRI | Log in</title>

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
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">LOGIN APLIKASI</p>
      
      <form action="" method="post">
          <div class="input-group mb-3">
            <input name="nama" maxlength="9" type="text" class="form-control" placeholder="Masukan Nama Lengkap">
            <div class="input-group-append">
              <div class="input-group-text">
              <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
            <div class="input-group mb-3">
              <input name="nik"  type="number"  class="form-control" placeholder="Masukan Nik Anda" >
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-solid fa-address-card"></span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-8">
                <div class="icheck-primary">
                  <input name="ingatsaya" type="checkbox" id="remember">
                  <label for="remember">
                    Remember Me
                  </label>
                </div>
              </div>
              <!-- /.col -->
              <div class="col-4">
                <button name="masuk" type="submit" class="btn btn-primary btn-block">Masuk</button>
              </div>
              <!-- /.col -->
            </div>
      </form>

      <!-- /.social-auth-links -->
      <p class="mb-0">
        <a href="register.php" class="text-center">Belum Punya Akun Klik disini</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
</body>
</html>
