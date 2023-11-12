<style type="text/css">
	.input-control {
		border: 1px solid #d9d9d9;
		padding: 10px;
	}
</style>

<h1>
<a href="<?= $_url ?>presensi_mahasiswa" class="nav-button transform"><span></span></a>
</h1>
<?php
	$sql = "SELECT makul_matakuliah.nama_makul, akademik_jadwal_kuliah.semester, app_dosen.nama_lengkap, akademik_tahun_akademik.keterangan 
	        FROM akademik_jadwal_kuliah
	        LEFT JOIN makul_matakuliah ON makul_matakuliah.makul_id=akademik_jadwal_kuliah.makul_id
	        LEFT JOIN app_dosen ON app_dosen.dosen_id=akademik_jadwal_kuliah.dosen_id
	        LEFT JOIN akademik_tahun_akademik ON akademik_tahun_akademik.tahun_akademik_id=akademik_jadwal_kuliah.tahun_akademik_id
	        WHERE akademik_jadwal_kuliah.jadwal_id='$_id'";
	$query = mysqli_query($koneksi, $sql);
	$f = mysqli_fetch_array($query);
?>
<h4><b>PRESENSI DOSEN</b></h4>
<table>
    <tr>
        <td>Mata Kuliah</td>
        <td>:</td>
        <td><?= $f['nama_makul'] ?></td>
    </tr>
    <tr>
        <td>Semester</td>
        <td>:</td>
        <td><?= $f['semester'] ?></td>
    </tr>
    <tr>
        <td>Pengampu</td>
        <td>:</td>
        <td><?= $f['nama_lengkap'] ?></td>
    </tr>
    <tr>
        <td>Tahun Akademik</td>
        <td>:</td>
        <td><?= $f['keterangan'] ?></td>
    </tr>
</table>

</center>
<table class="table striped hovered border bordered" align="center" width="100%">
	<thead>
	
		<tr>
			<th>No.</th>
			<th>Tanggal</th>
			<th>Pokok Bahasan dan Sumber</th>
			<th width='5%'>Jml MHS</th>
			<th width='10%'>Aksi</th>
		</tr>
	</thead>
	<tbody>
			<?php

	$sql1 = "select * from dosen_absen where jadwal_id='$_id'";
	$querya = mysqli_query($koneksi, $sql1);
		$no=1;
		if (mysqli_num_rows($querya) > 0):
			while($field1 = mysqli_fetch_array($querya)):
	?>
	
		<tr>
			<td><?= $no++ ?></td>
			<td><?= $field1['tanggalabsen'] ?></td>
			<td><?= $field1['materi'] ?></td>
			<td><?php
			    $load = mysqli_query($koneksi,"SELECT * FROM mhs_absen WHERE jadwal_id='$_id' AND pertemuan='$field1[pertemuan]' AND kehadiran='hadir'");
			    $cek = mysqli_num_rows($load);
			    echo $cek;
			?></td>
			<td><button class="button primary"><a href="<?= $_url ?>presensi_mahasiswa/edit_presensi_dosen/<?= $field1['absen_id'] ?>"><span class="icon mif-school"></span> Edit Presensi Dosen</a></button></td>
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