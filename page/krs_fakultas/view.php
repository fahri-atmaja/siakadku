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
<a href="<?= $_url ?><?= in_array($_access, array('admin','dosen')) ? '' : '' ?>" class="nav-button transform"><span></span></a>
KRS Mahasiswa
</h1>

<?php
$querya = mysqli_query($koneksi, "SELECT student_mahasiswa.*, student_angkatan.keterangan, akademik_konsentrasi.nama_konsentrasi as nama_konsentrasi FROM student_mahasiswa 
	LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=student_mahasiswa.konsentrasi_id
	LEFT JOIN student_angkatan ON student_angkatan.angkatan_id=student_mahasiswa.angkatan_id
	WHERE nim='{$_id}'");
$field = mysqli_fetch_array($querya);
extract($field);
?>


<div class="grid">

<div class="row cells2">
	<div class="cell">
		<label>NIM</label>
		<div class="form-group">
			<?= $nim ?>
		</div>
	</div>
	
	<div class="cell">
		<label>Nama</label>
		<div class="form-group">
			<?= $nama ?>
		</div>
	</div>
</div>

<div class="row cells2">
	<div class="cell">
		<label>Semester</label>
		<div class="form-group">
			<?= $semester ?> 
		</div>
	</div>

	<div class="cell">
		<label>Program Studi</label>
		<div class="form-group">
			<?= $nama_konsentrasi ?>
		</div>
	</div>
</div>

</div>

<?php

$ququ= mysqli_query($koneksi,"select aktif_krs from student_mahasiswa where nim='$nim'");
$row= mysqli_fetch_array($ququ);
if ($row['aktif_krs']=="y"):
?>
<a href= "<?= $_url ?>krs/add-krs/<?= $_id ?>" class="button primary">Pilih Matakuliah</a>
<a href="<?= $_url ?>krs/laporan/<?= $_id ?>" class="button success">Cetak</a>
<?php
else:
?>
<p>PERIODE KRS DITUTUP</p>
<a href="<?= $_url ?>krs/laporan/<?= $_id ?>" class="button success">Cetak</a>
<?php
		endif;
?>	
<?php
	
	$sql = "SELECT akademik_krs.*, makul_matakuliah.kode_makul, makul_matakuliah.nama_makul, makul_matakuliah.sks, app_dosen.nama_lengkap FROM
        akademik_krs
        LEFT JOIN akademik_jadwal_kuliah ON akademik_jadwal_kuliah.jadwal_id=akademik_krs.jadwal_id
        LEFT JOIN makul_matakuliah ON makul_matakuliah.makul_id=akademik_jadwal_kuliah.makul_id
        LEFT JOIN app_dosen ON app_dosen.dosen_id=akademik_jadwal_kuliah.dosen_id
        WHERE akademik_krs.nim='$nim' AND akademik_jadwal_kuliah.semester='$semester'";

	$query = mysqli_query($koneksi, $sql);
?>
<table class="table striped hovered border bordered">
	<thead>
		<tr>
			<th>Kode</th>
			<th>Matakuliah</th>
			<th>SKS</th>
			<th>Dosen</th>
			<th>Disetujui</th>
			<th>Aksi</th>
		</tr>
	</thead>
	<tbody>
	<?php
		$sks=0;
		if (mysqli_num_rows($query) > 0):
			while($field = mysqli_fetch_array($query)):
				$sks=$sks+$field['sks'];
	?>
		<tr>
			<td><?= $field['makul_id'] ?></td>
			<td><?= $field['nama_makul'] ?></td>
			<td><?= $field['sks'] ?></td>
			<td><?= $field['nama_lengkap'] ?></td>
			<td><?= $field['accept']==1?'sudah disetujui':'belum disetujui'; ?></td>
			<td><?php
			$quququ = mysqli_query($koneksi,"Select accept from akademik_krs where nim='$nim'");
			$rowe= mysqli_fetch_array($quququ);
			if ($rowe['accept']==0): ?>
			<div class="inline-block">
				    <button class="button mini-button dropdown-toggle">Aksi</button>
				    <ul class="split-content d-menu" data-role="dropdown">
		
					<li><a href="<?= $_url ?>krs_fakultas/delete/<?= $_id ?>/<?= $field['krs_id'] ?>/<?= urlencode($field['nim']) ?>" class="place-right"><span class="mif-cross"> Hapus KRS </span></a></li>
					</ul>
			</div>
			<?php
			else:
			?>
			<p>Anda Sudah KRS</p>
				<?php endif; ?></td>
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
	<tfoot><tr><td colspan='2' align='right'>Total SKS yang ditempuh</td><td><?php 
			echo $sks ?></td><td colspan=3></td></tr></tfoot>
</table>