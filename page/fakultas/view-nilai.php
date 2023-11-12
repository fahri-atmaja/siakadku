<style type="text/css">
	.input-control {
		border: 1px solid #d9d9d9;
		padding: 10px;
	}
</style>
<div class="container">
<h1>
<a href="<?= $_url ?>fakultas/jadwal" class="nav-button transform"><span></span></a>
<?php
$t = mysqli_query($koneksi,"SELECT nama_makul FROM makul_matakuliah WHERE kode_makul='$_params[1]'");
$p = mysqli_fetch_array($t);
?>
DAFTAR NILAI MAHASISWA MATAKULIAH <?= $p['nama_makul'] ?>
</h1>

<div class="row">
    <div class="cell">
    <a href="<?= $_url ?>fakultas/cetak-nilai/<?= $_id ?>" class="button success">Cetak</a>
    <!--<a href="<?= $_url ?>dosen/publish-all/<?= $_id ?>" class="button primary">Publish All (Beta Test)</a>-->
    <!--<p>*) "Publish All" dapat digunakan jika semua status KRS Mahasiswa sudah disetujui</p>-->
    </div>
</div>
<?php
	$sql = "select akrs.*,akh.confirm, akh.kehadiran, akh.tugas, akh.praktik, akh.mutu, akh.mutu2, akh.nilai_akhir, akh.grade, sm.nama, ak.nama_konsentrasi FROM
			akademik_krs as akrs, akademik_khs as akh, akademik_konsentrasi as ak, student_mahasiswa as sm WHERE
			akrs.krs_id=akh.krs_id and sm.nim=akrs.nim and sm.konsentrasi_id=ak.konsentrasi_id and akrs.jadwal_id='$_id' order by akrs.nim asc";
	$query = mysqli_query($koneksi, $sql);
?>
<table class="table striped hovered border bordered">
	<thead>
		<tr>
			<th>NO</th>
			<th>NIM</th>
			<th>NAMA MAHASISWA</th>
			<th>JURUSAN</th>
			<th>STATUS</th>
			<th>KEHADIRAN</th>
			<th>TUGAS</th>
			<th>PRAKTIK</th>
			<th>UTS</th>
			<th>UAS</th>
			<th>NILAI AKHIR</th>
			<th>GRADE</th>
			<th>STATUS</th>
			<!--<th></th>-->
		</tr>
	</thead>
	<tbody>

	<?php
	$no=1;
		if (mysqli_num_rows($query) > 0):
			while($field = mysqli_fetch_array($query)):
	?>
	
		<tr>
			<td><?= $no ++ ?></td>
			<td><?= $field['nim'] ?></td>
			<td><?= $field['nama'] ?></td>
			<td><?= $field['nama_konsentrasi'] ?></td>
			<td><?= $field['accept']==1?'Sudah disetujui':'Belum disetujui'; ?></td>
			<td><?= $field['kehadiran'] ?></td>
			<td><?= $field['tugas'] ?></td>
			<td><?= $field['praktik'] ?></td>
			<td><?= $field['mutu'] ?></td>
			<td><?= $field['mutu2'] ?></td>
			<td><?= $field['nilai_akhir'] ?></td>
			<td><?= $field['grade'] ?></td>
			<td><?= $field['confirm']==2?'Unpublish':'Published'; ?></td>
			<!--<td><div class="inline-block">-->
			<!--		<button class="button dropdown-toggle">Aksi</button>-->
			<!--	<ul class="split-content d-menu" data-role="dropdown">-->
			<!--	<li><a href="<?= $_url ?>dosen/publish-khs/<?= $field['krs_id'] ?>/<?= urlencode($field['accept']) ?>"><span class="mif-zoom-in"></span> PUBLISH NILAI</a></li>-->
			<!--		<li><a href="<?= $_url ?>dosen/unpublish-khs/<?= $field['krs_id'] ?>/<?= urlencode($field['accept']) ?>"><span class="mif-books"></span> UNPUBLISH NILAI</a></li>-->
			<!--	</ul>-->
			<!--	</div>-->
			<!--</td>-->
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