<h1>
<a href="<?= $_url ?>" class="nav-button transform"><span></span></a>
Dosen

</h1>

<?php
	$sql = "SELECT ad.*, ak.nama_konsentrasi FROM
			app_dosen as ad, akademik_konsentrasi as ak
			WHERE ad.konsentrasi_id=ak.konsentrasi_id AND ak.nama_konsentrasi='$_username' ORDER BY nip ASC";
	$query = mysqli_query($koneksi, $sql);
?>
<center>
		<a target="_blank" href="export/export-dosen.php">EXPORT KE EXCEL</a>
</center>
<table class="table striped hovered border bordered">
	<thead>
		<tr>
			<th>NIDN</th>
			<th>Nama</th>
			<th>Alamat</th>
			<th>Jenis Kelamin</th>
			<th>Gelar</th>
			<th>Prodi</th>
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
			<td><?= $field['nama_konsentrasi'] ?></td>
			<td>
				<div class="inline-block">
				    <button class="button mini-button dropdown-toggle">Aksi</button>
				    <ul class="split-content d-menu" data-role="dropdown">
						<li><a href="<?= $_url ?>dosen/view/<?= $field['nip'] ?>/<?= urlencode($field['nama_lengkap']) ?>"><span class="mif-zoom-in"></span> View</a></li>
					<!--	
						<li><a href="<?= $_url ?>dosen/edit/<?= $field['nip'] ?>/<?= urlencode($field['nama_lengkap']) ?>"><span class="mif-pencil"></span> Edit</a></li>
						<li><a href="<?= $_url ?>dosen/delete/<?= $field['nip'] ?>/<?= urlencode($field['nama_lengkap']) ?>"><span class="mif-cross"></span> Delete</a></li>
				    -->
					</ul>
				</div>
			</td>
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