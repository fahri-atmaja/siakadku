<?php
// $koneksi = mysqli_connect('localhost','smilefoo_siakad','Sina_atmaja666','smilefoo_siakad');
// $kode_bayar= $_GET['kode_bayar'];
// $hasil = mysqli_query("SELECT * FROM kode_tagihan");
   
// echo "<option>-- Jenis Tagihan --</option>";
  
// while($k = mysqli_fetch_object($hasil)){
//      echo "<option value='$k->kode_bayar'> " . $k->keterangan ."</option>";
// }
?>

<?php
	$koneksi = mysqli_connect('localhost','smilefoo_siakad','Sina_atmaja666','smilefoo_siakad');
 
	echo "<option value=''>-- Pilih --</option>";
 
	$query = "SELECT * FROM kode_tagihan";
	$dewan1 = mysqli_query($koneksi, $query);
	while ($row = mysqli_fetch_array($dewan1)) {
		echo "<option value='" . $row['kode_bayar'] . "'>" . $row['keterangan'] . "</option>";
	}
?>