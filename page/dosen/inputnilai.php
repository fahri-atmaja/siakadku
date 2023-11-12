<?php
	if ($_access == 'mahasiswa' && $_id != $_username) {
		header("location:{$_url}krs/view/{$_username}");
	}
?>
<style type="text/css">
	.input-control {
		border: 1px solid #d9d9d9;
		padding: 1px;
	}
</style>

<h1>
<a href="<?= $_url ?><?= in_array($_access, array('admin','dosen')) ? 'dosen/list' : '' ?>" class="nav-button transform"><span></span></a>
Input Nilai
</h1>
<div class="container">
<div class="row cells2">
<div class="form-group">
<div class="cell">
	<?php 
		$load ="select * from setpersentase where nip='$_username' and jadwal_id='$_id'";
		$qqq = mysqli_query($koneksi,$load);
		$row = mysqli_fetch_array($qqq);
		$a = $row['kehadiran'];
		$b = $row['tugas'];
		$c = $row['uts'];
		$d = $row['uas'];
		$e = $row['praktik'];
		$kehadiran  = $a/100;
		$tugas 	    = $b/100;
		$uts 		= $c/100;
		$uas 		= $d/100;
		$praktik	= $e/100;
		//$kehadiran  = 10 / 100;
		//$tugas 	    = 20 / 100;
		//$uts 		= 30 / 100;
		//$uas 		= 40 /100;

	?>
	<?php
// 	$ldmakul = mysqli_query($koneksi,"SELECT mm.nama_makul from makul_matakuliah as mm, akademik_jadwal_kuliah as jk WHERE mm.makul_id=jk.makul_id and jk.jadwal_id='$_id'");
	$ldmakul = mysqli_query($koneksi,"SELECT makul_matakuliah.nama_makul FROM makul_matakuliah
	                                    LEFT JOIN akademik_jadwal_kuliah ON akademik_jadwal_kuliah.makul_id=makul_matakuliah.makul_id
	                                    WHERE akademik_jadwal_kuliah.jadwal_id='$_id'");
	$dis = mysqli_fetch_array($ldmakul);
	?>
	<h2>PERSENTASE NILAI<br> <?php echo $dis['nama_makul'] ?></h2>
	<br>
	</div>

<div class="container">
    <!--<p>Bentuk persentase dalam bilangan desimal</p>-->
 <div class="row">   
	<label>KEHADIRAN <?php echo $a ?>%</label>
	<input type="hidden" name="kehadiran1" id="kehadiran1" value="<?php echo $kehadiran?>0" readonly>
	<br>
	<label>TUGAS <?php echo $b ?>%</label>
	<input type="hidden" name="tugas1" id="tugas1" value="<?php echo $tugas?>0" readonly>
	<br>
	<label>PRAKTIK <?php echo $e ?>%</label>
	<input type="hidden" name="praktik1" id="praktik1" value="<?php echo $praktik?>0" readonly>
	<br>
	<label>UTS <?php echo $c ?>%</label>
	<input type="hidden" name="uts1" id="uts1" value="<?php echo $uts?>0" readonly>
	<br>
	<label>UAS <?php echo $d ?>%</label>
	<input type="hidden" name="uas1" id="uas1" value="<?php echo $uas?><?php if ($uas!=1): ?> 0 <?php endif; ?>" readonly>
</div>
</div>
<div class="row">
<p>Jika persentase masih kosong/tidak sesuai silahkan setting terlebih dahulu</p>
<a target="_BLANK" href="<?= $_url ?>persentase">Setting persentase nilai matakuliah</a>
</div>
</div>
</div>
</div>
<?php

if (isset($_POST['submit'])) {

	extract($_POST);

// 	if ($a == 0)
// 	{
// 	echo "<script>window.alert('Persentase Kehadiran Belum Disetting')
//     window.location.href='{$_url}persentase'</script>";
// 	}
// 	elseif ($b == 0)
// 	{
// 	echo "<script>window.alert('Persentase Tugas Belum Disetting')
//     window.location.href='{$_url}persentase'</script>";
// 	}
// 	elseif ($c == 0)
// 	{
// 	echo "<script>window.alert('Persentase UTS Belum Disetting')
//     window.location.href='{$_url}persentase'</script>";
// 	}
// 	else
	if ($d == 0)
	{
	echo "<script>window.alert('Persentase UAS Belum Disetting')
    window.location.href='{$_url}persentase'</script>";
	}
	elseif ($a+$b+$c+$d+$e != 100){
	echo "<script>window.alert('Persentase Tidak 100%')
    window.location.href='{$_url}persentase'</script>"; 
	}
	else{
	$sqlu = "UPDATE akademik_khs SET mutu='{$mutu}', mutu2='{$mutu2}', kehadiran='{$kehadiran}', tugas='{$tugas}', praktik='{$praktik}', grade='{$grade}', nilai_akhir='{$akhir}', bobot='{$bobot}' WHERE krs_id='{$krs_id}'";
	$que = mysqli_query($koneksi, $sqlu);

	if ($que) {
		echo "<script>$.Notify({
		    caption: 'Success',
		    content: 'Data KHS Berhasil Ubah',
    		type: 'success'
		});
		
		</script>";

	} else {
		echo "<script>$.Notify({
		    caption: 'Failed',
		    content: 'Data KHS Gagal Ubah',
		    type: 'alert'
		});</script>";
	}
}
}
// if (isset($_POST['publish'])) {

