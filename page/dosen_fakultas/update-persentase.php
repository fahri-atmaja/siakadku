<?php
	if ($_access == 'mahasiswa' && $_id != $_username) {
		header("location:{$_url}krs/view/{$_username}");
	}
?>
<style type="text/css">
	.input-control {
		border: 1px solid #d9d9d9;
		padding: 1px;
	}
</style>

<h1>
<a href="<?= $_url ?><?= in_array($_access, array('admin','dosen')) ? 'dosen/inputnilai' : '' ?>" class="nav-button transform"><span></span></a>
Update Persentase
</h1>

<?php

if (isset($_POST['submit'])) {

	extract($_POST);

	$sqlu = "UPDATE setpersentase SET uts='{$uts}', uas='{$uas}', kehadiran='{$kehadiran}', tugas='{$tugas}' WHERE nip='$_username'";
	$que = mysqli_query($koneksi, $sqlu);

	if ($que) {
		echo "<script>$.Notify({
		    caption: 'Success',
		    content: 'Data Persentase Berhasil Ubah',
    		type: 'success'
		});</script>";
	} else {
		echo "<script>$.Notify({
		    caption: 'Failed',
		    content: 'Data Persentase Gagal Ubah',
		    type: 'alert'
		});</script>";
	}
}
?>
<form Method="POST">
	<table class="table striped hovered border bordered">
	<td>

			<input type="hidden" name="nip" id="nip" value="<?php echo $_username ?>" readonly>

	<td>
	<div class="form-group">
		<label for="semester">KEHADIRAN :</label>
			<input class="form-control" type="text" name="kehadiran" id="kehadiran">
		<label for="semester">TUGAS :</label>
			<input class="form-control" type="text" name="tugas" id="tugas">	
	</td>
	<br>
	<td>
	<div class="form-group">
		<label for="semester">UTS :</label>
			<input class="form-control" type="text" name="uts" id="uts">
		<label for="semester">UAS :</label>
			<input class="form-control" type="text" name="uas" id="uas">
	</div>
	</td>
	<td>
	<div class="row cells2">
	<div class="cell">
		<button type="submit" name="submit" class="button primary">SUBMIT</button>
	</div>
	</div>
	</td>
	</table>
</form>
