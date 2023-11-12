
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>UNIVERSITAS DARUL ULUM ISLAMIC CENTRE SUDIRMAN GUPPI (UNDARIS)</title>
</head>
<a href="javascript:printDiv('cetak');"><span style="color: red; font-size: 50;"><b><i><u>PRINT</u></i></b></span></a>
<div id="cetak">
<body>
	<center>
		<img src="../../../assets/img/logo/logo.png" alt="UNIVERSITAS DARUL ULUM ISLAMIC CENTRE SUDIRMAN GUPPI (UNDARIS)" height="100" width="100">
		<h3>UNIVERSITAS DARUL ULUM ISLAMIC CENTRE SUDIRMAN GUPPI <br> (UNDARIS)</h3>
		<h4>Jl. Tentara Pelajar No.13 Ungaran Kab.Semarang, 50314 ,Jawa Tengah Telp.(024) 6923180 | Fax(022) 76911689</h4>
		<h4><b>____________________________________________________________________________________________________________</b></h4>
	</center>
	<?php
$querya = mysqli_query($koneksi, "SELECT student_mahasiswa.*, app_dosen.nama_lengkap, student_angkatan.keterangan, akademik_konsentrasi.nama_konsentrasi as nama_konsentrasi FROM student_mahasiswa 
	LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=student_mahasiswa.konsentrasi_id
	LEFT JOIN student_angkatan ON student_angkatan.angkatan_id=student_mahasiswa.angkatan_id
	LEFT JOIN app_dosen ON app_dosen.dosen_id=student_mahasiswa.dosen_id
	WHERE nim='{$_username}'");
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

	$sql = "SELECT bsk.*, bs.jenis_sks, bs.biaya FROM bayar_sks as bsk, biaya_sks as bs, student_mahasiswa as sm
						WHERE bsk.id_sks=bs.id_sks and sm.id_sks=bs.id_sks and bsk.nim='$_username' and bsk.semester='$semester' limit 1";

	$query = mysqli_query($koneksi, $sql);
?>

<table border="1px" padding="1" align="center" style="width: 600px;">
	<thead>
		<tr>
			<th>Jenis SKS</th>
			<th>SKS diambil</th>
			<th>Harga/SKS</th>
			<th>Total Bayar</th>
		</tr>
	</thead>
	<tbody>

	<?php
	$sks=0;
		if (mysqli_num_rows($query) > 0):
			while($field1 = mysqli_fetch_array($query)):
				
	?>
		<tr>
			<td><?= $field1['jenis_sks'] ?></td>
			<td><?= $field1['jumlah_sks'] ?></td>
			<td><?= $field1['biaya'] ?></td>
			<td><?= $field1['jumlah_bayar'] ?></td>
			<!--
			<td><?= $field1['accept']==1?'sudah disetujui':'belum disetujui'; ?></td>
			-->
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
<table style="width: 600px;" align="center">
<tr>
	<td></td>
	<td></td>
	<td align="right"><h4>Ungaran, <?php echo date('Y-m-d')?></h4></td>
</tr>
<tr>
	<td><h4>Mengetahui Biro Administrasi Umum</h4></td><td></td><td align="right"><h4>Mahasiswa Yang Bersangkutan</h4></td>
</tr>
<tr><td><br><br><br><br>__________________________________</td><td></td><td align="right"><br><br><br><?= $nama?><br>__________________________________</td></tr>
</table>

	
</body>
</div>
<textarea id="printing-css" style="display:none;">.no-print{display:none}</textarea>
<iframe id="printing-frame" name="print_frame" src="about:blank" style="display:none;"></iframe>
<script type="text/javascript">
function printDiv(elementId) {
 var a = document.getElementById('printing-css').value;
 var b = document.getElementById(elementId).innerHTML;
 window.frames["print_frame"].document.title = document.title;
 window.frames["print_frame"].document.body.innerHTML = '<style>' + a + '</style>' + b;
 window.frames["print_frame"].window.focus();
 window.frames["print_frame"].window.print();
}
</script>
</html>