// 	extract($_POST);
// 	if ($a == 0)
// 	{
// 	echo "<script>window.alert('Persentase Kehadiran Belum Disetting')
//     window.location.href='{$_url}persentase'</script>";
// 	}
// 	elseif ($b == 0)
// 	{
// 	echo "<script>window.alert('Persentase Tugas Belum Disetting')
//     window.location.href='{$_url}persentase'</script>";
// 	}
// 	elseif ($c == 0)
// 	{
// 	echo "<script>window.alert('Persentase UTS Belum Disetting')
//     window.location.href='{$_url}persentase'</script>";
// 	}
// 	elseif ($d == 0)
// 	{
// 	echo "<script>window.alert('Persentase UAS Belum Disetting')
//     window.location.href='{$_url}persentase'</script>";
// 	}
// 	elseif ($akhir == 0)
// 	{
// 	echo "<script>window.alert('Nilai Akhir Tidak Boleh Kosong')
//     window.location.href='{$_url}dosen/list'</script>";
// 	}else{
// 	$sqlu = "UPDATE akademik_khs SET confirm='1' WHERE krs_id='{$krs_id}'";
// 	$que = mysqli_query($koneksi, $sqlu);

// 	if ($que) {
// 		echo "<script>$.Notify({
// 		    caption: 'Success',
// 		    content: 'Data KHS Berhasil di publish',
//     		type: 'success'
// 		});
// 		setTimeout(function(){ window.location.href='{$_url}dosen/list/'; }, 2000);
// 		</script>";

// 	} else {
// 		echo "<script>$.Notify({
// 		    caption: 'Failed',
// 		    content: 'Data KHS Gagal di publish',
// 		    type: 'alert'
// 		});</script>";
// 	}
// }
// }
?>
<div class="container">
<form Method="POST">

	<label>Pilih Mahasiswa</label>
		<div class="form-group">
			<select class="form-control" name="krs_id" id="krs_id" onchange='changeValue(this.value)' required>
				<option value="">-Pilih-</option>
                <?php
