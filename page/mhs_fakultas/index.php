<h1>
<a href="<?= $_url ?>" class="nav-button transform"><span></span></a>
Mahasiswa
<!--
<span class="place-right">
	<a href="<?= $_url ?>mahasiswa/synchronize" class="button"><span class="mif-sync-problem"></span> Sinkronisasi Data</a>
	<a href="<?= $_url ?>mahasiswa/add" class="button">Tambah Mahasiswa</a>
</span>
-->
</h1>

<?php
	$sql = "SELECT student_mahasiswa.*, student_angkatan.keterangan, akademik_konsentrasi.nama_konsentrasi FROM student_mahasiswa 
			LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=student_mahasiswa.konsentrasi_id
			LEFT JOIN student_angkatan ON student_angkatan.angkatan_id=student_mahasiswa.angkatan_id
			WHERE akademik_konsentrasi.nama_konsentrasi='$_username'
			ORDER BY nim ASC";
	$query = mysqli_query($koneksi, $sql);
?>
<div class="panel" data-role="panel">
    <div class="heading">
        <span class="title">Cari Mahasiswa</span>
    </div>
    <div class="grid">
    	<input type="text" name="cari" value="">
    	<button type="submit">CARI</button>
    </div>
  </div>
  <?php
  	
  ?>
<center>
		<a href="mhs_fakultas/export-mahasiswa">EXPORT KE EXCEL</a>
</center>
<table class="table striped hovered border bordered">
	<thead>
		<tr>
			<th>NIM</th>
			<th>Nama</th>
			<th>Alamat</th>
			<th>Program Studi</th>
			<th>Semester</th>
			<th>Tahun Masuk</th>
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
			<td><?= $field['alamat'] ?></td>
			<td><?= $field['nama_konsentrasi'] ?></td>
			<td><?= $field['semester'] ?></td>
			<td><?= $field['keterangan'] ?></td>
			<td>
				<div class="inline-block">
				    <button class="button mini-button dropdown-toggle">Aksi</button>
				    <ul class="split-content d-menu" data-role="dropdown">
						<li><a href="<?= $_url ?>mahasiswa/view/<?= $field['nim'] ?>/<?= urlencode($field['nama']) ?>"><span class="mif-zoom-in"></span> View</a></li>
						<li><a href="<?= $_url ?>status/mahasiswa/<?= $field['nim'] ?>/<?= urlencode($field['nama']) ?>"><span class="mif-pencil"></span> Set Status</a></li>
						<!--<li><a href="<?= $_url ?>mahasiswa/delete/<?= $field['nim'] ?>/<?= urlencode($field['nama']) ?>"><span class="mif-cross"></span> Delete</a></li>
				   --> </ul>
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