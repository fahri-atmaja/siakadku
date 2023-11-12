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
Jadwal Kuliahmu
</h1>


<?php

// 	$sql = "select jk.*,akrs.jadwal_id,ak.nama_konsentrasi,mm.nama_makul,ad.nama_lengkap,ah.hari,dj.nama_dos
// 			FROM akademik_jadwal_kuliah as jk,dosen_junior as dj,app_hari as ah,akademik_krs as akrs,akademik_konsentrasi as ak,makul_matakuliah as mm,app_dosen as ad
// 			WHERE jk.konsentrasi_id=ak.konsentrasi_id and jk.hari_id=ah.hari_id and jk.jadwal_id=akrs.jadwal_id
// 			and jk.makul_id=mm.makul_id and jk.dosen_id=ad.dosen_id and jk.dosen_id2=dj.dosen_id and akrs.nim='{$_id}'
// 			ORDER BY jk.hari_id ASC";
    // $sql = "SELECT akademik_jadwal_kuliah.*, akademik_konsentrasi.nama_konsentrasi, akademik_kelas.nama_kelas, makul_matakuliah.nama_makul, app_dosen.nama_lengkap, app_hari.hari, dosen_junior.nama_dos
    //     FROM akademik_jadwal_kuliah
    //     LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=akademik_jadwal_kuliah.konsentrasi_id
    //     LEFT JOIN akademik_kelas ON akademik_kelas.id_kelas=akademik_jadwal_kuliah.id_kelas
    //     LEFT JOIN makul_matakuliah ON makul_matakuliah.makul_id=akademik_jadwal_kuliah.makul_id
    //     LEFT JOIN app_dosen ON app_dosen.dosen_id=akademik_jadwal_kuliah.dosen_id
    //     LEFT JOIN dosen_junior ON dosen_junior.dosen_id=akademik_jadwal_kuliah.dosen_id2
    //     WHERE akademik_krs.jadwal_id=akademik_jadwal_kuliah.jadwal_id AND
    //     akademik_krs.nim='$_id'";
    $sql = "SELECT akademik_jadwal_kuliah.*,akademik_konsentrasi.nama_konsentrasi, akademik_kelas.nama_kelas, makul_matakuliah.nama_makul, app_dosen.nama_lengkap, dosen_junior.nama_dos, app_hari.hari FROM
            akademik_jadwal_kuliah
            LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=akademik_jadwal_kuliah.konsentrasi_id
            LEFT JOIN akademik_kelas ON akademik_kelas.id_kelas=akademik_jadwal_kuliah.id_kelas
            LEFT JOIN makul_matakuliah ON makul_matakuliah.makul_id=akademik_jadwal_kuliah.makul_id
            LEFT JOIN app_dosen ON app_dosen.dosen_id=akademik_jadwal_kuliah.dosen_id
            LEFT JOIN dosen_junior ON dosen_junior.dosen_id=akademik_jadwal_kuliah.dosen_id2
            LEFT JOIN app_hari ON app_hari.hari_id=akademik_jadwal_kuliah.hari_id
            LEFT JOIN akademik_krs ON akademik_krs.jadwal_id=akademik_jadwal_kuliah.jadwal_id
            WHERE akademik_krs.nim='$_id'";
	$query = mysqli_query($koneksi, $sql);
	
?>

<table class="table striped hovered border bordered">
	<thead>
		<tr>
			<th>No</th>
			<th>Prodi/Konsentrasi</th>
			<th>Kelas</th>
			<th>Matakuliah</th>
			<th>Dosen Pengajar</th>
			<th>Dosen Pengajar 2</th>
			<th>Semester</th>
			<th>Hari</th>
			<th>Jam Mulai</th>
			<th>Pertemuan</th>
		</tr>
	</thead>
	<tbody>

	<?php
		$no=1;
		if (mysqli_num_rows($query) > 0):
			while($field1 = mysqli_fetch_array($query)):
	?>
		<tr>
			<td><?= $no++ ?></td>
			<td><?= $field1['nama_konsentrasi'] ?></td>
			<td><?= $field1['nama_kelas'] ?></td>
			<td><?= $field1['nama_makul'] ?></td>
			<td><?= $field1['nama_lengkap'] ?></td>
			<td><?php if ($field1['nama_dos']==0){
				echo "Not Set";
				}else{
				echo $field1['nama_dos'];
			}  ?></td>
			<td><?= $field1['semester'] ?></td>
			<td><?= $field1['hari'] ?></td>
			<td><?= $field1['jam_mulai'] ?></td>
			<td><?= $field1['pertemuan'] ?></td>
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