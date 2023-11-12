
<html>
<?php
	if ($_access == 'mahasiswa' && $_id != $_username) {
		header("location:{$_url}krs/view/{$_username}");
	}
?>
<a href="javascript:printDiv('cetak');"><span style="color: red; font-size: 50;"><b><i><u>PRINT</u></i></b></span></a>
<div id="cetak">
<style type="text/css">
	.input-control {
		border: 1px solid #d9d9d9;
		padding: 10px;
	}
</style>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>UNIVERSITAS DARUL ULUM ISLAMIC CENTRE SUDIRMAN GUPPI (UNDARIS)</title>
</head>
<body>
	<center>
		<img src="../../../assets/img/logo/logo universitas.png" alt="UNIVERSITAS DARUL ULUM ISLAMIC CENTRE SUDIRMAN GUPPI (UNDARIS)" height="125" width="125">
		<h3>UNIVERSITAS DARUL ULUM ISLAMIC CENTRE SUDIRMAN GUPPI <br>(UNDARIS)</h3>
		<h4>Jl. Tentara Pelajar No.13 Ungaran Kab.Semarang, 50314 ,Jawa Tengah Telp.(024) 6923180 | Fax(024) 76911689</h4>
		<h4><b>____________________________________________________________________________________________________________</b></h4>
	</center>
<center>
	<?php
$querya = mysqli_query($koneksi, "SELECT student_mahasiswa.*, app_dosen.nama_lengkap, student_angkatan.keterangan,akademik_konsentrasi.nama_konsentrasi as nama_konsentrasi FROM student_mahasiswa 
	LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=student_mahasiswa.konsentrasi_id
	LEFT JOIN student_angkatan ON student_angkatan.angkatan_id=student_mahasiswa.angkatan_id
	LEFT JOIN app_dosen ON app_dosen.dosen_id=student_mahasiswa.dosen_id
	WHERE nim='{$_id}'");
$field = mysqli_fetch_array($querya);
extract($field);
?>
<h4>KARTU HASIL STUDI MAHASISWA</h4>
</center>
<br>
<center>
<table style="width: 600px;">
<tr><td>NIM</td><td>:</td><td><?= $nim ?></td><td></td><td>Semester</td><td>:</td><td><?= $_params[1] ?></td></tr>
<tr><td>Nama</td><td>:</td><td><?= $nama ?></td><td></td><td>Tahun Angkatan</td><td>:</td><td><?= $keterangan ?></td></tr>
<tr><td>Progdi</td><td>:</td><td><?= $nama_konsentrasi ?></td><td></td><td>Pembimbing Akademik</td><td>:</td><td><?= $nama_lengkap?></td></tr>
</table>
</center>
<?php

	$sql = "select kh.grade,mm.kode_makul,mm.nama_makul,mm.sks,ad.nama_lengkap,kh.bobot,kh.confirm,kh.khs_id,kh.kehadiran,kh.tugas
                            FROM makul_matakuliah as mm,akademik_jadwal_kuliah as jk,akademik_krs as ak,
                            app_dosen as ad,akademik_khs as kh
                            WHERE mm.makul_id=jk.makul_id and ad.dosen_id=jk.dosen_id and jk.jadwal_id=ak.jadwal_id 
                            and ak.nim='$nim' and kh.krs_id=ak.krs_id and ak.konversi='$_params[1]' and kh.confirm='1'";
	$query = mysqli_query($koneksi, $sql);
	$no=1;
	$sks=0;
	$nb=0;
?>

<table border="1px" align="center" width="600px">
	<thead>
		<tr>
			<th>No</th>
			<th>Kode Makul</th>
			<th>Matakuliah</th>
			<th>SKS</th>
			<th>Nilai</th>
			<th>Bobot</th>
			<th>NB</th>
		</tr>
	</thead>
	<tbody>

	<?php
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
			<td><?= $field['kode_makul'] ?></td>
			<td><?= $field['nama_makul'] ?></td>
			<td><?= $field['sks'] ?></td>
			<td><?= $field['grade'] ?></td>
			<td><?= $field['bobot'] ?></td>
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
	<tfoot><tr><td colspan='3' align='right'>Jumlah</td><td><?php 
			echo $sks ?></td><td colspan=2></td><td><?php echo $nb ?></td></tr>
			<tr><td colspan='3' align='right'>Indeks Prestasi Kumulatif</td><td></td><td colspan=2></td><td><?php echo number_format($ip,2) ?></td></tr>
	</tfoot>
</table>
<br>
<table style="width: 600px;" align="center">
<tr>
	<td></td>
	<td></td>
	<td align="right"><h4>Ungaran, <?php echo date('d-m-Y')?></h4></td>
</tr>
<tr>
	<td><h4>Mengetahui Pembimbing Akademik</h4></td><td></td><td align="right"><h4>Mahasiswa Yang Bersangkutan</h4></td>
</tr>
<tr><td><br><br><br><?= $nama_lengkap?><br>__________________________________</td><td></td><td align="right"><br><br><br><?= $nama?><br>__________________________________</td></tr>
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