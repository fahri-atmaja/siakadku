<?php
	if ($_access == 'mahasiswa' && $_id != $_username) {
		header("location:{$_url}krs-cicilan/view/{$_username}");
	}
	$cek = mysqli_query($koneksi,"SELECT status_angsur FROM student_mahasiswa WHERE nim='$_username'");
$validasi = mysqli_fetch_array($cek);
if ($validasi['status_angsur']!='1'){
    echo "<script>window.alert('MAAF HALAMAN TIDAK BISA DIAKSSES')
		    window.location.href='{$_url}'</script>";
}
?>
<style type="text/css">
	.input-control {
		border: 1px solid #d9d9d9;
		padding: 1px;
	}
</style>

<h1>
<a href="<?= $_url ?>krs-cicilan/view/<?= $_id ?>" class="nav-button transform"><span></span></a>ADD KRS
</h1>
<?php
$querya = mysqli_query($koneksi, "SELECT student_mahasiswa.*, akademik_kelas.nama_kelas, biaya_sks.id_sks,biaya_sks.jenis_sks, student_angkatan.keterangan, akademik_konsentrasi.nama_konsentrasi as nama_konsentrasi FROM student_mahasiswa 
	LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=student_mahasiswa.konsentrasi_id
	LEFT JOIN student_angkatan ON student_angkatan.angkatan_id=student_mahasiswa.angkatan_id
	LEFT JOIN akademik_kelas ON akademik_kelas.id_kelas=student_mahasiswa.id_kelas
	LEFT JOIN biaya_sks ON biaya_sks.id_sks=student_mahasiswa.id_sks
	WHERE nim='{$_username}'");
$field = mysqli_fetch_array($querya);
extract($field);
$konversi   = $semester;
?>

<?php
$cek="select max(krs_id) as maxKode from akademik_krs";
$hasil	= mysqli_query($koneksi, $cek);
$data	= mysqli_fetch_array($hasil);
$kode = substr($data['maxKode'], 2, 8);
$tambah=$kode+1;
if($tambah<10){
		$kodekrs="Q00000".$tambah;
	} elseif($tambah<100) {
		$kodekrs="Q0000".$tambah;
	} elseif($tambah<1000) {
		$kodekrs="Q000".$tambah;
	} elseif($tambah<10000) {
	    $kodekrs="Q00".$tambah;
	} elseif($tambah<100000) {
	    $kodekrs="Q0".$tambah;
	} else {
	    $kodekrs="Q".$tambah;
	}


if (isset($_POST['submit'])) {
	$loadkrs = mysqli_query($koneksi,"SELECT sum(mm.sks) as value_sks FROM makul_matakuliah as mm, akademik_krs as ak, akademik_jadwal_kuliah as jk 
			WHERE mm.makul_id=jk.makul_id AND jk.jadwal_id=ak.jadwal_id AND ak.nim='$_username' AND ak.konversi='$semester' ");
	$sumsks = mysqli_fetch_array($loadkrs);
	$sks 		= $_POST['sks'];
	if ($sumsks['value_sks']+$sks > 24){
		echo "<script>window.alert('MAAF SKS MELEBIHI SYARAT! SYARAT MAKSIMAL 24 SKS')
		    window.location.href='{$_url}krs-cicilan/view/$_username'</script>";
	}else{
	$jadwal   	= $_POST['jadwal_id'];
	$semes	 	= $_POST['semester'];
	$acc 		= '0';
	$cekjdwl    = mysqli_query($koneksi,"SELECT * FROM akademik_krs WHERE nim='$nim' AND jadwal_id='$jadwal'");
	$valid      = mysqli_num_rows($cekjdwl);
	    if ($valid > 0){
	        echo "<script>$.Notify({
		    caption: 'Failed',
		    content: 'Data Jadwal KRS sudah diambil',
		    type: 'alert'
		});
		setTimeout(function(){ window.location.href='{$_url}krs-cicilan/view/<?= $_id ?>'; }, 2000);
		</script>";
	    } else {
	$cekkrs     = mysqli_query($koneksi,"SELECT krs_id FROM akademik_khs WHERE krs_id='$kodekrs'");
	$num = mysqli_num_rows($cekkrs);
	if($num > 0){
	    echo "<script>$.Notify({
		    caption: 'Failed',
		    content: 'Data KHS sudah diambil',
		    type: 'alert'
		});
		setTimeout(function(){ window.location.href='{$_url}krs-cicilan/view/<?= $_id ?>'; }, 2000);
		</script>";
	}else{
	$sql 		= "INSERT INTO akademik_krs Values('$kodekrs','$_username','$jadwal','$semes','$acc','$konversi')";
	$sql2 		= "INSERT INTO akademik_khs (khs_id,krs_id,mutu,kehadiran,tugas,grade,confirm) VALUES('','$kodekrs','0','0','0','','2')";
	$queque 	= mysqli_query($koneksi, $sql);
	$queque 	= mysqli_query($koneksi, $sql2);
	if ($queque) {
		echo "<script>$.Notify({
		    caption: 'Success',
		    content: 'Data KRS dan KHS Berhasil Ditambah',
    		type: 'success'
		});
		setTimeout(function(){ window.location.href='{$_url}krs-cicilan/add-krs/<?= $_id ?>'; }, 2000);
		</script>";
	} else {
		echo "<script>$.Notify({
		    caption: 'Failed',
		    content: 'Data KRS dan KHS Gagal Ditambah',
		    type: 'alert'
		});</script>";
	}
	    }
	    }
}
}
?>
<form Method="POST">
	<label>JADWAL PRODIMU</label>
		<div class="form-group">
			<select class="form-control" name="jadwal_id" id="jadwal_id" onchange='changeValue(this.value)' required>
				<option value="">-Pilih-</option>
                <?php
                if ($id_sks=='1'){
				$result=mysqli_query($koneksi,"SELECT akademik_jadwal_kuliah.*, makul_kelompok.kode_kelompok, akademik_konsentrasi.nama_konsentrasi, makul_matakuliah.kode_makul, makul_matakuliah.sks as sks,makul_matakuliah.nama_makul as nama_makul, makul_matakuliah.makul_id as makul_id,makul_matakuliah.kelompok_id , app_dosen.nama_lengkap as nama_lengkap
				FROM akademik_jadwal_kuliah 
				LEFT JOIN makul_matakuliah ON akademik_jadwal_kuliah.makul_id=makul_matakuliah.makul_id
				LEFT JOIN makul_kelompok ON makul_kelompok.kelompok_id=makul_matakuliah.kelompok_id
				LEFT JOIN app_dosen ON akademik_jadwal_kuliah.dosen_id=app_dosen.dosen_id
				LEFT JOIN akademik_konsentrasi ON akademik_jadwal_kuliah.konsentrasi_id=akademik_konsentrasi.konsentrasi_id
				LEFT JOIN student_mahasiswa ON akademik_jadwal_kuliah.konsentrasi_id=student_mahasiswa.konsentrasi_id
				LEFT JOIN akademik_tahun_akademik ON akademik_jadwal_kuliah.tahun_akademik_id=akademik_tahun_akademik.tahun_akademik_id
				WHERE student_mahasiswa.nim='$_username' and makul_matakuliah.kelompok_id !='1' and akademik_jadwal_kuliah.semester=student_mahasiswa.semester AND akademik_jadwal_kuliah.id_kelas=student_mahasiswa.id_kelas
				and akademik_tahun_akademik.status='y' and jadwal_id NOT IN (Select jadwal_id FROM akademik_krs Where nim='$_username')");
				$jsArray = "var prdName = new Array();\n";
				while ($row= mysqli_fetch_array($result)) {
				echo '<option name="jadwal_id" value="' . $row['jadwal_id'] . '">Kurikulum: ' . $row['nama_kelas'] . '- Kelas:' . $row['nama_kelas'] . '- Semester: ' . $row['semester'] . '-' . $row['nama_makul'] . '</option>';
				$jsArray .= "prdName['" . $row['jadwal_id'] . "'] = {
				nama_makul:'" . addslashes($row['nama_makul']) . "',
				sks:'" . addslashes($row['sks']) . "',
				nama_lengkap:'" . addslashes($row['nama_lengkap']) . "',
				semester:'" . addslashes($row['semester']) . "'
				};\n";
				}
                } else {
				$result=mysqli_query($koneksi,"SELECT akademik_jadwal_kuliah.*, akademik_konsentrasi.nama_konsentrasi, makul_matakuliah.kode_makul, makul_matakuliah.sks as sks,makul_matakuliah.nama_makul as nama_makul, makul_matakuliah.makul_id as makul_id,makul_matakuliah.kelompok_id , app_dosen.nama_lengkap as nama_lengkap
				FROM akademik_jadwal_kuliah 
				LEFT JOIN makul_matakuliah ON akademik_jadwal_kuliah.makul_id=makul_matakuliah.makul_id
				LEFT JOIN app_dosen ON akademik_jadwal_kuliah.dosen_id=app_dosen.dosen_id
				LEFT JOIN akademik_konsentrasi ON akademik_jadwal_kuliah.konsentrasi_id=akademik_konsentrasi.konsentrasi_id
				LEFT JOIN student_mahasiswa ON akademik_jadwal_kuliah.konsentrasi_id=student_mahasiswa.konsentrasi_id 
				LEFT JOIN akademik_tahun_akademik ON akademik_jadwal_kuliah.tahun_akademik_id=akademik_tahun_akademik.tahun_akademik_id
				WHERE student_mahasiswa.nim='$_username' and makul_matakuliah.kelompok_id!='1' AND akademik_jadwal_kuliah.id_kelas=student_mahasiswa.id_kelas
				and akademik_tahun_akademik.status='y' and jadwal_id NOT IN (Select jadwal_id FROM akademik_krs Where nim='$_username') ORDER BY semester ASC");
				$jsArray = "var prdName = new Array();\n";
				while ($row= mysqli_fetch_array($result)) {
				echo '<option name="jadwal_id" value="' . $row['jadwal_id'] . '">Semester: ' . $row['semester'] . '-' . $row['kode_makul'] . '-' . $row['nama_makul'] . '</option>';
				$jsArray .= "prdName['" . $row['jadwal_id'] . "'] = {
				nama_makul:'" . addslashes($row['nama_makul']) . "',
				sks:'" . addslashes($row['sks']) . "',
				nama_lengkap:'" . addslashes($row['nama_lengkap']) . "',
				semester:'" . addslashes($row['semester']) . "'
				};\n";
				}  
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
		<label for="nama_makul">SKS :</label>
			<input class="form-control" type="text" name="sks" id="sks" readonly>
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
    document.getElementById('sks').value = prdName[id].sks;
	document.getElementById('nama_lengkap').value = prdName[id].nama_lengkap;
    document.getElementById('semester').value = prdName[id].semester;
};
</script>