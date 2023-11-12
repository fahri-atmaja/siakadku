<?php
	if ($_access == 'mahasiswa' && $_id != $_username) {
		header("location:{$_url}krs/view/{$_username}");
	}
?>
<h1>
<a href="<?= $_url ?>krs/view/<?= $_id ?>" class="nav-button transform"><span></span></a>
Pilih Matakuliah
</h1>
<?php
$querya = mysqli_query($koneksi, "SELECT student_mahasiswa.*, akademik_konsentrasi.nama_konsentrasi as nama_konsentrasi FROM student_mahasiswa 
	LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=student_mahasiswa.konsentrasi_id WHERE nim='{$_id}'");
$field = mysqli_fetch_array($querya);
extract($field);
?>

<?php
	$npk = $_id;
	if (isset($_POST['submit'])) {
		extract($_POST);

		$sqlin = "INSERT INTO akademik_krs(nim,jadwal_id,semester) VALUES('{$nim}','{$jadwal_id}','{$semester}')";
		$query = mysqli_query($koneksi, $sqlin);

		if ($query) {
			mysqli_query($koneksi, "UPDATE akademik_jadwal_kuliah SET `join`=`join`+1 WHERE id={$jadwal_id}");
			echo "<script>$.Notify({
			    caption: 'Success',
			    content: 'Matakuliah Berhasil Dipilih',
	    		type: 'success'
			});</script>";
		} else {
			echo "<script>$.Notify({
			    caption: 'Failed',
			    content: 'Matakuliah Gagal Dipilih',
			    type: 'alert'
			});</script>";
		}
	}
	
	//$sql = "select jk.jadwal_id,jk.semester,ak.nama_konsentrasi,mm.nama_makul,ad.nama_lengkap
	//		FROM akademik_jadwal_kuliah as jk, akademik_konsentrasi as ak, makul_matakuliah as mm, app_dosen as ad
	//		WHERE jk.konsentrasi_id=ak.konsentrasi_id and jk.makul_id=mm.makul_id and jk.dosen_id=ad.nama_lengkap jk.tahun_akademik_id='1' and ak.nim='$nim'";
		
	$sql = "SELECT akademik_jadwal_kuliah.*, akademik_konsentrasi.nama_konsentrasi, makul_matakuliah.nama_makul as nama_makul, makul_matakuliah.makul_id as makul_id, app_dosen.nama_lengkap as nama_lengkap
			FROM akademik_jadwal_kuliah 
			LEFT JOIN makul_matakuliah ON akademik_jadwal_kuliah.makul_id=makul_matakuliah.makul_id
			LEFT JOIN app_dosen ON akademik_jadwal_kuliah.dosen_id=app_dosen.dosen_id
			LEFT JOIN akademik_konsentrasi ON akademik_jadwal_kuliah.konsentrasi_id=akademik_konsentrasi.konsentrasi_id
			LEFT JOIN student_mahasiswa ON akademik_jadwal_kuliah.konsentrasi_id=student_mahasiswa.konsentrasi_id
			WHERE student_mahasiswa.nim='$_username' and akademik_jadwal_kuliah.semester=student_mahasiswa.semester";
	
	

	$query= mysqli_query($koneksi, $sql);
?>

<form method="post">

<table class="table striped hovered border bordered">
	<thead>
		<tr>
			<th></th>
			<th>Kode Konsentrasi</th>
			<th>Matakuliah</th>
			<th>Dosen</th>
			<th>Semester</th>
		</tr>
	</thead>
	<tbody>

	<?php
		if (mysqli_num_rows($query) > 0):
			while($field = mysqli_fetch_array($query)):
	?>
		<tr>
			<td><input type="radio" name="mkid" value="<?= $field['jadwal_id'] ?>"></td>
			<td><?= $field['nama_konsentrasi'] ?></td>
			<td><?= $field['nama_makul'] ?></td>
			<td><?= $field['nama_lengkap'] ?></td>
			<td><?= $field['semester']-$field['join'] ?></td>
		</tr>
	<?php
			endwhile;
		else:
	?>
		<tr>
			<td colspan="5">
			Data tidak ditemukan
			</td>
		</tr>
	<?php
		endif;
	?>
		
	</tbody>
</table>

<button type="submit" name="submit" class="button primary">SUBMIT</button>

</form>