<?php
	if ($_access == 'dosen' && $_id != $_username) {
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
<a href="<?= $_url ?><?= in_array($_access, array('admin','dosen')) ? 'krs' : '' ?>" class="nav-button transform"><span></span></a>
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
				$query=mysqli_query($koneksi, "SELECT jk.*, mm.kode_makul, mm.nama_makul, ak.nama_konsentrasi, akrs.nim,sm.nama
					   FROM akademik_jadwal_kuliah as jk, makul_matakuliah as mm, akademik_konsentrasi as ak, akademik_krs as akrs, student_mahasiswa.nama
					   WHERE jk.jadwal_id=akrs.jadwal_id and jk.makul_id=mm.makul_id and jk.konsentrasi_id=ak.konsentrasi_id and akrs.nim=sm.nim and jk.dosen_id=app.dosen_id
					   and app_dosen.nip='$_username'");
				$result=mysqli_query($koneksi, "SELECT jk.*, mm.kode_makul, mm.nama_makul, ak.nama_konsentrasi, akrs.nim,sm.nama
					   FROM akademik_jadwal_kuliah as jk, makul_matakuliah as mm, akademik_konsentrasi as ak, akademik_krs as akrs, student_mahasiswa.nama
					   WHERE jk.jadwal_id=akrs.jadwal_id and jk.makul_id=mm.makul_id and jk.konsentrasi_id=ak.konsentrasi_id and akrs.nim=sm.nim and jk.dosen_id=app.dosen_id
					   and app_dosen.nip='$_username'
					   ORDER BY jadwal_id");
				$jsArray = "var prdName = new Array();\n";
				while ($row= mysqli_fetch_array($result)) {
				echo '<option name="jadwal_id" value="' . $row['jadwal_id'] . '">' . $row['jadwal_id'] . '-' . $row['kode_makul'] . '-' . $row['nama_makul'] . '</option>';
				$jsArray .= "prdName['" . $row['jadwal_id'] . "'] = {
				nama_makul:'" . addslashes($row['nama_makul']) . "',
				nama_lengkap:'" . addslashes($row['nama_lengkap']) . "',
				semester:'" . addslashes($row['semester']) . "',
				nama_konsentrasi:'" . addslashes($row['nama_konsentrasi']) . "',
				nim:'" . addslashes($row['nim']) . "',
				nama:'" . addslashes($row['nama']) . "',
				};\n";
				}
				
				?>
		</div>
	</div>
	<?php
		if (mysqli_num_rows($query) > 0):
			while($field = mysqli_fetch_array($query)):
	?>
	<div class="cell">
		<label>Nama Makul</label>
		<div class="form-group">
			<?= $field['nama_makul'] ?>
		</div>
	</div>
</div>

<div class="row cells2">
	<div class="cell">
		<label>Semester</label>
		<div class="form-group">
			<?= $field['semester'] ?>
		</div>
	</div>

	<div class="cell">
		<label>Program Studi / Konsentrasi</label>
		<div class="form-group">
			<?= $field['nama_konsentrasi'] ?>
		</div>
	</div>
	<div class="cell">
		<label>Dosen Pengajar</label>
		<div class="form-group">
			<?= $field['nama_lengkap'] ?>
		</div>
	</div>
</div>

</div>

<table class="table striped hovered border bordered">
	<thead>
		<tr>
			<th>NIM</th>
			<th>NAMA MAHASISWA</th>
			<th>TTD</th>
			<th>Cek Dosen</th>
			
		</tr>
	</thead>
	<tbody>

	<?php
		if (mysqli_num_rows($query) > 0):
			while($field = mysqli_fetch_array($query)):
	?>
		<tr>
			<td><?= $field['nim'] ?></td>
			<td><?= $field['nama'] ?></td>
			<td></td>
			<td></td>
			
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