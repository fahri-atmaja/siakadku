<div class="container-fluid">
<div class="row">
    <div class="col-md-6">
        <h3><a href="<?= $_url ?>nilai_fakultas" class="nav-button transform"><span></span></a>Daftar Makul Dosen</h3>
        <?php
	if ($_access == 'mahasiswa' && $_id != $_username) {
		header("location:{$_url}krs/view/{$_username}");
	}
?>
<?php
if (isset($_POST['submit'])){
    $semester = $_POST['semester'];
    $akademik = $_POST['akademik'];
	$sql = "select jk.*,akls.nama_kelas, ata.keterangan as tahun, ak.nama_konsentrasi,ah.hari,mm.nama_makul,ad.nama_lengkap
			FROM akademik_jadwal_kuliah as jk, akademik_tahun_akademik as ata,akademik_kelas as akls, akademik_konsentrasi as ak,makul_matakuliah as mm,app_dosen as ad,app_hari as ah
			WHERE jk.tahun_akademik_id=ata.tahun_akademik_id and jk.hari_id=ah.hari_id and jk.id_kelas=akls.id_kelas and jk.konsentrasi_id=ak.konsentrasi_id 
			and jk.makul_id=mm.makul_id and jk.dosen_id=ad.dosen_id and ad.nip='{$_id}' and jk.semester='$semester' and ata.tahun_akademik_id='$akademik'
			and ak.nama_konsentrasi='{$_username}'
			ORDER BY ata.tahun_akademik_id ASC, ak.konsentrasi_id ASC, jk.hari_id ASC, jk.semester ASC";	
	$query = mysqli_query($koneksi, $sql);
}else{
	$sql = "select jk.*,akls.nama_kelas, ata.keterangan as tahun, ak.nama_konsentrasi,ah.hari,mm.nama_makul,ad.nama_lengkap
			FROM akademik_jadwal_kuliah as jk, akademik_tahun_akademik as ata,akademik_kelas as akls, akademik_konsentrasi as ak,makul_matakuliah as mm,app_dosen as ad,app_hari as ah
			WHERE jk.tahun_akademik_id=ata.tahun_akademik_id and jk.hari_id=ah.hari_id and jk.id_kelas=akls.id_kelas and jk.konsentrasi_id=ak.konsentrasi_id 
			and jk.makul_id=mm.makul_id and jk.dosen_id=ad.dosen_id and ad.nip='{$_id}'
			and ak.nama_konsentrasi='{$_username}'
			ORDER BY ata.tahun_akademik_id DESC, ak.konsentrasi_id ASC, jk.hari_id ASC, jk.semester ASC";
	$query = mysqli_query($koneksi, $sql);
}
?>
<div class="container-fluid">
<form method="POST">

    <div class="row">
    <label for="semester">Semester</label>
    </div>
    <div class="row">
    <select name="semester" id="semester" required>
        <option value="">-- pilih --</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="7">7</option>
        <option value="8">8</option>
    </select>
    </div>
    <div class="row">
        <label for="semester">Tahun Akademik</label>
        </div>
        <div class="row">
    <select name="akademik" id="akademik" required>
       <option value="">-- pilih --</option>
				<?php
					$result = mysqli_query($koneksi, "SELECT * FROM akademik_tahun_akademik");
					while ($row= mysqli_fetch_array($result)) {
					echo '<option name="akademik" value="' . $row['tahun_akademik_id'] . '">'. $row['keterangan'].'</option>';
				}
				?>
    </select>
    <button type="submit" name="submit">Submit</button>
        </div>

</form>
</div>
<table class="table striped hovered border bordered">
	<thead>
		<tr>
			<th>No</th>
			<th>Tahun Akademik</th>
			<th>Prodi/Konsentrasi</th>
			<th>Matakuliah</th>
			<th>Kelas</th>
			<th>Dosen Pengajar</th>
			<th>Semester</th>
			<th>Hari</th>
			<th>Jam Mulai</th>
			<th></th>
		</tr>
	</thead>
	<tbody>

	<?php
		$no=1;
		if (mysqli_num_rows($query) > 0):
			while($field = mysqli_fetch_array($query)):
	?>
	
		<tr>
			<td><?= $no++ ?></td>
			<td><?= $field['tahun'] ?></td>
			<td><?= $field['nama_konsentrasi'] ?></td>
			<td><?= $field['nama_makul'] ?></td>
			<td><?= $field['nama_kelas'] ?></td>
			<td><?= $field['nama_lengkap'] ?></td>
			<td><?= $field['semester'] ?></td>
			<td><?= $field['hari'] ?></td>
			<td><?= $field['jam_mulai'] ?></td>
			<td>
				<div class="inline-block">
					<button class="button dropdown-toggle">Aksi</button>
				<ul class="split-content d-menu" data-role="dropdown">
				<li><a href="<?= $_url ?>nilai_fakultas/lihat_nilai/<?= $field['jadwal_id'] ?>/<?= urlencode($_id) ?>"><span class="mif-zoom-in"></span>View Nilai</a></li>
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
</form>
    </div>
</div>
</div>