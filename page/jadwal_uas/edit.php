<?php

$sql1   = "SELECT jadwal_kuliah.tanggal, jadwal_kuliah.jam, app_ruangan.nama_ruangan, akademik_jadwal_kuliah.semester, akademik_jadwal_kuliah.jadwal_id, akademik_konsentrasi.nama_konsentrasi, akademik_kelas.nama_kelas,makul_matakuliah.nama_makul,app_dosen.nama_lengkap FROM jadwal_kuliah
        LEFT JOIN app_ruangan ON app_ruangan.ruangan_id=jadwal_kuliah.ruangan_id
        LEFT JOIN akademik_jadwal_kuliah ON akademik_jadwal_kuliah.jadwal_id=jadwal_kuliah.jadwal_id
        LEFT JOIN akademik_kelas ON akademik_kelas.id_kelas=akademik_jadwal_kuliah.id_kelas
        LEFT JOIN makul_matakuliah ON makul_matakuliah.makul_id=akademik_jadwal_kuliah.makul_id
        LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=akademik_jadwal_kuliah.konsentrasi_id
        LEFT JOIN app_dosen ON app_dosen.dosen_id=jadwal_kuliah.dosen_id
        WHERE akademik_konsentrasi.nama_konsentrasi='$_username'
        ";
	$query1 = mysqli_query($koneksi, $sql1);
	$field = mysqli_fetch_array($query1);
?>

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
<a href="<?= $_url ?><?= in_array($_access, array('admin','dosen','fakultas')) ? 'dashboard' : '' ?>" class="nav-button transform"><span></span></a>
Input Jadwal UAS
</h1>

<?php
	
