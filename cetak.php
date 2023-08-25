<?php  
// jalnkan session
    session_start();

// Include autoloader 
require_once 'vendor/autoload.php'; 


// membutuhkan file finctions.php untuk mengambil koneksi dan melakukan query
    require'functions.php';
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




// Reference the Dompdf namespace 
use Dompdf\Dompdf; 
 
// Instantiate class untuk menggunakan semua calss yang ada di dompdf 
$dompdf = new Dompdf();

// html string untuk mencetak
$html = '   <h4>Data Perjalanan</h4>
            <hr><br> 
            <table width="100%" border="1" cellpadding="8" cellspacing="0">
            <thead>
            <tr>
                <td><b>No</b></td>
                <td><b>Tanggal</b></td>
                <td><b>Jam</b></td>
                <td><b>Lokasi Berkunjung</b></td>
                <td><b>Suhu</b></td>
            </tr>
            </thead>';
            $i = 1;
            foreach($data as $riwayat){ 
$html .= '  <tbody>
                <tr>
                    <td>'.$i++.'</td>
                    <td>'.$riwayat['tanggal'].'</td>
                    <td>'.$riwayat['jam'].'</td>
                    <td>'.$riwayat['lokasi'].'</td>
                    <td>'.$riwayat['suhu'].'°C</td>
                </tr>
            </tbody';    
            }
$html .= '</table>';

// cetak 
$dompdf->loadHtml($html);  

// Render the HTML as PDF 
$dompdf->render(); 
 
// Output the generated PDF (1 = download and 0 = preview) 
$dompdf->stream("data-perjalanan", array("Attachment" => 0));




