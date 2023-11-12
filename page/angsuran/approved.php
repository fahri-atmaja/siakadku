<?php
$sql = "SELECT konsentrasi_id FROM student_mahasiswa WHERE nim='$_id'";
$query = mysqli_query($koneksi, $sql);
$row = mysqli_fetch_array($query);
$konsen = $row['konsentrasi_id'];
$loadangsur= mysqli_query($koneksi,"SELECT * FROM biaya_angsuran WHERE konsentrasi_id='$konsen'");
    	$display = mysqli_fetch_array($loadangsur);
    	$bayar = $display['total_biaya']/$display['jumlah_angsur'];
$angsur=$_params[1];
date_default_timezone_set("Asia/Jakarta");
$tanggal = date('Y-m-d');
if (isset($_params[2]) && $_params[2] == 'yes') {
	$cekdulu = mysqli_num_rows(mysqli_query($koneksi,"SELECT * from bayar_angsuran where nim = '$_id' and angsuran='1'"));
if ($cekdulu > 0){
		echo "<script>window.alert('MAAF MAHASISWA SUDAH BAYAR ANGSURAN PERTAMA')
    window.location.href='{$_url}angsuran'</script>";
	}else{
$query = mysqli_query($koneksi, "INSERT INTO bayar_angsuran SET nim='$_id', bayar='$bayar', angsuran=1, tanggal='$tanggal'");
if ($query) {
		echo "<script>$.Notify({
		    caption: 'Success',
		    content: 'Pembayaran Berhasil Ditambah',
    		type: 'success'
		});
		setTimeout(function(){ window.location.href='{$_url}angsuran'; }, 2000);
		</script>";
	} else {
		echo "<script>$.Notify({
		    caption: 'Failed',
		    content: 'Pembayaran Gagal Ditambah',
		    type: 'alert'
		});
		setTimeout(function(){ window.location.href='{$_url}angsuran'; }, 2000);
		</script>";
	}
}
}
?>
<h1>Bayar Angsuran</h1>
<h3>Apakah data sudah benar?<br>
 Mahasiswa dengan NIM <?= $_id ?><br>
 Bayar Angsuran ke <?= $angsur - $angsur + 1 ?><br>
 Bayar Angsuran Rp. <?php echo $bayar ?>,00<br> </h3>
<a href="<?= $_url ?>angsuran/approved/<?= $_id ?>/<?= $_params[1] ?>/yes" class="button primary">Yes</a> <a href="<?= $_url ?>angsuran" class="button danger">No</a>