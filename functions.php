<?php  
// koneksi ke database
    $koneksi = mysqli_connect('localhost', 'root', '', 'perjalanan');


// function read data
    function query($query){
        // get koneksi 
            global $koneksi;

            // query berdasarkan nilai variable $query
                $result = mysqli_query($koneksi, $query);

                // buat fariable rows untuk menyimpan hasil query
                    $rows = [];

                    while($row = mysqli_fetch_assoc($result) ){
                        $rows[] = $row;
                    }

        return $rows;
    }
    
// functuoin resgister
    function register($data_users){
        // get gelobal $koneksi
            global $koneksi;

            // ambil semuda data user
                $nik =  $data_users['nik'];
                $nama = $data_users['nama'];    
                
                // mengecek apakah tidak ada data yang di input jika tidak gagalkan  
                if(empty($nik) || empty($nama)){
                    //  alert data tidak boleh kosong
                    echo"<script>
                    alert('Tolong isi semua DATA yang ada!');
                    </script>";
                    
                    // retrun nilai false untuk membatalka  login
                    return false;
                }  
                
                // cek jika karakter lebih dari 16 character maka batalkan login
                if (strlen($nik)  < 16) {
                    //  alert data tidak boleh lebih kecil dari 16 
                    echo"<script>
                        alert('Nik minimal 16 angka');
                    </script>";
                    
                    // retrun nilai false untuk membatalka  login
                    return false;
                }

                    // upload gambar untuk profile
                    $profile = gambarUpload();
                    if (!$profile) {
                        return false;
                    }
                
                        // cek apakah data user yang di masukan sudah ada pada database
                            $result = mysqli_query($koneksi, "SELECT * FROM users WHERE username = '$nama'");
                            if(mysqli_fetch_assoc($result)){
                                echo "<script>
                                        alert('Nik dengan NAMA ini sudah terdaftar');
                                    </script>";
                                    
                                // return false untuk gagalkan login
                                return false;
                            }

                            // enkripsi nik
                                $nik = password_hash($nik, PASSWORD_DEFAULT);                               
                                // masukan semua data user ke dalam database
                                    mysqli_query($koneksi, "INSERT INTO users VALUES(null,'$nik', '$nama', '$profile')");

    // return nilai affected
        return mysqli_affected_rows($koneksi);

    }



// function login
    function login($data_user_login){
        // get gelobal $koneksi
            global $koneksi; 

        // ambil semua data yang di inputkan oleh user yang di simpan ke dalam variable $data_user_login
            $nik = $data_user_login['nik'];
            $nama = strtolower($data_user_login['nama']);

            // jika user menginputkan data konsong maka batalkan login
                if (empty($nik) || empty($nama)) {
                    //  alert data tidak boleh kosong
                        echo"<script>
                                alert('tolong isi semua DATA yang ada!');
                            </script>";

                    // retrun nilai false untuk membatalka  login
                        return false;
                    }
                    
                    // cek apakah di dalam database ada data yang di cari berdasarkan nama yang di inputkan
                    $result = mysqli_query($koneksi, "SELECT * FROM users WHERE username = '$nama'");
                    $baris_data = mysqli_fetch_assoc($result);
                    
                    if (!$baris_data) {
                        echo"<script>
                                alert('akun tidak ditemukan');
                            </script>";
    
                        return false;
                    }
                    // cek apakah data user sudah terdaftar atau belum berdasarkan nama

                    // verify nik
                        $nikverify = password_verify($nik, $baris_data['nik']);

                    // cek apakah nik yang di inputkan user tidak sesuai dengan nik yang ada pada database
                        if ($nikverify === false) {
                            echo"<script>
                                    alert('nik tidak sesuai');
                                </script>";

                            return false;
                        }


    // return nilai affecter
        return mysqli_affected_rows($koneksi);

    }


// function tambah Catatan
    function tambahCatatan($data_catatan){
        // get gelobal $koneksi
            global $koneksi;

        // ambil semua data post yang sudah di tampung di variable $data_catatan
            $id          =    htmlspecialchars($data_catatan['us_di']);
            $tanggal     =    htmlspecialchars($data_catatan['tanggal']);
            $waktu       =    htmlspecialchars($data_catatan['waktu']);
            $lokasi      =    htmlspecialchars($data_catatan['lokasi']);
            $suhu        =    htmlspecialchars($data_catatan['suhu']);

            // cek apakah user menekan tombol submit dengan data yang di inputkan null jika ya maka batalkan peroses penyimpanan catatan ke database
                if (empty($tanggal) || empty($waktu) || empty($lokasi)|| empty($suhu) ) {
                    
                    // berikan notifikasi gagal menyimpan data
                        echo"<script>
                                alert('catatan GAGAL disimpan silahkan coba lagi. Diharapkan isi semua data agar kami dapat menyimpannya');
                            </script>";

                        // return false untuk membatalkan login
                          return false;
              
                }

                // masukan data catatan ke  database
                    mysqli_query($koneksi, "INSERT INTO catatan VALUES(null, '$id', '$tanggal', '$waktu', '$lokasi', '$suhu')");

            

    // return nilai affecter
       return mysqli_affected_rows($koneksi);

    }

