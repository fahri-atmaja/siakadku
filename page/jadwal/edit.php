<?php

$querya = mysqli_query($koneksi, 
			"select jk.*,ak.nama_konsentrasi,mm.nama_makul,ad.nama_lengkap,ah.hari_id,ah.hari,ar.ruangan_id,
			ar.nama_ruangan,ata.keterangan,ata.tahun_akademik_id
			FROM akademik_jadwal_kuliah as jk,app_hari as ah,akademik_konsentrasi as ak,makul_matakuliah as mm,app_dosen as ad,app_ruangan as ar,
			akademik_tahun_akademik as ata
			WHERE jk.konsentrasi_id=ak.konsentrasi_id and jk.hari_id=ah.hari_id
			and jk.makul_id=mm.makul_id and jk.dosen_id=ad.dosen_id and jk.ruangan_id=ar.ruangan_id and jk.tahun_akademik_id=ata.tahun_akademik_id  
			and jk.jadwal_id='$_id'");
$field = mysqli_fetch_array($querya);
extract($field);
?>
<h1>
<a href="<?= $_url ?>jadwal<?= $_access == 'jadwal' ? '/' . $_id . '/' . urlencode($nama_makul) : '' ?>" class="nav-button transform"><span></span></a>
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
$dosen2			= $_POST['dosen_id2'];
$semester		= $_POST['semester'];
$jam_mulai		= $_POST['jam_mulai'];
$jam_selesai	= $_POST['jam_selesai'];

	$sql = "UPDATE akademik_jadwal_kuliah SET tahun_akademik_id='$tahun', konsentrasi_id='$konsentrasi',
	makul_id='$makul',hari_id='$hari',ruangan_id='$ruang',dosen_id='$dosen',dosen_id2='$dosen2',semester='$semester',
	jam_mulai='$jam_mulai',jam_selesai='$jam_selesai',id_kelas='$kelas' WHERE jadwal_id='{$_id}'";
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
					while ($field = mysqli_fetch_array($quedos)) {
						echo "<option value='{$field['dosen_id']}'>{$field['nama_lengkap']}</option>";
					}
				?>
			</select>
		</div>
		</td>
		<td>
		<div class="cell">
		<label>Dosen Pembantu</label>
			<select name="dosen_id2">
				<option name="dosen_id2" value="<?= $field['dosen_id2'] ?>"><?= $field['dosen_id2'] ?></option>
				<?php
					$quedos1 = mysqli_query($koneksi, "SELECT * FROM app_dosen ORDER BY dosen_id");
					while ($field1 = mysqli_fetch_array($quedos1)) {
						echo "<option value='{$field1['dosen_id']}'>{$field1['nama_lengkap']}</option>";
					}
				?>
			</select>
		</div>
		</td>
				<td>
		<div class="cell">
		<label>Status Kelas</label>
			<select name="id_kelas">
				<option name="id_kelas" value="">-- pilih --</option>
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