// 				$query=mysqli_query($koneksi,"select akh.*,ak.krs_id,ak.semester,jk.jadwal_id,sm.nim,sm.nama,mm.nama_makul,ad.nama_lengkap
// 			FROM akademik_khs as akh, akademik_krs as ak, akademik_jadwal_kuliah as jk, student_mahasiswa as sm, makul_matakuliah as mm, app_dosen as ad
// 			WHERE akh.krs_id=ak.krs_id and ak.nim=sm.nim and ak.jadwal_id=jk.jadwal_id and jk.makul_id=mm.makul_id and jk.dosen_id=ad.dosen_id and ad.nip='$_username'
// 					and akh.confirm='2' and jk.jadwal_id='$_id'
// 			ORDER BY ak.krs_id ASC");
// 				$result=mysqli_query($koneksi,"select akh.*,ak.krs_id,ak.semester,jk.jadwal_id,sm.nim,sm.nama,mm.nama_makul,ad.nama_lengkap
// 			FROM akademik_khs as akh, akademik_krs as ak, akademik_jadwal_kuliah as jk, student_mahasiswa as sm, makul_matakuliah as mm, app_dosen as ad
// 			WHERE akh.krs_id=ak.krs_id and ak.nim=sm.nim and ak.jadwal_id=jk.jadwal_id and jk.makul_id=mm.makul_id and jk.dosen_id=ad.dosen_id and ad.nip='$_username'
// 					 and akh.confirm='2' and jk.jadwal_id='$_id'
// 			ORDER BY sm.nim ASC");
			$result = mysqli_query($koneksi,"SELECT akademik_khs.*, akademik_krs.krs_id, akademik_krs.semester, akademik_jadwal_kuliah.jadwal_id, student_mahasiswa.nim, student_mahasiswa.nama,
			                                    makul_matakuliah.nama_makul, app_dosen.nama_lengkap FROM akademik_khs
			                                    LEFT JOIN akademik_krs ON akademik_krs.krs_id=akademik_khs.krs_id
			                                    LEFT JOIN akademik_jadwal_kuliah ON akademik_jadwal_kuliah.jadwal_id=akademik_krs.jadwal_id
			                                    LEFT JOIN makul_matakuliah ON makul_matakuliah.makul_id=akademik_jadwal_kuliah.makul_id
			                                    LEFT JOIN app_dosen ON app_dosen.dosen_id=akademik_jadwal_kuliah.dosen_id
			                                    LEFT JOIN student_mahasiswa ON student_mahasiswa.nim=akademik_krs.nim
			                                    WHERE app_dosen.nip='$_username' AND akademik_jadwal_kuliah.jadwal_id='$_id' AND akademik_khs.confirm='2'
			                                    ORDER BY student_mahasiswa.nim ASC");
				$jsArray = "var prdName = new Array();\n";
				while ($row= mysqli_fetch_array($result)) {
					echo '<option name="krs_id" value="' . $row['krs_id'] . '">' . $row['nim'] . '  -  ' . $row['nama'] . '</option>';
					$jsArray .= "prdName['" . $row['krs_id'] . "'] = {
					nim:'" . addslashes($row['nim']) . "',
					nama:'" . addslashes($row['nama']) . "',
					semester:'" . addslashes($row['semester']) . "',
					nama_makul:'" . addslashes($row['nama_makul']) . "',
					mutu:'" . addslashes($row['mutu']) . "',
					mutu2:'" . addslashes($row['mutu2']) . "',
					kehadiran:'" . addslashes($row['kehadiran']) . "',
					praktik:'" . addslashes($row['praktik']) . "',
					tugas:'" . addslashes($row['tugas']) . "'
					};\n";
				}
				?>
			</select>
	
	
	</div>
	<table class="table striped hovered border bordered">
	<td>
	<div class="form-group">
		<label for="nim">NIM :</label>
			<input class="form-control" type="text" name="nim" id="nim" readonly>
		<label for="nim">NAMA :</label>
			<input class="form-control" type="text" name="nama" id="nama" readonly>
	</div>
	</td>
	<br>
	<td>
	<div class="form-group">
		<label for="semester">SEMESTER :</label>
			<input class="form-control" type="text" name="semester" id="semester" readonly>
		<label for="semester">MAKUL :</label>
			<input class="form-control" type="text" name="nama_makul" id="nama_makul" readonly>
	</div>
	</td>
	<br>
	<td>
	<div class="form-group">
		<label for="semester">KEHADIRAN :</label>
			<input class="form-control" type="text" name="kehadiran" id="kehadiran" onkeyup="sum();" required>
		<label for="semester">TUGAS :</label>
			<input class="form-control" type="text" name="tugas" id="tugas" onkeyup="sum();" required>
		<label for="semester">PRAKTIK :</label>
			<input class="form-control" type="text" name="praktik" id="praktik" onkeyup="sum();">
		<label for="semester">GRADE :</label>
			<input class="form-control" type="text" name="grade" id="grade" readonly>
		
	</td>
	<br>
	<td>
	<div class="form-group">
		<label for="semester">UTS :</label>
			<input class="form-control" type="text" name="mutu" id="mutu" onkeyup="sum();" required>
		<label for="semester">UAS :</label>
			<input class="form-control" type="text" name="mutu2" id="mutu2" onkeyup="sum();" required>
		<label for="semester">Nilai Akhir :</label>
			<input class="form-control" type="text" name="akhir" id="akhir" readonly>
		<label for="semester">Bobot :</label>	
			<input class="form-control" type="text" name="bobot" id="bobot" readonly>
	</div>
	</td>
	<td>
		<button type="submit" name="submit" class="button primary">SUBMIT</button>
		<!--<button type="submit" name="publish" class="button success">PUBLISH</button>-->
		<p style="color: blue";>Tombol publish dipindahkan ke daftar nilai/ view nilai mahasiswa.<br> Silahkan tekan publish jika nilai mahasiswa sudah "final"<br></p>
		*note: Daftar NIM akan hilang jika nilai sudah dipublish.
	</td>
	</table>
</form>
</div>
<!--
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script type="text/javascript">
            function isi_otomatis(){
                var krs_id = $("#krs_id").val();
                $.ajax({
                    url: 'dosen/proses-ajax.php',
                    data:"krs_id="+krs_id ,
                }).success(function (data) {
                    var json = data,
                    obj = JSON.parse(json);
                    $('#nim').val(obj.nim);
                    
                });
            }
        </script>
