<h1>
<a href="<?= $_url ?>fakultas/jadwal<?= in_array($_access, array('admin','dosen','fakultas')) ? '' : '' ?>" class="nav-button transform"><span></span></a>
Input Jadwal
</h1>


<?php
if (isset($_POST['submit'])) {
$tahun        	= $_POST['tahun_akademik_id'];
$konsentrasi	= $_POST['konsentrasi_id'];
$makul			= $_POST['makul_id'];
$hari			= $_POST['hari_id'];
$kelas 			= $_POST['id_kelas'];
$ruang			= $_POST['ruangan_id'];
$dosen			= $_POST['dosen_id'];
$dosen2			= $_POST['dosen_id2'];
$semester		= $_POST['semester'];
$jam_mulai		= $_POST['jam_mulai'];
$jam_selesai	= $_POST['jam_selesai'];
$pertemuan		= $_POST['pertemuan'];

	$sql = "INSERT INTO akademik_jadwal_kuliah SET tahun_akademik_id='$tahun', konsentrasi_id='$konsentrasi',
	makul_id='$makul',hari_id='$hari',ruangan_id='$ruang',dosen_id='$dosen',dosen_id2='$dosen2',semester='$semester',
	jam_mulai='$jam_mulai',jam_selesai='$jam_selesai',pertemuan='$pertemuan',pertemuan_mhs='$pertemuan',id_kelas='$kelas'";
	$queque = mysqli_query($koneksi, $sql);

	if ($queque) {
		echo "<script>$.Notify({
		    caption: 'Success',
		    content: 'Data Jadwal Berhasil Ditambah',
    		type: 'success'
		});
		setTimeout(function(){ window.location.href='{$_url}fakultas/jadwal'; }, 2000);
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
	<div class="form-group">
	<label>Select Makul</label>
			<select class="form-control" name="makul_id" id="makul_id" onchange='changeValue(this.value)' required>
				<option value="">-- pilih --</option>
				<?php
					$query = mysqli_query($koneksi, "SELECT mm.*,ak.nama_konsentrasi FROM makul_matakuliah as mm, akademik_konsentrasi as ak
													WHERE mm.konsentrasi_id=ak.konsentrasi_id");
					$result = mysqli_query($koneksi, "SELECT mm.*,ak.nama_konsentrasi, mk.kode_kelompok FROM makul_matakuliah as mm, akademik_konsentrasi as ak, makul_kelompok as mk
													WHERE mm.kelompok_id=mk.kelompok_id and mm.konsentrasi_id=ak.konsentrasi_id and ak.nama_konsentrasi='$_username'
													-- and makul_id NOT IN (Select makul_id FROM akademik_jadwal_kuliah)
													ORDER BY kelompok_id DESC , semester ASC, nama_konsentrasi ASC");
					$jsArray = "var prdName = new Array();\n";
					while ($row= mysqli_fetch_array($result)) {
					echo '<option name="makul_id" value="' . $row['makul_id'] . '">'. $row['kode_kelompok'].' - Semester ' . $row['semester'] . '-' . $row['nama_makul'] . '</option>';
					$jsArray .= "prdName['" . $row['makul_id'] . "'] = {
					semester:'" . addslashes($row['semester']) . "',
					nama_makul:'" . addslashes($row['nama_makul']) . "',
					nama_konsentrasi:'" . addslashes($row['nama_konsentrasi']) . "',
					konsentrasi_id:'" . addslashes($row['konsentrasi_id']) . "',
					};\n";
				}
				?>
			</select>
	</div>
	<table class="table striped hovered border bordered">
		<tr>
<td>
		<div class="form-group">
		<div class="cell">
		<label>Mata Kuliah</label>
		<input type="text" name="nama_makul" id="nama_makul" readonly>
		</div>
</td><td>
		<div class="cell">
		<label>Semester</label>
		<input type="text" name="semester" id="semester" readonly>
		</div>
</td><td>
		<div class="cell">
		<label>Konsentrasi</label>
		<input type="hidden" name="konsentrasi_id" id="konsentrasi_id">
		<input type="text" name="nama_konsentrasi" id="nama_konsentrasi" readonly>
		</div>
		</div>
</td>
		</tr>
		<tr>
		<td>
		<div class="cell">
		<label>Dosen Pengampu</label>
			<select name="dosen_id" required>
				<option name="dosen_id" value="">-- pilih --</option>
				<?php
					$quedos = mysqli_query($koneksi, "SELECT * FROM app_dosen ORDER BY nama_lengkap ASC");
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
				<option name="dosen_id2" value="">-- Not Set --</option>
				<?php
					$quedos = mysqli_query($koneksi, "SELECT * FROM dosen_junior ORDER BY dosen_id");
					while ($field = mysqli_fetch_array($quedos)) {
						echo "<option value='{$field['dosen_id']}'>{$field['nama_dos']}</option>";
					}
				?>
			</select>
		</div>
		</td>
		<td>
		<div class="cell">
		<label>Status Kelas</label>
			<select name="id_kelas" required>
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
			<select name="ruangan_id" required>
				<option name="ruangan_id" value="">-- pilih --</option>
				<?php
					$queruang = mysqli_query($koneksi, "SELECT * FROM app_ruangan ORDER BY nama_ruangan ASC");
					while ($fill = mysqli_fetch_array($queruang)) {
						echo "<option value='{$fill['ruangan_id']}'>{$fill['nama_ruangan']}</option>";
					}
				?>
			</select>
		</div>
		</td>	
		<td>
		<div class="cell">
		<label>Tahun Akademik</label>
			<select name="tahun_akademik_id" required>
				<option name="tahun_akademik_id" value="">-- pilih --</option>
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
		<input type="text" name="pertemuan" id="pertemuan" required>
		</div>
		</td>	
		</tr>
		<tr>
		<td>
		<div class="cell">
		<label>Hari</label>
			<select name="hari_id" required>
				<option name="hari_id" value="">-- pilih --</option>
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
		<input type="time" name="jam_mulai" id="jam_mulai" value="<?php $date = date("H:i", strtotime($row['time_d']));?>" required>
		</div>
		</td>
		<td>
		<div class="cell">
		<label>Jam Selesai</label>
		<input type="time" name="jam_selesai" id="jam_selesai" value="<?php $date = date("H:i", strtotime($row['time_d'])); ?>" required>
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