<style type="text/css">
	.input-control {
		border: 1px solid #d9d9d9;
		padding: 10px;
	}
</style>

<h1>
<a href="<?= $_url ?>presensi_mahasiswa" class="nav-button transform"><span></span></a>
ABSENSI <?php echo $_params[1] ?>
</h1>
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
			<td><?= $field['accept']==1?'Sudah disetujui':'Belum disetujui'; ?></td>
			<td><div class="inline-block">
				    <button class="button mini-button dropdown-toggle">Aksi</button>
				    <ul class="split-content d-menu" data-role="dropdown">
						<li>
						<a href="<?= $_url ?>presensi_mahasiswa/absen/<?= $field['jadwal_id'] ?>/<?= urlencode($field['nim']) ?>"><span class="mif-pencil"></span> Absen Mahasiswa</a>
						</li>
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