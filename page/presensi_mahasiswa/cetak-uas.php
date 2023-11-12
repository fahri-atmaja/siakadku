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
	$sql = "SELECT makul_matakuliah.nama_makul, akademik_jadwal_kuliah.semester, app_dosen.nama_lengkap, akademik_konsentrasi.nama_konsentrasi, akademik_kelas.nama_kelas FROM akademik_jadwal_kuliah
	        LEFT JOIN makul_matakuliah ON makul_matakuliah.makul_id=akademik_jadwal_kuliah.makul_id
	        LEFT JOIN app_dosen ON app_dosen.dosen_id=akademik_jadwal_kuliah.dosen_id
	        LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=akademik_jadwal_kuliah.konsentrasi_id
	        LEFT JOIN akademik_kelas ON akademik_kelas.id_kelas=akademik_jadwal_kuliah.id_kelas
	        WHERE akademik_jadwal_kuliah.jadwal_id='$_id'";
// $sql = "SELECT jadwal_kuliah.tanggal, jadwal_kuliah.jam, app_ruangan.nama_ruangan, akademik_jadwal_kuliah.semester, akademik_jadwal_kuliah.jadwal_id, akademik_kelas.nama_kelas,makul_matakuliah.nama_makul,app_dosen.nama_lengkap,
// 	        akademik_konsentrasi.nama_konsentrasi FROM jadwal_kuliah
//             LEFT JOIN app_ruangan ON app_ruangan.ruangan_id=jadwal_kuliah.ruangan_id
//             LEFT JOIN akademik_jadwal_kuliah ON akademik_jadwal_kuliah.jadwal_id=jadwal_kuliah.jadwal_id
//             LEFT JOIN akademik_kelas ON akademik_kelas.id_kelas=akademik_jadwal_kuliah.id_kelas
//             LEFT JOIN makul_matakuliah ON makul_matakuliah.makul_id=akademik_jadwal_kuliah.makul_id
//             LEFT JOIN app_dosen ON app_dosen.dosen_id=akademik_jadwal_kuliah.dosen_id
//             LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=akademik_jadwal_kuliah.konsentrasi_id
//             WHERE jadwal_kuliah.jadwal_id='{$_id}'";
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
<h4><b>DAFTAR HADIR UJIAN AKHIR SEMESTER <?= $fill['semester'] ?> <br>TAHUN AKADEMIK <?= $f['keterangan']; ?></b></h4>
<table border="0px" align="justify" width="100%">
    <tr>
        <td><b>JURUSAN</b></td><td>:</td><td><?= $fill['nama_konsentrasi'] ?></td><td><b>DOSEN</b></td><td>:</td><td><?= $fill['nama_lengkap'] ?></td>
    </tr>
    <tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
    <tr>
        <td><b>MATAKULIAH</b></td><td>:</td><td><?= $fill['nama_makul'] ?></td><td><b>KELAS</b></td><td>:</td><td><?= $fill['nama_kelas'] ?></td>
    </tr>
    <!--<tr>-->
    <!--    <td><b>JADWAL</b></td><td>:</td><td><?= tgl_indo($fill['tanggal']) ;?></td><td><b>JAM</b></td><td>:</td><td><?= $fill['jam'] ?></td>-->
    <!--</tr>-->
</table>

</center>
<!--<h5><b>DAFTAR PESERTA DAN NILAI UJIAN AKHIR SEMESTER</b></h5>-->
<!--<table border="0px" align="center" width="40%">-->
<!--    <tr>-->
<!--        <td>Mata kuliah</td>-->
<!--        <td>:</td>-->
<!--        <td><b><?= $f['nama_makul'] ?></b></td>-->
<!--    </tr>-->
<!--    <tr>-->
<!--        <td>Semester</td>-->
<!--        <td>:</td>-->
<!--        <td><b><?= $f['semester'] ?></b></td>-->
<!--    </tr>-->
<!--    <tr>-->
<!--        <td>Dosen</td>-->
<!--        <td>:</td>-->
<!--        <td><b><?= $f['nama_lengkap'] ?></b></td>-->
<!--    </tr>-->
<!--</table>-->
<!--<h5>Mata Kuliah :: <b><?= $f['nama_makul'] ?></b> || Semester :: <b><?= $f['semester'] ?></b> || Pengampu :: <b><?= $f['nama_lengkap'] ?></b>   </h5>-->

