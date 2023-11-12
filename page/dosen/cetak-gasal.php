<html>
<style type="text/css">
	.input-control {
		border: 1px solid #d9d9d9;
		padding: 10px;
	}
</style>

<h1>
<a href="<?= $_url ?>absen_dosen" class="nav-button transform"><span></span></a>
</h1>

<?php
	$sql = "select akrs.*, mm.nama_makul, jk.pertemuan, ad.nama_lengkap FROM
			akademik_krs as akrs, app_dosen as ad, student_mahasiswa as sm, akademik_jadwal_kuliah as jk, makul_matakuliah as mm WHERE
			ad.dosen_id=jk.dosen_id and jk.jadwal_id='$_id' and jk.makul_id=mm.makul_id and sm.nim=akrs.nim and akrs.jadwal_id='$_id'";
	$query = mysqli_query($koneksi, $sql);
	$fieldd = mysqli_fetch_array($query);
	extract($fieldd);
?>
<a href="javascript:printDiv('cetak');"><span style="color: red; font-size: 50;"><b><i><u>PRINT</u></i></b></span></a>
<div id="cetak">
<head>
	<title>UNIVERSITAS DARUL ULUM ISLAMIC CENTRE SUDIRMAN GUPPI (UNDARIS)</title>
</head>
<body>
	<center>
		<img src="../../../assets/img/logo/logo universitas.png" alt="UNIVERSITAS DARUL ULUM ISLAMIC CENTRE SUDIRMAN GUPPI (UNDARIS)" height="125" width="125">
		<h2>UNIVERSITAS DARUL ULUM ISLAMIC CENTRE SUDIRMAN GUPPI <br>(UNDARIS)</h2>
		<h4><b>_________________________________________________________________________________________________</b></h4>
	</center>
<center>
<h4><b>PRESENSI MAHASISWA</b></h4>
<h4>Mata Kuliah :: <b><?= $nama_makul ?></b> || Semester :: <b><?= $semester ?></b> || Pengampu :: <b><?= $nama_lengkap ?></b>   </h4>

</center>
<table border="1px" align="center" width="70%">
	<thead>
	
		<tr>
			<th>No.</th>
			<th>NIM</th>
			<th>NAMA</th>
			<th>Per 1<br>Tgl:..........</th>
			<th>Per 2<br>Tgl:..........</th>
			<th>Per 3<br>Tgl:..........</th>
			<th>Per 4<br>Tgl:..........</th>
			<th>Per 5<br>Tgl:..........</th>
			<th>Per 6<br>Tgl:..........</th>
			<th>Per 7<br>Tgl:..........</th>
			<th>Per 8<br>Tgl:..........</th>
		</tr>
	</thead>
	<tbody>
			<?php
	$sql = "select akrs.*, sm.nama FROM
			akademik_krs as akrs, student_mahasiswa as sm, akademik_jadwal_kuliah as jk WHERE
			akrs.jadwal_id=jk.jadwal_id and sm.nim=akrs.nim and akrs.jadwal_id='$_id'";
	$querya = mysqli_query($koneksi, $sql);
		$no=1;
		if (mysqli_num_rows($querya) > 0):
			while($field = mysqli_fetch_array($querya)):
	?>
	
		<tr>
			<td><?= $no++ ?></td>
			<td><?= $field['nim'] ?></td>
			<td><?= $field['nama'] ?></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
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
	<td><h4>Mengetahui Kepala Prodi</h4></td><td></td><td align="right"><h4>Dosen Pengampu</h4></td>
</tr>
<tr><td><br><br><br><br>__________________________________</td><td></td><td align="right"><br><br><br><?= $nama_lengkap?><br>_____________________</td></tr>
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