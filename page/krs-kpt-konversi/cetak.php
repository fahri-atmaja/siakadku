<html>
<?php
	$cek = mysqli_query($koneksi,"SELECT id_sks FROM student_mahasiswa WHERE nim='$_username'");
$validasi = mysqli_fetch_array($cek);
if ($validasi['id_sks']!='2'){
    echo "<script>window.alert('MAAF HALAMAN TIDAK BISA DIAKSSES')
		    window.location.href='{$_url}'</script>";
}
$semester = $_params[1];
$loadbayar=mysqli_query($koneksi,"SELECT status FROM bayar_sks WHERE nim='$_username' and semester='$semester'");
$loadkpt = mysqli_query($koneksi,"SELECT kpt FROM student_mahasiswa WHERE nim='$_username'");
$kpt = mysqli_fetch_array($loadkpt);
$mhs= mysqli_fetch_array($loadbayar);
//echo $mhs['status'];
if ($mhs['status']==1 and $kpt['kpt']!=1):
 	?>
	<a href="javascript:printDiv('cetak');"><span style="color: red; font-size: 50;"><b><i><u>KLIK DISINI "PRINT"</u></i></b></span></a>
<div id="cetak">
	<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>UNIVERSITAS DARUL ULUM ISLAMIC CENTRE SUDIRMAN GUPPI (UNDARIS)</title>
</head>
<body>
	<center>
		<img src="../../../assets/img/logo/logo universitas.png" alt="UNIVERSITAS DARUL ULUM ISLAMIC CENTRE SUDIRMAN GUPPI (UNDARIS)" height="125" width="125">
		<h3>UNIVERSITAS DARUL ULUM ISLAMIC CENTRE SUDIRMAN GUPPI <br> (UNDARIS)</h3>
		<h4>Jl. Tentara Pelajar No.13 Ungaran Kab.Semarang, 50314 ,Jawa Tengah Telp.(024) 6923180 | Fax(022) 76911689</h4>
		<h4><b>____________________________________________________________________________________________________________</b></h4>
	</center>
	<?php
$querya = mysqli_query($koneksi, "SELECT student_mahasiswa.*, app_dosen.nama_lengkap, student_angkatan.keterangan, akademik_konsentrasi.nama_konsentrasi as nama_konsentrasi FROM student_mahasiswa 
	LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=student_mahasiswa.konsentrasi_id
	LEFT JOIN student_angkatan ON student_angkatan.angkatan_id=student_mahasiswa.angkatan_id
	LEFT JOIN app_dosen ON app_dosen.dosen_id=student_mahasiswa.dosen_id
	WHERE nim='{$_id}'");
$field = mysqli_fetch_array($querya);
extract($field);

?>
<center>
<h3>KARTU RENCANA STUDI MAHASISWA</h3>
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

	$sql = "SELECT akademik_krs.*, makul_matakuliah.kode_makul, makul_matakuliah.nama_makul, makul_matakuliah.sks, app_dosen.nama_lengkap FROM
        akademik_krs
        LEFT JOIN akademik_jadwal_kuliah ON akademik_jadwal_kuliah.jadwal_id=akademik_krs.jadwal_id
        LEFT JOIN makul_matakuliah ON makul_matakuliah.makul_id=akademik_jadwal_kuliah.makul_id
        LEFT JOIN app_dosen ON app_dosen.dosen_id=akademik_jadwal_kuliah.dosen_id
        WHERE akademik_krs.nim='$nim' AND akademik_krs.konversi='$semester'";

	$query = mysqli_query($koneksi, $sql);
?>

<table border="1" padding="1" align="center" style="width: 600px;">
	<thead>
		<tr>
			<th>Kode</th>
			<th>Matakuliah</th>
			<th>Semester</th>
			<th>SKS</th>
			<th>Dosen</th>
		</tr>
	</thead>
	<tbody>

	<?php
	$sks=0;
		if (mysqli_num_rows($query) > 0):
			while($field = mysqli_fetch_array($query)):
				$sks=$sks+$field['sks'];
				
	?>
		<tr>
			<td><?= $field['kode_makul'] ?></td>
			<td><?= $field['nama_makul'] ?></td>
			<td><?= $field['semester'] ?></td>
			<td><?= $field['sks'] ?></td>
			<td><?= $field['nama_lengkap'] ?></td>
			
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
	<tfoot><tr><td colspan='2' align='right'>Total SKS yang ditempuh</td><td><?php 
			echo $sks ?></td><td colspan=3></td></tr></tfoot>
</table>
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

	
</body>
<?php
elseif ($kpt['kpt']==1) :
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
<h3>KARTU RENCANA STUDI MAHASISWA</h3>
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

	$sql = "SELECT akademik_krs.*, makul_matakuliah.kode_makul, makul_matakuliah.nama_makul, makul_matakuliah.sks, app_dosen.nama_lengkap FROM
        akademik_krs
        LEFT JOIN akademik_jadwal_kuliah ON akademik_jadwal_kuliah.jadwal_id=akademik_krs.jadwal_id
        LEFT JOIN makul_matakuliah ON makul_matakuliah.makul_id=akademik_jadwal_kuliah.makul_id
        LEFT JOIN app_dosen ON app_dosen.dosen_id=akademik_jadwal_kuliah.dosen_id
        WHERE akademik_krs.nim='$nim' and akademik_krs.konversi='$semester'";

	$query = mysqli_query($koneksi, $sql);
?>

<table border="1" padding="1" align="center" style="width: 600px;">
	<thead>
		<tr>
			<th>Kode</th>
			<th>Matakuliah</th>
			<th>Semester</th>
			<th>SKS</th>
			<th>Dosen</th>
		</tr>
	</thead>
	<tbody>

	<?php
	$sks=0;
		if (mysqli_num_rows($query) > 0):
			while($field = mysqli_fetch_array($query)):
				$sks=$sks+$field['sks'];
				
	?>
		<tr>
			<td><?= $field['kode_makul'] ?></td>
			<td><?= $field['nama_makul'] ?></td>
			<td><?= $field['semester'] ?></td>
			<td><?= $field['sks'] ?></td>
			<td><?= $field['nama_lengkap'] ?></td>
			
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
	<tfoot><tr><td colspan='2' align='right'>Total SKS yang ditempuh</td><td><?php 
			echo $sks ?></td><td colspan=3></td></tr></tfoot>
</table>
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

	
</body>
<?php
else:
?>
<?php
echo "<script>window.alert('MAAF ANDA BELUM MELAKUKAN APEMBAYARAN SKS')
     window.location.href='{$_url}krs/view/$_username'</script>";
?>
<?php
endif;
?>
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