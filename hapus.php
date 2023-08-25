<?php  
// ambil file functions
    require'functions.php';

// ambil id dari GET
    $id =  $_GET['ell-us'];


    mysqli_query($koneksi, "DELETE FROM catatan  WHERE id_catatan  = '$id'");
    header('location: riwayat.php');


?>