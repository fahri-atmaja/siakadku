<!DOCTYPE html>
<html>

<?php
	if ($_access == 'mahasiswa' && $_id != $_username) {
		header("location:{$_url}krs/view/{$_username}");
	}
?>
<a href="javascript:printDiv('cetak');"><span style="color: red; font-size: 50;"><b><i><u>PRINT</u></i></b></span></a>
<div id="cetak">
	
<?php
// $load   = "SELECT status FROM bayar_sks WHERE nim='$_username' AND semester='$_params[1]'";
// $proses = mysqli_query($koneksi,$load);
// $block = mysqli_fetch_array($proses);
// $loadangsur=mysqli_query($koneksi,"SELECT angsuran FROM bayar_angsuran WHERE nim='$_id' order by angsuran ASC limit 1");
// $mhsangsur= mysqli_fetch_array($loadangsur);
// if ($block==0){
// 		echo "<script>window.alert('MAAF ANDA BELUM MELAKUKAN PEMBAYARAN')
//     window.location.href='{$_url}krs/view/$_username'</script>";
// 	}
// if ($mhsangsur['angsuran']=='1'):
$loaduang=mysqli_query($koneksi,"SELECT jenis_bayar_id FROM keuangan_pembayaran_detail WHERE nim='$_id' AND jenis_bayar_id between 34 and 40");
$status= mysqli_fetch_array($loaduang);
if ($status['jenis_bayar_id']=='34' and $_params[1]=='1'):
	?>
	<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
