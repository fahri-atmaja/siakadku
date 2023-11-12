
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
<h4><b>TRANSKRIP NILAI AKADEMIK SEMENTARA MAHASISWA</b></h4>
</center>
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
</table>
</center>
<?php

	$sql = "select ak.*,ah.*,mm.makul_id,mm.nama_makul,mm.sks,ad.nama_lengkap
                            FROM akademik_khs as ah,makul_matakuliah as mm,akademik_jadwal_kuliah as jk,akademik_krs as ak,app_dosen as ad
                            WHERE ah.krs_id=ak.krs_id and mm.makul_id=jk.makul_id and ad.dosen_id=jk.dosen_id and jk.jadwal_id=ak.jadwal_id and ah.confirm='1' and ak.nim='$nim'";
	
	$query = mysqli_query($koneksi, $sql);
?>

<table border="1px" align="center" width="100%">
	<thead>
		<tr>
			<th>No</th>
			<th>Matakuliah</th>
			<th>SKS</th>
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
			<td><center><?= $no++ ?></center></td>
			<td><?= $field['nama_makul'] ?></td>
			<td><center><?= $field['sks'] ?></center></td>
			<td><center><?= $field['grade']?></center></td>
			<td><center><?= $field['bobot']?></center></td>
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
		<?php
	$loadmakul = mysqli_query($koneksi,"SELECT * FROM nilai_konversi WHERE nim='$nim'");
	if (mysqli_num_rows($loadmakul) > 0):
			while($f = mysqli_fetch_array($loadmakul)):
			    $sks_kon=$sks_kon+$f['sks'];
			    $bobotk = $f['bobot'];
            	$sksk = $f['sks'];
            	$nbxk = $bobotk*$sksk;
            	$nbk= $nbk+$nbxk;
            	$ipk = $nbk/$totsks;
	?>
	<tr>
			<td><?= $no++ ?></td>
			<td><?= $f['mapel'] ?></td>
			<td><center><?= $f['sks'] ?></center></td>
			<td><center><?= $f['grade']?></center></td>
			<td><center><?= $f['bobot']?></center></td>
			<td><center><?php echo $nbxk ?></center></td>
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
			<td colspan='5'>Jumlah SKS</td><td><?php $total_sks= $sks+$sks_kon;
			echo $total_sks; ?></td>
		</tr>		
		<tr>
			<td colspan='5'>Jumlah Mutu</td><td><?php $total_nb = $nb+$nbk; echo $total_nb; ?></td>
		</tr>
		<tr>
			<td colspan='5'><b>Indeks Prestasi Kumulatif(IPK)</b></td><td><b><?php echo number_format($total_nb/$total_sks,2) ?></b></td>
		</tr>
</table>

<table style="float: right; width: 47%">
	<tr><td><p align="center">Diberikan di Ungaran,
	<!--pada Tanggal -->
	<?php 
// 	echo tgl_indo(date('Y-m-d'));
	?></p></td></tr>
	<tr><td><p align="center">Ketua Program Studi <?= $nama_konsentrasi ?>,</p></td></tr>
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