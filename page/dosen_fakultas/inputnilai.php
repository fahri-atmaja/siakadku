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
<a href="<?= $_url ?><?= in_array($_access, array('admin','dosen')) ? 'dashboard' : '' ?>" class="nav-button transform"><span></span></a>
Input Nilai
</h1>
<table class="table striped hovered border bordered">
<div class="row cells2">
<div class="form-group">
<div class="cell">
	<?php 
		$load ="select * from setpersentase where nip='$_username'";
		$qqq = mysqli_query($koneksi,$load);
		$row = mysqli_fetch_array($qqq);
		$a = $row['kehadiran'];
		$b = $row['tugas'];
		$c = $row['uts'];
		$d = $row['uas'];
		$kehadiran = $a / 100;
		$tugas 	   = $b / 100;
		$uts 		= $c / 100;
		$uas 		= $d /100;

	?>
	<h2>PERSENTASE NILAI</h2>
	<br>
	<label>KEHADIRAN</label>
</div>
<div class="cell">
	<input type="form-control" name="kehadiran1" id="kehadiran1" value="<?php echo $kehadiran?>0" readonly>
</div>
<div class="cell">
	<label>TUGAS</label>
</div>
<div class="cell">
	<input type="form-control" name="tugas1" id="tugas1" value="<?php echo $tugas?>0" readonly>
</div>
<div class="cell">
	<label>UTS</label>
</div>
<div class="cell">
	<input type="form-control" name="uts1" id="uts1" value="<?php echo $uts?>0" readonly>
</div>
<div class="cell">
	<label>UAS</label>
</div>
<div class="cell">
	<input type="form-control" name="uas1" id="uas1" value="<?php echo $uas?>0" readonly>
</div>
</div>
</div>
</table>
<?php

