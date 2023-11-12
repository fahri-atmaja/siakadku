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
Setup Absen Tanggal Mulai Jadwal
</h1>

<?php
if (isset($_POST['submit'])) {

	extract($_POST);

	$sql = "INSERT INTO student_absen values('{$absen_id}', '{$jadwal_id}', '{$tanggal}', '{$keterangan}');";
	$query = mysqli_query($koneksi, $sql);

	if ($query) {
		echo "<script>$.Notify({
		    caption: 'Success',
		    content: 'Data Mulai Absen Berhasil Ditambah',
    		type: 'success'
		});</script>";
	} else {
		echo "<script>$.Notify({
		    caption: 'Failed',
		    content: 'Data MulaiAbsen Gagal Ditambah',
		    type: 'alert'
		});</script>";
	}
}
?>

<form method="POST">


<div class="form-group">
		<label>Jadwal ID</label>
		<div class="input-control text full-size">
		<select class="form-control" name="jadwal_id" id="jadwal_id" onchange='changeValue(this.value)' required>
				<option value="">-Pilih-</option>
			<?php
				$query=mysqli_query($koneksi,"select jk.*,ak.nama_konsentrasi,mm.nama_makul,ad.nama_lengkap
			FROM akademik_jadwal_kuliah as jk,akademik_konsentrasi as ak,makul_matakuliah as mm,app_dosen as ad
			WHERE jk.konsentrasi_id=ak.konsentrasi_id and jk.makul_id=mm.makul_id and jk.dosen_id=ad.dosen_id and ad.nip='{$_username}'");
				$result=mysqli_query($koneksi,"select jk.*,ak.nama_konsentrasi,mm.nama_makul,ad.nama_lengkap
			FROM akademik_jadwal_kuliah as jk,akademik_konsentrasi as ak,makul_matakuliah as mm,app_dosen as ad
			WHERE jk.konsentrasi_id=ak.konsentrasi_id and jk.makul_id=mm.makul_id and jk.dosen_id=ad.dosen_id and ad.nip='{$_username}'
			ORDER BY jk.hari_id ASC");
				$jsArray = "var prdName = new Array();\n";
				while ($row= mysqli_fetch_array($result)) {
					echo '<option name="jadwal_id" value="' . $row['jadwal_id'] . '">' . $row['jadwal_id'] . '-' . $row['nama_makul'] . '</option>';
					$jsArray .= "prdName['" . $row['jadwal_id'] . "'] = {nama_makul:'" . addslashes($row['nama_makul']) . "',
					semester:'" . addslashes($row['semester']) . "',
					hari_id:'" . addslashes($row['hari_id']) . "',
					jam_mulai:'" . addslashes($row['jam_mulai']) . "',
					nama_konsentrasi:'" . addslashes($row['nama_konsentrasi']) . "',
					nama_lengkap:'" . addslashes($row['nama_lengkap']) . "'
					};\n";
				}
				?>	
		</select>
		</div>
	
	<div class="form-group">
		<label>Jadwal ID</label>
		<div class="input-control text full-size">
			<input type="text" name="jadwal_id" id="jadwal_id" readonly>
		</div>
	</div>
	<div class="form-group">
		<label>Nama Makul</label>
		<div class="input-control text full-size">
			<input type="text" name="nama_makul" id="nama_makul" readonly>
		</div>
		<label>Semester</label>
		<div class="input-control text full-size">
			<input type="text" name="semester" id="semester" readonly>
		</div>
	</div>
	
<div class="form-group">
	<label>Tanggal Mulai</label>
		<div class="input-control text full-size">
			<input type="date" name="tanggal_mulai" id="tanggal_mulai">
		</div>
	<label>Keterangan</label>
		<div class="input-control text full-size">
			<input type="text-area" name="keterangan" id="keterangan">
		</div>
</div>

<div class="row cells2">
	<div class="cell">
		<button type="submit" name="submit" class="button primary">SUBMIT</button>
	</div>
</div>

</div>

</form>
<script type="text/javascript"> 
<?php echo $jsArray; ?>
function changeValue(id){
    document.getElementById('jadwal_id').value = prdName[id].jadwal_id;
	document.getElementById('nama_makul').value = prdName[id].nama_makul;
    document.getElementById('semester').value = prdName[id].semester;
	document.getElementById('hari_id').value = prdName[id].hari_id;
	document.getElementById('jam_mulai').value = prdName[id].jam_mulai;
	document.getElementById('nama_konsentrasi').value = prdName[id].nama_konsentrasi;
    document.getElementById('nama_lengkap').value = prdName[id].nama_lengkap;
};
</script>