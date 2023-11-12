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

	$sql = "INSERT INTO jadwal_kuliah SET jadwal_id='$jadwal_id', dosen_id='$dosen', ruangan_id='$ruang',tanggal='$tanggal',
	jam='$jam'";
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
				<option value="">-Pilih-</option>
                <?php
				// $query=mysqli_query($koneksi,"SELECT akademik_jadwal_kuliah.*, akademik_konsentrasi.nama_konsentrasi, makul_matakuliah.kode_makul , makul_matakuliah.sks as sks, makul_matakuliah.nama_makul as nama_makul, makul_matakuliah.makul_id as makul_id, app_dosen.nama_lengkap as nama_lengkap
				// FROM akademik_jadwal_kuliah 
				// LEFT JOIN makul_matakuliah ON akademik_jadwal_kuliah.makul_id=makul_matakuliah.makul_id
				// LEFT JOIN app_dosen ON akademik_jadwal_kuliah.dosen_id=app_dosen.dosen_id
				// LEFT JOIN akademik_konsentrasi ON akademik_jadwal_kuliah.konsentrasi_id=akademik_konsentrasi.konsentrasi_id
				// LEFT JOIN student_mahasiswa ON akademik_jadwal_kuliah.konsentrasi_id=student_mahasiswa.konsentrasi_id
				// LEFT JOIN student_mahasiswa ON akademik_jadwal_kuliah.id_kelas=student_mahasiswa.id_kelas
				// WHERE akademik_konsentrasi.nama_konsentrasi='$_username'");
				$result=mysqli_query($koneksi,"SELECT akademik_jadwal_kuliah.*,akademik_kelas.nama_kelas, akademik_konsentrasi.nama_konsentrasi, makul_matakuliah.kode_makul, makul_matakuliah.sks as sks,makul_matakuliah.nama_makul as nama_makul, makul_matakuliah.makul_id as makul_id, app_dosen.nama_lengkap as nama_lengkap
				FROM akademik_jadwal_kuliah 
				LEFT JOIN akademik_kelas ON akademik_kelas.id_kelas=akademik_jadwal_kuliah.id_kelas
				LEFT JOIN makul_matakuliah ON akademik_jadwal_kuliah.makul_id=makul_matakuliah.makul_id
				LEFT JOIN app_dosen ON akademik_jadwal_kuliah.dosen_id=app_dosen.dosen_id
				LEFT JOIN akademik_konsentrasi ON akademik_jadwal_kuliah.konsentrasi_id=akademik_konsentrasi.konsentrasi_id
				LEFT JOIN akademik_tahun_akademik ON akademik_jadwal_kuliah.tahun_akademik_id=akademik_tahun_akademik.tahun_akademik_id
				WHERE akademik_konsentrasi.nama_konsentrasi='$_username' and akademik_tahun_akademik.status='y' and jadwal_id NOT IN (Select jadwal_id FROM jadwal_kuliah)
				ORDER BY akademik_jadwal_kuliah.semester ASC");
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
	<td>
	<div class="form-group">
		<label for="semester">SEMESTER :</label>
			<input class="form-control" type="text" name="semester" id="semester" readonly>
	</div>
	</td>
		<td>
		<div class="form-group">
		<label>Kelas</label>
			<input class="form-control" type="text" name="nama_kelas" id="nama_kelas" readonly>
		</div>
		</td>
	</tr>
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

<?php

	   // $sql1 ="SELECT akademik_jadwal_kuliah.*,akademik_konsentrasi.nama_konsentrasi,akademik_kelas.nama_kelas,makul_matakuliah.nama_makul,makul_matakuliah.kelompok_id, app_dosen.nama_lengkap, app_hari.hari, dosen_junior.nama_dos FROM akademik_jadwal_kuliah
    //     LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=akademik_jadwal_kuliah.konsentrasi_id
    //     LEFT JOIN akademik_kelas ON akademik_kelas.id_kelas=akademik_jadwal_kuliah.id_kelas
    //     LEFT JOIN makul_matakuliah ON makul_matakuliah.makul_id=akademik_jadwal_kuliah.makul_id
    //     LEFT JOIN app_dosen ON app_dosen.dosen_id=akademik_jadwal_kuliah.dosen_id
    //     LEFT JOIN dosen_junior ON dosen_junior.dosen_id=akademik_jadwal_kuliah.dosen_id2
    //     LEFT JOIN app_hari ON app_hari.hari_id=akademik_jadwal_kuliah.hari_id
    //     ORDER by akademik_konsentrasi.nama_konsentrasi ASC, akademik_jadwal_kuliah.id_kelas ASC, app_hari.hari_id ASC ";
        
    $sql1   = "SELECT jadwal_kuliah.tanggal, jadwal_kuliah.jam, app_ruangan.nama_ruangan, akademik_jadwal_kuliah.semester, akademik_jadwal_kuliah.jadwal_id, akademik_konsentrasi.nama_konsentrasi, akademik_kelas.nama_kelas,makul_matakuliah.nama_makul,app_dosen.nama_lengkap FROM jadwal_kuliah
        LEFT JOIN app_ruangan ON app_ruangan.ruangan_id=jadwal_kuliah.ruangan_id
        LEFT JOIN akademik_jadwal_kuliah ON akademik_jadwal_kuliah.jadwal_id=jadwal_kuliah.jadwal_id
        LEFT JOIN akademik_kelas ON akademik_kelas.id_kelas=akademik_jadwal_kuliah.id_kelas
        LEFT JOIN makul_matakuliah ON makul_matakuliah.makul_id=akademik_jadwal_kuliah.makul_id
        LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=akademik_jadwal_kuliah.konsentrasi_id
        LEFT JOIN app_dosen ON app_dosen.dosen_id=jadwal_kuliah.dosen_id
        LEFT JOIN akademik_tahun_akademik ON akademik_jadwal_kuliah.tahun_akademik_id=akademik_tahun_akademik.tahun_akademik_id
        WHERE akademik_tahun_akademik.status='y' and akademik_konsentrasi.nama_konsentrasi='$_username'
        ";
	$query1 = mysqli_query($koneksi, $sql1);
	
?>

<table class="table striped hovered border bordered">
	<thead>
		<tr>
			<th>No</th>
			<th>Kelas</th>
			<th>Matakuliah</th>
			<th>Prodi</th>
			<th>Pengawas Ujian</th>
			<th>Semester</th>
			<th>Tanggal</th>
			<th>Jam Mulai</th>
			<th>Ruangan</th>
			<th></th>
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
			<td><?= $field1['nama_kelas'] ?></td>
			<td><?= $field1['nama_makul'] ?></td>
			<td><?= $field1['nama_konsentrasi'] ?></td>
			<td><?= $field1['nama_lengkap'] ?></td>
			<td><?= $field1['semester'] ?></td>
			<td><?php echo tgl_indo($field1['tanggal']) ?></td>
			<td><?= $field1['jam'] ?></td>
			<td><?= $field1['nama_ruangan'] ?></td>
			<td>
				<div class="inline-block">
				    <button class="button dropdown-toggle">Aksi</button>
				    <ul class="split-content d-menu" data-role="dropdown">
				        <li><a href="<?= $_url ?>presensi_mahasiswa/cetak-uas/<?= $field1['jadwal_id'] ?>/<?= urlencode($field1['nama_makul']) ?>"><span class="mif-zoom-in"></span>Cetak Presensi</a></li>
				        <li><a href="<?= $_url ?>jadwal_uas/edit/<?= $field1['jadwal_id'] ?>/<?= urlencode($field1['nama_makul']) ?>"><span class="mif-zoom-in"></span>Edit</a></li>
						<li><a href="<?= $_url ?>jadwal_uas/delete/<?= $field1['jadwal_id'] ?>/<?= urlencode($field1['nama_makul']) ?>"><span class="mif-cross"></span> Delete</a></li>
					
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