if (isset($_POST['submit'])) {

	extract($_POST);

	$sqlu = "UPDATE akademik_khs SET mutu='{$mutu}', mutu2='{$mutu2}', kehadiran='{$kehadiran}', tugas='{$tugas}', grade='{$grade}', nilai_akhir='{$akhir}' WHERE krs_id='{$krs_id}'";
	$que = mysqli_query($koneksi, $sqlu);

	if ($que) {
		echo "<script>$.Notify({
		    caption: 'Success',
		    content: 'Data KHS Berhasil Ubah',
    		type: 'success'
		});
		setTimeout(function(){ window.location.href='{$_url}dosen/inputnilai/'; }, 2000);
		</script>";

	} else {
		echo "<script>$.Notify({
		    caption: 'Failed',
		    content: 'Data KHS Gagal Ubah',
		    type: 'alert'
		});</script>";
	}
}
?>
<form Method="POST">


	<!--
				$query=mysqli_query($koneksi,"select * from akademik_krs order by krs_id ASC");
				$result=mysqli_query($koneksi,"select * from akademik_krs");
		<label>ID KRS</label>
		<div class="input-control text full-size">
			<select class="form-control" name="krs_id" id="krs_id" onchange='changeValue(this.value)' required>
				<?php while($data = mysqli_fetch_assoc($result) ){?>
				<option value="<?php echo $data['krs_id']; ?>"><?php echo $data['krs_id']; ?></option>
                <?php } ?>
			</select>
	-->
	<label>ID KRS</label>
		<div class="form-group">
			<select class="form-control" name="krs_id" id="krs_id" onchange='changeValue(this.value)' required>
				<option value="">-Pilih-</option>
                <?php
				$query=mysqli_query($koneksi,"select akh.*,ak.krs_id,ak.semester,jk.jadwal_id,sm.nim,sm.nama,mm.nama_makul,ad.nama_lengkap
			FROM akademik_khs as akh, akademik_krs as ak, akademik_jadwal_kuliah as jk, student_mahasiswa as sm, makul_matakuliah as mm, app_dosen as ad
			WHERE akh.krs_id=ak.krs_id and ak.nim=sm.nim and ak.jadwal_id=jk.jadwal_id and jk.makul_id=mm.makul_id and jk.dosen_id=ad.dosen_id and ad.nip='$_username'
			ORDER BY ak.krs_id ASC");
				$result=mysqli_query($koneksi,"select akh.*,ak.krs_id,ak.semester,jk.jadwal_id,sm.nim,sm.nama,mm.nama_makul,ad.nama_lengkap
			FROM akademik_khs as akh, akademik_krs as ak, akademik_jadwal_kuliah as jk, student_mahasiswa as sm, makul_matakuliah as mm, app_dosen as ad
			WHERE akh.krs_id=ak.krs_id and ak.nim=sm.nim and ak.jadwal_id=jk.jadwal_id and jk.makul_id=mm.makul_id and jk.dosen_id=ad.dosen_id and ad.nip='$_username'
			ORDER BY ak.krs_id ASC");
				$jsArray = "var prdName = new Array();\n";
				while ($row= mysqli_fetch_array($result)) {
					echo '<option name="krs_id" value="' . $row['krs_id'] . '">' . $row['krs_id'] . '  -  ' . $row['nama_makul'] . '  -  ' . $row['nama'] . '</option>';
					$jsArray .= "prdName['" . $row['krs_id'] . "'] = {
					nim:'" . addslashes($row['nim']) . "',
					nama:'" . addslashes($row['nama']) . "',
					semester:'" . addslashes($row['semester']) . "',
					nama_makul:'" . addslashes($row['nama_makul']) . "',
					mutu:'" . addslashes($row['mutu']) . "',
					mutu2:'" . addslashes($row['mutu2']) . "',
					kehadiran:'" . addslashes($row['kehadiran']) . "',
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
			<input class="form-control" type="text" name="kehadiran" id="kehadiran">
		<label for="semester">TUGAS :</label>
			<input class="form-control" type="text" name="tugas" id="tugas">
		<label for="semester">GRADE :</label>
			<input class="form-control" type="text" name="grade" id="grade" readonly>
		
	</td>
	<br>
	<td>
	<div class="form-group">
		<label for="semester">UTS :</label>
			<input class="form-control" type="text" name="mutu" id="mutu">
		<label for="semester">UAS :</label>
			<input class="form-control" type="text" name="mutu2" id="mutu2">
		<label for="semester">Nilai Akhir :</label>
			<input class="form-control" type="text" name="akhir" id="akhir" readonly>
	</div>
	</td>
	<td>
	<div class="row cells2">
	<div class="cell">
		<button type="submit" name="submit" class="button primary" onclick="hitung()">SUBMIT</button>
	</div>

	</div>
	</td>
	</table>
</form>
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
     var quis    = parseFloat(document.getElementById('kehadiran').value);
    var tugas   = parseFloat(document.getElementById('tugas').value);
    var uts     = parseFloat(document.getElementById('mutu').value);
    var uas     = parseFloat(document.getElementById('mutu2').value);
    var per1   = parseFloat(document.getElementById('kehadiran1').value);    
    var per2   = parseFloat(document.getElementById('tugas1').value);
    var per3   = parseFloat(document.getElementById('uts1').value);
    var per4   = parseFloat(document.getElementById('uas1').value);
    var ip      = "";
    var ket     = "";

    var na = (per1*quis)+(per2*tugas)+(per3*uts)+(per4*uas);

        if ((na > 80) && (na <=100))
        {
            ip="A";
            ket="Lulus dengan sangat baik";
        }
            else if ((na > 69) && (na<=80))
            {
                ip="B";
                ket="Lulus dengan baik";
            }
            else if ((na > 55) && (na<=69))
            {
                ip="C";
                ket="Lulus dengan cukup";
            }
            else if ((na > 38) && (na<=55))
            {
                ip="D";
                ket="Lulus dengan kurang";
            }
                else
                {
                    ip="E";
                    ket="Tidak Lulus";
                }
            document.getElementById('grade').value=ip;
            document.getElementById('akhir').value=na;
  
}
function hitung(id){
    var quis    = parseFloat(document.getElementById('kehadiran').value);
    var tugas   = parseFloat(document.getElementById('tugas').value);
    var uts     = parseFloat(document.getElementById('mutu').value);
    var uas     = parseFloat(document.getElementById('mutu2').value);
    var ip      = "";
    var ket     = "";

    var na = (0.10*quis)+(0.20*tugas)+(0.30*uts)+(0.40*uas);

        if ((na > 80) && (na <=100))
        {
            ip="A";
            ket="Lulus dengan sangat baik";
        }
            else if ((na > 69) && (na<=80))
            {
                ip="B";
                ket="Lulus dengan baik";
            }
            else if ((na > 55) && (na<=69))
            {
                ip="C";
                ket="Lulus dengan cukup";
            }
            else if ((na > 38) && (na<=55))
            {
                ip="D";
                ket="Lulus dengan kurang";
            }
                else
                {
                    ip="E";
                    ket="Tidak Lulus";
                }
            document.getElementById('grade').value=ip;
            document.getElementById('akhir').value=na;
        };
</script>