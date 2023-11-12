<?php
	if ($_access == 'mahasiswa' && $_id != $_username) {
		header("location:{$_url}krs/view/{$_username}");
	}
?>
<style type="text/css">
	.input-control {
		border: 1px solid #d9d9d9;
		padding: 10px;
	}
</style>
<h1>
<a href="<?= $_url ?><?= in_array($_access, array('admin','dosen')) ? 'dashboard' : '' ?>" class="nav-button transform"><span></span></a>
Jadwal Ajar Dosen
</h1>
<?php
if (isset($_POST['submit'])){
    $semester = $_POST['semester'];
    $akademik = $_POST['akademik'];
	$sql = "select jk.*,akls.nama_kelas, ata.keterangan as tahun, ak.nama_konsentrasi,ah.hari,mm.nama_makul,ad.nama_lengkap
			FROM akademik_jadwal_kuliah as jk, akademik_tahun_akademik as ata,akademik_kelas as akls, akademik_konsentrasi as ak,makul_matakuliah as mm,app_dosen as ad,app_hari as ah
			WHERE jk.hari_id=ah.hari_id and jk.id_kelas=akls.id_kelas and jk.konsentrasi_id=ak.konsentrasi_id and ata.tahun_akademik_id=jk.tahun_akademik_id
			and jk.makul_id=mm.makul_id and jk.dosen_id=ad.dosen_id and ad.nip='{$_username}' and jk.semester='$semester' and ata.tahun_akademik_id='$akademik'
			ORDER BY ata.tahun_akademik_id ASC, ak.konsentrasi_id ASC, jk.hari_id ASC, jk.semester ASC";	
// 	$sql = "SELECT akademik_jadwal_kuliah.*, akademik_tahun_akademik.keterangan as tahun, akademik_kelas.nama_kelas, akademik_konsentrasi.nama_konsentrasi, app_hari.hari
// 	        , makul_matakuliah.nama_makul, app_dosen.nama_lengkap FROM akademik_jadwal_kuliah
// 	        LEFT JOIN app_hari ON app_hari.hari_id=akademik_jadwal_kuliah.hari_id
// 	        LEFT JOIN akademik_kelas ON akademik_kelas.id_kelas=akademik_jadwal_kuliah.id_kelas
// 	        LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=akademik_jadwal_kuliah.konsentrasi_id
// 	        RIGHT JOIN makul_matakuliah ON makul_matakuliah.makul_id=akademik_jadwal_kuliah.jadwal_id
// 	        LEFT JOIN app_dosen ON app_dosen.dosen_id=akademik_jadwal_kuliah.dosen_id
// 	        LEFT JOIN akademik_tahun_akademik ON akademik_tahun_akademik.tahun_akademik_id=akademik_jadwal_kuliah.tahun_akademik_id
// 	        WHERE app_dosen.nip='{$_username}' AND akademik_jadwal_kuliah.semester='$semester' AND akademik_tahun_akademik.tahun_akademik_id='$akademik'
// 	        ORDER BY akademik_tahun_akademik.tahun_akademik_id ASC, akademik_konsentrasi.konsentrasi_id ASC, akademik_jadwal_kuliah.semester ASC, app_hari.hari_id ASC";
	$query = mysqli_query($koneksi, $sql);
}else{
    // $sql = "SELECT akademik_jadwal_kuliah.*, akademik_tahun_akademik.keterangan as tahun, akademik_kelas.nama_kelas, akademik_konsentrasi.nama_konsentrasi, app_hari.hari
	   //     , makul_matakuliah.nama_makul, app_dosen.nama_lengkap FROM akademik_jadwal_kuliah
	   //     LEFT JOIN app_hari ON app_hari.hari_id=akademik_jadwal_kuliah.hari_id
	   //     LEFT JOIN akademik_kelas ON akademik_kelas.id_kelas=akademik_jadwal_kuliah.id_kelas
	   //     LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=akademik_jadwal_kuliah.konsentrasi_id
	   //     RIGHT JOIN makul_matakuliah ON makul_matakuliah.makul_id=akademik_jadwal_kuliah.jadwal_id
	   //     LEFT JOIN app_dosen ON app_dosen.dosen_id=akademik_jadwal_kuliah.dosen_id
	   //     LEFT JOIN akademik_tahun_akademik ON akademik_tahun_akademik.tahun_akademik_id=akademik_jadwal_kuliah.tahun_akademik_id
	   //     WHERE app_dosen.nip='{$_username}'
	   //     ORDER BY akademik_tahun_akademik.tahun_akademik_id ASC, akademik_konsentrasi.konsentrasi_id ASC, akademik_jadwal_kuliah.semester ASC, app_hari.hari_id ASC";
	$sql = "select jk.*,akls.nama_kelas, ata.keterangan as tahun, ak.nama_konsentrasi,ah.hari,mm.nama_makul,ad.nama_lengkap
			FROM akademik_jadwal_kuliah as jk, akademik_tahun_akademik as ata,akademik_kelas as akls, akademik_konsentrasi as ak,makul_matakuliah as mm,app_dosen as ad,app_hari as ah
			WHERE jk.hari_id=ah.hari_id and jk.id_kelas=akls.id_kelas and jk.konsentrasi_id=ak.konsentrasi_id and ata.tahun_akademik_id=jk.tahun_akademik_id
			and jk.makul_id=mm.makul_id and jk.dosen_id=ad.dosen_id and ad.nip='{$_username}'
			ORDER BY ata.tahun_akademik_id DESC, ak.konsentrasi_id ASC, jk.hari_id ASC, jk.semester ASC";
	$query = mysqli_query($koneksi, $sql);
}
?>
<div class="container-fluid">
<form method="POST">

    <div class="row">
    <label for="semester">Semester</label>
    </div>
    <div class="row">
    <select name="semester" id="semester" required>
        <option value="">-- pilih --</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="7">7</option>
        <option value="8">8</option>
    </select>
    </div>
    <div class="row">
        <label for="semester">Tahun Akademik</label>
        </div>
        <div class="row">
    <select name="akademik" id="akademik" required>
       <option value="">-- pilih --</option>
				<?php
					$result = mysqli_query($koneksi, "SELECT * FROM akademik_tahun_akademik");
					while ($row= mysqli_fetch_array($result)) {
					echo '<option name="akademik" value="' . $row['tahun_akademik_id'] . '">'. $row['keterangan'].'</option>';
				}
				?>
    </select>
    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
