<?php
// include("config/main.php");
// include("config/routing.php");

$koneksi        = mysqli_connect('localhost','smilefoo_siakad','','smilefoo_wp');
$nik            = $_POST['nik'];
$nisn           = $_POST['nisn'];
$nama           = $_POST['nama'];
$email          = $_POST['email'];
$tpt_lahir      = $_POST['tpt_lahir'];
$tgl_lahir      = $_POST['tgl_lahir'];
$alamat         = $_POST['alamat'];
$asal_sekolah   = $_POST['asal_sekolah'];
$nmayah         = $_POST['nmayah'];
$nmibu          = $_POST['nmibu'];
$nohp           = $_POST['nohp'];
$jenkel         = $_POST['jenkel'];
$kdagama        = $_POST['kdagama'];
$prodi_id       = $_POST['prodi_id'];
$konsentrasi_id = $_POST['konsentrasi_id'];
$angkatan_id    = $_POST['angkatan_id'];
$id_sks         = $_POST['id_sks'];
$id_kelas       = $_POST['id_kelas'];
$ospek          = $_POST['ospek'];
$size           = $_POST['size'];


// ambil 2 digit tahun
$tahun = date('Y');
$dua = substr($tahun,2);
$getnim = mysqli_query($koneksi,"SELECT * FROM akademik_nim WHERE konsentrasi_id='$konsentrasi_id'");
$nim = mysqli_fetch_array($getnim);
$gabung = $dua.$nim['gen_nim'];
// $gabung = '1911';
$ceknim = mysqli_query($koneksi,"SELECT nim FROM student_mahasiswa WHERE nim like '%$gabung%' ORDER BY nim DESC limit 1");
$cek = mysqli_num_rows($ceknim);
if ($cek > 0){
    $fill = mysqli_fetch_array($ceknim);
    $fixnim = $fill['nim']+1;
}else{
    // echo $gabung."0001";
    $fixnim = $gabung."0001";
}
$cekemail = mysqli_query($koneksi,"SELECT email FROM student_mahasiswa WHERE email='$email'");
$mail = mysqli_num_rows($cekemail);
if ($mail > 0){
    echo "<script>window.alert('Anda sudah terdaftar. Silahkan login!.')
		    window.location.href='https://siakad.undaris.ac.id/view_nim.php?email=".$email."'</script>";
}else{
$insert = mysqli_query($koneksi,"INSERT INTO student_mahasiswa (nim,nikmhs,password,nama,id_sks,id_kelas,status_angsur,
                                    konsentrasi_id,kpt,beasiswa,angkatan_id,alamat,semester,gender,agama_id,
                                    tempat_lahir,tanggal_lahir,nama_ibu,nama_ayah,sekolah_nama,no_hp_ortu,semester_aktif,status,email,nisn)
                                    VALUES('$fixnim','$nik',md5('$tgl_lahir'),'$nama','$id_sks','$id_kelas','1','$konsentrasi_id',
                                    '0','1','$angkatan_id','$alamat','1','$jenkel','$kdagama','$tpt_lahir','$tgl_lahir','$nmibu','$nmayah','$asal_sekolah',
                                    '$nohp',1,'mahasiswa','$email','$nisn')");
$konfirmasi = mysqli_query($koneksi,"INSERT INTO konfirmasi_ospek (ospek,tahun,size,nim)
                                        VALUES('$ospek','$tahun','$size','$fixnim')");
if($insert){
    echo "<script>window.alert('DATA BERHASIL DI EXPORT.')
		    window.location.href='https://siakad.undaris.ac.id/view_nim.php?email=".$email."'</script>";
}else{
    echo "<script>window.alert('DATA GAGAL')
		    window.location.href='https://pmb.undaris.ac.id/kip'</script>";
}
}
?>
