
<html>
<?php
	if ($_access == 'mahasiswa' && $_id != $_username) {
		header("location:{$_url}krs/view/{$_username}");
	}
?>
<a href="javascript:printDiv('cetak');"><span style="color: red; font-size: 50;"><b><i><u>PRINT</u></i></b></span></a>
<div id="cetak">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>UNIVERSITAS DARUL ULUM ISLAMIC CENTRE SUDIRMAN GUPPI (UNDARIS)</title>
</head>
<body>
	<center>
		<!--<img src="../../assets/img/logo/logo universitas.png" alt="UNIVERSITAS DARUL ULUM ISLAMIC CENTRE SUDIRMAN GUPPI (UNDARIS)" height="125" width="125">-->
		<!--<h2>UNIVERSITAS DARUL ULUM ISLAMIC CENTRE SUDIRMAN GUPPI (UNDARIS)</h2>-->
		<!--<h4><b>____________________________________________________________________________________________________________</b></h4>-->
		<img src="https://siakad.undaris.ac.id/assets/img/header.png" alt="UNIVERSITAS DARUL ULUM ISLAMIC CENTRE SUDIRMAN GUPPI (UNDARIS)" width="100%">
	</center>
<center>
<h3>Transkrip Nilai Sementara Mahasiswa</h3>
</center>
<?php
$querya = mysqli_query($koneksi, "SELECT student_mahasiswa.*, student_angkatan.keterangan, akademik_konsentrasi.nama_konsentrasi as nama_konsentrasi FROM student_mahasiswa 
	LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=student_mahasiswa.konsentrasi_id
	LEFT JOIN student_angkatan ON student_angkatan.angkatan_id=student_mahasiswa.angkatan_id
	WHERE nim='{$_id}'");
$field = mysqli_fetch_array($querya);
extract($field);

?>
<br>
<center>
<table style="width: 600px;">
<tr><td>NIM</td><td>:</td><td><?= $nim ?></td><td></td><td>Nama</td><td>:</td><td><?= $nama ?></td></tr>
<tr><td>Program Studi</td><td>:</td><td><?= $nama_konsentrasi ?></td><td></td><td>Semester Aktif</td><td>:</td><td><?= $semester?></td></tr>
</table>
</center>
<?php

	$sql = "select ak.*,ah.*,mm.makul_id,mm.nama_makul,mm.sks,ad.nama_lengkap
                            FROM akademik_khs as ah,makul_matakuliah as mm,akademik_jadwal_kuliah as jk,akademik_krs as ak,app_dosen as ad
                            WHERE ah.krs_id=ak.krs_id and mm.makul_id=jk.makul_id and ad.dosen_id=jk.dosen_id and jk.jadwal_id=ak.jadwal_id and ah.confirm='1' and ak.nim='$nim'";
	
	$query = mysqli_query($koneksi, $sql);
?>

<table border="1px" align="center" width="600px">
	<thead>
		<tr>
			<th>No</th>
			<th>Matakuliah</th>
			<th>Semester</th>
			<th>SKS</th>
			<th>Dosen</th>
			<th>Nilai</th>
			<th>Bobot</th>
			<th>NB</th>
		</tr>
	</thead>
	<tbody>

	<?php
	$no=1;
	$sks=0;
		if (mysqli_num_rows($query) > 0):
			while($field = mysqli_fetch_array($query)):
				$sks=$sks+$field['sks'];
				
	?>
	<?php
	$bobot = $field['bobot'];
	$sksx = $field['sks'];
	$nbx = $bobot*$sksx;
	$nb= $nb+$nbx;
	$ip = $nb/$sks;
	?>
		<tr>
			<td><?= $no++ ?></td>
			<td><?= $field['nama_makul'] ?></td>
			<td><?= $field['semester']?></td>
			<td><?= $field['sks'] ?></td>
			<td><?= $field['nama_lengkap'] ?></td>
			<td><?= $field['grade']?></td>
			<td><?= $field['bobot']?></td>
			<td><?php echo $nbx ?></td>
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
	<tr><td colspan='3' align='right'>Jumlah</td><td><?php 
			echo $sks ?></td><td colspan=3></td><td><?php echo $nb ?></td></tr>
			<tr><td colspan='3' align='right'>Indeks Prestasi Kumulatif</td><td></td><td colspan=3></td><td><?php echo number_format($ip,2) ?></td></tr>
	
</table>
<table style="width: 600px;" align="center">
<tr>
	<td></td>
	<td></td>
	<td align="right"><h4>Ungaran, <?php echo date('d-m-Y')?></h4></td>
</tr>
<tr>
	<td></td><td></td><td align="right"><h4>Kepala Prodi <?= $nama_konsentrasi ?> </h4></td>
</tr>
<tr><td><br><br><br><br></td><td></td><td align="right"><br><br><br>__________________________________</td></tr>
</table>

<!-- <script>
		window.print();
</script> -->

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