</div>

</form>
</div>
<div class="table-responsive-sm">
<table id="dtHorizontalExample" class="table table-striped table-bordered table-sm" cellspacing="0"
  width="100%">
	<thead>
		<tr>
			<th>No</th>
			<th>Tahun Akademik</th>
			<th>Prodi/Konsentrasi</th>
			<th>Matakuliah</th>
			<th>Kelas</th>
			<!--<th>Dosen Pengajar</th>-->
			<th>Semester</th>
			<th>Hari</th>
			<th>Jam Mulai</th>
			<th></th>
		</tr>
	</thead>
	<tbody>

	<?php
		$no=1;
		if (mysqli_num_rows($query) > 0):
			while($field = mysqli_fetch_array($query)):
	?>
	
		<tr>
			<td><?= $no++ ?></td>
			<td><?= $field['tahun'] ?></td>
			<td><?= $field['nama_konsentrasi'] ?></td>
			<td><b><?= $field['nama_makul'] ?></b></td>
			<td><b><?= $field['nama_kelas'] ?></b></td>
			<!--<td><?= $field['nama_lengkap'] ?></td>-->
			<td><?= $field['semester'] ?></td>
			<td><?= $field['hari'] ?></td>
			<td><?= $field['jam_mulai'] ?></td>
			<td>
				<div class="inline-block">
					<button class="button dropdown-toggle">Aksi</button>
				<ul class="split-content d-menu" data-role="dropdown">
				<!--<li><a href="<?= $_url ?>dosen/cetak-absen-mhs/<?= $field['jadwal_id'] ?>/<?= urlencode($field['nama_makul']) ?>"><span class="mif-zoom-in"></span> View Absen</a></li>-->
				<li><a href="<?= $_url ?>dosen/inputnilai/<?= $field['jadwal_id'] ?>/<?= urlencode($field['nama_makul']) ?>"><span class="mif-pencil"></span> Input Nilai</a></li>
				<li><a href="<?= $_url ?>dosen/form-penilaian/<?= $field['jadwal_id'] ?>/<?= urlencode($field['nama_makul']) ?>"><span class="mif-zoom-in"></span> Publish & View Nilai</a></li>
				</ul>
				</div>
			</td>
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
</div>
</form>