<?php
	if ($_access == 'mahasiswa' && $_id != $_username) {
		header("location:{$_url}krs/view/{$_username}");
	}
	if ($_access == 'fakultas' && $_id != $_username) {
		header("location:{$_url}fakultas/jadwal");
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
		setTimeout(function(){ window.location.href='{$_url}jadwal'; }, 2000);
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
					$result = mysqli_query($koneksi, "SELECT mm.*,ak.nama_konsentrasi FROM makul_matakuliah as mm, akademik_konsentrasi as ak
													WHERE mm.konsentrasi_id=ak.konsentrasi_id and mm.kelompok_id=3 and makul_id NOT IN (Select makul_id FROM akademik_jadwal_kuliah)
													ORDER BY mm.kelompok_id ASC, mm.semester ASC");
					$jsArray = "var prdName = new Array();\n";
					while ($row= mysqli_fetch_array($result)) {
					echo '<option name="makul_id" value="' . $row['makul_id'] . '">Semester ' . $row['semester'] . '-' . $row['nama_konsentrasi'] . '-' . $row['kode_makul'] . '-' . $row['nama_makul'] . '</option>';
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
			<select name="dosen_id">
				<option name="dosen_id" value="">-- pilih --</option>
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
				<option name="dosen_id2" value="">-- pilih --</option>
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
				<option name="ruangan_id" value="">-- pilih --</option>
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
		<input type="text" name="pertemuan" id="pertemuan">
		</div>
		</td>	
		</tr>
		<tr>
		<td>
		<div class="cell">
		<label>Hari</label>
			<select name="hari_id">
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
		<input type="time" name="jam_mulai" id="jam_mulai">
		</div>
		</td>
		<td>
		<div class="cell">
		<label>Jam Selesai</label>
		<input type="time" name="jam_selesai" id="jam_selesai">
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

<?php

// 	$sql1 = "select jk.*,ak.nama_konsentrasi,akls.nama_kelas,mm.nama_makul,ad.nama_lengkap,ah.hari,adj.nama_dos
// 			FROM akademik_jadwal_kuliah as jk,akademik_kelas as akls,app_hari as ah,akademik_konsentrasi as ak,makul_matakuliah as mm,app_dosen as ad,
// 			dosen_junior as adj
// 			WHERE jk.konsentrasi_id=ak.konsentrasi_id and jk.hari_id=ah.hari_id
// 			and jk.makul_id=mm.makul_id and jk.id_kelas=akls.id_kelas and jk.dosen_id=ad.dosen_id and jk.dosen_id2=adj.dosen_id
// 			ORDER BY jk.hari_id ASC, ak.nama_konsentrasi ASC, jk.semester ASC, jk.id_kelas ASC";		
// 	$query1 = mysqli_query($koneksi, $sql1);
	    $sql1 ="SELECT akademik_jadwal_kuliah.*,akademik_konsentrasi.nama_konsentrasi,akademik_kelas.nama_kelas,makul_matakuliah.nama_makul,makul_matakuliah.kelompok_id, app_dosen.nama_lengkap, app_hari.hari, dosen_junior.nama_dos FROM akademik_jadwal_kuliah
        LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=akademik_jadwal_kuliah.konsentrasi_id
        LEFT JOIN akademik_kelas ON akademik_kelas.id_kelas=akademik_jadwal_kuliah.id_kelas
        LEFT JOIN makul_matakuliah ON makul_matakuliah.makul_id=akademik_jadwal_kuliah.makul_id
        LEFT JOIN app_dosen ON app_dosen.dosen_id=akademik_jadwal_kuliah.dosen_id
        LEFT JOIN dosen_junior ON dosen_junior.dosen_id=akademik_jadwal_kuliah.dosen_id2
        LEFT JOIN app_hari ON app_hari.hari_id=akademik_jadwal_kuliah.hari_id
        ORDER by akademik_konsentrasi.nama_konsentrasi ASC, akademik_jadwal_kuliah.id_kelas ASC, app_hari.hari_id ASC ";
	$query1 = mysqli_query($koneksi, $sql1);
	
?>

<table class="table striped hovered border bordered">
	<thead>
		<tr>
			<th>No</th>
			<th>Prodi/Konsentrasi</th>
			<th>Kelas</th>
			<th>Matakuliah</th>
			<th>Dosen Pengajar</th>
			<th>Dosen Pengajar 2</th>
			<th>Semester</th>
			<th>Hari</th>
			<th>Jam Mulai</th>
			<th>Pertemuan</th>
		</tr>
	</thead>
	<tbody>

	<?php
		$no=1;
		if (mysqli_num_rows($query1) > 0):
			while($field1 = mysqli_fetch_array($query1)):
	?>
		<tr>
			<td><?= $no++ ?></td>
			<td><?= $field1['nama_konsentrasi'] ?></td>
			<td><?= $field1['nama_kelas'] ?></td>
			<td><?= $field1['nama_makul'] ?></td>
			<td><?= $field1['nama_lengkap'] ?></td>
			<td><?php if ($field1['nama_dos']==0){
				echo "Not Set";
				}else{
				echo $field1['nama_dos'];
			}  ?></td>
			<td><?= $field1['semester'] ?></td>
			<td><?= $field1['hari'] ?></td>
			<td><?= $field1['jam_mulai'] ?></td>
			<td><?= $field1['pertemuan'] ?></td>
			<td>
				<div class="inline-block">
				    <button class="button mini-button dropdown-toggle">Aksi</button>
				    <ul class="split-content d-menu" data-role="dropdown">
						<li><a href="<?= $_url ?>jadwal/delete/<?= $field1['jadwal_id'] ?>/<?= urlencode($field1['nama_makul']) ?>"><span class="mif-cross"></span> Delete</a></li>
						<!--
						<li><a href="<?= $_url ?>krs/approve/<?= $field['nim'] ?>/<?= urlencode($field['nama']) ?>"><span class="mif-checkmark"></span> Approve</a></li> -->
						<li><a href="<?= $_url ?>jadwal/edit/<?= $field1['jadwal_id'] ?>/<?= urlencode($field1['nama_makul']) ?>"><span class="mif-pencil"></span> Edit</a></li>
						<li><a href="<?= $_url ?>dosen/list_absensi/<?= $field1['jadwal_id'] ?>/<?= urlencode($field1['nama_makul']) ?>"><span class="mif-pencil"></span> List Absen</a></li>
					
				    </ul>
				</div>
			</td>
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
