<?php
	if ($_access == 'mahasiswa' && $_id != $_username) {
		header("location:{$_url}krs/view/{$_username}");
	}
?>

<h1>
<a href="<?= $_url ?><?= in_array($_access, array('admin','dosen')) ? 'dashboard' : '' ?>" class="nav-button transform"><span></span></a>
Input Nilai
</h1>

<?php
	//$sql = "select jk.*,ak.nama_konsentrasi,mm.nama_makul,ad.nama_lengkap
	//		FROM akademik_jadwal_kuliah as jk,akademik_konsentrasi as ak,makul_matakuliah as mm,app_dosen as ad
	//		WHERE jk.konsentrasi_id=ak.konsentrasi_id and jk.makul_id=mm.makul_id and jk.dosen_id=ad.dosen_id and ad.nip='{$_username}'
	//		ORDER BY jk.hari_id ASC";
	
	$sql = "select akh.*,ak.krs_id,ak.semester,jk.jadwal_id,sm.nim,sm.nama,mm.nama_makul,ad.nama_lengkap
			FROM akademik_khs as akh, akademik_krs as ak, akademik_jadwal_kuliah as jk, student_mahasiswa as sm, makul_matakuliah as mm, app_dosen as ad
			WHERE akh.krs_id=ak.krs_id and ak.nim=sm.nim and ak.jadwal_id=jk.jadwal_id and jk.makul_id=mm.makul_id and sm.dosen_id=ad.dosen_id and ad.nip='$_username' and sm.nim='$_id'
			ORDER BY mm.nama_makul ASC";
	$query = mysqli_query($koneksi, $sql);
	
?>
<table class="table striped hovered border bordered">
	<thead>
		<tr>
			<th>No</th>
			<th>NIM</th>
			<th>Nama</th>
			<th>Matakuliah</th>
			<th>Dosen Pengajar</th>
			<th>Semester</th>
			<th>UTS</th>
			<th>UAS</th>
			<th>Kehadiran</th>
			<th>Tugas</th>
			<th>grade</th>

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
			<td><?= $field['nim'] ?></td>
			<td><?= $field['nama'] ?></td>
			<td><?= $field['nama_makul'] ?></td>
			<td><?= $field['nama_lengkap'] ?></td>
			<td><?= $field['semester'] ?></td>
			<td><?= $field['mutu'] ?></td>
			<td><?= $field['mutu2'] ?></td>
			<td><?= $field['kehadiran'] ?></td>
			<td><?= $field['tugas'] ?></td>
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