// function tambah Catatan
function ubahCatatan($data_catatan){
    // get gelobal $koneksi
        global $koneksi;

    // ambil semua data post yang sudah di tampung di variable $data_catatan
        $id = $data_catatan['edtl-t'];
        $tanggal     =   htmlspecialchars( $data_catatan['tanggal']);
        $waktu       =   htmlspecialchars($data_catatan['waktu']);
        $lokasi      =   htmlspecialchars($data_catatan['lokasi']);
        $suhu        =   htmlspecialchars($data_catatan['suhu']);

        // cek apakah user menekan tombol submit dengan data yang di inputkan null jika ya maka batalkan peroses penyimpanan catatan ke database
            if (empty($tanggal) || empty($waktu) || empty($lokasi)|| empty($suhu) ) {
                
                // berikan notifikasi gagal menyimpan data
                    echo"<script>
                            alert('catatan GAGAL diubah silahkan cobalagi || Diharapkan isi semua data agar kami dapat menyimpannya');
                        </script>";

                    // return false untuk membatalkan login
                      return false;
          
            }


            
                    
            // masukan data catatan ke  database
                mysqli_query($koneksi, "UPDATE catatan SET
                            tanggal = '$tanggal',
                            jam = '$waktu',
                            lokasi = '$lokasi',
                            suhu = '$suhu'
                            WHERE id_catatan = $id");

        

// return nilai affecter
   return mysqli_affected_rows($koneksi);

}                                                                                                       



// momentum
    $waktu=gmdate("H:i",time()+7*3600);
    $t=explode(":",$waktu);
    $jam=$t[0];
    $menit=$t[1];

    if ($jam >= 00 and $jam < 10 ){
        if ($menit >00 and $menit<60){
        $momentum="Selamat Pagi";
    }
    }else if ($jam >= 10 and $jam < 15 ){
        if ($menit >00 and $menit<60){
        $momentum="Selamat Siang";
    }
    }else if ($jam >= 15 and $jam < 18 ){
        if ($menit >00 and $menit<60){
        $momentum="Selamat Sore";
    }
    }else if ($jam >= 18 and $jam <= 24 ){
        if ($menit >00 and $menit<60){
        $momentum="Selamat Malam";
    }
    }else {
        $momentum="Selamat Datang";

    }

// function upload 
    function gambarUpload(){

        // ambil semua value gambar dari variable super gelobal $_FILES dan tampung suma nilai ke dalam sebuah variable
            $namaGambar   =     $_FILES['gambar']['name'];
            $typeGambar   =     $_FILES['gambar']['type'];
            $tmp_name     =     $_FILES['gambar']['tmp_name'];
            $error        =     $_FILES['gambar']['error'];
            $size         =     $_FILES['gambar']['size'];


            // cek apakah ada gambar yang di upload jika tidak ada maka gtagalkan user untuk memasuki statement berikutnya
                if ($error === 4) {
                    // tampilkan pesan untuk mengupload gambar
                    echo'<script>
                            alert("silahkan upload gambar terlebih dahulu untuk foto profile kamu");
                        </script>';

                    // nilai balik false untuk mengagalkan statement berikutnya
                    return false;
                }



                // cek apakah yang di upload adalah gambar atau bukan dengan cara mengecek type gambar
                    // buat variable untuk gambar valid
                        $ekstensiGambarOk = ['image/png',
                                             'image/jpg',
                                             'image/jpeg',
                                             'image/webp'];

                        // mengecek type data gambar jika type data gambar tidak ada pada array $ekstensiGambarOk maka gagalkan penguploadan
                        if (!in_array($typeGambar, $ekstensiGambarOk)) {
                            // tampolkan pesan yang di upload harus gambar
                            echo'<script>
                                        alert("yang anda upload bukanlah gambar");
                                </script>';

                            // berikan nilai balik false untuk membatalkan proses upload
                            return false;
                        }

                        // cek ukuran gambar jilebih dari 2 mb maka gagalkan peroses penguploadan 
                            if ($size > 100000 ) {

                                // tampolkan pesan ukuran gambar terlalu besar
                            echo'<script>
                                        alert("ukuran gambar terlalu besar harap ukuran gambar < 1mb");
                                </script>';

                            // berikan nilai balik false untuk membatalkan proses upload
                            return false;

                            }


                        // bangkitkan bilangan random untuk gambar supaya gambar yang lain dengan file yang sama tidak akan terduplikasi
                            $namaGambarRandom      =     uniqid();
                            $namaGambarRandom      .=    '.';
                            $typeGambar            =     explode('.', $namaGambar);
                            $typeGambar            =     end($typeGambar);
                            $namaGambarRandom      .=    $typeGambar;
                            
                        // masukan ganbar ke folder images
                            move_uploaded_file($tmp_name, 'images/'.$namaGambarRandom);


                        // berikan nilai balik nama gambar random untuk di masukan ke database
                            return $namaGambarRandom;
                    

    }   




