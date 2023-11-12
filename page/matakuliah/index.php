<?php
	if ($_access == 'mahasiswa' && $_id != $_username) {
		header("location:{$_url}krs/view/{$_username}");
	}
?>
<h1>
<a href="<?= $_url ?>" class="nav-button transform"><span></span></a>
Matakuliah
<span class="place-right">
	<a href="<?= $_url ?>matakuliah/import" class="button">Import Matakuliah</a>
</span>
</h1>

<?php
if ($_access=='fakultas'){
	$sql = "SELECT makul_matakuliah.kode_makul, makul_matakuliah.nama_makul, makul_matakuliah.sks, makul_matakuliah.semester, akademik_konsentrasi.nama_konsentrasi, makul_kelompok.nama as kurikulum FROM makul_matakuliah 
	LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=makul_matakuliah.konsentrasi_id 
	LEFT JOIN makul_kelompok ON makul_kelompok.kelompok_id=makul_matakuliah.kelompok_id
	WHERE akademik_konsentrasi.nama_konsentrasi='$_username'";
	$query = mysqli_query($koneksi, $sql);
}else{
    $sql = "SELECT makul_matakuliah.kode_makul, makul_matakuliah.nama_makul, makul_matakuliah.sks, makul_matakuliah.semester, akademik_konsentrasi.nama_konsentrasi, makul_kelompok.nama as kurikulum FROM makul_matakuliah 
	LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=makul_matakuliah.konsentrasi_id 
	LEFT JOIN makul_kelompok ON makul_kelompok.kelompok_id=makul_matakuliah.kelompok_id";
	$query = mysqli_query($koneksi, $sql);
}
?>

<table class="table striped hovered border bordered">
	<thead>
		<tr>
			<th>Kode</th>
			<th>Nama</th>
			<th>SKS</th>
			<th>Semester</th>
			<th>Kelompok Kurikulum</th>
			<th>Program Studi</th>
			<th>Aksi</th>
		</tr>
	</thead>
	<tbody>

	<?php
		if (mysqli_num_rows($query) > 0):
			while($field = mysqli_fetch_array($query)):
	?>
		<tr>
			<td><?= $field['kode_makul'] ?></td>
			<td><?= $field['nama_makul'] ?></td>
			<td><?= $field['sks'] ?></td>
			<td><?= $field['semester'] ?></td>
			<td><?= $field['kurikulum'] ?></td>
			<td><?= $field['nama_konsentrasi'] ?></td>
			<td>
				<div class="inline-block">
				    <button class="button button dropdown-toggle">Aksi</button>
				    <ul class="split-content d-menu" data-role="dropdown">
				  <!--      <li><a href="<?= $_url ?>matakuliah/view-nilai/<?= $field['kode_makul'] ?>/<?= urlencode($field['nama_makul']) ?>">-->
						<!--<span class="mif-zoom-in"></span> View Nilai</a></li>-->
						<!--<li><a href="<?= $_url ?>matakuliah/view/<?= $field['kode_makul'] ?>/<?= urlencode($field['nama_makul']) ?>">-->
						<!--<span class="mif-zoom-in"></span> View</a></li>-->
						<li><a href="<?= $_url ?>matakuliah/edit/<?= $field['makul_id'] ?>/<?= urlencode($field['kode_makul']) ?>">
						<span class="mif-pencil"></span> Edit</a></li>
						<!--<li><a href="<?= $_url ?>matakuliah/delete/<?= $field['kode_makul'] ?>/<?= urlencode($field['nama_makul']) ?>">-->
						<!--<span class="mif-cross"></span> Delete</a></li>-->
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