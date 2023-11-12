<html>
<h1>
<a href="<?= $_url ?>" class="nav-button transform"><span></span></a>
</h1>

<?php
// 	$sql = "select akrs.*, ad.nama_lengkap, akls.nama_kelas, ata.keterangan, sm.nama, mm.nama_makul, mm.sks, akon.nama_konsentrasi 
// 	        FROM
// 			akademik_krs as akrs, student_mahasiswa as sm, akademik_jadwal_kuliah as jk,
// 			makul_matakuliah as mm, akademik_kelas as akls, akademik_tahun_akademik as ata,
// 			akademik_konsentrasi as akon, app_dosen as ad
// 			WHERE jk.jadwal_id=akrs.jadwal_id and
// 			jk.dosen_id=ad.dosen_id and
// 			jk.konsentrasi_id=akon.konsentrasi_id and
// 			jk.tahun_akademik_id=ata.tahun_akademik_id and
// 			jk.makul_id=mm.makul_id and
// 			jk.id_kelas=akls.id_kelas and
// 			sm.nim=akrs.nim and
// 			akrs.jadwal_id='$_id'";
	$sql = "SELECT akademik_krs.*, app_dosen.nama_lengkap, akademik_kelas.nama_kelas, student_mahasiswa.nama, makul_matakuliah.nama_makul, makul_matakuliah.sks, akademik_konsentrasi.nama_konsentrasi
	        FROM akademik_krs
	        LEFT JOIN akademik_jadwal_kuliah ON akademik_jadwal_kuliah.jadwal_id=akademik_krs.jadwal_id
	        LEFT JOIN app_dosen ON app_dosen.dosen_id=akademik_jadwal_kuliah.dosen_id
	        LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=akademik_jadwal_kuliah.konsentrasi_id
	        LEFT JOIN akademik_tahun_akademik ON akademik_tahun_akademik.tahun_akademik_id=akademik_jadwal_kuliah.tahun_akademik_id
	        LEFT JOIN makul_matakuliah ON makul_matakuliah.makul_id=akademik_jadwal_kuliah.makul_id
	        LEFT JOIN akademik_kelas ON akademik_kelas.id_kelas=akademik_jadwal_kuliah.id_kelas
	        LEFT JOIN student_mahasiswa ON student_mahasiswa.nim=akademik_krs.nim
	        WHERE akademik_krs.jadwal_id='$_id'";
	$query = mysqli_query($koneksi, $sql);
	$fieldd = mysqli_fetch_array($query);
	extract($fieldd);
?>
<a href="javascript:printDiv('cetak');"><span style="color: red; font-size: 50;"><b><i><u>PRINT</u></i></b></span></a>
<div id="cetak">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>UNIVERSITAS DARUL ULUM ISLAMIC CENTRE SUDIRMAN GUPPI (UNDARIS)</title>
</head>
<body>
	<center>
		<img src="https://siakad.undaris.ac.id/assets/img/header.png" alt="UNIVERSITAS DARUL ULUM ISLAMIC CENTRE SUDIRMAN GUPPI (UNDARIS)" width="100%">
	</center>
<center>
<h4>DAFTAR NILAI MAHASISWA</h4>
<!--<H4>Fakultas :: <b><?= $nama_konsentrasi; ?></b> </H4>-->
<!--<h4>Tahun Akademik :: <b><?= $keterangan; ?></b> || Kelas :: <b><?= $nama_kelas; ?></b> || Mata Kuliah :: <b><?= $nama_makul; ?></b> || Semester :: <b><?= $semester; ?></b>   </h4>-->
<table>
    <tr>
        <td>Jurusan</td>
        <td>:</td>
        <td><?= $nama_konsentrasi; ?></td>
        <td>&nbsp;&nbsp;</td>
        <td>Kelas</td>
        <td>:</td>
        <td><?= $nama_kelas ?></td>
    </tr>
    <tr>
        <td>Matakuliah</td>
        <td>:</td>
        <td><?= $nama_makul; ?></td>
        <td>&nbsp;&nbsp;</td>
        <td>Dosen</td>
        <td>:</td>
        <td><?= $nama_lengkap; ?></td>
    </tr>
    <tr>
        <td>SKS</td>
        <td>:</td>
        <td><?= $sks; ?></td>
    </tr>
