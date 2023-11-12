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
	.scrollme {
    overflow-x: auto;
}
</style>

<h1>
<a href="<?= $_url ?><?= in_array($_access, array('admin','fakultas')) ? 'dashboard' : '' ?>" class="nav-button transform"><span></span></a>
Presensi Mahasiswa
</h1>
<form method="GET">
    <label>Cari Makul</label>
    <input type="text" name="cari" id="cari">
    <button type="submit">Cari</button>
</form>



<?php
if(isset($_GET['cari'])){
	$cari = $_GET['cari'];
	echo "<b>Hasil pencarian : ".$cari."</b>";
}
	if ($_access == 'fakultas') {
	    if(isset($_GET['cari'])){
		$cari = $_GET['cari'];
		$sql1 ="SELECT akademik_jadwal_kuliah.*,akademik_konsentrasi.nama_konsentrasi,akademik_kelas.nama_kelas,makul_matakuliah.nama_makul,
		app_dosen.nama_lengkap, app_hari.hari, dosen_junior.nama_dos, akademik_tahun_akademik.keterangan
		FROM akademik_jadwal_kuliah
        LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=akademik_jadwal_kuliah.konsentrasi_id
        LEFT JOIN akademik_kelas ON akademik_kelas.id_kelas=akademik_jadwal_kuliah.id_kelas
        LEFT JOIN makul_matakuliah ON makul_matakuliah.makul_id=akademik_jadwal_kuliah.makul_id
        LEFT JOIN app_dosen ON app_dosen.dosen_id=akademik_jadwal_kuliah.dosen_id
        LEFT JOIN dosen_junior ON dosen_junior.dosen_id=akademik_jadwal_kuliah.dosen_id2
        LEFT JOIN app_hari ON app_hari.hari_id=akademik_jadwal_kuliah.hari_id
        LEFT JOIN akademik_tahun_akademik ON akademik_tahun_akademik.tahun_akademik_id=akademik_jadwal_kuliah.tahun_akademik_id
        WHERE akademik_konsentrasi.nama_konsentrasi='$_username' AND akademik_tahun_akademik.status='y' AND nama_makul like '%$cari%'
        ORDER BY akademik_jadwal_kuliah.tahun_akademik_id DESC";	
	}else{
	    $sql1 ="SELECT akademik_jadwal_kuliah.*,akademik_konsentrasi.nama_konsentrasi,akademik_kelas.nama_kelas,makul_matakuliah.nama_makul,
	    app_dosen.nama_lengkap, app_hari.hari, dosen_junior.nama_dos, akademik_tahun_akademik.keterangan
	    FROM akademik_jadwal_kuliah
        LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=akademik_jadwal_kuliah.konsentrasi_id
        LEFT JOIN akademik_kelas ON akademik_kelas.id_kelas=akademik_jadwal_kuliah.id_kelas
        LEFT JOIN makul_matakuliah ON makul_matakuliah.makul_id=akademik_jadwal_kuliah.makul_id
        LEFT JOIN app_dosen ON app_dosen.dosen_id=akademik_jadwal_kuliah.dosen_id
        LEFT JOIN dosen_junior ON dosen_junior.dosen_id=akademik_jadwal_kuliah.dosen_id2
        LEFT JOIN app_hari ON app_hari.hari_id=akademik_jadwal_kuliah.hari_id
        LEFT JOIN akademik_tahun_akademik ON akademik_tahun_akademik.tahun_akademik_id=akademik_jadwal_kuliah.tahun_akademik_id
        WHERE akademik_konsentrasi.nama_konsentrasi='$_username' AND akademik_tahun_akademik.status='y'
        ORDER BY akademik_jadwal_kuliah.tahun_akademik_id DESC";
	}
	}
	if ($_access == 'dosen'){
	     if(isset($_GET['cari'])){
		$cari = $_GET['cari'];
		$sql1 ="SELECT akademik_jadwal_kuliah.*,akademik_konsentrasi.nama_konsentrasi,akademik_kelas.nama_kelas,makul_matakuliah.nama_makul,
		app_dosen.nama_lengkap, app_hari.hari, dosen_junior.nama_dos , akademik_tahun_akademik.keterangan
		FROM akademik_jadwal_kuliah
        LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=akademik_jadwal_kuliah.konsentrasi_id
        LEFT JOIN akademik_kelas ON akademik_kelas.id_kelas=akademik_jadwal_kuliah.id_kelas
        LEFT JOIN makul_matakuliah ON makul_matakuliah.makul_id=akademik_jadwal_kuliah.makul_id
        LEFT JOIN app_dosen ON app_dosen.dosen_id=akademik_jadwal_kuliah.dosen_id
        LEFT JOIN dosen_junior ON dosen_junior.dosen_id=akademik_jadwal_kuliah.dosen_id2
        LEFT JOIN app_hari ON app_hari.hari_id=akademik_jadwal_kuliah.hari_id
        LEFT JOIN akademik_tahun_akademik ON akademik_tahun_akademik.tahun_akademik_id=akademik_jadwal_kuliah.tahun_akademik_id
        WHERE app_dosen.nip='$_username' AND akademik_tahun_akademik.status='y' AND nama_makul like '%$cari%' ORDER BY akademik_jadwal_kuliah.hari_id ASC";	
	}else{
	    $sql1 ="SELECT akademik_jadwal_kuliah.*,akademik_konsentrasi.nama_konsentrasi,akademik_kelas.nama_kelas,makul_matakuliah.nama_makul,
		app_dosen.nama_lengkap, app_hari.hari, dosen_junior.nama_dos , akademik_tahun_akademik.keterangan
		FROM akademik_jadwal_kuliah
        LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=akademik_jadwal_kuliah.konsentrasi_id
        LEFT JOIN akademik_kelas ON akademik_kelas.id_kelas=akademik_jadwal_kuliah.id_kelas
        LEFT JOIN makul_matakuliah ON makul_matakuliah.makul_id=akademik_jadwal_kuliah.makul_id
        LEFT JOIN app_dosen ON app_dosen.dosen_id=akademik_jadwal_kuliah.dosen_id
        LEFT JOIN dosen_junior ON dosen_junior.dosen_id=akademik_jadwal_kuliah.dosen_id2
        LEFT JOIN app_hari ON app_hari.hari_id=akademik_jadwal_kuliah.hari_id
        LEFT JOIN akademik_tahun_akademik ON akademik_tahun_akademik.tahun_akademik_id=akademik_jadwal_kuliah.tahun_akademik_id
        WHERE app_dosen.nip='$_username' AND akademik_tahun_akademik.status='y' ORDER BY akademik_jadwal_kuliah.hari_id ASC";
	}	

	 }
		$query1 = mysqli_query($koneksi, $sql1);
