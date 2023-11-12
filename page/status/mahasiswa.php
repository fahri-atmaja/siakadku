<?php
$querya = mysqli_query($koneksi, "SELECT * FROM student_mahasiswa WHERE nim='{$_id}'");
$field = mysqli_fetch_array($querya);
extract($field);
?>
<h2>
<a href="<?= $_url ?>mahasiswa<?= $_access == 'mahasiswa' ? '/view/' . $_id . '/' . urlencode($nama) : '' ?>" class="nav-button transform"><span></span></a>
Set Status Mahasiswa<br><br><?= $nama ?>
</h2>

<?php

if (isset($_POST['submit'])) {

	extract($_POST);

	$sql = "UPDATE student_mahasiswa SET aktif_krs='{$status}' WHERE nim='{$_id}'";
	$query = mysqli_query($koneksi, $sql);

	if ($query) {
		echo "<script>$.Notify({
		    caption: 'Success',
		    content: 'Data Status KRS Mahasiswa Berhasil Ubah',
    		type: 'success'
		});</script>";
	} else {
		echo "<script>$.Notify({
		    caption: 'Failed',
		    content: 'Data Status KRS Mahasiswa Gagal Diubah',
		    type: 'alert'
		});</script>";
	}
}
?>

<form method="post">

<div class="grid">

<div class="row cells2">
	<?php if ($_access == 'admin'): ?>
	<div class="cell">
		<label>NIM</label>
		<div class="form-group">
			<label> <?= $nim ?> <label>
		</div>
	</div>
	<?php endif; ?>
	
	<div class="cell">
		<label>Nama</label>
		<div class="form-group">
			<label> <?= $nama ?> <label>
		</div>
	</div>
</div>

<div class="row cells2">
	<div class="cell">
		<label>Status</label>
			<select name="status">
				<option name="status" value="">--pilih--</option>
				<option value="y">AKTIF KRS</option>
				<option value="t">NONAKTIF KRS</option>
			</select>
		</div>
	</div>


<div class="row cells2">
	<div class="cell">
		<button type="submit" name="submit" class="button primary">SUBMIT</button>
	</div>
</div>

</div>

</form>