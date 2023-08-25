<?php  
// jalankan session
  session_start();

// membutuhkan function.php untuk mengambil function query dan koneksi
    require'../functions.php';

    
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
  
  
  
  // tangkap value get dari ajax yang dikirmkan melalui url
  $keyword = $_GET['keyword'];

  $query = "SELECT * FROM catatan
            WHERE 
            lokasi LIKE '%$keyword%' AND id_user = '$row'
            ";
    $data = query($query);

?>


            
              <!-- /.card-header -->
              
                <thead>
                <table id="scr" id="example2" class="table table-bordered table-hover">
                  <tr style="background-color: #eaeaea;">
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>Lookasi Berkunjung</th>
                    <th>Suhu</th>
                    <th>Edit</th>
                    <th>Delete</th>
                  </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Lookasi Berkunjung</th>
                        <th>Suhu</th>
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
                      <td><?= $riwayat['suhu']; ?>&deg</td>
                      <td>
                        <a href="edit.php?ede-t=<?= $riwayat['id_catatan'];?>" ">
                            <img src="img/penn.svg" alt="icon-edit" width="15px" style="cursor:pointer;">
                        </a>
                      </td>
                      <td>
                        <a href="hapus.php?ell-us=<?= $riwayat['id_catatan'];?>" onclick="return confirm('Apakah kamu yakin ingin menghapus catatan ini?') ">
                            <img src="img/trash.svg" alt="icon-delete" width="15px" style="cursor:pointer;">
                        </a>
                      </td>
                    </tr>
                  </tbody>
                <?php endforeach; ?>
                </table>
      
                  <!-- /.card-body -->