</center>
<table border="1px" align="center" width="100%">
	<thead>
		<tr>
			<th>No.</th>
			<th>NIM</th>
			<th>NAMA</th>
			<!--<th>SPP</th>-->
			<th>TTD</th>
			<th>Khd</th>
			<th>Tugas</th>
			<th>UTS</th>
			<th>UAS</th>
			<th>Nilai Akhir</th>
			<!--<th>NH</th>-->
		</tr>
	</thead>
	<tbody>
			<?php
	$sqll = "SELECT akademik_krs.nim, student_angkatan.spp, student_mahasiswa.nama, student_mahasiswa.beasiswa,student_mahasiswa.kpt FROM akademik_krs
	         LEFT JOIN student_mahasiswa ON student_mahasiswa.nim=akademik_krs.nim
	         LEFT JOIN student_angkatan ON student_angkatan.angkatan_id=student_mahasiswa.angkatan_id
	         WHERE akademik_krs.jadwal_id='$_id'
	         GROUP BY akademik_krs.nim";
	$querya = mysqli_query($koneksi, $sqll);
		$no=1;
		if (mysqli_num_rows($querya) > 0):
			while($field = mysqli_fetch_array($querya)):
			    $load = mysqli_query($koneksi,"SELECT * FROM proses_transaksi
			                                    LEFT JOIN tagihan_mahasiswa ON tagihan_mahasiswa.id_tagihan=proses_transaksi.id_tagihan
			                                    WHERE tagihan_mahasiswa.jenis_bayar='03' AND proses_transaksi.nim='$field[nim]' AND proses_transaksi.status_bayar='Y'");
			    $c = mysqli_num_rows($load);
			    $bpd = mysqli_query($koneksi,"SELECT * FROM bpd_jateng WHERE nim='$field[nim]' AND kode_bayar='03'");
			    $cc = mysqli_num_rows($bpd);
			    $ccc = $c + $cc;
	?>
	
		<tr>
			<td><?= $no++ ?></td>
			<td><? if($field['beasiswa']==0 && $field['kpt']==0){
			if($field['spp'] > $ccc){ echo "<span style= 'color:red'><u>".$field['nim']."</u></span>";}else echo $field['nim']; }
			else{
			    echo $field['nim'];
			}?>
			</td>
			<td><? if($field['beasiswa']==0 && $field['kpt']==0){
			if($field['spp'] > $ccc){ echo "<span style= 'color:red'><u>".strtoupper($field['nama'])."</u></span>";}else echo strtoupper($field['nama']); }
			else{
			    echo strtoupper($field['nama']);
			}?>
			</td>
			<!--<td><?= $ccc ?></td>-->
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<!--<td></td>-->
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
<table style="width: 600px;" align="center">
	<?php 
		$load=mysqli_query($koneksi,"SELECT ap.ketua FROM akademik_prodi as ap, akademik_konsentrasi as ak, akademik_jadwal_kuliah as jk 
			WHERE ap.prodi_id=ak.prodi_id and ak.konsentrasi_id=jk.konsentrasi_id and jk.jadwal_id='{$_id}'");
		$display = mysqli_fetch_array($load);
	?>
<tr>
	<td></td>
	<td></td>
	<td align="right"><h4>Ungaran, ..................</h4></td>
</tr>
<tr>
	<td><h4>Mengetahui Ketua Prodi</h4></td><td></td><td align="right"><h4>Dosen Penguji</h4></td>
</tr>
<tr><td><br><br><br><p align="center>"><b><?php echo $display['ketua'] ?></b></p></td><td></td><td align="right"><br><br><br><p align="center>"><b>
    <?php
    // $loadp = mysqli_query($koneksi,"SELECT jadwal_kuliah.*, app_dosen.nama_lengkap FROM jadwal_kuliah
    //                                 LEFT JOIN app_dosen ON app_dosen.dosen_id=jadwal_kuliah.dosen_id
    //                                 WHERE jadwal_kuliah.jadwal_id='$_id'");
    // $p = mysqli_fetch_array($loadp);
    // echo $p['nama_lengkap']; 
    ?>
    ..........................</b></p></td></tr>
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