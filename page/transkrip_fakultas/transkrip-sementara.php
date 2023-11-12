
<html>
<?php
	if ($_access == 'mahasiswa' && $_id != $_username) {
		header("location:{$_url}krs/view/{$_username}");
	}
?>
<style type="text/css">
	.input-control {
		border: 1px solid #d9d9d9;
		padding: 10px;
	}
</style>
<a href="javascript:printDiv('cetak');"><span style="color: red; font-size: 50;"><b><i><u>PRINT</u></i></b></span></a>
<div id="cetak">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>UNIVERSITAS DARUL ULUM ISLAMIC CENTRE SUDIRMAN GUPPI (UNDARIS)</title>
</head>
<body>
	<center>
		<!--<img src="../../assets/img/logo/logo universitas.png" alt="UNIVERSITAS DARUL ULUM ISLAMIC CENTRE SUDIRMAN GUPPI (UNDARIS)" height="125" width="125">-->
		<!--<h3>UNIVERSITAS DARUL ULUM ISLAMIC CENTRE SUDIRMAN GUPPI <br>(UNDARIS)</h3>-->
		<!--<h4>Jl. Tentara Pelajar No.13 Ungaran Kab.Semarang, 50314 ,Jawa Tengah Telp.(024) 6923180 | Fax(024) 76911689</h4>-->
		<!--<h4><b>____________________________________________________________________________________________________________</b></h4>-->
		<img src="https://siakad.undaris.ac.id/assets/img/header.png" alt="UNIVERSITAS DARUL ULUM ISLAMIC CENTRE SUDIRMAN GUPPI (UNDARIS)" width="100%">
	</center>
<center>
	<?php
