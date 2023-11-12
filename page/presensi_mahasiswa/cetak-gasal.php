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
	<!--<center>-->
	<!--	<img src="../../../assets/img/logo/logo universitas.png" alt="UNIVERSITAS DARUL ULUM ISLAMIC CENTRE SUDIRMAN GUPPI (UNDARIS)" height="125" width="125">-->
	<!--	<h2>UNIVERSITAS DARUL ULUM ISLAMIC CENTRE SUDIRMAN GUPPI <br>(UNDARIS)</h2>-->
	<!--	<h4><b>_________________________________________________________________________________________________</b></h4>-->
	<!--</center>-->
	<center>
	    <table>
	        <tr>
	            <td><img src="../../../assets/img/logo/logo universitas.png" alt="UNIVERSITAS DARUL ULUM ISLAMIC CENTRE SUDIRMAN GUPPI (UNDARIS)" height="60" width="60"></td>
	            <td></td>
	    <td>
	<h4><b>UNIVERSITAS DARUL ULUM ISLAMIC CENTRE SUDIRMAN GUPPI<br><center>(UNDARIS)</center> </b></h4>
	</td>
	</tr>
	</table>
	</center>
<center>
<h5><b>PRESENSI MAHASISWA</b></h5>
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
<?php

?>
		<tr>
			<th rowspan="2">No.</th>
			<th rowspan="2">NIM</th>
			<th rowspan="2">NAMA</th>
			<th colspan="8">PERTEMUAN</th>
		</tr>
		<tr>
			<?php
			$per1 = mysqli_query($koneksi,"SELECT tanggalabsen FROM mhs_absen WHERE jadwal_id='$_id' AND pertemuan='1'");
			if (mysqli_num_rows($per1) > 0){
			$v1 = mysqli_fetch_array($per1);
			?>
			<th><?php $newDate1 = date("d-m-Y", strtotime($v1['tanggalabsen'])); echo "<h11>".$newDate1."</h11>"; ?></th>
			<?php
			}else{
			?>
			<th>Per 1</th>
			<?php
			}
			?>
			<!-- -->
			<?php
			$per2 = mysqli_query($koneksi,"SELECT tanggalabsen FROM mhs_absen WHERE jadwal_id='$_id' AND pertemuan='2'");
			if (mysqli_num_rows($per2) > 0){
			$v2 = mysqli_fetch_array($per2);
			?>
			<th><?php $newDate2 = date("d-m-Y", strtotime($v2['tanggalabsen'])); echo "<h11>".$newDate2."</h11>"; ?></th>
			<?php
			}else{
			?>
			<th>Per 2</th>
			<?php
			}
			?>
			<!-- -->
			<?php
			$per3 = mysqli_query($koneksi,"SELECT tanggalabsen FROM mhs_absen WHERE jadwal_id='$_id' AND pertemuan='3'");
			if (mysqli_num_rows($per3) > 0){
			$v3 = mysqli_fetch_array($per3);
			?>
			<th><?php $newDate3 = date("d-m-Y", strtotime($v3['tanggalabsen'])); echo "<h11>".$newDate3."</h11>"; ?></th>
			<?php
			}else{
			?>
			<th>Per 3</th>
			<?php
			}
			?>
			<!-- -->
			<?php
			$per4 = mysqli_query($koneksi,"SELECT tanggalabsen FROM mhs_absen WHERE jadwal_id='$_id' AND pertemuan='4'");
			if (mysqli_num_rows($per4) > 0){
			$v4 = mysqli_fetch_array($per4);
			?>
			<th><?php $newDate4 = date("d-m-Y", strtotime($v4['tanggalabsen'])); echo "<h11>".$newDate4."</h11>"; ?></th>
			<?php
			}else{
			?>
			<th>Per 4</th>
			<?php
			}
			?>
			<!-- -->
			<?php
			$per5 = mysqli_query($koneksi,"SELECT tanggalabsen FROM mhs_absen WHERE jadwal_id='$_id' AND pertemuan='5'");
			if (mysqli_num_rows($per5) > 0){
			$v5 = mysqli_fetch_array($per5);
			?>
			<th><?php $newDate5 = date("d-m-Y", strtotime($v5['tanggalabsen'])); echo "<h11>".$newDate5."</h11>"; ?></th>
			<?php
			}else{
			?>
			<th>Per 5</th>
			<?php
			}
			?>
			<!-- -->
			<?php
			$per6 = mysqli_query($koneksi,"SELECT tanggalabsen FROM mhs_absen WHERE jadwal_id='$_id' AND pertemuan='6'");
			if (mysqli_num_rows($per6) > 0){
			$v6 = mysqli_fetch_array($per6);
			?>
			<th><?php $newDate6 = date("d-m-Y", strtotime($v6['tanggalabsen'])); echo "<h11>".$newDate6."</h11>"; ?></th>
			<?php
			}else{
			?>
			<th>Per 6</th>
			<?php
			}
			?>
			<!-- -->
			<?php
			$per7 = mysqli_query($koneksi,"SELECT tanggalabsen FROM mhs_absen WHERE jadwal_id='$_id' AND pertemuan='7'");
			if (mysqli_num_rows($per7) > 0){
			$v7 = mysqli_fetch_array($per7);
			?>
			<th><?php $newDate7 = date("d-m-Y", strtotime($v7['tanggalabsen'])); echo "<h11>".$newDate7."</h11>"; ?></th>
			<?php
			}else{
			?>
			<th>Per 7</th>
			<?php
			}
			?>
			<!-- -->
			<?php
			$per8 = mysqli_query($koneksi,"SELECT tanggalabsen FROM mhs_absen WHERE jadwal_id='$_id' AND pertemuan='8'");
			if (mysqli_num_rows($per8) > 0){
			$v8 = mysqli_fetch_array($per8);
			?>
			<th><?php $newDate8 = date("d-m-Y", strtotime($v8['tanggalabsen'])); echo "<h11>".$newDate8."</h11>"; ?></th>
			<?php
			}else{
			?>
			<th>Per 8</th>
			<?php
			}
			?>
			<!-- -->
		</tr>
	</thead>
	<tbody>
			<?php
	$sql = "SELECT akademik_krs.*, student_mahasiswa.nama FROM akademik_krs
	       LEFT JOIN akademik_jadwal_kuliah ON akademik_jadwal_kuliah.jadwal_id=akademik_krs.jadwal_id
	       LEFT JOIN student_mahasiswa ON student_mahasiswa.nim=akademik_krs.nim
	       WHERE akademik_krs.jadwal_id='$_id' ORDER BY akademik_krs.nim ASC";
	$querya = mysqli_query($koneksi, $sql);
		$no=1;
		if (mysqli_num_rows($querya) > 0):
			while($field = mysqli_fetch_array($querya)):
		
	?>
	
		<tr>
			<td><?= $no++ ?></td>
			<td><?= $field['nim'] ?></td>
			<td><?= $field['nama'] ?></td>
			<!-- pertemuan 1 -->
			<td>
			<?php
			$absen1 = mysqli_query($koneksi,"SELECT * FROM mhs_absen WHERE nim='$field[nim]' AND jadwal_id='$field[jadwal_id]' AND pertemuan='1'");
			$view1 = mysqli_fetch_array($absen1);
			if($view1['kehadiran']!='hadir'){
			echo "<b>".$view1['kehadiran']."</b>";
			}else{
			echo $view1['kehadiran'];    
			}
			?>
			</td>
			<!-- end -->
			<!-- pertemuan 2 -->
			<td>
			<?php
			$absen2 = mysqli_query($koneksi,"SELECT * FROM mhs_absen WHERE nim='$field[nim]' AND jadwal_id='$field[jadwal_id]' AND pertemuan='2'");
			$view2 = mysqli_fetch_array($absen2);
			if($view2['kehadiran']!='hadir'){
			echo "<b>".$view2['kehadiran']."</b>";
			}else{
			echo $view2['kehadiran'];    
			}
			?>
			</td>
			<!-- end -->
			<!-- pertemuan 3 -->
			<td>
			<?php
			$absen3 = mysqli_query($koneksi,"SELECT * FROM mhs_absen WHERE nim='$field[nim]' AND jadwal_id='$field[jadwal_id]' AND pertemuan='3'");
			$view3 = mysqli_fetch_array($absen3);
			if($view3['kehadiran']!='hadir'){
			echo "<b>".$view3['kehadiran']."</b>";
			}else{
			echo $view3['kehadiran'];    
			}
			?>    
			</td>
			<!-- end -->
			<!-- pertemuan 4 -->
			<td>   
			<?php
			$absen4 = mysqli_query($koneksi,"SELECT * FROM mhs_absen WHERE nim='$field[nim]' AND jadwal_id='$field[jadwal_id]' AND pertemuan='4'");
			$view4 = mysqli_fetch_array($absen4);
			if($view4['kehadiran']!='hadir'){
			echo "<b>".$view4['kehadiran']."</b>";
			}else{
			echo $view4['kehadiran'];    
			}
			?>
			</td>
			<!-- end -->
			<!-- pertemuan 5 -->
			<td>
			<?php
			$absen5 = mysqli_query($koneksi,"SELECT * FROM mhs_absen WHERE nim='$field[nim]' AND jadwal_id='$field[jadwal_id]' AND pertemuan='5'");
			$view5 = mysqli_fetch_array($absen5);
			if($view5['kehadiran']!='hadir'){
			echo "<b>".$view5['kehadiran']."</b>";
			}else{
			echo $view5['kehadiran'];    
			}
			?> 
			</td>
			<!-- end -->
			<!-- pertemuan 6 -->
			<td>
			<?php
			$absen6 = mysqli_query($koneksi,"SELECT * FROM mhs_absen WHERE nim='$field[nim]' AND jadwal_id='$field[jadwal_id]' AND pertemuan='6'");
			$view6 = mysqli_fetch_array($absen6);
			if($view6['kehadiran']!='hadir'){
			echo "<b>".$view6['kehadiran']."</b>";
			}else{
			echo $view6['kehadiran'];    
			}
			?>     
			</td>
			<!-- end -->
			<!-- pertemuan 7 -->
			<td>
			<?php
			$absen7 = mysqli_query($koneksi,"SELECT * FROM mhs_absen WHERE nim='$field[nim]' AND jadwal_id='$field[jadwal_id]' AND pertemuan='7'");
			$view7 = mysqli_fetch_array($absen7);
			if($view7['kehadiran']!='hadir'){
			echo "<b>".$view7['kehadiran']."</b>";
			}else{
			echo $view7['kehadiran'];    
			}
			?>     
			</td>
			<!-- end -->
			<!-- pertemuan 8 -->
			<td>
			<?php
			$absen8 = mysqli_query($koneksi,"SELECT * FROM mhs_absen WHERE nim='$field[nim]' AND jadwal_id='$field[jadwal_id]' AND pertemuan='8'");
			$view8 = mysqli_fetch_array($absen7);
			if($view8['kehadiran']!='hadir'){
			echo "<b>".$view8['kehadiran']."</b>";
			}else{
			echo $view8['kehadiran'];    
			}
			?>    
			</td>
			<!-- end -->
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
	<td><h4>Mengetahui K.a Prodi</h4></td><td></td><td align="right"><h4>Dosen Pengampu</h4></td>
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