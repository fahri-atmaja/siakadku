<?php
	if ($_access == 'mahasiswa' && $_id != $_username) {
		header("location:{$_url}fakultas/mahasiswa/view/{$_username}");
	}
?>
<style type="text/css">
	.input-control {
		border: 1px solid #d9d9d9;
		padding: 10px;
	}
</style>

<?php
$querya = mysqli_query($koneksi, "SELECT student_mahasiswa.*, student_angkatan.keterangan, akademik_konsentrasi.nama_konsentrasi as nama_konsentrasi FROM student_mahasiswa 
	LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=student_mahasiswa.konsentrasi_id
	LEFT JOIN student_angkatan ON student_angkatan.angkatan_id=student_mahasiswa.angkatan_id
	WHERE nim='{$_id}'");

$field = mysqli_fetch_array($querya);
extract($field);
?>
<h1>
<a href="<?= $_url ?>fakultas/<?= $_access == 'admin' ? 'mahasiswa' : '' ?>" class="nav-button transform"><span></span></a>
Mahasiswa <br> <?= $nama ?>
</h1>
 


<div class="panel" data-role="panel">
    <div class="heading">
        <span class="title">Profil</span>
    </div>
<div class="grid">
	<div class="content">
<table class="table striped hovered border bordered">
<tr>
	<td>
<div class="row cells2">
	<div class="cell">
		<label>NIM</label>
		<div class="form-group">
			<?= $nim ?>
		</div>
	</div>
	
	<div class="cell">
		<label>Nama</label>
		<div class="form-group">
			<?= $nama ?>
		</div>
	</div>
</div>
	</td>
</tr>
<tr>
<td>
<div class="row cells2">
	<div class="cell">
		<label>Alamat</label>
		<div class="form-group">
			<?= $alamat ?>
		</div>
	</div>

	<div class="cell">
		<label>Telepon</label>
		<div class="form-group">
			<?= $no_hp_ortu ?>
		</div>
	</div>
</div>
</td>
</tr>
<tr><td>
<div class="row cells2">
	<div class="cell">
		<label>Tempat Lahir</label>
		<div class="form-group">
			<?= $tempat_lahir ?>
		</div>
	</div>

	<div class="cell">
		<label>Tanggal Lahir</label>
		<div class="form-group">
			<?= $tanggal_lahir ?>
		</div>
	</div>
</div>
</td></tr>
<tr><td>
<div class="row cells2">
	<div class="cell">
		<label>Agama</label>
		<div class="form-group">
			<?= $agama_id ?> .Islam
		</div>
	</div>

	<div class="cell">
		<label>Jenis Kelamin</label>
		<div class="form-group">
			<?= $gender ?>
		</div>
	</div>
</div>
</td></tr>
<tr><td>
<div class="row cells2">
	<div class="cell">
		<label>Tahun Masuk</label>
		<div class="form-group">
			<?= $keterangan ?>
		</div>
	</div>

	<div class="cell">
		<label>Program Studi</label>
		<div class="form-group">
			<?= $nama_konsentrasi ?>
		</div>
	</div>
</div>
</td></tr>
</table>
</div>
</div>
</div>
</div>