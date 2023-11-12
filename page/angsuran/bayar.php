
<html>
<head>
	<title>UNIVERSITAS DARUL ULUM ISLAMIC CENTRE SUDIRMAN GUPPI (UNDARIS)</title>
</head>
<body>
	<center>
		<img src="../../../assets/img/logo/logo.png" alt="UNIVERSITAS DARUL ULUM ISLAMIC CENTRE SUDIRMAN GUPPI (UNDARIS)" height="125" width="125">
		<h3>UNIVERSITAS DARUL ULUM ISLAMIC CENTRE SUDIRMAN GUPPI <br> (UNDARIS)</h3>
		<h4>Jl. Tentara Pelajar No.13 Ungaran Kab.Semarang, 50314 ,Jawa Tengah Telp.(024) 6923180 | Fax(022) 76911689</h4>
		<h4><b>____________________________________________________________________________________________________________</b></h4>
	</center>
	<?php
$querya = mysqli_query($koneksi, "SELECT student_mahasiswa.*, app_dosen.nama_lengkap, student_angkatan.keterangan, akademik_konsentrasi.nama_konsentrasi as nama_konsentrasi FROM student_mahasiswa 
	LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=student_mahasiswa.konsentrasi_id
	LEFT JOIN student_angkatan ON student_angkatan.angkatan_id=student_mahasiswa.angkatan_id
	LEFT JOIN app_dosen ON app_dosen.dosen_id=student_mahasiswa.dosen_id
	WHERE nim='{$_params[1]}'");
$field = mysqli_fetch_array($querya);
extract($field);

?>
<center>
<h3>PEMBAYARAN SKS MAHASISWA</h3>
<!-- <h3>Semester <?= $semester ?> Tahun <?= $keterangan ?> </h3> -->
</center>

<br>
<center>
<table style="width: 600px;">
<tr><td>NIM</td><td>:</td><td><?= $nim ?></td><td></td><td>Semester</td><td>:</td><td><?= $semester ?></td></tr>
<tr><td>Nama</td><td>:</td><td><?= $nama ?></td><td></td><td>Tahun Akademik</td><td>:</td><td><?= $keterangan ?></td></tr>
<tr><td>Progdi</td><td>:</td><td><?= $nama_konsentrasi ?></td><td></td><td>Pembimbing Akademik</td><td>:</td><td><?= $nama_lengkap?></td></tr>
</table>
</center>

<?php

	$sql = "SELECT bsk.*,bs.biaya ,bs.jenis_sks, sm.nama ,ak.nama_konsentrasi FROM bayar_sks as bsk, biaya_sks as bs, student_mahasiswa as sm, akademik_konsentrasi as ak
			 WHERE bsk.id_sks=bs.id_sks AND sm.id_sks=bs.id_sks AND sm.konsentrasi_id=ak.konsentrasi_id AND bsk.nim=sm.nim AND bsk.biaya_id='{$_id}'
			 ORDER BY semester ASC, nama_konsentrasi ASC";

	$query = mysqli_query($koneksi, $sql);
?>

<table class="table striped hovered border bordered">
	<thead>
		<tr>
			<th>Jenis SKS</th>
			<th>SKS diambil</th>
			<th>Harga/SKS</th>
			<th>Total Bayar</th>
			<th>Status</th>
			<th>Tanggal Bayar</th>
		</tr>
	</thead>
	<tbody>

	<?php
	$sks=0;
		if (mysqli_num_rows($query) > 0):
			while($field = mysqli_fetch_array($query)):
				
	?>
		<tr>
			<td><?= $field['jenis_sks'] ?></td>
			<td><?= $field['jumlah_sks'] ?></td>
			<td><?= $field['biaya'] ?></td>
			<td><?= $field['jumlah_bayar'] ?></td>
			<td><?= $field['status']==1?'Lunas':'Belum Dibayar'; ?></td>
			<td><?= $field['tanggal_bayar'] ?></td>
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
<table style="width: 800px;">
<tr>
	<td></td>
	<td></td>
	<td align="right"><h4>Ungaran, <?php echo date('d-m-Y')?></h4></td>
</tr>
<tr>
	<td><h4>Mengetahui Biro Administrasi Umum</h4></td><td></td><td align="right"><h4>Mahasiswa Yang Bersangkutan</h4></td>
</tr>
<tr><td><br><br><br><br>__________________________________</td><td></td><td align="right"><br><br><br><?= $nama?><br>__________________________________</td></tr>
</table>
<script>
		window.print();
</script>
	
</body>
</html>