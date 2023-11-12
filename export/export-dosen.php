<?php
	$koneksi = mysqli_connect("localhost","smilefoo_siakad","Sina_atmaja666","smilefoo_siakad");
	$sql = "SELECT * FROM app_dosen ORDER BY nip ASC";
	$query = mysqli_query($koneksi, $sql);
?>
<?php
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=dosen.xls");
?>
<table class="table striped hovered border bordered">
	<thead>
		<tr>
			<th>Nip</th>
			<th>Nama</th>
			<th>Alamat</th>
			<th>Jenis Kelamin</th>
			<th>Gelar</th>
			<th></th>
		</tr>
	</thead>
	<tbody>

	<?php
		if (mysqli_num_rows($query) > 0):
			while($field = mysqli_fetch_array($query)):
	?>
		<tr>
			<td><?= $field['nip'] ?></td>
			<td><?= $field['nama_lengkap'] ?></td>
			<td><?= $field['alamat'] ?></td>
			<td><?= $field['gender'] ?></td>
			<td><?= $field['gelar_pendidikan'] ?></td>
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
		
	</tbody>
</table>