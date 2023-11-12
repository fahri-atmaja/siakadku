<style type="text/css">
	.input-control {
		border: 1px solid #d9d9d9;
		padding: 10px;
	}
</style>
<div class="container">
<h1>
<a href="<?= $_url ?>dosen/list" class="nav-button transform"><span></span></a>
INPUT NILAI MAHASISWA
</h1>

<div class="row">
    <div class="cell">
    <a href="<?= $_url ?>dosen/cetak-nilai/<?= $_id ?>" class="button success">Cetak</a>
    <a href="<?= $_url ?>dosen/publish-all/<?= $_id ?>" class="button primary">Publish All (Beta Test)</a>
    <p>*) "Publish All" dapat digunakan jika semua status KRS Mahasiswa sudah disetujui</p>
    </div>
</div>
<?php
	$sql = "Select akademik_krs.*,akademik_khs.confirm, akademik_khs.kehadiran, akademik_khs.tugas, 
	        akademik_khs.praktik, akademik_khs.mutu, akademik_khs.mutu2, akademik_khs.nilai_akhir, 
	        akademik_khs.grade, student_mahasiswa.nama, akademik_konsentrasi.nama_konsentrasi FROM akademik_krs
			LEFT JOIN akademik_khs ON akademik_krs.krs_id=akademik_khs.krs_id
			LEFT JOIN student_mahasiswa ON student_mahasiswa.nim=akademik_krs.nim
			LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=student_mahasiswa.konsentrasi_id
			WHERE akademik_krs.jadwal_id='$_id' 
			order by akademik_krs.nim asc";
	$query = mysqli_query($koneksi, $sql);
?>
<div class="table-responsive-sm">
<table id="dtHorizontalExample" class="table table-striped table-bordered table-sm" cellspacing="0"
  width="100%">
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
			<th>AKSI</th>
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
			<td><div class="inline-block">
					<button class="button dropdown-toggle">Aksi</button>
				<ul class="split-content d-menu" data-role="dropdown">
				<li><a href="<?= $_url ?>dosen/publish-khs/<?= $field['krs_id'] ?>/<?= urlencode($field['accept']) ?>"><span class="mif-zoom-in"></span> PUBLISH NILAI</a></li>
					<li><a href="<?= $_url ?>dosen/unpublish-khs/<?= $field['krs_id'] ?>/<?= urlencode($field['accept']) ?>"><span class="mif-books"></span> UNPUBLISH NILAI</a></li>
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
</div>