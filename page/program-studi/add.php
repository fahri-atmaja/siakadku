<h1>
<a href="<?= $_url ?>program-studi" class="nav-button transform"><span></span></a>
Tambah Program Studi
</h1>

<?php
if (isset($_POST['submit'])) {

	extract($_POST);

	$sql = "INSERT INTO akademik_prodi values('', '{$nama_prodi}','{$ketua}', '{$no_izin}');";
	$query = mysqli_query($koneksi, $sql);

	if ($query) {
		echo "<script>$.Notify({
		    caption: 'Success',
		    content: 'Data Program studi Berhasil Ditambah',
    		type: 'success'
		});</script>";
	} else {
		echo "<script>$.Notify({
		    caption: 'Failed',
		    content: 'Data Program studi Gagal Ditambah',
		    type: 'alert'
		});</script>";
	}
}
?>

<form method="post">

<div class="grid">

<div class="row cells2">
	<div class="cell">
		<label>Kode</label>
		<div class="input-control text full-size">
			<input type="text" name="ketua">
		</div>
	</div>
	
	<div class="cell">
		<label>Nama</label>
		<div class="input-control text full-size">
			<input type="text" name="nama_prodi">
		</div>
	</div>
</div>
<div class="row cells2">	
	<div class="cell">
		<label>Nomor Izin</label>
		<div class="input-control text full-size">
			<input type="text" name="no_izin">
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