<?php
	if ($_access == 'mahasiswa' && $_id != $_username) {
		header("location:{$_url}");
	}

$querya = mysqli_query($koneksi, "SELECT * FROM student_mahasiswa WHERE nim='{$_id}'");
$field = mysqli_fetch_array($querya);
extract($field);
?>
<h1>
<a href="<?= $_url ?>mahasiswa<?= $_access == 'mahasiswa' ? '/view/' . $_id . '/' . urlencode($nama) : '' ?>" class="nav-button transform"><span></span></a>
Edit Status Mahasiswa<br><?= $nama ?>
</h1>

<?php

if (isset($_POST['submit'])) {

	extract($_POST);

	$sql = "UPDATE student_mahasiswa SET nisn='{$nisn}', status_angsur='{$status_angsur}', id_sks='{$id_sks}', semester='{$semester}', 
	id_kelas='{$id_kelas}', kpt='{$kpt}', beasiswa='{$beasiswa}', angkatan_id='{$angkatan}' WHERE nim='{$nim}'";
	$query = mysqli_query($koneksi, $sql);

	if ($query) {
		echo "<script>$.Notify({
		    caption: 'Success',
		    content: 'Data Mahasiswa Berhasil Ubah',
    		type: 'success'
		});
		setTimeout(function(){ window.location.href='{$_url}mahasiswa'; }, 2000);
		</script>";
	} else {
		echo "<script>$.Notify({
		    caption: 'Failed',
		    content: 'Data Mahasiswa Gagal Ubah',
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
		<div>
			<input type="text" name="nim" value="<?= $nim ?>" readonly>
		</div>
	</div>
	<div class="cell">
		<label>NISN</label>
		<div>
			<input type="text" name="nisn" value="<?= $nisn ?>">
		</div>
	</div>
	<?php endif; ?>
	
	<div class="cell">
		<label>Nama</label>
		<div>
			<input type="text" name="nama" value="<?= $nama ?>" readonly>
		</div>
	</div>
</div>
<div class="row cells2">
	<div class="cell">
		<label>Status Biaya Mahasiswa</label>
		<div>
			<select name="status_angsur" required>
				<option value="<?= $status_angsur ?>"><?= $status_angsur==1?'Bulanan':'Semesteran'; ?> / <?= $status_angsur ?></option>
				<option value="1">Bulanan</option>
				<option value="0">Semesteran</option>
			</select>
		</div>
	</div>
	<div class="cell">
		<label>Semester</label>
		<div>
			<input type="text" name="semester" value="<?= $semester?>">
		</div>
	</div>
	</div>
<div class="row cells2">	
	<div class="cell">
		<label>Status SKS</label>
		<div>
			<select name="id_sks" required readonly>
				<option value="<?= $id_sks ?>"><?= $id_sks==1?'Reguler':'Konversi'; ?> / <?= $id_sks ?></option>
				<option value="1">Reguler</option>
				<option value="2">Konversi</option>
			</select>
		</div>
	</div>
	<div class="cell">
		<label>Status Kelas Mahasiswa</label>
		<div>
			<select name="id_kelas" required>
			    <?php
			    $query1 = mysqli_query($koneksi, "SELECT nama_kelas FROM akademik_kelas WHERE id_kelas= $id_kelas");
			    $field1 = mysqli_fetch_array($query1)
			    ?>
				<option value="<?= $id_kelas ?>"><?= $field1['nama_kelas']?> </option>
				<?php
					$query = mysqli_query($koneksi, "SELECT * FROM akademik_kelas");
					while ($field = mysqli_fetch_array($query)) {
						echo "<option value='{$field['id_kelas']}'>{$field['nama_kelas']}</option>";
					}
				?>
			</select>
		</div>
	</div>	
	</div>
<div class="row cells2">
	<div class="cell">
		<label>Status Jalur</label>
		<div>
			<select name="kpt" required>
				<option value="<?= $kpt ?>"><?= $kpt==1?'KPT':'UNIVERSITAS'; ?> / <?= $kpt ?></option>
				<option value="1">KPT</option>
				<option value="0">UNIVERSITAS</option>
			</select>
		</div>
	</div>
	<div class="cell">
		<label>Status Biaya</label>
		<div>
			<select name="beasiswa" required>
				<option value="<?= $beasiswa ?>"><?= $beasiswa==1?'Beasiswa':'Reguler'; ?> / <?= $beasiswa ?> </option>
				<option value="1">Beasiswa</option>
				<option value="0">Reguler</option>
			</select>
		</div>
	</div>
</div>
<div class="row cells2">
	<div class="cell">
		<label>Angkatan</label>
		<div>
			<select name="angkatan" required>
			    <?php
			    $loadangkatan = mysqli_query($koneksi,"SELECT * FROM student_angkatan WHERE angkatan_id='$angkatan_id'");
			    $array = mysqli_fetch_array($loadangkatan);
			    ?>
				<option value="<?= $angkatan_id ?>"><?= $array['keterangan']; ?> / <?= $angkatan_id ?> </option>
				<?php
				$loadangkatan2 = mysqli_query($koneksi,"SELECT * FROM student_angkatan");
				while ($f = mysqli_fetch_array($loadangkatan2)){
				    echo "<option value='{$f['angkatan_id']}'>{$f['keterangan']}</option>";
				}
				?>
			</select>
		</div>
	</div>
</div>

<div class="container">
<div class="row cells2">
	<div class="cell">
	    <div>
		<button type="submit" name="submit" class="button primary">UBAH</button>
	    </div>
	</div>
</div>
</div>
</div>
</div>
</form>