<?php
	if ($_access == 'mahasiswa' && $_id != $_username) {
		header("location:{$_url}krs/view/{$_username}");
	}
?>
<?php
$idjadwal=$_POST['jadwal_id'];
?>
<style type="text/css">
	.input-control {
		border: 1px solid #d9d9d9;
		padding: 10px;
	}
</style>

<h1>
<a href="<?= $_url ?><?= in_array($_access, array('admin','dosen')) ? 'dashboard' : '' ?>" class="nav-button transform"><span></span></a>
ABSENSI JADWAL
</h1>

<?php
	$sql = "select jk.*,ak.nama_konsentrasi,mm.nama_makul,ad.nama_lengkap
			FROM akademik_jadwal_kuliah as jk,akademik_konsentrasi as ak,makul_matakuliah as mm,app_dosen as ad
			WHERE jk.konsentrasi_id=ak.konsentrasi_id and jk.makul_id=mm.makul_id and jk.dosen_id=ad.dosen_id and ad.nip='{$_username}'
			ORDER BY jk.hari_id ASC";		
	$query = mysqli_query($koneksi, $sql);
	
?>
<input type="text" name="jadwal_id" value="<?php echo $idjadwal ?>">
<table class="table striped hovered border bordered">
	<thead>
		<tr>
			<th>No</th>
			<th>ID Jadwal</th>
			<th>Prodi/Konsentrasi</th>
			<th>Matakuliah</th>
			<th>Dosen Pengajar</th>
			<th>Semester</th>
			<th>ID Hari</th>
			<th>Jam Mulai</th>
			<th></th>
		</tr>
	</thead>
	<tbody>

	<?php
		if (mysqli_num_rows($query) > 0):
			while($field = mysqli_fetch_array($query)):
	?>
	<?php
	$no=1;
	?>
		<tr>
			<td><?= $no ?></td>
			<td><?= $field['jadwal_id'] ?></td>
			<td><?= $field['nama_konsentrasi'] ?></td>
			<td><?= $field['nama_makul'] ?></td>
			<td><?= $field['nama_lengkap'] ?></td>
			<td><?= $field['semester'] ?></td>
			<td><?= $field['hari_id'] ?></td>
			<td><?= $field['jam_mulai'] ?></td>
			<td>
				
					<a href="<?= $_url ?>krs/delete/<?= $nim ?>/<?= $field['krs_id'] ?>/<?= urlencode($field['nama_makul']) ?>"><span class="mif-cross"></span> Hapus </a>
				
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