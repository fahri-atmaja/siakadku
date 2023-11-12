<style type="text/css">
	.input-control {
		border: 1px solid #d9d9d9;
		padding: 10px;
	}
</style>

<h1>
<a href="<?= $_url ?>" class="nav-button transform"><span></span></a>
ABSENSI JADWAL
</h1>
<a href="<?= $_url ?>dosen/cetak-absen/<?= $_id ?>" class="button success">Cetak</a>
<?php
	$sql = "select akrs.*, sm.nama FROM
			akademik_krs as akrs, student_mahasiswa as sm WHERE
			sm.nim=akrs.nim and akrs.jadwal_id='$_id'";
	$query = mysqli_query($koneksi, $sql);
	
	
?>
<table class="table striped hovered border bordered">
	<thead>
		<tr>
			<th>NO</th>
			<th>NIM</th>
			<th>NAMA MAHASISWA</th>
			<th>STATUS DOSEN WALI</th>
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
			<td><?= $field['accept']==1?'Sudah disetujui':'Belum disetujui'; ?></td>
			<td></td>
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