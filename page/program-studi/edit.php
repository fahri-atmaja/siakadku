<?php
$querya = mysqli_query($koneksi, "SELECT * FROM akademik_prodi WHERE prodi_id='{$_id}'");
$field = mysqli_fetch_array($querya);
extract($field);
?>
<h1>
<a href="<?= $_url ?>program-studi" class="nav-button transform"><span></span></a>
Edit Program studi <br> <?= $nama_prodi ?>
</h1>

<?php

if (isset($_POST['submit'])) {

	extract($_POST);

	$sql = "UPDATE akademik_prodi SET nama_prodi='{$nama_prodi}', ketua='{$ketua}', no_izin='{$no_izin}'
		 WHERE prodi_id='{$_id}'";
	$query = mysqli_query($koneksi, $sql);

	if ($query) {
		echo "<script>$.Notify({
		    caption: 'Success',
		    content: 'Data Program studi Berhasil Ubah',
    		type: 'success'
		});</script>";
	} else {
		echo "<script>$.Notify({
		    caption: 'Failed',
		    content: 'Data Program studi Gagal Ubah',
		    type: 'alert'
		});</script>";
	}
}
?>

<form method="post">

<div class="grid">

<div class="row cells2">
	<div class="cell">
		<label>Ketua Prodi</label>
		<div class="input-control text full-size">
			<input type="text" name="ketua" value="<?= $ketua ?>">
		</div>
	</div>
	
	<div class="cell">
		<label>Nama Prodi</label>
		<div class="input-control text full-size">
			<input type="text" name="nama_prodi" value="<?= $nama_prodi ?>">
		</div>
	</div>
	
	<div class="cell">
		<label>Nomor Ijin</label>
		<div class="input-control text full-size">
			<input type="text" name="no_izin" value="<?= $no_izin ?>">
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