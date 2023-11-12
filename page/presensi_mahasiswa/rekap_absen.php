<html>
<style type="text/css">
	.input-control {
		border: 1px solid #d9d9d9;
		padding: 10px;
	}
</style>

<h1>
<a href="<?= $_url ?>presensi_mahasiswa" class="nav-button transform"><span></span></a>
</h1>

<?php
	$sql = "SELECT makul_matakuliah.nama_makul, akademik_jadwal_kuliah.semester, app_dosen.nama_lengkap, akademik_tahun_akademik.keterangan 
	        FROM akademik_jadwal_kuliah
	        LEFT JOIN makul_matakuliah ON makul_matakuliah.makul_id=akademik_jadwal_kuliah.makul_id
	        LEFT JOIN app_dosen ON app_dosen.dosen_id=akademik_jadwal_kuliah.dosen_id
	        LEFT JOIN akademik_tahun_akademik ON akademik_tahun_akademik.tahun_akademik_id=akademik_jadwal_kuliah.tahun_akademik_id
	        WHERE akademik_jadwal_kuliah.jadwal_id='$_id'";
	$query = mysqli_query($koneksi, $sql);
	$f = mysqli_fetch_array($query);
?>
<a href="javascript:printDiv('cetak');"><span style="color: red; font-size: 50;"><b><i><u>PRINT</u></i></b></span></a>
<div id="cetak">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>UNIVERSITAS DARUL ULUM ISLAMIC CENTRE SUDIRMAN GUPPI (UNDARIS)</title>
</head>
<body>
	<center>
		<img src="../../../assets/img/logo/logo universitas.png" alt="UNIVERSITAS DARUL ULUM ISLAMIC CENTRE SUDIRMAN GUPPI (UNDARIS)" height="125" width="125">
		<h2>UNIVERSITAS DARUL ULUM ISLAMIC CENTRE SUDIRMAN GUPPI <br>(UNDARIS)</h2>
		<h4><b>_________________________________________________________________________________________________</b></h4>
	</center>
<center>
<h4><b>PRESENSI DOSEN</b></h4>
<table>
    <tr>
        <td>Mata Kuliah</td>
        <td>:</td>
        <td><?= $f['nama_makul'] ?></td>
    </tr>
    <tr>
        <td>Semester</td>
        <td>:</td>
        <td><?= $f['semester'] ?></td>
    </tr>
    <tr>
        <td>Pengampu</td>
        <td>:</td>
        <td><?= $f['nama_lengkap'] ?></td>
    </tr>
    <tr>
        <td>Tahun Akademik</td>
        <td>:</td>
        <td><?= $f['keterangan'] ?></td>
    </tr>
</table>

</center>
<table border="1px" align="center" width="100%">
	<thead>
	
		<tr>
			<th>No.</th>
			<th>Tanggal</th>
			<th>Pokok Bahasan dan Sumber</th>
			<th width='5%'>Jml MHS</th>
			<th width='10%'>TTD</th>
		</tr>
	</thead>
	<tbody>
			<?php

	$sql1 = "select * from dosen_absen where jadwal_id='$_id'";
	$querya = mysqli_query($koneksi, $sql1);
		$no=1;
		if (mysqli_num_rows($querya) > 0):
			while($field1 = mysqli_fetch_array($querya)):
	?>
	
		<tr>
			<td><?= $no++ ?></td>
			<td><?= $field1['tanggalabsen'] ?></td>
			<td><?= $field1['materi'] ?></td>
			<td><?php
			    $load = mysqli_query($koneksi,"SELECT * FROM mhs_absen WHERE jadwal_id='$_id' AND pertemuan='$field1[pertemuan]' AND kehadiran='hadir'");
			    $cek = mysqli_num_rows($load);
			    echo $cek;
			?></td>
			<td></td>
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
</body>
<table style="width: 700px;" align="center">
<tr>
	<td></td>
	<td></td>
	<td align="right"><h4>Ungaran, ..................</h4></td>
</tr>
<tr>
	<td><h4>Mengetahui K.a Progdi</h4></td><td></td><td align="right"><h4>Dosen Pengampu</h4></td>
</tr>
<tr><td><br><br><br><br>__________________________________</td><td></td><td align="right"><br><br><br><?= $f['nama_lengkap']?><br>_____________________</td></tr>
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