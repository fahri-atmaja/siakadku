<html>
<style type="text/css">
	.input-control {
		border: 1px solid #d9d9d9;
		padding: 10px;
	}
</style>

<h1>
<a href="<?= $_url ?>keuangan" class="nav-button transform"><span></span></a>
</h1>

<?php
	$sql = "SELECT student_mahasiswa.*, akademik_kelas.nama_kelas,student_angkatan.keterangan, akademik_konsentrasi.nama_konsentrasi, biaya_sks.jenis_sks FROM student_mahasiswa 
			LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=student_mahasiswa.konsentrasi_id
			LEFT JOIN student_angkatan ON student_angkatan.angkatan_id=student_mahasiswa.angkatan_id
			LEFT JOIN akademik_kelas ON akademik_kelas.id_kelas=student_mahasiswa.id_kelas
			LEFT JOIN biaya_sks ON biaya_sks.id_sks
			    =student_mahasiswa.id_sks
			WHERE student_mahasiswa.nim='$_id'";
	$query = mysqli_query($koneksi, $sql);
	$field = mysqli_fetch_array($query);
	extract($field);
	if ($status_angsur==1){
	    $angsur="Bulanan";
	}else{
	    $angsur="Semesteran";
	}
?>
<a href="javascript:printDiv('cetak');"><span style="color: red; font-size: 50;"><b><i><u>PRINT</u></i></b></span></a>
<div id="cetak">
<head>
	<title>UNIVERSITAS DARUL ULUM ISLAMIC CENTRE SUDIRMAN GUPPI (UNDARIS)</title>
</head>
<body>
	<center>
		<img src="../../../assets/img/logo/logo universitas.png" alt="UNIVERSITAS DARUL ULUM ISLAMIC CENTRE SUDIRMAN GUPPI (UNDARIS)" height="60" width="60">
		<h4>UNIVERSITAS DARUL ULUM ISLAMIC CENTRE SUDIRMAN GUPPI <br>(UNDARIS)</h4>
		<h4><b>_________________________________________________________________________________________________</b></h4>
	</center>
<center>
<h4><b>PEMBAYARAN MAHASISWA</b></h4>
<table style='width: 600px;'>
<tr><td>NIM</td><td>:</td><td><?= $nim ?></td><td></td><td>Semester</td><td>:</td><td><?= $semester ?></td></tr>
<tr><td>Nama</td><td>:</td><td><?= $nama ?></td><td></td><td>Tahun Akademik</td><td>:</td><td><?= $keterangan ?></td></tr>
<tr><td>Progdi</td><td>:</td><td><?= $nama_konsentrasi ?></td><td></td><td>Kelas</td><td>:</td><td><?= $nama_kelas ?></td></tr>
<tr><td>Metode SKS</td><td>:</td><td><?= $jenis_sks ?></td><td></td><td>Metode Bayar</td><td>:</td><td><?= $angsur ?></td></tr>
</table>

</center>
<?php
 $sqll = "SELECT keuangan_jenis_bayar.keterangan,keuangan_pembayaran_detail.jumlah,keuangan_pembayaran_detail.semester FROM keuangan_pembayaran_detail
        LEFT JOIN keuangan_jenis_bayar ON keuangan_jenis_bayar.jenis_bayar_id=keuangan_pembayaran_detail.jenis_bayar_id
        WHERE keuangan_pembayaran_detail.nim='$nim' AND keuangan_pembayaran_detail.status!=1";
 $queryy= mysqli_query($koneksi,$sqll);
 ?>
<table style='width: 50%;' border="1" align="center">
<tr>
    <td>Jenis Bayar</td>
    <td>Semester</td>
    <td>Jumlah</td>
    <td>Keterangan</td>
</tr>
<?php
 if (mysqli_num_rows($queryy) > 0):
			while($fieldd = mysqli_fetch_array($queryy)):
			    ?>
<tr>
    <td><?= $fieldd['keterangan'] ?></td>
    <td><?= $fieldd['semester'] ?></td>
    <td><?= $fieldd['jumlah'] ?></td>
    <td></td>
</tr>
<?php
endwhile;
			else:
			    ?>
	<tr>
			<td colspan='4'>
			Data tidak ditemukan
			</td>
		</tr>
<?php
		endif;
?>
</table>
</body>
<table style="width: 700px;" align="center">
	<?php 
		$load=mysqli_query($koneksi,"SELECT ap.ketua FROM akademik_prodi as ap, akademik_konsentrasi as ak, akademik_jadwal_kuliah as jk 
			WHERE ap.prodi_id=ak.prodi_id and ak.konsentrasi_id=jk.konsentrasi_id and jk.jadwal_id='{$_id}'");
		$display = mysqli_fetch_array($load);
	?>
<tr>
    <td align="left"><h4>Ungaran, ..................</h4></td>
	<td></td>
	<td></td>
	
</tr>

<tr>
	<td><h4>Mengetahui Admin BAUK</h4></td><td></td><td align="right"></td>
</tr>
<tr><td><br><br><br><p align="center>"><b>________________________</b></p></td><td></td><td align="right"><br><br><br></td></tr>
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