<style type="text/css">
	.input-control {
		border: 1px solid #d9d9d9;
		padding: 10px;
	}
</style>

<h1>
<a href="<?= $_url ?>" class="nav-button transform"><span></span></a>
INPUT NILAI MAHASISWA
</h1>
<a href="<?= $_url ?>dosen/cetak-nilai/<?= $_id ?>" class="button success">Cetak</a>
<?php
	$sql = "select akrs.*, akh.kehadiran, akh.tugas, akh.mutu, akh.mutu2, akh.nilai_akhir, akh.grade, sm.nama, ak.nama_konsentrasi FROM
			akademik_krs as akrs, akademik_khs as akh, akademik_konsentrasi as ak, student_mahasiswa as sm WHERE
			akrs.krs_id=akh.krs_id and sm.nim=akrs.nim and sm.konsentrasi_id=ak.konsentrasi_id and akrs.jadwal_id='$_id'";
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
			<th>UTS</th>
			<th>UAS</th>
			<th>NILAI AKHIR</th>
			<th>GRADE</th>
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
			<td><?= $field['mutu'] ?></td>
			<td><?= $field['mutu2'] ?></td>
			<td><?= $field['nilai_akhir'] ?></td>
			<td><?= $field['grade'] ?></td>
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