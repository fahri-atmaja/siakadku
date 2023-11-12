<?php
// Ambil data yang dikirim dari form
$angkatan       = $_POST['angkatan'];
$konsentrasi	= $_POST['konsentrasi'];
$status			= $_POST['status'];
$jenis_bayar    = $_POST['jenis_bayar'];
$jumlah         = $_POST['jumlah'];
$batas_bayar    = $_POST['batas_bayar'];
$semester       = $_POST['semester'];
$count = count($jenis_bayar);

$sql = "INSERT INTO tagihan_mahasiswa (id_tagihan,angkatan_id,konsentrasi_id,status,jenis_bayar,semester,jumlah,batas_bayar) VALUES ";

for($i=0; $i < $count; $i++)
{
    $sql.="('','{$angkatan}','{$konsentrasi}','{$status}','{$jenis_bayar[$i]}','{$semester[$i]}','{$jumlah[$i]}','{$batas_bayar[$i]}')";
    $sql.=",";
}
$sql = rtrim($sql,",");

$insert = mysqli_query($koneksi,$sql);

// $sql = mysqli_query($koneksi,"INSERT INTO tagihan_mahasiswa VALUES('','$angkatan','$konsentrasi','$status','$jenis_bayar','$jumlah','$batas_bayar')");
if ($insert) {
		echo "<script>$.Notify({
		    caption: 'Success',
		    content: 'Data Berhasil Ditambah',
    		type: 'success'
		});
		setTimeout(function(){ window.location.href='{$_url}tagihan'; }, 2000);
		</script>";
	} else {
		echo "<script>$.Notify({
		    caption: 'Failed',
		    content: 'Data Gagal Ditambah',
		    type: 'alert'
		});</script>";
	}
?>