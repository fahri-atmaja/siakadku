<html>
<?php
	if ($_access == 'mahasiswa' && $_id != $_username) {
		header("location:{$_url}krs/view/{$_username}");
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
	<?php
$querya = mysqli_query($koneksi, "SELECT jadwal_kuliah.tanggal, jadwal_kuliah.jam, app_ruangan.nama_ruangan, akademik_konsentrasi.nama_konsentrasi, akademik_jadwal_kuliah.semester, akademik_jadwal_kuliah.jadwal_id, akademik_kelas.nama_kelas,makul_matakuliah.nama_makul,app_dosen.nama_lengkap FROM jadwal_kuliah
        LEFT JOIN app_ruangan ON app_ruangan.ruangan_id=jadwal_kuliah.ruangan_id
        LEFT JOIN akademik_jadwal_kuliah ON akademik_jadwal_kuliah.jadwal_id=jadwal_kuliah.jadwal_id
        LEFT JOIN akademik_kelas ON akademik_kelas.id_kelas=akademik_jadwal_kuliah.id_kelas
        LEFT JOIN makul_matakuliah ON makul_matakuliah.makul_id=akademik_jadwal_kuliah.makul_id
        LEFT JOIN app_dosen ON app_dosen.dosen_id=jadwal_kuliah.dosen_id
        LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=akademik_jadwal_kuliah.konsentrasi_id
        WHERE jadwal_kuliah.uas_id='{$_id}'");
$field = mysqli_fetch_array($querya);
extract($field);

?>
<center>
<h3>JADWAL UJIAN AKHIR SEMESTER <?= $semester ?> </h3>
<!-- <h3>Semester <?= $semester ?> Tahun <?= $keterangan ?> </h3> -->
</center>

<br>

<center>
    <p align="center">
    Diberitahukan kepada mahasiswa <?= $nama_konsentrasi ?> Semester <?= $semester ?>,<br> bahwa akan dilaksanakannya ujian akhir semester (UAS) dengan rincian sebagai berikut :
    </p>
<table style="width: 30%;">
<tr><td>Nama Matakuliah</td><td>:</td><td><?= $nama_makul ?></td></tr><tr><td>Semester</td><td>:</td><td><?= $semester ?></td></tr>
<tr><td>Pengawas Ujian</td><td>:</td><td><?= $nama_lengkap ?></td></tr><tr><td>Tanggal Ujian</td><td>:</td><td><?= tgl_indo($tanggal) ?></td></tr>
<tr><td>Jam Mulai</td><td>:</td><td><?= $jam ?></td></tr><tr><td>Ruangan</td><td>:</td><td><?= $nama_ruangan?></td></tr>
</table>
</center>



	
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