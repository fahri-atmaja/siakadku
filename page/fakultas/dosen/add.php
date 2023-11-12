<h1>
<a href="<?= $_url ?>dosen" class="nav-button transform"><span></span></a>
Tambah Dosen
</h1>

<?php
if (isset($_POST['submit'])) {

	$nipdos				=$_POST['nip'];
	$password			=$_POST['password'];
	$nama_lengkap		=$_POST['nama_lengkap'];
	$alamat				=$_POST['alamat'];
	$gender				=$_POST['gender'];
	$prodi_id			=$_POST['prodi_id'];
	$gelar_pendidikan	=$_POST['gelar_pendidikan'];

	$sql = "INSERT INTO app_dosen (nip,password,nama_lengkap,alamat,gender,prodi_id,gelar_pendidikan)
			values('$nipdos', (md5('$password')), '$nama_lengkap', '$alamat', '$gender', '$prodi_id', '$gelar_pendidikan')";
	$query = mysqli_query($koneksi, $sql);

	if ($query) {
		echo "<script>$.Notify({
		    caption: 'Success',
		    content: 'Data Dosen Berhasil Ditambah',
    		type: 'success'
		});</script>";
	} else {
		echo "<script>$.Notify({
		    caption: 'Failed',
		    content: 'Data Dosen Gagal Ditambah',
		    type: 'alert'
		});</script>";
	}
}
?>

<form method="post">

<div class="grid">

<div class="row cells2">
	<div class="cell">
		<label>NIP</label>
		<div class="input-control text full-size">
			<input type="text" name="nip">
		</div>
	</div>
	<div class="cell">
		<label>PASSWORD</label>
		<div class="form-group">
			<input type="password" name="password">
		</div>
	</div>
	
	</div>

<div class="row cells2">
	<div class="cell">
		<label>Nama</label>
		<div class="input-control text full-size">
			<input type="text" name="nama_lengkap">
		</div>
	</div>
	</div>
	
<div class="row cells2">
	<div class="cell">
		<label>Alamat</label>
		<div class="input-control text full-size">
			<input type="text" name="alamat">
		</div>
	</div>

	<div class="cell">
		<label>Jenis Kelamin</label>
		<div class="full-size">
		<label class="input-control radio">
			<input type="radio" name="gender" value="Laki-laki">
		    <span class="check"></span>
		    <span class="caption">Laki-laki</span>
		</label>
		<label class="input-control radio">
			<input type="radio" name="gender" value="Perempuan">
		    <span class="check"></span>
		    <span class="caption">Perempuan</span>
		</label>
		</div>
	</div>
</div>

<div class="row cells2">
	<div class="cell">
		<label>Prodi</label>
		<div class="form-group">
			<select name="prodi_id">
				<option value=""></option>
				<?php
					$query = mysqli_query($koneksi, "SELECT * FROM akademik_prodi ORDER BY prodi_id");
					while ($field = mysqli_fetch_array($query)) {
						echo "<option value='{$field['prodi_id']}'>{$field['nama_prodi']}</option>";
					}
				?>
			</select>
		</div>
	</div>



	<div class="cell">
		<label>Gelar</label>
		<div class="input-control text full-size">
			<input type="text" name="gelar_pendidikan">
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