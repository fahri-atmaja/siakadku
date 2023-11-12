<h1>
<a href="<?= $_url ?>" class="nav-button transform"><span></span></a>
KRS Mahasiswa
</h1>

<?php
	if ($_access == 'admin') {
		$sql = "SELECT student_mahasiswa.*, akademik_konsentrasi.nama_konsentrasi as nama_konsentrasi FROM student_mahasiswa 
			LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=student_mahasiswa.konsentrasi_id
			ORDER BY nim ASC";
	} else if ($_access == 'dosen') {
		$sql = "SELECT mahasiswa.*, prodi.nama as prodi_nama FROM dosen_wali 
			LEFT JOIN mahasiswa ON mahasiswa.nim=dosen_wali.mahasiswa_nim
			LEFT JOIN prodi ON prodi.kode=mahasiswa.prodi_kode
			WHERE dosen_wali.dosen_npk='{$_username}'
			ORDER BY mahasiswa.nim ASC";
	}
	$query = mysqli_query($koneksi, $sql);
?>

<table class="table striped hovered border bordered">
	<thead>
		<tr>
			<th>NIM</th>
			<th>Nama</th>
			<th>Program Studi</th>
			<th></th>
		</tr>
	</thead>
	<tbody>

	<?php
		if (mysqli_num_rows($query) > 0):
			while($field = mysqli_fetch_array($query)):
	?>
		<tr>
			<td><?= $field['nim'] ?></td>
			<td><?= $field['nama'] ?></td>
			<td><?= $field['nama_konsentrasi'] ?></td>
			<td>
				<div class="inline-block">
				    <button class="button mini-button dropdown-toggle">Aksi</button>
				    <ul class="split-content d-menu" data-role="dropdown">
						<li><a href="<?= $_url ?>krs/krs-mhs/<?= $field['nim'] ?>/<?= urlencode($field['nama']) ?>"><span class="mif-zoom-in"></span> View</a></li>
						<li><a href="<?= $_url ?>status/mahasiswa/<?= $field['nim'] ?>/<?= urlencode($field['nama']) ?>"><span class="mif-checkmark"></span> Approve KRS</a></li>
						<!-- <li><a href="<?= $_url ?>krs/edit/<?= $field['nim'] ?>/<?= urlencode($field['nama']) ?>"><span class="mif-pencil"></span> Edit</a></li> -->
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