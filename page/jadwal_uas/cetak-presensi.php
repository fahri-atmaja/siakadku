<html>
<style type="text/css">
	.input-control {
		border: 1px solid #d9d9d9;
		padding: 10px;
	}
</style>

<h1>
<a href="<?= $_url ?>jadwal_uas"  class="nav-button transform"><span></span></a>
</h1>

<?php
	$sql = "SELECT jadwal_kuliah.tanggal, jadwal_kuliah.jam, app_ruangan.nama_ruangan, akademik_jadwal_kuliah.semester, akademik_jadwal_kuliah.jadwal_id, akademik_kelas.nama_kelas,makul_matakuliah.nama_makul,app_dosen.nama_lengkap,
	        akademik_konsentrasi.nama_konsentrasi FROM jadwal_kuliah
            LEFT JOIN app_ruangan ON app_ruangan.ruangan_id=jadwal_kuliah.ruangan_id
            LEFT JOIN akademik_jadwal_kuliah ON akademik_jadwal_kuliah.jadwal_id=jadwal_kuliah.jadwal_id
            LEFT JOIN akademik_kelas ON akademik_kelas.id_kelas=akademik_jadwal_kuliah.id_kelas
            LEFT JOIN makul_matakuliah ON makul_matakuliah.makul_id=akademik_jadwal_kuliah.makul_id
            LEFT JOIN app_dosen ON app_dosen.dosen_id=akademik_jadwal_kuliah.dosen_id
            LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=akademik_jadwal_kuliah.konsentrasi_id
            WHERE jadwal_kuliah.jadwal_id='{$_id}'";
        	$query = mysqli_query($koneksi, $sql);
        	$fill = mysqli_fetch_array($query);
        	$tahun = mysqli_query($koneksi,"SELECT * FROM akademik_tahun_akademik WHERE status='y'");
        	$f = mysqli_fetch_array($tahun);
?>
<a href="javascript:printDiv('cetak');"><span style="color: red; font-size: 50;"><b><i><u>PRINT</u></i></b></span></a>
<div id="cetak">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>UNIVERSITAS DARUL ULUM ISLAMIC CENTRE SUDIRMAN GUPPI (UNDARIS)</title>
</head>
<body>
	<center>
		<img src="https://siakad.undaris.ac.id/assets/img/header.png" alt="UNIVERSITAS DARUL ULUM ISLAMIC CENTRE SUDIRMAN GUPPI (UNDARIS)">
	</center>
<center>
<!--<h4><b>PRESENSI UAS MAHASISWA</b></h4>-->
<!--<h4>Mata Kuliah :: <b><?= $nama_makul ?></b> || Semester :: <b><?= $semester ?></b> || Pengawas Ujian :: <b><?= $fill['nama_lengkap'] ?></b><br>-->
<!--    Tanggal :: <b><?= tgl_indo($tanggal) ?></b> || Jam :: <b><?= $jam ?></b> || Ruangan :: <b><?= $nama_ruangan ?></b>-->
<!--</h4>-->
<h4><b>DAFTAR HADIR UJIAN AKHIR SEMESTER (UAS)<br>Semester <?= $fill['semester'] ?> Tahun <?= $f['keterangan']; ?></b></h4>
<table border="0px" align="center">
    <tr>
        <td><b>JURUSAN</b></td><td>:</td><td><?= $fill['nama_konsentrasi'] ?></td><td><b>DOSEN</b></td><td>:</td><td><?= $fill['nama_lengkap'] ?></td>
    </tr>
    <tr>
        <td><b>MATAKULIAH</b></td><td>:</td><td><?= $fill['nama_makul'] ?></td><td><b>KELAS</b></td><td>:</td><td><?= $fill['nama_kelas'] ?></td>
    </tr>
    <tr>
        <td><b>JADWAL</b></td><td>:</td><td><?= tgl_indo($fill['tanggal']) ;?></td><td><b>JAM</b></td><td>:</td><td><?= $fill['jam'] ?></td>
    </tr>
</table>

</center>
<table border="1px" align="center" width=100%>
	<thead>
	
		<tr>
			<th>No.</th>
			<th>NIM</th>
			<th>NAMA</th>
			<th>NILAI</th>
			<th>TTD KEHADIRAN</th>
		</tr>
	</thead>
	<tbody>
			<?php
	$sql = "select akrs.*, sm.nama FROM
			akademik_krs as akrs, student_mahasiswa as sm, akademik_jadwal_kuliah as jk WHERE
			akrs.jadwal_id=jk.jadwal_id and sm.nim=akrs.nim and akrs.jadwal_id='$_id'
			order by akrs.nim ASC
			";
	$querya = mysqli_query($koneksi, $sql);
		$no=1;
		if (mysqli_num_rows($querya) > 0):
			while($field = mysqli_fetch_array($querya)):
	?>
	
		<tr height="50px">
			<td><?= $no++ ?></td>
			<td><?= $field['nim'] ?></td>
			<td><?= $field['nama'] ?></td>
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
<table style="width: 600px;" align="center">
<tr>
	<td></td>
	<td></td>
	<td align="right"><h4>Ungaran, ..................</h4></td>
</tr>
<tr>
	<td></td><td></td><td align="right"><h4>Pengawas Ujian</h4></td>
</tr>
<?php
$loadkaprodi = mysqli_query($koneksi,"SELECT nama_ketua FROM akademik_prodi WHERE akademik_prodi.prodi_id=akademik_konsentrasi.prodi_id AND akademik_konsentrasi.konsentrasi_id='$konsentrasi_id'");
$display = mysqli_fetch_array($loadkaprodi);
?>
<tr><td><br><br><br><?= $display['nama_ketua'] ?><br></td><td></td><td align="right"><br><br><br><?= $nama_lengkap?><br>_____________________</td></tr>
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