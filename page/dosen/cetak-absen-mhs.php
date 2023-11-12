<html>
<style type="text/css">
	.input-control {
		border: 1px solid #d9d9d9;
		padding: 10px;
	}
</style>

<h1>
<a href="<?= $_url ?>" class="nav-button transform"><span></span></a>
</h1>

<?php
	$sql = "select akrs.*, mm.nama_makul, jk.pertemuan FROM
			akademik_krs as akrs, student_mahasiswa as sm, akademik_jadwal_kuliah as jk, makul_matakuliah as mm WHERE
			jk.jadwal_id='$_id' and jk.makul_id=mm.makul_id and sm.nim=akrs.nim and akrs.jadwal_id='$_id'";
	$query = mysqli_query($koneksi, $sql);
	$fieldd = mysqli_fetch_array($query);
	extract($fieldd);
?>

<head>
	<title>UNIVERSITAS DARUL ULUM ISLAMIC CENTRE SUDIRMAN GUPPI (UNDARIS)</title>
</head>
<body>
	<center>
		<img src="../../../assets/img/logo/logo universitas.png" alt="UNIVERSITAS DARUL ULUM ISLAMIC CENTRE SUDIRMAN GUPPI (UNDARIS)" height="125" width="125">
		<h2>UNIVERSITAS DARUL ULUM ISLAMIC CENTRE SUDIRMAN GUPPI (UNDARIS)</h2>
		<h4>Jl. Tentara Pelajar No.13 Ungaran Kab.Semarang, 50314 ,Jawa Tengah</h4>
		<h4>E-mail : pcmbundaris@gmail.com | Website : http://www.undaris.ac.id</h4>
		<h4>Telp.(024) 6923180 | Fax(022) 76911689</h4>
		<h4><b>_________________________________________________________________________________________________</b></h4>
	</center>
<center>
<h4>Absensi Mahasiswa</h4>
<h4>Mata Kuliah :: <b><?= $nama_makul ?></b> || Semester :: <b><?= $semester ?></b>  || Pertemuan ke :: <b><?= $pertemuan ?></b>   </h4>

</center>
<table class="table striped hovered border bordered">
	<thead>
	
		<tr>
			<th>No.</th>
			<th>NIM</th>
			<th>NAMA</th>
			<th>TTD</th>

		</tr>
	</thead>
	<tbody>
			<?php
	$sql = "select akrs.*, sm.nama FROM
			akademik_krs as akrs, student_mahasiswa as sm, akademik_jadwal_kuliah as jk WHERE
			akrs.jadwal_id=jk.jadwal_id and sm.nim=akrs.nim and akrs.jadwal_id='$_id'";
	$querya = mysqli_query($koneksi, $sql);
		$no=1;
		if (mysqli_num_rows($querya) > 0):
			while($field = mysqli_fetch_array($querya)):
	?>
	
		<tr>
			<td><?= $no++ ?></td>
			<td><?= $field['nim'] ?></td>
			<td><?= $field['nama'] ?></td>
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
</body>
<?php
date_default_timezone_set('Asia/Jakarta');
?>
	<h4>Ungaran, <?php date_default_timezone_set('Asia/Jakarta'); echo date('d-m-Y')?></h4>
	<h4>Mengetahui Bagian Akademik</h4>
	<br><br><br><br><br>
	_____________________________	
<script>
		window.print();
</script>
	
</body>
</html>