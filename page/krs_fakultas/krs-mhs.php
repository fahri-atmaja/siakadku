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
<a href="<?= $_url ?>krs_fakultas/<?= in_array($_access, array('admin','dosen')) ? 'krs' : '' ?>" class="nav-button transform"><span></span></a>
KRS Mahasiswa
</h1>

<?php
$querya = mysqli_query($koneksi, "SELECT student_mahasiswa.*, student_angkatan.keterangan, akademik_konsentrasi.nama_konsentrasi as nama_konsentrasi FROM student_mahasiswa 
	LEFT JOIN akademik_konsentrasi ON student_mahasiswa.konsentrasi_id=akademik_konsentrasi.konsentrasi_id
	LEFT JOIN student_angkatan ON student_mahasiswa.angkatan_id=student_angkatan.angkatan_id
	WHERE nim='{$_id}'");
$field = mysqli_fetch_array($querya);
extract($field);

?>


<div class="grid">

<div class="row cells2">
	<div class="cell">
		<label>NIM</label>
		<div class="form-group">
			<?= $nim ?>
		</div>
	</div>
	
	<div class="cell">
		<label>Nama</label>
		<div class="form-group">
			<?= $nama ?>
		</div>
	</div>
</div>

<div class="row cells2">
	<div class="cell">
		<label>Semester</label>
		<div class="form-group">
		    <form method="POST">
		    <select name="semester">
		        <option value="<?= $semester ?>">Semester Sekarang : <?= $semester ?></option>
		        <option value="1">1</option>
		        <option value="2">2</option>
		        <option value="3">3</option>
		        <option value="4">4</option>
		        <option value="5">5</option>
		        <option value="6">6</option>
		        <option value="7">7</option>
		        <option value="8">8</option>
		    </select>
		    <button type="submit" class="button primary">Generate</button>
			</form>
		</div>
	</div>

	<div class="cell">
		<label>Program Studi</label>
		<div class="form-group">
			<?= $nama_konsentrasi ?>
		</div>
	</div>
</div>

</div>
<?php
$semesteri = $_POST['semester'];
?>


<?php
	if (isset($_POST['semester'])):
?>
<div class="container">
    <div class="row">
        <div class="col-md-6">
	    <a href="<?= $_url ?>krs_fakultas/approve/<?= $field['nim'] ?>/<?= $semesteri ?>"><button class="button success">Setujui</button></a>
        <a href="<?= $_url ?>krs_fakultas/disapprove/<?= $field['nim'] ?>/<?= $semesteri ?>"><button class="button danger"> Batal Setujui </a>
        <a target="_blank" href="<?= $_url ?>krs_fakultas/cetak/<?= $field['nim'] ?>/<?= $semesteri ?>"><button class="button success">Cetak</button></a>
        </div>
    </div>
</div>
<?php	    
	    $sql = "SELECT akademik_krs.*, makul_matakuliah.kode_makul, makul_matakuliah.nama_makul, makul_matakuliah.sks, app_dosen.nama_lengkap FROM
        akademik_krs
        LEFT JOIN akademik_jadwal_kuliah ON akademik_jadwal_kuliah.jadwal_id=akademik_krs.jadwal_id
        LEFT JOIN makul_matakuliah ON makul_matakuliah.makul_id=akademik_jadwal_kuliah.makul_id
        LEFT JOIN app_dosen ON app_dosen.dosen_id=akademik_jadwal_kuliah.dosen_id
        LEFT JOIN student_mahasiswa ON student_mahasiswa.nim=akademik_krs.nim
        WHERE student_mahasiswa.nim='$_id' AND akademik_krs.konversi='$semesteri'";
        ?>
        <?php
	else:
	    ?>
	    <?php
		$sql = "SELECT akademik_krs.*, makul_matakuliah.kode_makul, makul_matakuliah.nama_makul, makul_matakuliah.sks, app_dosen.nama_lengkap FROM
        akademik_krs
        LEFT JOIN akademik_jadwal_kuliah ON akademik_jadwal_kuliah.jadwal_id=akademik_krs.jadwal_id
        LEFT JOIN makul_matakuliah ON makul_matakuliah.makul_id=akademik_jadwal_kuliah.makul_id
        LEFT JOIN app_dosen ON app_dosen.dosen_id=akademik_jadwal_kuliah.dosen_id
        LEFT JOIN student_mahasiswa ON student_mahasiswa.nim=akademik_krs.nim
        WHERE student_mahasiswa.nim='$_id' AND student_mahasiswa.semester=akademik_krs.konversi";
        ?>
        <?php
        endif;
        ?>
        <?php
	$query = mysqli_query($koneksi, $sql);
?>

<div class="table-responsive">
<table id="dtHorizontalExample" class="table table-striped table-bordered table-sm" cellspacing="0"
  width="100%">
	<thead>
		<tr>
			<th>Kode</th>
			<th>Matakuliah</th>
			<th>SKS</th>
			<th>Semester</th>
			<th>Dosen</th>
			<th>Disetujui</th>
			<th>Aksi</th>
		</tr>
	</thead>
	<tbody>

	<?php
		if (mysqli_num_rows($query) > 0):
			while($field = mysqli_fetch_array($query)):
			    $sks=$sks+$field['sks'];
	?>
		<tr>
			<td><?= $field['kode_makul'] ?></td>
			<td><?= $field['nama_makul'] ?></td>
			<td><?= $field['sks'] ?></td>
			<td><?= $field['semester'] ?></td>
			<td><?= $field['nama_lengkap'] ?></td>
			<td><?= $field['accept']==1?'sudah disetujui':'belum disetujui'; ?></td>
			<td><?php
			$quququ = mysqli_query($koneksi,"Select accept from akademik_krs where nim='$_id' AND konversi='$semester'");
			$rowe= mysqli_fetch_array($quququ);
			if ($rowe['accept']==0): ?>
			<div class="inline-block">
				    <ul class="split-content d-menu" data-role="dropdown">
		
					<li><a href="<?= $_url ?>krs_fakultas/delete/<?= $_id ?>/<?= $field['krs_id'] ?>/<?= urlencode($field['nim']) ?>" class="place-right"><span class="mif-cross"> Hapus KRS </span></a></li>
					</ul>
			</div>
			<?php
			else:
			?>
			<p>Sudah KRS</p>
				<?php endif; ?></td>
		
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
		<tfoot><tr><td colspan='2' align='right'>Total SKS yang ditempuh</td><td><?php 
			echo $sks ?></td><td colspan=3></td></tr>


	</tfoot>
</table>
</div>