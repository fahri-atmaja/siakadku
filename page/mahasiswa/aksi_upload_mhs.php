<!-- www.malasngoding.com -->
 
<?php 
include "excel_reader2.php";
?>
 
<?php
// upload file xls
$target = basename($_FILES['matakuliah']['name']) ;
move_uploaded_file($_FILES['matakuliah']['tmp_name'], $target);
 
// beri permisi agar file xls dapat di baca
chmod($_FILES['matakuliah']['name'],0777);
 $load = "SELECT konsentrasi_id FROM akademik_konsentrasi WHERE akademik_konsentrasi.nama_konsentrasi='$_username'";
	$query = mysqli_query($koneksi, $load); 
	$field = mysqli_fetch_array($query);
	$konsentrasi = $field['konsentrasi_id'];
// mengambil isi file xls
$data = new Spreadsheet_Excel_Reader($_FILES['matakuliah']['name'],false);
// menghitung jumlah baris data yang ada
$jumlah_baris = $data->rowcount($sheet_index=0);
 
// jumlah default data yang berhasil di import
$berhasil = 0;
for ($i=2; $i<=$jumlah_baris; $i++){
 
	// menangkap data dan memasukkan ke variabel sesuai dengan kolumnya masing-masing
	$kode_makul     = $data->val($i, 1);
	$nama_makul   = $data->val($i, 2);
	$sks  = $data->val($i, 3);
	$semester  = $data->val($i, 4);
	//$konsentrasi_id  = $data->val($i, 5);
	$kelompok_id = $data->val($i, 5);
	$aktif  = $data->val($i, 6);
	$jam  = $data->val($i, 7);
 
	if($kode_makul != "" && $nama_makul != "" && $sks != "" && $semester != "" && $kelompok_id != "" && $aktif != "" && $jam != ""){
		// input data ke database (table data_pegawai)
		mysqli_query($koneksi,"INSERT into makul_matakuliah values('','$kode_makul','$nama_makul','$sks','$semester','$konsentrasi','$kelompok_id','$aktif','$jam')");
		$berhasil++;
	}
}
 
// hapus kembali file .xls yang di upload tadi
unlink($_FILES['matakuliah']['name']);
 
// alihkan halaman ke index.php
//header("location:index.php?berhasil=$berhasil");
header("location:{$_url}matakuliah?berhasil=$berhasil");
?>