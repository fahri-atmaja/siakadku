<?php
if (isset($_POST['submit'])) {
$koneksi = mysqli_connect('localhost','smilefoo_siakad','Sina_atmaja666','smilefoo_wp');
// ambil 2 digit tahun
$tahun = date('Y');
$dua = substr($tahun,2);

// ambil nim konsentrasi
$getnim = mysqli_query($koneksi,"SELECT * FROM akademik_nim WHERE konsentrasi_id='$konsentrasi_id'");
$nim = mysqli_fetch_array($getnim);
// echo $dua;
// echo $nim['gen_nim'];
// $gabung = $dua.$nim['gen_nim'];
$gabung = '1911';
$ceknim = mysqli_query($koneksi,"SELECT nim FROM student_mahasiswa WHERE nim like % $gabung %");
$cek = mysqli_num_rows($ceknim);
if ($cek > 0){
    $fill = mysqli_fetch_array($ceknim);
    echo $fill['nim']+1;
}else{
    echo $gabung."0001";
}
}
?>