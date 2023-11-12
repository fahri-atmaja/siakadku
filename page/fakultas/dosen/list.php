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
<form name="jadwal" action="list_absensi.php" method="POST">
<h1>
<a href="<?= $_url ?><?= in_array($_access, array('admin','dosen')) ? 'dashboard' : '' ?>" class="nav-button transform"><span></span></a>
Jadwal Ajar Dosen
</h1>
<?php
	$sql = "select jk.*,ak.nama_konsentrasi,ah.hari,mm.nama_makul,ad.nama_lengkap
			FROM akademik_jadwal_kuliah as jk,akademik_konsentrasi as ak,makul_matakuliah as mm,app_dosen as ad,app_hari as ah
			WHERE jk.hari_id=ah.hari_id and jk.konsentrasi_id=ak.konsentrasi_id and jk.makul_id=mm.makul_id and jk.dosen_id=ad.dosen_id and ad.nip='{$_username}'
			ORDER BY jk.hari_id ASC";		
	$query = mysqli_query($koneksi, $sql);
	
?>

<table class="table striped hovered border bordered">
	<thead>
		<tr>
			<th>No</th>
			<th>ID Jadwal</th>
			<th>Prodi/Konsentrasi</th>
			<th>Matakuliah</th>
			<th>Dosen Pengajar</th>
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
			<td><?= $field['jadwal_id'] ?></td>
			<td><?= $field['nama_konsentrasi'] ?></td>
			<td><?= $field['nama_makul'] ?></td>
			<td><?= $field['nama_lengkap'] ?></td>
			<td><?= $field['semester'] ?></td>
			<td><?= $field['hari'] ?></td>
			<td><?= $field['jam_mulai'] ?></td>
			<td>
				<div class="inline-block">
					<button class="button mini-button dropdown-toggle">Aksi</button>
				<ul class="split-content d-menu" data-role="dropdown">
				<li><a href="<?= $_url ?>dosen/list_absensi/<?= $field['jadwal_id'] ?>/<?= urlencode($field['nama_makul']) ?>"><span class="mif-zoom-in"></span> View Absen</a></li>
				<li><a href="<?= $_url ?>dosen/form-penilaian/<?= $field['jadwal_id'] ?>/<?= urlencode($field['nama_makul']) ?>"><span class="mif-zoom-in"></span> View Nilai</a></li>
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
</form>