$querya = mysqli_query($koneksi, "SELECT student_mahasiswa.*, app_dosen.nama_lengkap, student_angkatan.keterangan, akademik_konsentrasi.nama_konsentrasi as nama_konsentrasi FROM student_mahasiswa 
	LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=student_mahasiswa.konsentrasi_id
	LEFT JOIN student_angkatan ON student_angkatan.angkatan_id=student_mahasiswa.angkatan_id
	LEFT JOIN app_dosen ON app_dosen.dosen_id=student_mahasiswa.dosen_id
	WHERE nim='{$_id}'");
$field = mysqli_fetch_array($querya);
extract($field);

?>
<center>
<h3>KARTU RENCANA STUDI MAHASISWA</h3>
<!-- <h3>Semester <?= $semester ?> Tahun <?= $keterangan ?> </h3> -->
</center>

<br>
<center>
<table style="width: 600px;">
<tr><td>NIM</td><td>:</td><td><?= $nim ?></td><td></td><td>Semester</td><td>:</td><td><?= $semester ?></td></tr>
<tr><td>Nama</td><td>:</td><td><?= $nama ?></td><td></td><td>Tahun Akademik</td><td>:</td><td><?= $keterangan ?></td></tr>
<tr><td>Progdi</td><td>:</td><td><?= $nama_konsentrasi ?></td><td></td><td>Pembimbing Akademik</td><td>:</td><td><?= $nama_lengkap?></td></tr>
</table>
</center>

<?php

	$sql = "SELECT akademik_krs.*, makul_matakuliah.kode_makul, makul_matakuliah.nama_makul, makul_matakuliah.sks, app_dosen.nama_lengkap FROM
        akademik_krs
        LEFT JOIN akademik_jadwal_kuliah ON akademik_jadwal_kuliah.jadwal_id=akademik_krs.jadwal_id
        LEFT JOIN makul_matakuliah ON makul_matakuliah.makul_id=akademik_jadwal_kuliah.makul_id
        LEFT JOIN app_dosen ON app_dosen.dosen_id=akademik_jadwal_kuliah.dosen_id
        WHERE akademik_krs.nim='$nim' AND akademik_jadwal_kuliah.semester='$semester'";
	$query = mysqli_query($koneksi, $sql);
?>

<table border="1px" padding="1" align="center" style="width: 600px;">
	<thead>
		<tr>
			<th>Kode</th>
			<th>Matakuliah</th>
			<th>SKS</th>
			<th>Dosen</th>
			<th>Status</th>
		</tr>
	</thead>
	<tbody>

	<?php
	$sks=0;
		if (mysqli_num_rows($query) > 0):
			while($field = mysqli_fetch_array($query)):
				$sks=$sks+$field['sks'];
				
	?>
		<tr>
			<td><?= $field['kode_makul'] ?></td>
			<td><?= $field['nama_makul'] ?></td>
			<td><?= $field['sks'] ?></td>
			<td><?= $field['nama_lengkap'] ?></td>
			<td><?= $field['accept']==1?'sudah disetujui':'belum disetujui'; ?></td>
			
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
	<tfoot><tr><td colspan='2' align='right'>Total SKS yang ditempuh</td><td><?php 
			echo $sks ?></td><td colspan=3></td></tr></tfoot>
</table>
<table style="width: 600px;" align="center">
<tr>
	<td></td>
	<td></td>
	<td align="right"><h4>Ungaran, <?php echo date('d-m-Y')?></h4></td>
</tr>
<tr>
	<td><h4>Mengetahui Pembimbing Akademik</h4></td><td></td><td align="right"><h4>Mahasiswa Yang Bersangkutan</h4></td>
</tr>
<tr><td><br><br><br><?= $nama_lengkap?><br>__________________________________</td><td></td><td align="right"><br><br><br><?= $nama?><br>__________________________________</td></tr>
</table>
<!-- <script>
		window.print();
</script> -->
	
</body>
<?php
	elseif ($status['jenis_bayar_id']=='35' and $_params[1]=='2'):
		?>
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
$querya = mysqli_query($koneksi, "SELECT student_mahasiswa.*, app_dosen.nama_lengkap, student_angkatan.keterangan, akademik_konsentrasi.nama_konsentrasi as nama_konsentrasi FROM student_mahasiswa 
	LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=student_mahasiswa.konsentrasi_id
	LEFT JOIN student_angkatan ON student_angkatan.angkatan_id=student_mahasiswa.angkatan_id
	LEFT JOIN app_dosen ON app_dosen.dosen_id=student_mahasiswa.dosen_id
	WHERE nim='{$_id}'");
$field = mysqli_fetch_array($querya);
extract($field);

?>
<center>
<h3>KARTU RENCANA STUDI MAHASISWA</h3>
<!-- <h3>Semester <?= $semester ?> Tahun <?= $keterangan ?> </h3> -->
</center>

<br>
<center>
<table style="width: 600px;">
<tr><td>NIM</td><td>:</td><td><?= $nim ?></td><td></td><td>Semester</td><td>:</td><td><?= $semester ?></td></tr>
<tr><td>Nama</td><td>:</td><td><?= $nama ?></td><td></td><td>Tahun Akademik</td><td>:</td><td><?= $keterangan ?></td></tr>
<tr><td>Progdi</td><td>:</td><td><?= $nama_konsentrasi ?></td><td></td><td>Pembimbing Akademik</td><td>:</td><td><?= $nama_lengkap?></td></tr>
</table>
</center>

<?php

	$sql = "select ak.*,mm.kode_makul,mm.nama_makul,mm.sks,ad.nama_lengkap
            FROM makul_matakuliah as mm,akademik_jadwal_kuliah as jk,akademik_krs as ak,app_dosen as ad
            WHERE mm.makul_id=jk.makul_id and ad.dosen_id=jk.dosen_id and jk.jadwal_id=ak.jadwal_id and ak.nim='$nim'
            and jk.semester='$semester'";

	$query = mysqli_query($koneksi, $sql);
?>

<table border="1" padding="1" align="center" style="width: 600px;">
	<thead>
		<tr>
			<th>Kode</th>
			<th>Matakuliah</th>
			<th>SKS</th>
			<th>Dosen</th>
			<th>Status</th>
		</tr>
	</thead>
	<tbody>

	<?php
	$sks=0;
		if (mysqli_num_rows($query) > 0):
			while($field = mysqli_fetch_array($query)):
				$sks=$sks+$field['sks'];
				
	?>
		<tr>
			<td><?= $field['kode_makul'] ?></td>
			<td><?= $field['nama_makul'] ?></td>
			<td><?= $field['sks'] ?></td>
			<td><?= $field['nama_lengkap'] ?></td>
			<td><?= $field['accept']==1?'sudah disetujui':'belum disetujui'; ?></td>
			
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
	<tfoot><tr><td colspan='2' align='right'>Total SKS yang ditempuh</td><td><?php 
			echo $sks ?></td><td colspan=3></td></tr></tfoot>
</table>
<table style="width: 600px;" align="center">
<tr>
	<td></td>
	<td></td>
	<td align="right"><h4>Ungaran, <?php echo date('d-m-Y')?></h4></td>
</tr>
<tr>
	<td><h4>Mengetahui Pembimbing Akademik</h4></td><td></td><td align="right"><h4>Mahasiswa Yang Bersangkutan</h4></td>
</tr>
<tr><td><br><br><br><?= $nama_lengkap?><br>__________________________________</td><td></td><td align="right"><br><br><br><?= $nama?><br>__________________________________</td></tr>
</table>
<!-- <script>
		window.print();
</script> -->
	
</body>
<?php
		elseif ($status['jenis_bayar_id']=='36' and $_params[1]=='3'):
			?>
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
$querya = mysqli_query($koneksi, "SELECT student_mahasiswa.*, app_dosen.nama_lengkap, student_angkatan.keterangan, akademik_konsentrasi.nama_konsentrasi as nama_konsentrasi FROM student_mahasiswa 
	LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=student_mahasiswa.konsentrasi_id
	LEFT JOIN student_angkatan ON student_angkatan.angkatan_id=student_mahasiswa.angkatan_id
	LEFT JOIN app_dosen ON app_dosen.dosen_id=student_mahasiswa.dosen_id
	WHERE nim='{$_id}'");
$field = mysqli_fetch_array($querya);
extract($field);

?>
<center>
<h3>KARTU RENCANA STUDI MAHASISWA</h3>
<!-- <h3>Semester <?= $semester ?> Tahun <?= $keterangan ?> </h3> -->
</center>

<br>
<center>
<table style="width: 600px;">
<tr><td>NIM</td><td>:</td><td><?= $nim ?></td><td></td><td>Semester</td><td>:</td><td><?= $semester ?></td></tr>
<tr><td>Nama</td><td>:</td><td><?= $nama ?></td><td></td><td>Tahun Akademik</td><td>:</td><td><?= $keterangan ?></td></tr>
<tr><td>Progdi</td><td>:</td><td><?= $nama_konsentrasi ?></td><td></td><td>Pembimbing Akademik</td><td>:</td><td><?= $nama_lengkap?></td></tr>
</table>
</center>

<?php

	$sql = "select ak.*,mm.kode_makul,mm.nama_makul,mm.sks,ad.nama_lengkap
            FROM makul_matakuliah as mm,akademik_jadwal_kuliah as jk,akademik_krs as ak,app_dosen as ad
            WHERE mm.makul_id=jk.makul_id and ad.dosen_id=jk.dosen_id and jk.jadwal_id=ak.jadwal_id and ak.nim='$nim'
            and jk.semester='$semester'";

	$query = mysqli_query($koneksi, $sql);
?>

<table border="1" padding="1" align="center" style="width: 600px;">
	<thead>
		<tr>
			<th>Kode</th>
			<th>Matakuliah</th>
			<th>SKS</th>
			<th>Dosen</th>
			<th>Status</th>
		</tr>
	</thead>
	<tbody>

	<?php
	$sks=0;
		if (mysqli_num_rows($query) > 0):
			while($field = mysqli_fetch_array($query)):
				$sks=$sks+$field['sks'];
				
	?>
		<tr>
			<td><?= $field['kode_makul'] ?></td>
			<td><?= $field['nama_makul'] ?></td>
			<td><?= $field['sks'] ?></td>
			<td><?= $field['nama_lengkap'] ?></td>
			<td><?= $field['accept']==1?'sudah disetujui':'belum disetujui'; ?></td>
			
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
	<tfoot><tr><td colspan='2' align='right'>Total SKS yang ditempuh</td><td><?php 
			echo $sks ?></td><td colspan=3></td></tr></tfoot>
</table>
<table style="width: 600px;" align="center">
<tr>
	<td></td>
	<td></td>
	<td align="right"><h4>Ungaran, <?php echo date('d-m-Y')?></h4></td>
</tr>
<tr>
	<td><h4>Mengetahui Pembimbing Akademik</h4></td><td></td><td align="right"><h4>Mahasiswa Yang Bersangkutan</h4></td>
</tr>
<tr><td><br><br><br><?= $nama_lengkap?><br>__________________________________</td><td></td><td align="right"><br><br><br><?= $nama?><br>__________________________________</td></tr>
</table>
<!-- <script>
		window.print();
</script> -->
	
</body>
<?php
			elseif ($status['jenis_bayar_id']=='37' and $_params[1]=='4'):
				?>
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
$querya = mysqli_query($koneksi, "SELECT student_mahasiswa.*, app_dosen.nama_lengkap, student_angkatan.keterangan, akademik_konsentrasi.nama_konsentrasi as nama_konsentrasi FROM student_mahasiswa 
	LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=student_mahasiswa.konsentrasi_id
	LEFT JOIN student_angkatan ON student_angkatan.angkatan_id=student_mahasiswa.angkatan_id
	LEFT JOIN app_dosen ON app_dosen.dosen_id=student_mahasiswa.dosen_id
	WHERE nim='{$_id}'");
$field = mysqli_fetch_array($querya);
extract($field);

?>
<center>
<h3>KARTU RENCANA STUDI MAHASISWA</h3>
<!-- <h3>Semester <?= $semester ?> Tahun <?= $keterangan ?> </h3> -->
</center>

<br>
<center>
<table style="width: 600px;">
<tr><td>NIM</td><td>:</td><td><?= $nim ?></td><td></td><td>Semester</td><td>:</td><td><?= $semester ?></td></tr>
<tr><td>Nama</td><td>:</td><td><?= $nama ?></td><td></td><td>Tahun Akademik</td><td>:</td><td><?= $keterangan ?></td></tr>
<tr><td>Progdi</td><td>:</td><td><?= $nama_konsentrasi ?></td><td></td><td>Pembimbing Akademik</td><td>:</td><td><?= $nama_lengkap?></td></tr>
</table>
</center>

<?php

	$sql = "select ak.*,mm.kode_makul,mm.nama_makul,mm.sks,ad.nama_lengkap
            FROM makul_matakuliah as mm,akademik_jadwal_kuliah as jk,akademik_krs as ak,app_dosen as ad
            WHERE mm.makul_id=jk.makul_id and ad.dosen_id=jk.dosen_id and jk.jadwal_id=ak.jadwal_id and ak.nim='$nim'
            and jk.semester='$semester'";

	$query = mysqli_query($koneksi, $sql);
?>

<table border="1" padding="1" align="center" style="width: 600px;">
	<thead>
		<tr>
			<th>Kode</th>
			<th>Matakuliah</th>
			<th>SKS</th>
			<th>Dosen</th>
			<th>Status</th>
		</tr>
	</thead>
	<tbody>

	<?php
	$sks=0;
		if (mysqli_num_rows($query) > 0):
			while($field = mysqli_fetch_array($query)):
				$sks=$sks+$field['sks'];
				
	?>
		<tr>
			<td><?= $field['kode_makul'] ?></td>
			<td><?= $field['nama_makul'] ?></td>
			<td><?= $field['sks'] ?></td>
			<td><?= $field['nama_lengkap'] ?></td>
			<td><?= $field['accept']==1?'sudah disetujui':'belum disetujui'; ?></td>
			
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
	<tfoot><tr><td colspan='2' align='right'>Total SKS yang ditempuh</td><td><?php 
			echo $sks ?></td><td colspan=3></td></tr></tfoot>
</table>
<table style="width: 600px;" align="center">
<tr>
	<td></td>
	<td></td>
	<td align="right"><h4>Ungaran, <?php echo date('d-m-Y')?></h4></td>
</tr>
<tr>
	<td><h4>Mengetahui Pembimbing Akademik</h4></td><td></td><td align="right"><h4>Mahasiswa Yang Bersangkutan</h4></td>
</tr>
<tr><td><br><br><br><?= $nama_lengkap?><br>__________________________________</td><td></td><td align="right"><br><br><br><?= $nama?><br>__________________________________</td></tr>
</table>
<!-- <script>
		window.print();
</script> -->
	
</body>
<?php
				elseif ($status['jenis_bayar_id']=='38' and $_params[1]=='5'):
					?>
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
$querya = mysqli_query($koneksi, "SELECT student_mahasiswa.*, app_dosen.nama_lengkap, student_angkatan.keterangan, akademik_konsentrasi.nama_konsentrasi as nama_konsentrasi FROM student_mahasiswa 
	LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=student_mahasiswa.konsentrasi_id
	LEFT JOIN student_angkatan ON student_angkatan.angkatan_id=student_mahasiswa.angkatan_id
	LEFT JOIN app_dosen ON app_dosen.dosen_id=student_mahasiswa.dosen_id
	WHERE nim='{$_id}'");
$field = mysqli_fetch_array($querya);
extract($field);

?>
<center>
<h3>KARTU RENCANA STUDI MAHASISWA</h3>
<!-- <h3>Semester <?= $semester ?> Tahun <?= $keterangan ?> </h3> -->
</center>

<br>
<center>
<table style="width: 600px;">
<tr><td>NIM</td><td>:</td><td><?= $nim ?></td><td></td><td>Semester</td><td>:</td><td><?= $semester ?></td></tr>
<tr><td>Nama</td><td>:</td><td><?= $nama ?></td><td></td><td>Tahun Akademik</td><td>:</td><td><?= $keterangan ?></td></tr>
<tr><td>Progdi</td><td>:</td><td><?= $nama_konsentrasi ?></td><td></td><td>Pembimbing Akademik</td><td>:</td><td><?= $nama_lengkap?></td></tr>
</table>
</center>

<?php

	$sql = "select ak.*,mm.kode_makul,mm.nama_makul,mm.sks,ad.nama_lengkap
            FROM makul_matakuliah as mm,akademik_jadwal_kuliah as jk,akademik_krs as ak,app_dosen as ad
            WHERE mm.makul_id=jk.makul_id and ad.dosen_id=jk.dosen_id and jk.jadwal_id=ak.jadwal_id and ak.nim='$nim'
            and jk.semester='$semester'";

	$query = mysqli_query($koneksi, $sql);
?>

<table border="1" padding="1" align="center" style="width: 600px;">
	<thead>
		<tr>
			<th>Kode</th>
			<th>Matakuliah</th>
			<th>SKS</th>
			<th>Dosen</th>
			<th>Status</th>
		</tr>
	</thead>
	<tbody>

	<?php
	$sks=0;
		if (mysqli_num_rows($query) > 0):
			while($field = mysqli_fetch_array($query)):
				$sks=$sks+$field['sks'];
				
	?>
		<tr>
			<td><?= $field['kode_makul'] ?></td>
			<td><?= $field['nama_makul'] ?></td>
			<td><?= $field['sks'] ?></td>
			<td><?= $field['nama_lengkap'] ?></td>
			<td><?= $field['accept']==1?'sudah disetujui':'belum disetujui'; ?></td>
			
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
	<tfoot><tr><td colspan='2' align='right'>Total SKS yang ditempuh</td><td><?php 
			echo $sks ?></td><td colspan=3></td></tr></tfoot>
</table>
<table style="width: 600px;" align="center">
<tr>
	<td></td>
	<td></td>
	<td align="right"><h4>Ungaran, <?php echo date('d-m-Y')?></h4></td>
</tr>
<tr>
	<td><h4>Mengetahui Pembimbing Akademik</h4></td><td></td><td align="right"><h4>Mahasiswa Yang Bersangkutan</h4></td>
</tr>
<tr><td><br><br><br><?= $nama_lengkap?><br>__________________________________</td><td></td><td align="right"><br><br><br><?= $nama?><br>__________________________________</td></tr>
</table>
<!-- <script>
		window.print();
</script> -->
	
</body>
<?php
					elseif ($status['jenis_bayar_id']=='39' and $_params[1]=='6'):
						?>
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
$querya = mysqli_query($koneksi, "SELECT student_mahasiswa.*, app_dosen.nama_lengkap, student_angkatan.keterangan, akademik_konsentrasi.nama_konsentrasi as nama_konsentrasi FROM student_mahasiswa 
	LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=student_mahasiswa.konsentrasi_id
	LEFT JOIN student_angkatan ON student_angkatan.angkatan_id=student_mahasiswa.angkatan_id
	LEFT JOIN app_dosen ON app_dosen.dosen_id=student_mahasiswa.dosen_id
	WHERE nim='{$_id}'");
$field = mysqli_fetch_array($querya);
extract($field);

?>
<center>
<h3>KARTU RENCANA STUDI MAHASISWA</h3>
<!-- <h3>Semester <?= $semester ?> Tahun <?= $keterangan ?> </h3> -->
</center>

<br>
<center>
<table style="width: 600px;">
<tr><td>NIM</td><td>:</td><td><?= $nim ?></td><td></td><td>Semester</td><td>:</td><td><?= $semester ?></td></tr>
<tr><td>Nama</td><td>:</td><td><?= $nama ?></td><td></td><td>Tahun Akademik</td><td>:</td><td><?= $keterangan ?></td></tr>
<tr><td>Progdi</td><td>:</td><td><?= $nama_konsentrasi ?></td><td></td><td>Pembimbing Akademik</td><td>:</td><td><?= $nama_lengkap?></td></tr>
</table>
</center>

<?php

	$sql = "select ak.*,mm.kode_makul,mm.nama_makul,mm.sks,ad.nama_lengkap
            FROM makul_matakuliah as mm,akademik_jadwal_kuliah as jk,akademik_krs as ak,app_dosen as ad
            WHERE mm.makul_id=jk.makul_id and ad.dosen_id=jk.dosen_id and jk.jadwal_id=ak.jadwal_id and ak.nim='$nim'
            and jk.semester='$semester'";

	$query = mysqli_query($koneksi, $sql);
?>

<table border="1" padding="1" align="center" style="width: 600px;">
	<thead>
		<tr>
			<th>Kode</th>
			<th>Matakuliah</th>
			<th>SKS</th>
			<th>Dosen</th>
			<th>Status</th>
		</tr>
	</thead>
	<tbody>

	<?php
	$sks=0;
		if (mysqli_num_rows($query) > 0):
			while($field = mysqli_fetch_array($query)):
				$sks=$sks+$field['sks'];
				
	?>
		<tr>
			<td><?= $field['kode_makul'] ?></td>
			<td><?= $field['nama_makul'] ?></td>
			<td><?= $field['sks'] ?></td>
			<td><?= $field['nama_lengkap'] ?></td>
			<td><?= $field['accept']==1?'sudah disetujui':'belum disetujui'; ?></td>
			
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
	<tfoot><tr><td colspan='2' align='right'>Total SKS yang ditempuh</td><td><?php 
			echo $sks ?></td><td colspan=3></td></tr></tfoot>
</table>
<table style="width: 600px;" align="center">
<tr>
	<td></td>
	<td></td>
	<td align="right"><h4>Ungaran, <?php echo date('d-m-Y')?></h4></td>
</tr>
<tr>
	<td><h4>Mengetahui Pembimbing Akademik</h4></td><td></td><td align="right"><h4>Mahasiswa Yang Bersangkutan</h4></td>
</tr>
<tr><td><br><br><br><?= $nama_lengkap?><br>__________________________________</td><td></td><td align="right"><br><br><br><?= $nama?><br>__________________________________</td></tr>
</table>
<!-- <script>
		window.print();
</script> -->
	
</body>
<?php
						elseif ($status['jenis_bayar_id']=='40' and $_params[1]=='7'):
							?>

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
$querya = mysqli_query($koneksi, "SELECT student_mahasiswa.*, app_dosen.nama_lengkap, student_angkatan.keterangan, akademik_konsentrasi.nama_konsentrasi as nama_konsentrasi FROM student_mahasiswa 
	LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=student_mahasiswa.konsentrasi_id
	LEFT JOIN student_angkatan ON student_angkatan.angkatan_id=student_mahasiswa.angkatan_id
	LEFT JOIN app_dosen ON app_dosen.dosen_id=student_mahasiswa.dosen_id
	WHERE nim='{$_id}'");
$field = mysqli_fetch_array($querya);
extract($field);

?>
<center>
<h3>KARTU RENCANA STUDI MAHASISWA</h3>
<!-- <h3>Semester <?= $semester ?> Tahun <?= $keterangan ?> </h3> -->
</center>

<br>
<center>
<table style="width: 600px;">
<tr><td>NIM</td><td>:</td><td><?= $nim ?></td><td></td><td>Semester</td><td>:</td><td><?= $semester ?></td></tr>
<tr><td>Nama</td><td>:</td><td><?= $nama ?></td><td></td><td>Tahun Akademik</td><td>:</td><td><?= $keterangan ?></td></tr>
<tr><td>Progdi</td><td>:</td><td><?= $nama_konsentrasi ?></td><td></td><td>Pembimbing Akademik</td><td>:</td><td><?= $nama_lengkap?></td></tr>
</table>
</center>

<?php

	$sql = "select ak.*,mm.kode_makul,mm.nama_makul,mm.sks,ad.nama_lengkap
            FROM makul_matakuliah as mm,akademik_jadwal_kuliah as jk,akademik_krs as ak,app_dosen as ad
            WHERE mm.makul_id=jk.makul_id and ad.dosen_id=jk.dosen_id and jk.jadwal_id=ak.jadwal_id and ak.nim='$nim'
            and jk.semester='$semester'";

	$query = mysqli_query($koneksi, $sql);
?>

<table border="1" padding="1" align="center" style="width: 600px;">
	<thead>
		<tr>
			<th>Kode</th>
			<th>Matakuliah</th>
			<th>SKS</th>
			<th>Dosen</th>
			<th>Status</th>
		</tr>
	</thead>
	<tbody>

	<?php
	$sks=0;
		if (mysqli_num_rows($query) > 0):
			while($field = mysqli_fetch_array($query)):
				$sks=$sks+$field['sks'];
				
	?>
		<tr>
			<td><?= $field['kode_makul'] ?></td>
			<td><?= $field['nama_makul'] ?></td>
			<td><?= $field['sks'] ?></td>
			<td><?= $field['nama_lengkap'] ?></td>
			<td><?= $field['accept']==1?'sudah disetujui':'belum disetujui'; ?></td>
			
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
	<tfoot><tr><td colspan='2' align='right'>Total SKS yang ditempuh</td><td><?php 
			echo $sks ?></td><td colspan=3></td></tr></tfoot>
</table>
<table style="width: 600px;" align="center">
<tr>
	<td></td>
	<td></td>
	<td align="right"><h4>Ungaran, <?php echo date('d-m-Y')?></h4></td>
</tr>
<tr>
	<td><h4>Mengetahui Pembimbing Akademik</h4></td><td></td><td align="right"><h4>Mahasiswa Yang Bersangkutan</h4></td>
</tr>
<tr><td><br><br><br><?= $nama_lengkap?><br>__________________________________</td><td></td><td align="right"><br><br><br><?= $nama?><br>__________________________________</td></tr>
</table>
<!-- <script>
		window.print();
</script> -->
	
</body>
<?php
else:
?>
<?php
echo "<script>window.alert('MAAF ANDA BELUM MELAKUKAN PEMBAYARAN')
     window.location.href='{$_url}krs/view/$_username'</script>";
?>
<?php
endif;
?>
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