$querya = mysqli_query($koneksi, "SELECT student_mahasiswa.*, app_dosen.nama_lengkap, akademik_prodi.no_izin, akademik_prodi.akreditasi, akademik_konsentrasi.NIDN, akademik_prodi.ketua, akademik_konsentrasi.jenjang,
	akademik_konsentrasi.kode_nomor, student_angkatan.keterangan,akademik_konsentrasi.nama_konsentrasi as nama_konsentrasi FROM student_mahasiswa 
	LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=student_mahasiswa.konsentrasi_id
	LEFT JOIN akademik_prodi ON akademik_prodi.prodi_id=akademik_konsentrasi.prodi_id
	LEFT JOIN student_angkatan ON student_angkatan.angkatan_id=student_mahasiswa.angkatan_id
	LEFT JOIN app_dosen ON app_dosen.dosen_id=student_mahasiswa.dosen_id
	WHERE nim='{$_id}'");
$field = mysqli_fetch_array($querya);
extract($field);
?>
<h4><b>TRANSKRIP NILAI AKADEMIK SEMENTARA MAHASISWA</b></h4>
</center>
<br>
<center>
<table style="width: 80%;">
<tr><td>NIM</td><td>:</td><td><?= $nim ?></td><td></td>
<td>Program Studi</td><td>:</td><td><?= $nama_konsentrasi ?></td>
</tr>
<tr>
<td>Nama</td><td>:</td><td><?= $nama ?></td><td></td><td>Program</td><td>:</td><td><?= $jenjang ?></td>
</tr>
<tr>
<td>Tempat, Tanggal Lahir</td><td>:</td><td><?= $tempat_lahir ?>,<?= tgl_indo($tanggal_lahir) ?></td><td></td>
</tr>
<!--<tr>-->
<!--<td>Tahun Masuk</td><td>:</td><td><?= $keterangan ?></td><td></td><td>Nomor Seri Transkrip</td><td>:</td><td>----</td>-->
<!--</tr>-->
<!--<tr>-->
<!--<td>Ijin Penyelenggara</td><td>:</td><td><?= $kode_nomor ?></td><td></td><td>Tanggal Lulus</td><td>:</td><td>----</td>-->
<!--</tr>-->
<!--<tr><td></td><td></td><td></td><td></td><td>Status</td><td>:</td><td>Terakreditasi <?= $akreditasi ?><br><?= $no_izin ?></td>-->
<!--</tr>-->
</table>
</center>
<?php

	$sql = "select kh.grade,mm.kode_makul,mm.nama_makul,mm.sks,ad.nama_lengkap,kh.bobot,kh.confirm,kh.khs_id,kh.kehadiran,kh.tugas
                            FROM makul_matakuliah as mm,akademik_jadwal_kuliah as jk,akademik_krs as ak,
                            app_dosen as ad,akademik_khs as kh
                            WHERE mm.makul_id=jk.makul_id and ad.dosen_id=jk.dosen_id and jk.jadwal_id=ak.jadwal_id 
                            and ak.nim='$nim' and kh.krs_id=ak.krs_id and kh.confirm='1'";
	$query = mysqli_query($koneksi, $sql);
	$no=1;
	$sks=0;
	$nb=0;
?>

<table border="1px" align="center" width="100%">
	<thead>
		<tr>
			<th>No</th>
			<th>Matakuliah</th>
			<th>SKS</th>
			<th>Nilai</th>
			<th>Bobot</th>
			<th>Mutu</th>
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
			<td><center><?= $no++ ?></center></td>
			<td><?= $field['nama_makul'] ?></td>
			<td><center><?= $field['sks'] ?></center></td>
			<td><center><?= $field['grade'] ?></center></td>
			<td><center><?= $field['bobot'] ?></center></td>
			<td><center><?php echo $nbx ?></center></td>
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
	<tr>
			<th colspan='7'>Kumulatif</th>
		</tr>
		<tr>
			<td colspan='5'>Jumlah Matakuliah</td><td><?php $nomakul=($no++)-1;
			echo $nomakul ?></td>
		</tr>
		<tr>
			<td colspan='5'>Jumlah SKS</td><td><?php echo $sks ?></td>
		</tr>		
		<tr>
			<td colspan='5'>Jumlah Mutu</td><td><?php echo $nb ?></td>
		</tr>
		<tr>
			<td colspan='5'><b>Indeks Prestasi Kumulatif(IPK)</b></td><td><b><?php echo number_format($ip,2) ?></b></td>
		</tr>
</table>
<?php
//$loadmakul = mysqli_query($koneksi,"SELECT nim FROM akademik_krs where nim='$_id");
//$data = mysqli_num_rows($loadmakul);
?>
<center>
	<?php
		$load=mysqli_query($koneksi,"SELECT judul FROM pengajuan_skripsi WHERE nim='$_id'"); #and status='1';
		$display=mysqli_fetch_array($load);
	?>
	
<!--<table style="float: left; width: 70%">-->
<!--		<tr>-->
<!--			<th>Judul Skripsi</th><th></th><th></th>-->
<!--			<th>Predikat Kelulusan</th><th></th><th></th>-->
<!--		</tr>-->
<!--		<tr>-->
<!--			<td><?php echo $display['judul']; ?></td><td></td><td></td>-->
<!--			<td>----</td><td></td><td></td>-->
<!--		</tr>-->
<!--</table>-->
</center>
<br>
<br>
<br>
<br>
<br>
<br>
<?php 
	$loadrektor =mysqli_query($koneksi,"SELECT * FROM akademik_rektor");
	$rektor = mysqli_fetch_array($loadrektor);
?>
<!--<table style="float: left; width: 40%">-->
<!--	<tr></tr>-->
<!--	<tr><td><br><p align="center">Mengetahui,</p></td></tr>-->
<!--	<tr><td><p align="center">Rektor</p></td></tr>-->
<!--	<tr><td><br></td></tr>-->
<!--	<tr><td><br></td></tr>-->
<!--	<tr><td><br></td></tr>-->
<!--	<tr><td><br></td></tr>-->
<!--	<tr><td><b><p align="center"><?php echo $rektor['nama'] ?></p></b></td></tr>-->
<!--	<br>-->
<!--	<tr><td><p align="center"></p></td></tr>-->
<!--</table>-->
<table style="float: right; width: 47%">
	<tr><td><p align="center">Diberikan di Ungaran, 
	<!--pada Tanggal -->
	<?php 
// 	echo tgl_indo(date('Y-m-d'));
	?>
	</p></td></tr>
	<tr><td><p align="center">Ketua Program Studi,</p></td></tr>
	<tr><td><br></td></tr>
	<tr><td><br></td></tr>
	<tr><td><br></td></tr>
	<tr><td><br></td></tr>
	<tr><td><p align="center"><b><?= $ketua?></b></p></td></tr>
	<br>
	<tr><td><p align="center"></p></td></tr>
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