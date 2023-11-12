<html>
<?php
	if ($_access == 'mahasiswa' && $_id != $_username) {
		header("location:{$_url}krs/view/{$_username}");
	}
	if ($_id == 0){
		header('location:{$_url}report');
	}
?>

<a href="javascript:printDiv('cetak');"><span style="color: red; font-size: 50;"><b><i><u>PRINT</u></i></b></span></a>
<div id="cetak">
	<head>
	<title>UNIVERSITAS DARUL ULUM ISLAMIC CENTRE SUDIRMAN GUPPI (UNDARIS)</title>
</head>
<body>
	<center>
		<img src="../../../assets/img/logo/logo universitas.png" alt="UNIVERSITAS DARUL ULUM ISLAMIC CENTRE SUDIRMAN GUPPI (UNDARIS)" height="125" width="125">
		<h3>UNIVERSITAS DARUL ULUM ISLAMIC CENTRE SUDIRMAN GUPPI <br> (UNDARIS)</h3>
		<h4>Jl. Tentara Pelajar No.13 Ungaran Kab.Semarang, 50314 ,Jawa Tengah Telp.(024) 6923180 | Fax(022) 76911689</h4>
		<h4><b>____________________________________________________________________________________________________________</b></h4>
	</center>
<center>
<?php
$bulan = array (
		1 =>   'Januari',
		'Februari',
		'Maret',
		'April',
		'Mei',
		'Juni',
		'Juli',
		'Agustus',
		'September',
		'Oktober',
		'November',
		'Desember'
	);
?>
<h3>LAPORAN ANGSURAN PEMBAYARAN MAHASISWA BULANAN
<br>Bulan <?= $bulan[(int)$_id];?> Tahun <?= $_params[1] ?></h3>
<!-- <h3>Semester <?= $semester ?> Tahun <?= $keterangan ?> </h3> -->
</center>

<?php
	$sql = "SELECT ba.*, sm.nama FROM bayar_angsuran as ba, student_mahasiswa as sm 
	WHERE sm.nim=ba.nim and month(ba.tanggal)='$_id' and year(ba.tanggal)='$_params[1]' ORDER BY ba.nim ASC";

	$query = mysqli_query($koneksi, $sql);
?>

<table border="1" padding="1" align="center" style="width: 100%;">
	<thead>
		<tr>
			<th>No</th>
			<th>Tanggal</th>
			<th>NIM</th>
			<th>Nama</th>
			<th>Angsuran ke-</th>
			<th>Jumlah Bayar</th>
		</tr>
	</thead>
	<tbody>

	<?php
	$no = 1;
	$total = 0;
		if (mysqli_num_rows($query) > 0):
			while($field1 = mysqli_fetch_array($query)):
				$total = $total+$field1['bayar'];
				
	?>
		<tr>
			<td><?= $no++ ?></td>
			<td><?php echo tgl_indo($field1['tanggal']) ?></td>
			<td><?= $field1['nim'] ?></td>
			<td><?= $field1['nama'] ?></td>
			<td><?= $field1['angsuran'] ?></td>
			<td><?= $field1['bayar'] ?></td>
			
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
	<tr><td colspan='5' align='right'>Total</td><td><?php 
			echo $total ?></td></tr>	
	</tbody>
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