</table>
</center>
<center>
<table border="1px" width="100%">
		<tr>
			<th>NO</th>
			<th>NIM</th>
			<th>NAMA MAHASISWA</th>
			<!--<th>STATUS</th>-->
			<!--<th>KEHADIRAN</th>-->
			<!--<th>TUGAS</th>-->
			<!--<th>UTS</th>-->
			<!--<th>UAS</th>-->
			<th>NILAI AKHIR</th>
			<th>GRADE</th>
		</tr>
	<?php
// 	$sql = "select akrs.*, akh.kehadiran, akh.tugas, akh.mutu, akh.mutu2, akh.nilai_akhir, akh.grade, sm.nama, ak.nama_konsentrasi FROM
// 			akademik_krs as akrs, akademik_khs as akh, akademik_konsentrasi as ak, student_mahasiswa as sm WHERE
// 			akrs.krs_id=akh.krs_id and sm.nim=akrs.nim and sm.konsentrasi_id=ak.konsentrasi_id and akrs.jadwal_id='$_id'
// 			ORDER BY akrs.nim";
	$sql = "SELECT akademik_krs.*, akademik_khs.kehadiran, akademik_khs.tugas, akademik_khs.mutu, akademik_khs.mutu2, akademik_khs.nilai_akhir, akademik_khs.grade, student_mahasiswa.nama, akademik_konsentrasi.nama_konsentrasi
	        FROM akademik_krs
	        LEFT JOIN akademik_khs ON akademik_khs.krs_id=akademik_krs.krs_id
	        LEFT JOIN student_mahasiswa ON student_mahasiswa.nim=akademik_krs.nim
	        LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=student_mahasiswa.konsentrasi_id
	        WHERE akademik_krs.jadwal_id='$_id'
	        ORDER BY akademik_krs.nim ASC";
	$querya = mysqli_query($koneksi, $sql);
		$no=1;
		if (mysqli_num_rows($querya) > 0):
			while($field = mysqli_fetch_array($querya)):
	?>
		<tr>
			<td><?= $no ++ ?></td>
			<td><?= $field['nim'] ?></td>
			<td><?= $field['nama'] ?></td>
			<!--<td><?= $field['accept']==1?'<i>Sudah disetujui</i>':'<b>Belum disetujui</b>'; ?></td>-->
			<!--<td><?= $field['kehadiran'] ?></td>-->
			<!--<td><?= $field['tugas'] ?></td>-->
			<!--<td><?= $field['mutu'] ?></td>-->
			<!--<td><?= $field['mutu2'] ?></td>-->
			<td><?= round($field['nilai_akhir'],2) ?></td>
			<td><?= $field['grade'] ?></td>
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
</table>
</center>
<br>
<br>
<table border="0px" align="right">
    <center>
<tr>
	        <td>Mengetahui Dosen Pengampu</td>
	    </tr>
	    <tr>
	        <td>&nbsp;</td>
	        </tr>
	        <tr>
	        <td>&nbsp;</td>
	        </tr>
	        <tr>
	        <td>&nbsp;</td>
	        </tr>
	    <tr><td>
	        <b><?= $nama_lengkap; ?></b>
	    </td></tr>
	    </center>
	    </table>
<!--<table style="align : left;">-->
<!--    <tr>-->
<!--	        <td>Mengetahui Dosen Pengampu</td>-->
<!--	    </tr>-->
<!--	    <tr>-->
<!--	        <td>&nbsp;</td>-->
<!--	        </tr>-->
<!--	        <tr>-->
<!--	        <td>&nbsp;</td>-->
<!--	        </tr>-->
<!--	        <tr>-->
<!--	        <td>&nbsp;</td>-->
<!--	        </tr>-->
<!--	    <tr><td>-->
<!--	        <b><?= $nama_lengkap; ?></b>-->
<!--	    </td></tr>-->
<!--</table>-->
	
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