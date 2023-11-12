<?php
	if ($_access == 'mahasiswa' && $_id != $_username) {
		header("location:{$_url}krs/view/{$_username}");
	}
?>
<style type="text/css">
	.input-control {
		border: 1px solid #d9d9d9;
		padding: 10px;
	}
</style>

<h1>
<a href="<?= $_url ?>" class="nav-button transform"><span></span></a>
Absensi Mahasiswa
</h1>

<div class="grid">

<div class="row cells2">
	<div class="cell">
		<label>JADWAL ID</label>
		<div class="form-group">
			<select class="form-control" name="jadwal_id" id="jadwal_id" onchange='changeValue(this.value)' required>
				<option value="">-Pilih-</option>
				<?php
				$query=mysqli_query($koneksi, "SELECT jk.*, mm.nama_makul, ad.nama_lengkap
									 FROM akademik_jadwal_kuliah as jk, makul_matakuliah as mm, app_dosen as ad
									 WHERE jk.jadwal_id=mm.jadwal_id, jk.dosen_id=ad.dosen_id and ad.nip='$_username'");
				$result=mysqli_query($koneksi, "SELECT jk.*, mm.nama_makul, ad.nama_lengkap
									 FROM akademik_jadwal_kuliah as jk, makul_matakuliah as mm, app_dosen as ad
									 WHERE jk.makul_id=mm.makul_id, jk.dosen_id=ad.dosen_id and ad.nip='$_username'");
				$jsArray = "var prdName = new Array();\n";
				while ($row= mysqli_fetch_array($result)) {
				echo '<option name="jadwal_id" value="' . $row['jadwal_id'] . '">' . $row['jadwal_id'] . ' - ' . $row['kode_makul'] . ' - ' . $row['nama_makul'] . '</option>';
				$jsArray .= "prdName['" . $row['jadwal_id'] . "'] = {
				nama_makul:'" . addslashes($row['nama_makul']) . "',
				semester:'" . addslashes($row['semester']) . "',
				nama_lengkap:'" . addslashes($row['nama_lengkap']) . "'
				};\n";
				}
				?>
			</div>
		</div>
	</div>
</div>
<div class="row cells2">	
	<div class="cell">
		<label>Nama Makul</label>
		<div class="form-group">
			<input class="form-control" type="text" name="nama_makul" id="nama_makul" readonly>
		</div>
	</div>
</div>

<div class="row cells2">
	<div class="cell">
		<label>Semester</label>
		<div class="form-group">
			<input class="form-control" type="text" name="semester" id="semester" readonly>
		</div>
	</div>

<div class="row cells2">
	<div class="cell">
			<input type="submit" class="button primary">
	</div>
</div>
</div>


<script type="text/javascript"> 
<?php echo $jsArray; ?>
function changeValue(id){
    document.getElementById('nama_makul').value = prdName[id].nama_makul;
    document.getElementById('semester').value = prdName[id].semester;
};
</script>