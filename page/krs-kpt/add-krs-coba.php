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
<a href="<?= $_url ?><?= in_array($_access, array('admin','dosen')) ? 'dashboard' : '' ?>" class="nav-button transform"><span></span></a>
ADD KRS
</h1>

<?php
	
if (isset($_POST['submit'])) {
$jadwal_id   = $_POST['jadwal_id'];
$semester	 = $_POST['semester'];

	$sql = "INSERT INTO akademik_krs SET nim='$_username',jadwal_id='$jadwal_id', semester='$semester'";
	$queque = mysqli_query($koneksi, $sql);

	if ($queque) {
		echo "<script>$.Notify({
		    caption: 'Success',
		    content: 'Data KRS Berhasil Ditambah',
    		type: 'success'
		});</script>";
	} else {
		echo "<script>$.Notify({
		    caption: 'Failed',
		    content: 'Data KRS Gagal Ditambah',
		    type: 'alert'
		});</script>";
	}
}
?>
<form Method="POST">
	
	<table class="table striped hovered border bordered">
	<td>
	<div class="form-group">
	<label>JADWAL ID</label>
	<input class="form-control" type="text" name="jadwal_id" id="jadwal_id">
	</div>
	</td>
	<td>
	<div class="form-group">
		<label for="nama_makul">MAKUL :</label>
			<input class="form-control" type="text" name="nama_makul" id="nama_makul">
	</div>
	</td>
	<td>
	<div class="form-group">
		<label for="nama_lengkap">NAMA DOSEN :</label>
			<input class="form-control" type="text" name="nama_lengkap" id="nama_lengkap">
	</div>
	</td>
	<br>
	<td>
	<div class="form-group">
		<label for="semester">SEMESTER :</label>
			<input class="form-control" type="text" name="semester" id="semester">
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
