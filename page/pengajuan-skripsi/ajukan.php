<h1>
<a href="<?= $_url ?>pengajuan-skripsi" class="nav-button transform"><span></span></a>
AJUKAN JUDUL
</h1>

<?php
if (isset($_POST['submit'])) {
	
	$nim				= $_POST['nim'];
	$dosen_id       	= $_POST['dosen_id'];
	$judul				= $_POST['judul'];
	$cekdulu = mysqli_num_rows(mysqli_query($koneksi,"SELECT * from pengajuan_skripsi where nim = '$_username'"));
	
	if ($cekdulu > 0){
		echo "<script>window.alert('MAAF ANDA SUDAH MENGAJUKAN JUDUL SKRIPSI, CEK STATUS JUDUL ANDA!')
    window.location.href='{$_url}pengajuan-skripsi'</script>";
	}else{
	$sql = "INSERT INTO pengajuan_skripsi(dosen_id,nim,judul) values('$dosen_id', '$nim', '$judul');";
	$query = mysqli_query($koneksi, $sql);

	if ($query) {
		echo "<script>$.Notify({
		    caption: 'Success',
		    content: 'Pengajuan Berhasil Ditambah',
    		type: 'success'
		});</script>";
	} else {
		echo "<script>$.Notify({
		    caption: 'Failed',
		    content: 'Pengajuan Gagal Ditambah',
		    type: 'alert'
		});</script>";
	}
}
}
?>
<?php 
	$load = mysqli_query($koneksi,"SELECT * FROM student_mahasiswa WHERE nim='$_username'");
	$display = mysqli_fetch_array($load);
?>
<form method="post">

<div class="grid">

<div class="row cells2">
	
<input type="hidden" name="dosen_id" value="<?php echo $display['dosen_id'] ?>" readonly>
<input type="hidden" name="nim" value="<?php echo $display['nim'] ?>" readonly>	
	<div class="cell">
		<label>JUDUL SKRIPSI</label>
		<div class="input-control text full-size">
			<input type="text" name="judul">
		</div>
	</div>
</div>


<div class="row cells2">
	<div class="cell">
		<button type="submit" name="submit" class="button primary">SUBMIT</button>
	</div>
</div>

</div>

</form>