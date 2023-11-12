<?php
	if ($_access == 'mahasiswa' && $_id != $_username) {
		header("location:{$_url}krs/view/{$_username}");
	}
?>

<style type="text/css">
	.input-control {
		border: 1px solid #d9d9d9;
		padding: 1px;
	}
</style>

<h1>
<a href="<?= $_url ?><?= in_array($_access, array('admin','dosen','fakultas')) ? '' : '' ?>" class="nav-button transform"><span></span></a>
Jadwal UAS
</h1>


<?php

// 	$sql1 = "select jk.*,akls.nama_kelas,mm.nama_makul,ad.nama_lengkap,ah.hari,adj.nama_dos
// 			FROM akademik_jadwal_kuliah as jk,akademik_kelas as akls,app_hari as ah,akademik_konsentrasi as ak,makul_matakuliah as mm,app_dosen as ad,
// 			dosen_junior as adj
// 			WHERE jk.konsentrasi_id=ak.konsentrasi_id and jk.id_kelas=akls.id_kelas and jk.hari_id=ah.hari_id
// 			and jk.makul_id=mm.makul_id and jk.dosen_id=ad.dosen_id and jk.dosen_id2=adj.dosen_id and ak.nama_konsentrasi='$_username'
// 			ORDER BY jk.hari_id ASC, ak.nama_konsentrasi ASC, jk.semester ASC, jk.id_kelas ASC";	
    $sql1 ="SELECT akademik_jadwal_kuliah.*,akademik_kelas.nama_kelas,makul_matakuliah.nama_makul,makul_matakuliah.kelompok_id, app_dosen.nama_lengkap, app_hari.hari, dosen_junior.nama_dos FROM akademik_jadwal_kuliah
        LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=akademik_jadwal_kuliah.konsentrasi_id
        LEFT JOIN akademik_kelas ON akademik_kelas.id_kelas=akademik_jadwal_kuliah.id_kelas
        LEFT JOIN makul_matakuliah ON makul_matakuliah.makul_id=akademik_jadwal_kuliah.makul_id
        LEFT JOIN app_dosen ON app_dosen.dosen_id=akademik_jadwal_kuliah.dosen_id
        LEFT JOIN dosen_junior ON dosen_junior.dosen_id=akademik_jadwal_kuliah.dosen_id2
        LEFT JOIN app_hari ON app_hari.hari_id=akademik_jadwal_kuliah.hari_id
        WHERE akademik_konsentrasi.nama_konsentrasi='$_username' ORDER by makul_matakuliah.kelompok_id ASC, akademik_jadwal_kuliah.id_kelas ASC, app_hari.hari_id ASC ";
	$query1 = mysqli_query($koneksi, $sql1);
	
?>

<table class="table striped hovered border bordered">
	<thead>
		<tr>
			<th>No</th>
			<th>Kurikulum</th>
			<th>Kelas</th>
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
		if (mysqli_num_rows($query1) > 0):
			while($field1 = mysqli_fetch_array($query1)):
	?>
		<tr>
			<td><?= $no++ ?></td>
			<?php
			$kelompok = $field1['kelompok_id'];
			$load = mysqli_query($koneksi,"SELECT kode_kelompok FROM makul_kelompok where kelompok_id = '$kelompok'");
			$klmp = mysqli_fetch_array($load);
			?>
			<td><?= $klmp['kode_kelompok'] ?></td>
			<td><?= $field1['nama_kelas'] ?></td>
			<td><?= $field1['nama_makul'] ?></td>
			<td><?= $field1['nama_lengkap'] ?></td>
			<td><?php if ($field1['dosen_id2']==0){
				echo "Not Set";
				}else{
				echo $field1['nama_dos'];
			}  ?></td>
			<td><?= $field1['semester'] ?></td>
			<td><?= $field1['hari'] ?></td>
			<td><?= $field1['jam_mulai'] ?></td>
			<td>
				<div class="inline-block">
				    <button class="button dropdown-toggle">Aksi</button>
				    <ul class="split-content d-menu" data-role="dropdown">
						<li><a href="<?= $_url ?>fakultas/delete/<?= $field1['jadwal_id'] ?>"><span class="mif-cross"></span> Delete</a></li>
						<li><a href="<?= $_url ?>fakultas/edit/<?= $field1['jadwal_id'] ?>"><span class="mif-pencil"></span> Edit</a></li>
					
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
