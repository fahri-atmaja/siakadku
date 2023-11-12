
<?php
	$sql = "SELECT student_mahasiswa.*, student_angkatan.keterangan, akademik_konsentrasi.nama_konsentrasi FROM student_mahasiswa 
			LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=student_mahasiswa.konsentrasi_id
			LEFT JOIN student_angkatan ON student_angkatan.angkatan_id=student_mahasiswa.angkatan_id
			ORDER BY nim ASC";
	$query = mysqli_query($koneksi, $sql);
?>
<?php
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=mahasiswa.xls");
?>
<table>
		<tr>
			<th>NIM</th>
			<th>Nama</th>
			<th>TTL</th>
			<th>Program Studi</th>
			<th>Tahun Masuk</th>
			<th></th>
		</tr>

	<?php
		if (mysqli_num_rows($query) > 0):
			while($field = mysqli_fetch_array($query)):
	?>
		<tr>
			<td><?= $field['nim'] ?></td>
			<td><?= $field['nama'] ?></td>
			<td><?= $field['tempat_lahir'] ?>, <?= tgl_indo($field['tanggal_lahir']) ?></td>
			<td><?= $field['nama_konsentrasi'] ?></td>
			<td><?= $field['keterangan'] ?></td>
		</tr>
	<?php
			endwhile;
		else:
	?>
		<tr>
			<td colspan="6">
			Data tidak ditemukan
			</td>
		</tr>
	<?php
		endif;
	?>
		
</table>