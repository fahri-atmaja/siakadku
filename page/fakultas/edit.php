
<?php
	if ($_access == 'mahasiswa' && $_id != $_username) {
		header("location:{$_url}krs/view/{$_username}");
	}
// $querya =mysqli_query($koneksi,"SELECT akademik_jadwal_kuliah.*,akademik_konsentrasi.nama_konsentrasi,akademik_kelas.nama_kelas,makul_matakuliah.nama_makul, app_dosen.nama_lengkap, app_hari.hari, dosen_junior.nama_dos FROM akademik_jadwal_kuliah
//         LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=akademik_jadwal_kuliah.konsentrasi_id
//         LEFT JOIN akademik_kelas ON akademik_kelas.id_kelas=akademik_jadwal_kuliah.id_kelas
//         LEFT JOIN makul_matakuliah ON makul_matakuliah.makul_id=akademik_jadwal_kuliah.makul_id
//         LEFT JOIN app_dosen ON app_dosen.dosen_id=akademik_jadwal_kuliah.dosen_id
//         LEFT JOIN dosen_junior ON dosen_junior.dosen_id=akademik_jadwal_kuliah.dosen_id2
//         LEFT JOIN app_hari ON app_hari.hari_id=akademik_jadwal_kuliah.hari_id
//         WHERE akademik_konsentrasi.nama_konsentrasi='$_username' and akademik_jadwal_kuliah.jadwal_id='$_id'");
$querya = mysqli_query($koneksi,"SELECT akademik_jadwal_kuliah.*, akademik_konsentrasi.nama_konsentrasi,
        akademik_tahun_akademik.keterangan, akademik_kelas.nama_kelas, makul_matakuliah.nama_makul, 
        app_dosen.nama_lengkap, app_hari.hari, dosen_junior.nama_dos, app_ruangan.nama_ruangan 
        FROM akademik_jadwal_kuliah
        LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=akademik_jadwal_kuliah.konsentrasi_id
        LEFT JOIN akademik_kelas ON akademik_kelas.id_kelas=akademik_jadwal_kuliah.id_kelas
        LEFT JOIN makul_matakuliah ON makul_matakuliah.makul_id=akademik_jadwal_kuliah.makul_id
        LEFT JOIN app_dosen ON app_dosen.dosen_id=akademik_jadwal_kuliah.dosen_id
        LEFT JOIN dosen_junior ON dosen_junior.dosen_id=akademik_jadwal_kuliah.dosen_id2
        LEFT JOIN app_hari ON app_hari.hari_id=akademik_jadwal_kuliah.hari_id
        LEFT JOIN app_ruangan ON app_ruangan.ruangan_id=akademik_jadwal_kuliah.ruangan_id
        LEFT JOIN akademik_tahun_akademik ON akademik_tahun_akademik.tahun_akademik_id=akademik_jadwal_kuliah.tahun_akademik_id
        WHERE akademik_jadwal_kuliah.jadwal_id='$_id'");
$field = mysqli_fetch_array($querya);
?>
<h1>
<a href="<?= $_url ?>fakultas/jadwal" class="nav-button transform"><span></span></a>
Edit Jadwal<br><?= $nama_makul ?>
</h1>


<?php
	
if (isset($_POST['submit'])) {
$tahun        	= $_POST['tahun_akademik_id'];
$konsentrasi	= $_POST['konsentrasi_id'];
$makul			= $_POST['makul_id'];
$kelas 			= $_POST['id_kelas'];
$hari			= $_POST['hari_id'];
$ruang			= $_POST['ruangan_id'];
$dosen			= $_POST['dosen_id'];
$semester		= $_POST['semester'];
$jam_mulai		= $_POST['jam_mulai'];
$jam_selesai	= $_POST['jam_selesai'];

	$sql = "UPDATE akademik_jadwal_kuliah SET tahun_akademik_id='$tahun', konsentrasi_id='$konsentrasi',
	makul_id='$makul',hari_id='$hari',ruangan_id='$ruang',dosen_id='$dosen',semester='$semester',
	jam_mulai='$jam_mulai',jam_selesai='$jam_selesai',id_kelas='$kelas' WHERE jadwal_id='$_id'";
	$queque = mysqli_query($koneksi, $sql);

	if ($queque) {
		echo "<script>$.Notify({
		    caption: 'Success',
		    content: 'Data Jadwal Berhasil Diubah',
    		type: 'success'
		});
		setTimeout(function(){ window.location.href='{$_url}jadwal'; }, 2000);
		</script>";
	} else {
		echo "<script>$.Notify({
		    caption: 'Failed',
		    content: 'Data Jadwal Gagal Diubah',
		    type: 'alert'
		});</script>";
	}
}
?>

<form Method="POST">
	<table class="table striped hovered border bordered">
		<tr>
