<h1>
<a href="<?= $_url ?>" class="nav-button transform"><span></span></a>
KRS Mahasiswa
</h1>
<form action="#" method="GET">
<div class="panel" data-role="panel">
    <div class="heading">
        <span class="title">Cari Mahasiswa</span>
    </div>
    <div class="grid">
    	<input type="text" name="cari" value="">
    	<input type="submit" value="Cari NIM">
    </div>
  </div>
</form>
  <?php
if(isset($_GET['cari'])){
	$cari = $_GET['cari'];
	echo "<b>Hasil pencarian : ".$cari."</b>";
}
?>
<?php
if(isset($_GET['cari'])){
		$sql = "SELECT student_mahasiswa.*, akademik_konsentrasi.nama_konsentrasi as nama_konsentrasi FROM student_mahasiswa 
			LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=student_mahasiswa.konsentrasi_id
			WHERE student_mahasiswa.nim like '%".$cari."%'";
	$query = mysqli_query($koneksi, $sql);
}
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
						<li><a href="<?= $_url ?>krs-susulan/setting/<?= $field['nim'] ?>/<?= urlencode($field['id_kelas']) ?>"><span class="mif-zoom-in"></span> KRS Susulan</a></li>
						<li><a href="<?= $_url ?>krs_fakultas?cari=<?= $field['nim'] ?>"><span class="mif-zoom-in"></span> View</a></li>
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