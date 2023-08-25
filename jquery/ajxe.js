// cek ahalam sudah ready atau belum jika sudah maka jalankan ajax untuk mencari data
// $(document).ready(function(){


//     // ambil keyword dari document dengan id cari dan jalankan event saat di ketik 
//         $('#keyword').on('keyup', function(){

            
//             // ambil table lalu ubah isinya dengan data baru dari sumber ajax d
//                 $('table-data').load('d-ass-j/datasrc.php?keyword='+ $('#keyword').val());

//         })




// })




// ambil data dari tiap elemet
    var keyword = document.getElementById('keyword');
    var table = document.getElementById('scr');


    // buat event ketika keyword di keyup
        keyword.addEventListener('keyup', function(){

            // buat object ajax
                var xhr = new XMLHttpRequest();
            
            // cek ajax siap di gunakan
                xhr.onreadystatechange = function(){

                    if (xhr.readyState == 4 && xhr.status== 200) {
                        table.innerHTML = xhr.responseText;
                    }

                }
            
        // jalnkan ajax
            xhr.open('GET', "d-ass-j/datasrc.php?keyword="+ keyword.value, true );
            xhr.send();




        })
