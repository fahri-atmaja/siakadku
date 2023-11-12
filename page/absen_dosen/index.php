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
<a href="<?= $_url ?><?= in_array($_access, array('admin','fakultas')) ? 'dashboard' : '' ?>" class="nav-button transform"><span></span></a>
Presensi Dosen
</h1>




<?php
	if ($_access == 'fakultas') {
		$sql1 ="SELECT akademik_jadwal_kuliah.*,akademik_konsentrasi.nama_konsentrasi,akademik_kelas.nama_kelas,makul_matakuliah.nama_makul, app_dosen.nama_lengkap, app_hari.hari, dosen_junior.nama_dos FROM akademik_jadwal_kuliah
        LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=akademik_jadwal_kuliah.konsentrasi_id
        LEFT JOIN akademik_kelas ON akademik_kelas.id_kelas=akademik_jadwal_kuliah.id_kelas
        LEFT JOIN makul_matakuliah ON makul_matakuliah.makul_id=akademik_jadwal_kuliah.makul_id
        LEFT JOIN app_dosen ON app_dosen.dosen_id=akademik_jadwal_kuliah.dosen_id
        LEFT JOIN dosen_junior ON dosen_junior.dosen_id=akademik_jadwal_kuliah.dosen_id2
        LEFT JOIN app_hari ON app_hari.hari_id=akademik_jadwal_kuliah.hari_id
        WHERE akademik_konsentrasi.nama_konsentrasi='$_username'";
	}
	elseif ($_access == 'dosen')
	{
	    $sql1 ="SELECT akademik_jadwal_kuliah.*,akademik_konsentrasi.nama_konsentrasi,akademik_kelas.nama_kelas,makul_matakuliah.nama_makul, app_dosen.nama_lengkap, app_hari.hari, dosen_junior.nama_dos FROM akademik_jadwal_kuliah
        LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=akademik_jadwal_kuliah.konsentrasi_id
        LEFT JOIN akademik_kelas ON akademik_kelas.id_kelas=akademik_jadwal_kuliah.id_kelas
        LEFT JOIN makul_matakuliah ON makul_matakuliah.makul_id=akademik_jadwal_kuliah.makul_id
        LEFT JOIN app_dosen ON app_dosen.dosen_id=akademik_jadwal_kuliah.dosen_id
        LEFT JOIN dosen_junior ON dosen_junior.dosen_id=akademik_jadwal_kuliah.dosen_id2
        LEFT JOIN app_hari ON app_hari.hari_id=akademik_jadwal_kuliah.hari_id
        WHERE app_dosen.nip='$_username'";
	}
	elseif ($_access == 'yayasan')
	{
	    $sql1 ="SELECT akademik_jadwal_kuliah.*,akademik_konsentrasi.nama_konsentrasi,akademik_kelas.nama_kelas,makul_matakuliah.nama_makul, app_dosen.nama_lengkap, app_hari.hari, dosen_junior.nama_dos FROM akademik_jadwal_kuliah
        LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=akademik_jadwal_kuliah.konsentrasi_id
        LEFT JOIN akademik_kelas ON akademik_kelas.id_kelas=akademik_jadwal_kuliah.id_kelas
        LEFT JOIN makul_matakuliah ON makul_matakuliah.makul_id=akademik_jadwal_kuliah.makul_id
        LEFT JOIN app_dosen ON app_dosen.dosen_id=akademik_jadwal_kuliah.dosen_id
        LEFT JOIN dosen_junior ON dosen_junior.dosen_id=akademik_jadwal_kuliah.dosen_id2
        LEFT JOIN app_hari ON app_hari.hari_id=akademik_jadwal_kuliah.hari_id
        ORDER BY akademik_konsentrasi.konsentrasi_id ASC, akademik_jadwal_kuliah.semester ASC";
	}
	else
	{
	$sql1 = "select jk.*,ak.nama_konsentrasi,mm.nama_makul,ad.nama_lengkap,ah.hari,adj.nama_dos
			FROM akademik_jadwal_kuliah as jk,app_hari as ah,akademik_konsentrasi as ak,makul_matakuliah as mm,app_dosen as ad,
			dosen_junior as adj
			WHERE jk.konsentrasi_id=ak.konsentrasi_id and jk.hari_id=ah.hari_id
			and jk.makul_id=mm.makul_id and jk.dosen_id=ad.dosen_id and jk.dosen_id2=adj.dosen_id
			ORDER BY ak.nama_konsentrasi ASC, jk.semester ASC";	
			}	
	$query1 = mysqli_query($koneksi, $sql1);
	
?>

<table class="table striped hovered border bordered">
	<thead>
		<tr>
			<th>No</th>
			<th>Prodi/Konsentrasi</th>
			<th>Matakuliah</th>
			<th>Kelas</th>
			<th>Dosen Pengajar</th>
			<th>Dosen Pengajar 2</th>
			<th>Semester</th>
			<th>Hari</th>
			<th>Jam Mulai</th>
			<th>Pertemuan</th>
			<th></th>
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
			<td><?= $field1['nama_konsentrasi'] ?></td>
			<td><?= $field1['nama_makul'] ?></td>
			<td><?= $field1['nama_kelas'] ?></td>
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
			<td>
				<div class="inline-block">
				  <!--  <button class="button mini-button dropdown-toggle">Aksi</button>-->
				  <!--  <ul class="split-content d-menu" data-role="dropdown">-->
						
						<!--<li><a href="<?= $_url ?>dosen/list_absensi/<?= $field1['jadwal_id'] ?>/<?= urlencode($field1['nama_makul']) ?>"><span class="mif-zoom-in"></span> View Presensi Mahasiswa</a></li>-->
						<!--<li><a href="<?= $_url ?>dosen/cetak-gasal/<?= $field1['jadwal_id'] ?>/<?= urlencode($field1['nama_makul']) ?>"><span class="mif-zoom-in"></span> Cetak Presensi Gasal</a></li>-->
						<!--<li><a href="<?= $_url ?>dosen/cetak-genap/<?= $field1['jadwal_id'] ?>/<?= urlencode($field1['nama_makul']) ?>"><span class="mif-zoom-in"></span> Cetak Presensi Genap</a></li>-->
					
				  <!--  </ul>-->
				  <li><a href="<?= $_url ?>absen_dosen/absen/<?= $field1['jadwal_id'] ?>/<?= urlencode($field1['nama_makul']) ?>"><span class="mif-pencil"></span>Isi Jurnal Dosen</a></li>
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
<p>*Note : Kolom Pertemuan adalah jumlah pertemuan yang harus dilunasi. </p>

