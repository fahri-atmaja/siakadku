<?php
	if ($_access == 'mahasiswa' && $_id != $_username) {
		header("location:{$_url}fakultas/krs/view/{$_username}");
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
<a href="<?= $_url ?>fakultas/<?= in_array($_access, array('admin','dosen')) ? 'dashboard' : '' ?>" class="nav-button transform"><span></span></a>
Jadwal Kuliahmu
</h1>


<?php

	$sql = "select jk.*,akrs.jadwal_id,ak.nama_konsentrasi,mm.nama_makul,ad.nama_lengkap,ah.hari,dj.nama_dos
			FROM akademik_jadwal_kuliah as jk,dosen_junior as dj,app_hari as ah,akademik_krs as akrs,akademik_konsentrasi as ak,makul_matakuliah as mm,app_dosen as ad
			WHERE jk.konsentrasi_id=ak.konsentrasi_id and jk.hari_id=ah.hari_id and jk.jadwal_id=akrs.jadwal_id
			and jk.makul_id=mm.makul_id and jk.dosen_id=ad.dosen_id and jk.dosen_id2=dj.dosen_id and akrs.nim='{$_id}'
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
			<th>Dosen Pengajar 2</th>
			<th>Semester</th>
			<th>Hari</th>
			<th>Jam Mulai</th>
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
			<td><?= $field['nama_dos'] ?></td>
			<td><?= $field['semester'] ?></td>
			<td><?= $field['hari'] ?></td>
			<td><?= $field['jam_mulai'] ?></td>
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