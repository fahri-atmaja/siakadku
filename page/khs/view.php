<?php
	if ($_access == 'mahasiswa' && $_id != $_username) {
		header("location:{$_url}khs/view/{$_username}");
	}
?>
<style type="text/css">
	.input-control {
		border: 1px solid #d9d9d9;
		padding: 10px;
	}
</style>

<h1>
<a href="<?= $_url ?>" class="nav-button transform"><span></span></a>
KHS Mahasiswa
</h1>

<?php
if($_access == 'fakultas'){
  $querya = mysqli_query($koneksi, "SELECT student_mahasiswa.*, student_angkatan.keterangan,akademik_konsentrasi.nama_konsentrasi as nama_konsentrasi FROM student_mahasiswa 
	LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=student_mahasiswa.konsentrasi_id
	LEFT JOIN student_angkatan ON student_angkatan.angkatan_id=student_mahasiswa.angkatan_id
	WHERE nim='{$_id}'");
$field = mysqli_fetch_array($querya);
extract($field);  
}else{
$querya = mysqli_query($koneksi, "SELECT student_mahasiswa.*, student_angkatan.keterangan,akademik_konsentrasi.nama_konsentrasi as nama_konsentrasi FROM student_mahasiswa 
	LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=student_mahasiswa.konsentrasi_id
	LEFT JOIN student_angkatan ON student_angkatan.angkatan_id=student_mahasiswa.angkatan_id
	WHERE nim='{$_username}'");
$field = mysqli_fetch_array($querya);
extract($field);
}
if($_access == 'dosen'){
  $querya = mysqli_query($koneksi, "SELECT student_mahasiswa.*, student_angkatan.keterangan,akademik_konsentrasi.nama_konsentrasi as nama_konsentrasi FROM student_mahasiswa 
	LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=student_mahasiswa.konsentrasi_id
	LEFT JOIN student_angkatan ON student_angkatan.angkatan_id=student_mahasiswa.angkatan_id
	WHERE nim='{$_id}'");
$field = mysqli_fetch_array($querya);
extract($field);  
}else{
$querya = mysqli_query($koneksi, "SELECT student_mahasiswa.*, student_angkatan.keterangan,akademik_konsentrasi.nama_konsentrasi as nama_konsentrasi FROM student_mahasiswa 
	LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=student_mahasiswa.konsentrasi_id
	LEFT JOIN student_angkatan ON student_angkatan.angkatan_id=student_mahasiswa.angkatan_id
	WHERE nim='{$_username}'");
$field = mysqli_fetch_array($querya);
extract($field);
}
if($_access == 'admin'){
  $querya = mysqli_query($koneksi, "SELECT student_mahasiswa.*, student_angkatan.keterangan,akademik_konsentrasi.nama_konsentrasi as nama_konsentrasi FROM student_mahasiswa 
	LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=student_mahasiswa.konsentrasi_id
	LEFT JOIN student_angkatan ON student_angkatan.angkatan_id=student_mahasiswa.angkatan_id
	WHERE nim='{$_id}'");
$field = mysqli_fetch_array($querya);
extract($field);  
}else{
$querya = mysqli_query($koneksi, "SELECT student_mahasiswa.*, student_angkatan.keterangan,akademik_konsentrasi.nama_konsentrasi as nama_konsentrasi FROM student_mahasiswa 
	LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=student_mahasiswa.konsentrasi_id
	LEFT JOIN student_angkatan ON student_angkatan.angkatan_id=student_mahasiswa.angkatan_id
	WHERE nim='{$_username}'");
$field = mysqli_fetch_array($querya);
extract($field);
}
?>


<div class="grid">

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

<div class="row cells2">
	<div class="cell">
		<label>Tahun Angkatan</label>
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
<div class="row cells2">
	<div class="cell">
		<label>Pilih Semester</label>
		<div class="container">
		<div class="form-group">
		    <form method="POST">
		    <select name="semester" id="semester">
		        <option>-- Pilih Semester --</option>
		        <option>1</option>
		        <option>2</option>
		        <option>3</option>
		        <option>4</option>
		        <option>5</option>
		        <option>6</option>
		        <option>7</option>
		        <option>8</option>
		    </select>
		    <button type="submit" name="submit" class="button primary">Generate</button>
		    </form>
		    </div>
		</div>
	</div>

</div>
<p><b>note: * Nilai akan muncul ketika dosen sudah mempublish nilai anda.<br>
        tanyakan kepada dosen pengajar jika tidak ditemukan nilai sesuai di KRS atau yang kurang cocok.</b></p>
        <br>
<?php
    if (isset($_POST['submit'])){
    $sem = $_POST['semester'];
	$sql = "select kh.grade,mm.kode_makul,mm.nama_makul,mm.sks,ad.nama_lengkap,kh.mutu,kh.mutu2,kh.confirm,kh.khs_id,kh.kehadiran,kh.tugas
                            FROM makul_matakuliah as mm,akademik_jadwal_kuliah as jk,akademik_krs as ak,
                            app_dosen as ad,akademik_khs as kh
                            WHERE mm.makul_id=jk.makul_id and ad.dosen_id=jk.dosen_id and jk.jadwal_id=ak.jadwal_id 
                            and ak.nim='$nim' and kh.krs_id=ak.krs_id and kh.confirm='1' and ak.konversi='$sem'";
	$query = mysqli_query($koneksi, $sql);
	$no=1;
?>
		<label>Semester : <?= $sem ?></label><br>
			
<a target="_BLANK" href="<?= $_url ?>khs/laporan-khs/<?= $_id ?>/<?= $sem ?>" class="button success">Cetak / Detail</a>
<table class="table striped hovered border bordered">
	<thead>
		<tr>
			<th>No</th>
			<th>Kode Makul</th>
			<th>Matakuliah</th>
			<th>Dosen Pengampu</th>
			<th>SKS</th>
			<th>Kehadiran</th>
			<th>Tugas</th>
			<th>UTS</th>
			<th>UAS</th>
			<th>Grade</th>
		</tr>
	</thead>
	<tbody>

	<?php
		if (mysqli_num_rows($query) > 0):
			while($field = mysqli_fetch_array($query)):
	?>
		<tr>
			<td><?= $no++ ?></td>
			<td><?= $field['kode_makul'] ?></td>
			<td><?= $field['nama_makul'] ?></td>
			<td><?= $field['nama_lengkap'] ?></td>
			<td><?= $field['sks'] ?></td>
			<td><?= $field['kehadiran'] ?></td>
			<td><?= $field['tugas'] ?></td>
			<td><?= $field['mutu'] ?></td>
			<td><?= $field['mutu2'] ?></td>
			<td><?= $field['grade'] ?></td>
		</tr>
	<?php
			endwhile;
		else:
	?>
		<tr>
			<td colspan="4">
			Data tidak ditemukan
			</td>
		</tr>
	<?php
		endif;
	?>
		
	</tbody>
</table>
<?php
}
?>