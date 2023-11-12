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
<a href="<?= $_url ?>krs/view/<?= $_id ?>" class="nav-button transform"><span></span></a>ADD KRS
</h1>

<?php
$cek="select max(krs_id) as maxKode from akademik_krs";
$hasil	= mysqli_query($koneksi, $cek);
$data	= mysqli_fetch_array($hasil);
$kode = substr($data['maxKode'], 3, 8);
$tambah=$kode+1;
	if($tambah<10){
		$kodekrs="P000".$tambah;
	} else {
		$kodekrs="P00".$tambah;
	}

if (isset($_POST['submit'])) {
	$jadwal   	= $_POST['jadwal_id'];
	$semes	 	= $_POST['semester'];
	$acc 		= '0';
	$konversi   = '0';
	$sql 		= "INSERT INTO akademik_krs Values('$kodekrs','$_username','$jadwal','$semes',$acc,$konversi)";
	$sql2 		= "INSERT INTO akademik_khs (khs_id,krs_id,mutu,kehadiran,tugas,grade,confirm) VALUES('','$kodekrs','0','0','0','','2')";
	//$sql3		= "UPDATE akademik_jadwal_kuliah SET join=join + 1 where jadwal_id='$jadwal'";
	$queque 	= mysqli_query($koneksi, $sql);
	$queque 	= mysqli_query($koneksi, $sql2);
	//$queque 	= mysqli_query($koneksi, $sql3);
	if ($queque) {
		echo "<script>$.Notify({
		    caption: 'Success',
		    content: 'Data KRS dan KHS Berhasil Ditambah',
    		type: 'success'
		});
		setTimeout(function(){ window.location.href='{$_url}krs/add-krs/<?= $_id ?>'; }, 2000);
		</script>";
	} else {
		echo "<script>$.Notify({
		    caption: 'Failed',
		    content: 'Data KRS dan KHS Gagal Ditambah',
		    type: 'alert'
		});</script>";
	}
}
?>
<form Method="POST">
	<label>JADWAL PRODIMU</label>
		<div class="form-group">
			<select class="form-control" name="jadwal_id" id="jadwal_id" onchange='changeValue(this.value)' required>
				<option value="">-Pilih-</option>
                <?php
				$query=mysqli_query($koneksi,"SELECT akademik_jadwal_kuliah.*, akademik_konsentrasi.nama_konsentrasi, makul_matakuliah.kode_makul , makul_matakuliah.nama_makul as nama_makul, makul_matakuliah.makul_id as makul_id, app_dosen.nama_lengkap as nama_lengkap
				FROM akademik_jadwal_kuliah 
				LEFT JOIN makul_matakuliah ON akademik_jadwal_kuliah.makul_id=makul_matakuliah.makul_id
				LEFT JOIN app_dosen ON akademik_jadwal_kuliah.dosen_id=app_dosen.dosen_id
				LEFT JOIN akademik_konsentrasi ON akademik_jadwal_kuliah.konsentrasi_id=akademik_konsentrasi.konsentrasi_id
				LEFT JOIN student_mahasiswa ON akademik_jadwal_kuliah.konsentrasi_id=student_mahasiswa.konsentrasi_id
				WHERE student_mahasiswa.nim='$_username' and akademik_jadwal_kuliah.semester=student_mahasiswa.semester");
				$result=mysqli_query($koneksi,"SELECT akademik_jadwal_kuliah.*, akademik_konsentrasi.nama_konsentrasi, makul_matakuliah.kode_makul, makul_matakuliah.nama_makul as nama_makul, makul_matakuliah.makul_id as makul_id, app_dosen.nama_lengkap as nama_lengkap
				FROM akademik_jadwal_kuliah 
				LEFT JOIN makul_matakuliah ON akademik_jadwal_kuliah.makul_id=makul_matakuliah.makul_id
				LEFT JOIN app_dosen ON akademik_jadwal_kuliah.dosen_id=app_dosen.dosen_id
				LEFT JOIN akademik_konsentrasi ON akademik_jadwal_kuliah.konsentrasi_id=akademik_konsentrasi.konsentrasi_id
				LEFT JOIN student_mahasiswa ON akademik_jadwal_kuliah.konsentrasi_id=student_mahasiswa.konsentrasi_id
				WHERE student_mahasiswa.nim='$_username' and akademik_jadwal_kuliah.semester=student_mahasiswa.semester
				and jadwal_id NOT IN (Select jadwal_id FROM akademik_krs Where nim='$_username')");
				$jsArray = "var prdName = new Array();\n";
				while ($row= mysqli_fetch_array($result)) {
				echo '<option name="jadwal_id" value="' . $row['jadwal_id'] . '">' . $row['jadwal_id'] . '-' . $row['kode_makul'] . '-' . $row['nama_makul'] . '</option>';
				$jsArray .= "prdName['" . $row['jadwal_id'] . "'] = {
				nama_makul:'" . addslashes($row['nama_makul']) . "',
				nama_lengkap:'" . addslashes($row['nama_lengkap']) . "',
				semester:'" . addslashes($row['semester']) . "'
				};\n";
				}
				?>
			</select>
	</div>
	<table class="table striped hovered border bordered">
	<td>
	<div class="form-group">
		<label for="nama_makul">MAKUL :</label>
			<input class="form-control" type="text" name="nama_makul" id="nama_makul" readonly>
	</div>
	</td>
	<td>
	<div class="form-group">
		<label for="nama_lengkap">NAMA DOSEN :</label>
			<input class="form-control" type="text" name="nama_lengkap" id="nama_lengkap" readonly>
	</div>
	</td>
	<br>
	<td></td>
	<div class="form-group">
		<label for="semester">SEMESTER :</label>
			<input class="form-control" type="text" name="semester" id="semester" readonly>
	</div>
	</td>
	
	<td>
	<div class="row cells2">
	<div class="cell">
		<button type="submit" name="submit" class="button primary">SUBMIT</button>
	</div>
	</div>
	</td>
	</table>
</form>
<script type="text/javascript"> 
<?php echo $jsArray; ?>
function changeValue(id){
    document.getElementById('nama_makul').value = prdName[id].nama_makul;
	document.getElementById('nama_lengkap').value = prdName[id].nama_lengkap;
    document.getElementById('semester').value = prdName[id].semester;
};
</script>