if (isset($_POST['submit'])) {
$jadwal_id  	= $_POST['jadwal_id'];
$tanggal			= $_POST['tanggal'];
$jam			= $_POST['jam'];
$ruang			= $_POST['ruangan_id'];
$dosen			= $_POST['dosen_id'];

	$sql = "UPDATE jadwal_kuliah SET jadwal_id='$jadwal_id', dosen_id='$dosen', ruangan_id='$ruang',tanggal='$tanggal',
	jam='$jam' WHERE jadwal_id='$jadwal_id'";
	$queque = mysqli_query($koneksi, $sql);

	if ($queque) {
		echo "<script>$.Notify({
		    caption: 'Success',
		    content: 'Data Jadwal Berhasil Ditambah',
    		type: 'success'
		});
		setTimeout(function(){ window.location.href='{$_url}jadwal_uas'; }, 2000);
		</script>";
	} else {
		echo "<script>$.Notify({
		    caption: 'Failed',
		    content: 'Data Jadwal Gagal Ditambah',
		    type: 'alert'
		});</script>";
	}
}
?>
<form Method="POST">
<label>JADWAL PRODI</label>
		<div class="form-group">
			<select class="form-control" name="jadwal_id" id="jadwal_id" onchange='changeValue(this.value)' required>
                <?php
				$query=mysqli_query($koneksi,"SELECT akademik_jadwal_kuliah.*, akademik_konsentrasi.nama_konsentrasi, makul_matakuliah.kode_makul , makul_matakuliah.sks as sks, makul_matakuliah.nama_makul as nama_makul, makul_matakuliah.makul_id as makul_id, app_dosen.nama_lengkap as nama_lengkap
				FROM akademik_jadwal_kuliah 
				LEFT JOIN makul_matakuliah ON akademik_jadwal_kuliah.makul_id=makul_matakuliah.makul_id
				LEFT JOIN app_dosen ON akademik_jadwal_kuliah.dosen_id=app_dosen.dosen_id
				LEFT JOIN akademik_konsentrasi ON akademik_jadwal_kuliah.konsentrasi_id=akademik_konsentrasi.konsentrasi_id
				LEFT JOIN student_mahasiswa ON akademik_jadwal_kuliah.konsentrasi_id=student_mahasiswa.konsentrasi_id
				LEFT JOIN student_mahasiswa ON akademik_jadwal_kuliah.id_kelas=student_mahasiswa.id_kelas
				WHERE akademik_konsentrasi.nama_konsentrasi='$_username'");
				$result=mysqli_query($koneksi,"SELECT akademik_jadwal_kuliah.*,akademik_kelas.nama_kelas, akademik_konsentrasi.nama_konsentrasi, makul_matakuliah.kode_makul, makul_matakuliah.sks as sks,makul_matakuliah.nama_makul as nama_makul, makul_matakuliah.makul_id as makul_id, app_dosen.nama_lengkap as nama_lengkap
				FROM akademik_jadwal_kuliah 
				LEFT JOIN akademik_kelas ON akademik_kelas.id_kelas=akademik_jadwal_kuliah.id_kelas
				LEFT JOIN makul_matakuliah ON akademik_jadwal_kuliah.makul_id=makul_matakuliah.makul_id
				LEFT JOIN app_dosen ON akademik_jadwal_kuliah.dosen_id=app_dosen.dosen_id
				LEFT JOIN akademik_konsentrasi ON akademik_jadwal_kuliah.konsentrasi_id=akademik_konsentrasi.konsentrasi_id
				WHERE akademik_konsentrasi.nama_konsentrasi='$_username' and jadwal_id='$_id'");
				$jsArray = "var prdName = new Array();\n";
				while ($row= mysqli_fetch_array($result)) {
				echo '<option name="jadwal_id" value="' . $row['jadwal_id'] . '">Semester: ' . $row['semester'] . '-' . $row['kode_makul'] . '-' . $row['nama_makul'] . ' Kelas : ' . $row['nama_kelas'] . '</option>';
				$jsArray .= "prdName['" . $row['jadwal_id'] . "'] = {
				nama_makul:'" . addslashes($row['nama_makul']) . "',
				sks:'" . addslashes($row['sks']) . "',
				nama_lengkap:'" . addslashes($row['nama_lengkap']) . "',
				semester:'" . addslashes($row['semester']) . "',
				nama_kelas:'" . addslashes($row['nama_kelas']) . "'
				};\n";
				}
				?>
			</select>
	</div>
	<table class="table striped hovered border bordered">
		<tr>
		    		<td>
		<div class="cell">
		<label>Pilih Pengawas</label>
			<select name="dosen_id">
				<option name="dosen_id" value="" required>-- pilih --</option>
				<?php
					$queruang = mysqli_query($koneksi, "SELECT * FROM app_dosen ORDER BY nama_lengkap ASC");
					while ($fill = mysqli_fetch_array($queruang)) {
						echo "<option value='{$fill['dosen_id']}'>{$fill['nama_lengkap']}</option>";
					}
				?>
			</select>
		</div>
		</td>
		<td>
		<div class="cell">
		<label>Ruang Kelas</label>
			<select name="ruangan_id">
				<option name="ruangan_id" value="" required>-- pilih --</option>
				<?php
					$queruang = mysqli_query($koneksi, "SELECT * FROM app_ruangan ORDER BY ruangan_id");
					while ($fill = mysqli_fetch_array($queruang)) {
						echo "<option value='{$fill['ruangan_id']}'>{$fill['nama_ruangan']}</option>";
					}
				?>
			</select>
		</div>
		</td>	
		<td>
		<div class="cell">
		<label>Jam Mulai</label>
		<input type="time" name="jam" id="jam_mulai" required>
		</div>
		</td>
		<td>
		<div class="cell">
		<label>Tanggal</label>
		<input type="date" name="tanggal" id="tanggal" required>
		</div>
		</td>
		<td></td>
		</tr>
		
		<tr>
	<td>
	
		<button type="submit" name="submit" class="button primary">SUBMIT</button>
	
	</td>
	</tr>
	</table>
</form>
<script type="text/javascript"> 
<?php echo $jsArray; ?>
function changeValue(id){
    document.getElementById('nama_makul').value = prdName[id].nama_makul;
    document.getElementById('sks').value = prdName[id].sks;
	document.getElementById('nama_lengkap').value = prdName[id].nama_lengkap;
    document.getElementById('semester').value = prdName[id].semester;
    document.getElementById('nama_kelas').value = prdName[id].nama_kelas;
};
</script>
