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
// $sql = "SELECT jadwal_kuliah.tanggal, jadwal_kuliah.jam, app_ruangan.nama_ruangan, akademik_jadwal_kuliah.semester, akademik_jadwal_kuliah.jadwal_id, akademik_kelas.nama_kelas,makul_matakuliah.nama_makul,app_dosen.nama_lengkap,
// 	        akademik_konsentrasi.nama_konsentrasi FROM jadwal_kuliah
//             LEFT JOIN app_ruangan ON app_ruangan.ruangan_id=jadwal_kuliah.ruangan_id
//             LEFT JOIN akademik_jadwal_kuliah ON akademik_jadwal_kuliah.jadwal_id=jadwal_kuliah.jadwal_id
//             LEFT JOIN akademik_kelas ON akademik_kelas.id_kelas=akademik_jadwal_kuliah.id_kelas
//             LEFT JOIN makul_matakuliah ON makul_matakuliah.makul_id=akademik_jadwal_kuliah.makul_id
//             LEFT JOIN app_dosen ON app_dosen.dosen_id=akademik_jadwal_kuliah.dosen_id
//             LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=akademik_jadwal_kuliah.konsentrasi_id
//             WHERE jadwal_kuliah.jadwal_id='{$_id}'";
// 	$query = mysqli_query($koneksi, $sql);
// 		$fill = mysqli_fetch_array($query);
//         	$tahun = mysqli_query($koneksi,"SELECT * FROM akademik_tahun_akademik WHERE status='y'");
//         	$f = mysqli_fetch_array($tahun);
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
<h4><b>CEK PEMBAYARAN ANGKATAN 2021 REGULER</b></h4>

</center>
</center>
<table border="1px" align="center" width="100%">
	<thead>
		<tr>
			<th>No.</th>
			<th>NIM</th>
			<th>NAMA</th>
			<th>SPP</th>
			<th>JURUSAN</th>
		</tr>
	</thead>
	<tbody>
			<?php
	$sqll = "SELECT student_mahasiswa.nim, student_angkatan.spp, student_mahasiswa.nama, student_mahasiswa.beasiswa,student_mahasiswa.kpt, akademik_konsentrasi.nama_konsentrasi FROM student_mahasiswa
	         LEFT JOIN akademik_konsentrasi ON student_mahasiswa.konsentrasi_id=akademik_konsentrasi.konsentrasi_id
	         LEFT JOIN student_angkatan ON student_angkatan.angkatan_id=student_mahasiswa.angkatan_id
	         WHERE student_mahasiswa.angkatan_id=17 AND student_mahasiswa.kpt=0 AND student_mahasiswa.beasiswa=0
	         ORDER BY student_mahasiswa.nim ASC";
	$querya = mysqli_query($koneksi, $sqll);
	$f = mysqli_fetch_array($querya);
		$no=1;
		if (mysqli_num_rows($querya) > 0):
			while($field = mysqli_fetch_array($querya)):
			    $load = mysqli_query($koneksi,"SELECT * FROM proses_transaksi
			                                    LEFT JOIN tagihan_mahasiswa ON tagihan_mahasiswa.id_tagihan=proses_transaksi.id_tagihan
			                                    WHERE tagihan_mahasiswa.jenis_bayar='03' AND proses_transaksi.nim='$field[nim]' AND proses_transaksi.status_bayar='Y'");
			    $c = mysqli_num_rows($load);
	?>
	
		<tr>
			<td><?= $no++ ?></td>
			<td><? if($field['beasiswa']==0 && $field['kpt']==0){
			if($field['spp'] > $c){ echo "<s>".$field['nim']."</s>";}else echo $field['nim']; }
			else{
			    echo $field['nim'];
			}?>
			</td>
			<td><? if($field['beasiswa']==0 && $field['kpt']==0){
			if($field['spp'] > $c){ echo "<s>".strtoupper($field['nama'])."</s>";}else echo strtoupper($field['nama']); }
			else{
			    echo strtoupper($field['nama']);
			}?>
			</td>
			<td> <?= $c ?></td>
			<td><?= $field['nama_konsentrasi'] ?></td>
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