?>

<div class="table-responsive">
<table id="dtHorizontalExample" class="table table-striped table-bordered table-sm" cellspacing="0"
  width="100%">
	<thead>
		<tr>
		    <th></th>
			<th>No</th>
			<th>Tahun Akademik</th>
			<th>Prodi</th>
			<th>Matakuliah</th>
			<th>Kelas</th>
			<th>Semester</th>
			<!--<th>Dosen Pengajar</th>-->
			<!--<th>Dosen Pengajar 2</th>-->
			
			<th>Hari</th>
			<th>Jam Mulai</th>
			<th>Pertemuan</th>
			
		</tr>
	</thead>
	<tbody>

	<?php
		$no=1;
		if (mysqli_num_rows($query1) > 0):
			while($field1 = mysqli_fetch_array($query1)):
	?>
		<tr>
		    <td>
				<div class="inline-block">
				    <button class="button dropdown-toggle">Aksi</button>
				    <ul class="split-content d-menu" data-role="dropdown">
				        <li><a href="<?= $_url ?>presensi_mahasiswa/absensi/<?= $field1['jadwal_id'] ?>/<?= urlencode($field1['nama_makul']) ?>"><span class="icon mif-school"></span> Absensi Realtime Mahasiswa</a></li>
						<li>
						<li><a href="<?= $_url ?>presensi_mahasiswa/absensi-susulan/<?= $field1['jadwal_id'] ?>/<?= urlencode($field1['nama_makul']) ?>"><span class="icon mif-school"></span> Absensi Susulan Mahasiswa</a></li>
						<li><a href="<?= $_url ?>presensi_mahasiswa/rekap_absen/<?= $field1['jadwal_id'] ?>/<?= urlencode($field1['nama_makul']) ?>"><span class="icon mif-school"></span> View Presensi Dosen</a></li>
						<li><a target="_blank" href="<?= $_url ?>presensi_mahasiswa/cetak-gasal/<?= $field1['jadwal_id'] ?>/<?= urlencode($field1['nama_makul']) ?>"><span class="mif-zoom-in"></span> Cetak Presensi 1-8</a></li>
						<li><a target="_blank" href="<?= $_url ?>presensi_mahasiswa/cetak-genap/<?= $field1['jadwal_id'] ?>/<?= urlencode($field1['nama_makul']) ?>"><span class="mif-zoom-in"></span> Cetak Presensi 9-16</a></li>
						<li><a href="<?= $_url ?>presensi_mahasiswa/edit_rekap_absen/<?= $field1['jadwal_id'] ?>/<?= urlencode($field1['nama_makul']) ?>"><span class="icon mif-school"></span> Edit Bahasan Dosen</a></li>
						<li><a target="_blank" href="<?= $_url ?>presensi_mahasiswa/cetak-uts/<?= $field1['jadwal_id'] ?>/<?= urlencode($field1['nama_makul']) ?>"><span class="icon mif-books"></span> Cetak Presensi UTS</a></li>
						<li><a target="_blank" href="<?= $_url ?>presensi_mahasiswa/cetak-uas/<?= $field1['jadwal_id'] ?>"><span class="icon mif-books"></span> Cetak Presensi UAS</a></li>
					
				    </ul>
				</div>
			</td>
			<td><?= $no++ ?></td>
			<td><?= $field1['keterangan'] ?></td>
			<td><?= $field1['nama_konsentrasi'] ?></td>
			<td><?= $field1['nama_makul'] ?></td>
			<td><?= $field1['nama_kelas'] ?></td>
			<td><?= $field1['semester'] ?></td>
			<!--<td><?= $field1['nama_lengkap'] ?></td>-->
			<!--<td>-->
			<?php 
// 			if ($field1['nama_dos']==0){
// 				echo "Not Set";
// 				}else{
// 				echo $field1['nama_dos'];
// 			}  
			?>
			<!--</td>-->
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
</div>
