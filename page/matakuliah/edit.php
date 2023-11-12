<?php
$querya = mysqli_query($koneksi, "SELECT * FROM makul_matakuliah WHERE makul_id='{$_id}'");
$field = mysqli_fetch_array($querya);
$ququ = mysqli_query($koneksi,"SELECT * FROM akademik_konsentrasi WHERE nama_konsentrasi='$_username'");
$fill = mysqli_fetch_array($ququ);
$kon1 = $fill['konsentrasi_id'];
$kon2 = $field['konsentrasi_id'];
if ($kon1=$kon2){
    extract($field);
    
}else{
 echo "<script>window.alert('MAAF HALAMAN TIDAK BISA DIAKSSES')
		    window.location.href='{$_url}'</script>";
}
?>
<h1>
<a href="<?= $_url ?>matakuliah" class="nav-button transform"><span></span></a>
Edit Matakuliah <br> <?= $nama ?>
</h1>

<?php

if (isset($_POST['submit'])) {

	extract($_POST);

	$sql = "UPDATE makul_matakuliah SET nama_makul='{$nama_makul}', sks='{$sks}', semester='{$semester}'
		 WHERE makul_id='{$_id}'";
	$query = mysqli_query($koneksi, $sql);

	if ($query) {
		echo "<script>$.Notify({
		    caption: 'Success',
		    content: 'Data Matakuliah Berhasil Ubah',
    		type: 'success'
		});
		setTimeout(function(){ window.location.href='{$_url}matakuliah'; }, 2000);</script>";
	} else {
		echo "<script>$.Notify({
		    caption: 'Failed',
		    content: 'Data Matakuliah Gagal Ubah',
		    type: 'alert'
		});</script>";
	}
}
?>

<form method="post">

<div class="grid">

<div class="row cells2">
	<div class="cell">
		<label>Kode Makul</label>
		<div class="input-control text full-size">
			<input type="text" name="kode_makul" value="<?= $kode_makul ?>" readonly>
		</div>
	</div>
	
	<div class="cell">
		<label>Nama Makul</label>
		<div class="input-control text full-size">
			<input type="text" name="nama_makul" value="<?= $nama_makul ?>">
		</div>
	</div>
</div>

<div class="row cells2">
	<div class="cell">
		<label>Jumlah SKS</label>
		<div class="input-control text full-size">
			<input type="number" name="sks" maxlength="1" value="<?= $sks ?>">
		</div>
	</div>

	<div class="cell">
		<label>Semester</label>
		<div class="input-control text full-size">
			<input type="number" name="semester" maxlength="2" value="<?= $semester ?>">
		</div>
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