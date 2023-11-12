

<style type="text/css">
	.input-control {
		border: 1px solid #d9d9d9;
		padding: 1px;
	}
</style>

<h1>
<a href="<?= $_url ?>" class="nav-button transform"><span></span></a>
Jadwal UAS
</h1>
<?php
        
    $sql1   = "SELECT jadwal_kuliah.tanggal, jadwal_kuliah.jam, app_ruangan.nama_ruangan, akademik_jadwal_kuliah.semester, akademik_jadwal_kuliah.jadwal_id, akademik_konsentrasi.nama_konsentrasi, akademik_kelas.nama_kelas,makul_matakuliah.nama_makul,app_dosen.nama_lengkap FROM jadwal_kuliah
        LEFT JOIN app_ruangan ON app_ruangan.ruangan_id=jadwal_kuliah.ruangan_id
        LEFT JOIN akademik_jadwal_kuliah ON akademik_jadwal_kuliah.jadwal_id=jadwal_kuliah.jadwal_id
        LEFT JOIN akademik_kelas ON akademik_kelas.id_kelas=akademik_jadwal_kuliah.id_kelas
        LEFT JOIN makul_matakuliah ON makul_matakuliah.makul_id=akademik_jadwal_kuliah.makul_id
        LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=akademik_jadwal_kuliah.konsentrasi_id
        LEFT JOIN app_dosen ON app_dosen.dosen_id=jadwal_kuliah.dosen_id
        WHERE app_dosen.nidn='$_username' ORDER BY jadwal_kuliah.tanggal DESC
        ";
	$query1 = mysqli_query($koneksi, $sql1);
	
?>

<table class="table striped hovered border bordered">
	<thead>
		<tr>
			<th>No</th>
			<th>Kelas</th>
			<th>Matakuliah</th>
			<th>Pengawas Ujian</th>
			<th>Semester</th>
			<th>Tanggal</th>
			<th>Jam Mulai</th>
			<th>Ruangan</th>
		</tr>
	</thead>
	<tbody>

	<?php
		$no=1;
		if (mysqli_num_rows($query1) > 0):
			while($field1 = mysqli_fetch_array($query1)):
	?>
		<tr>
			<td><?= $no++ ?></td>
			<td><?= $field1['nama_kelas'] ?></td>
			<td><?= $field1['nama_makul'] ?></td>
			<td><?= $field1['nama_lengkap'] ?></td>
			<td><?= $field1['semester'] ?></td>
			<td><?php echo tgl_indo($field1['tanggal']) ?></td>
			<td><?= $field1['jam'] ?></td>
			<td><?= $field1['nama_ruangan'] ?></td>
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