<td>
		<div class="form-group">
		<div class="cell">
		<label>Mata Kuliah</label>
		<input type="hidden" name="makul_id" id="makul_id" value="<?= $field['makul_id'] ?>" readonly>
		<input type="text" name="nama_makul" id="nama_makul" value="<?= $field['nama_makul'] ?>" readonly>
		</div>
</td><td>
		<div class="cell">
		<label>Semester</label>
		<input type="text" name="semester" id="semester" value="<?= $field['semester'] ?>" readonly>
		</div>
</td><td>
		<div class="cell">
		<label>Konsentrasi</label>
		<input type="hidden" name="konsentrasi_id" id="konsentrasi_id" value="<?= $field['konsentrasi_id'] ?>">
		<input type="text" name="nama_konsentrasi" id="nama_konsentrasi" value="<?= $field['nama_konsentrasi'] ?>" readonly>
		</div>
		</div>
</td>
		</tr>
		<tr>
		<td>
		<div class="cell">
		<label>Dosen Pengampu</label>
			<select name="dosen_id">
				<option name="dosen_id" value="<?= $field['dosen_id'] ?>"><?= $field['nama_lengkap'] ?></option>
				<?php
					$quedos = mysqli_query($koneksi, "SELECT * FROM app_dosen ORDER BY dosen_id");
					while ($field2 = mysqli_fetch_array($quedos)) {
						echo "<option value='{$field2['dosen_id']}'>{$field2['nama_lengkap']}</option>";
					}
				?>
			</select>
		</div>
		</td>
				<td>
		<div class="cell">
		<label>Status Kelas</label>
			<select name="id_kelas">
				<option name="id_kelas" value="<?= $field['id_kelas'] ?>"><?= $field['nama_kelas'] ?></option>
				<?php
					$quekelas = mysqli_query($koneksi, "SELECT * FROM akademik_kelas ORDER BY id_kelas");
					while ($fillkelas = mysqli_fetch_array($quekelas)) {
						echo "<option value='{$fillkelas['id_kelas']}'>{$fillkelas['nama_kelas']}</option>";
					}
				?>
			</select>
		</div>
		</td>
		</tr>
		<tr>
		<td>
		<div class="cell">
		<label>Ruang Kelas</label>
			<select name="ruangan_id">
				<option name="ruangan_id" value="<?= $field['ruangan_id'] ?>"><?= $field['nama_ruangan'] ?></option>
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
		<label>Tahun Angkatan</label>
			<select name="tahun_akademik_id">
				<option name="tahun_akademik_id" value="<?= $field['tahun_akademik_id'] ?>"><?= $field['keterangan'] ?></option>
				<?php
					$quethn = mysqli_query($koneksi, "SELECT * FROM akademik_tahun_akademik ORDER BY tahun_akademik_id");
					while ($fillth = mysqli_fetch_array($quethn)) {
						echo "<option value='{$fillth['tahun_akademik_id']}'>{$fillth['keterangan']}</option>";
					}
				?>
			</select>
		</div>
		</td>
		<td>
		<div class="form-group">
		<div class="cell">
		<label>Jumlah Pertemuan</label>
		<input type="text" name="pertemuan" id="pertemuan" value="<?= $field['pertemuan'] ?>" required>
		</div>
		</tr>
		<tr>
		<td>
		<div class="cell">
		<label>Hari</label>
			<select name="hari_id">
				<option name="hari_id" value="<?= $field['hari_id'] ?>"><?= $field['hari'] ?></option>
				<?php
					$quehari = mysqli_query($koneksi, "SELECT * FROM app_hari ORDER BY hari_id");
					while ($fillh = mysqli_fetch_array($quehari)) {
						echo "<option value='{$fillh['hari_id']}'>{$fillh['hari']}</option>";
					}
				?>
			</select>
		</div>
		</td>
		<td>
		<div class="cell">
		<label>Jam Mulai</label>
		<input type="time" name="jam_mulai" id="jam_mulai" value="<?= $field['jam_mulai'] ?>">
		</div>
		</td>
		<td>
		<div class="cell">
		<label>Jam Selesai</label>
		<input type="time" name="jam_selesai" id="jam_selesai" value="<?= $field['jam_selesai'] ?>">
		</div>
		</td>
			
		</tr>
	<td>
	
		<button type="submit" name="submit" class="button primary">SUBMIT</button>
	
	</td>
	</table>
</form>
<script type="text/javascript"> 
<?php echo $jsArray; ?>
function changeValue(id){
    document.getElementById('nama_makul').value = prdName[id].nama_makul;
    document.getElementById('semester').value = prdName[id].semester;
    document.getElementById('konsentrasi_id').value = prdName[id].konsentrasi_id;
    document.getElementById('nama_konsentrasi').value = prdName[id].nama_konsentrasi;
};
</script>