-->
<script type="text/javascript"> 
<?php echo $jsArray; ?>
function changeValue(id){
    document.getElementById('nim').value = prdName[id].nim;
	document.getElementById('nama').value = prdName[id].nama;
    document.getElementById('semester').value = prdName[id].semester;
	document.getElementById('nama_makul').value = prdName[id].nama_makul;
	document.getElementById('mutu').value = prdName[id].mutu;
	document.getElementById('mutu2').value = prdName[id].mutu2;
	document.getElementById('kehadiran').value = prdName[id].kehadiran;
    document.getElementById('tugas').value = prdName[id].tugas;   
    document.getElementById('praktik').value = prdName[id].praktik;
    var quis    = parseFloat(document.getElementById('kehadiran').value);
    var tugas   = parseFloat(document.getElementById('tugas').value);
    var praktik   = parseFloat(document.getElementById('praktik').value);
    var uts     = parseFloat(document.getElementById('mutu').value);
    var uas     = parseFloat(document.getElementById('mutu2').value);
    var per1   = parseFloat(document.getElementById('kehadiran1').value);    
    var per2   = parseFloat(document.getElementById('tugas1').value);
    var per3   = parseFloat(document.getElementById('uts1').value);
    var per4   = parseFloat(document.getElementById('uas1').value);
    var per5   = parseFloat(document.getElementById('praktik1').value);
    var ip      = "";
    var ket     = "";
    var bobot = "";

    var na = (per1*quis)+(per2*tugas)+(per3*uts)+(per4*uas)+(per5*praktik);

        if (na >= 85.00)
        {
            ip="A";
            ket="Sangat baik";
            bobot="4.00";
        }
            else if (na >= 75.00)
            {
                ip="AB";
                ket="Baik +";
                bobot="3.50";
            }
            else if (na >= 67.00)
            {
                ip="B";
                ket="Baik";
                bobot="3.00";
            }
            else if (na >= 61.00)
            {
                ip="BC";
                ket="Cukup +";
                bobot="2.50";
            }
            else if (na >= 55.00)
            {
                ip="C";
                ket="Cukup";
                bobot="2.00";
            }
            else if (na >= 45.00)
            {
                ip="CD";
                ket="Cukup kurang";
                bobot="1.50";
            }
            else if (na >= 35.00)
            {
                ip="D";
                ket="Kurang";
                bobot="1.00";
            }
                else
                {
                    ip="E";
                    ket="Tidak Lulus";
                }
            document.getElementById('grade').value=ip;
            document.getElementById('akhir').value=na;
            document.getElementById('bobot').value=bobot;
  
}
function sum(id){
	var quis    = parseFloat(document.getElementById('kehadiran').value);
    var tugas   = parseFloat(document.getElementById('tugas').value);
    var praktik = parseFloat(document.getElementById('praktik').value);
    var uts     = parseFloat(document.getElementById('mutu').value);
    var uas     = parseFloat(document.getElementById('mutu2').value);
    var per1   = parseFloat(document.getElementById('kehadiran1').value);    
    var per2   = parseFloat(document.getElementById('tugas1').value);
    var per3   = parseFloat(document.getElementById('uts1').value);
    var per4   = parseFloat(document.getElementById('uas1').value);
    var per5   = parseFloat(document.getElementById('praktik1').value);
    var na 		= (per1*quis)+(per2*tugas)+(per3*uts)+(per4*uas)+(per5*praktik);
    if (na >= 85)
        {
            ip="A";
            ket="Sangat baik";
            bobot="4.00";
        }
            else if (na >= 75)
            {
                ip="AB";
                ket="Baik +";
                bobot="3.50";
            }
            else if (na >= 67)
            {
                ip="B";
                ket="Baik";
                bobot="3.00";
            }
            else if (na >= 61)
            {
                ip="BC";
                ket="Cukup +";
                bobot="2.50";
            }
            else if (na >= 55)
            {
                ip="C";
                ket="Cukup";
                bobot="2.00";
            }
            else if (na >= 45)
            {
                ip="CD";
                ket="Cukup kurang";
                bobot="1.50";
            }
            else if (na >= 35)
            {
                ip="D";
                ket="Kurang";
                bobot="1.00";
            }
                else
                {
                    ip="E";
                    ket="Tidak Lulus";
                }
     if (!isNaN(na)){
            	document.getElementById('akhir').value=na;
            	document.getElementById('grade').value=ip;            
            	document.getElementById('bobot').value=bobot;
            }
}
</script>