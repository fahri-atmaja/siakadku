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
<a href="<?= $_url ?><?= in_array($_access, array('admin','dosen')) ? 'dosen/acc-krs' : '' ?>" class="nav-button transform"><span></span></a>
KRS Mahasiswa
</h1>

<?php
$querya = mysqli_query($koneksi, "SELECT student_mahasiswa.*, student_angkatan.keterangan, akademik_konsentrasi.nama_konsentrasi as nama_konsentrasi FROM student_mahasiswa 
	LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=student_mahasiswa.konsentrasi_id
	LEFT JOIN student_angkatan ON student_angkatan.angkatan_id=student_mahasiswa.angkatan_id
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
			<?= $semester ?>
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

<!-- <a href="<?= $_url ?>krs/add-krs/<?= $_id ?>" class="button primary">Pilih Matakuliah</a> 
<a href="<?= $_url ?>krs/laporan/<?= $_id ?>" class="button success">Cetak</a> -->
<a href="<?= $_url ?>dosen/approve/<?= $field['nim'] ?>/<?= urlencode($field['semester']) ?>"><span class="mif-pencil"></span> Setujui </a>
<a href="<?= $_url ?>dosen/disapprove/<?= $field['nim'] ?>/<?= urlencode($field['semester']) ?>"><span class="mif-pencil"></span> Batal Setujui </a>

<?php
	
		$sql = "select ak.*,mm.makul_id,mm.nama_makul,mm.sks,ad.nama_lengkap
                            FROM makul_matakuliah as mm,akademik_jadwal_kuliah as jk,akademik_krs as ak,app_dosen as ad
                            WHERE mm.makul_id=jk.makul_id and ad.dosen_id=jk.dosen_id and jk.jadwal_id=ak.jadwal_id and ak.nim='$nim' and ak.konversi='$semester'";
	

	$query = mysqli_query($koneksi, $sql);
?>

<table class="table striped hovered border bordered">
	<thead>
		<tr>
			<th>Kode</th>
			<th>Matakuliah</th>
			<th>SKS</th>
			<th>Dosen</th>
			<th>Disetujui</th>
			<th></th>
		</tr>
	</thead>
	<tbody>

	<?php
		if (mysqli_num_rows($query) > 0):
			while($field = mysqli_fetch_array($query)):
			    $sks=$sks+$field['sks'];
	?>
		<tr>
			<td><?= $field['makul_id'] ?></td>
			<td><?= $field['nama_makul'] ?></td>
			<td><?= $field['sks'] ?></td>
			<td><?= $field['nama_lengkap'] ?></td>
			<td><?= $field['accept']==1?'sudah disetujui':'belum disetujui'; ?></td>
			<td>
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
	<tfoot><tr><td colspan='2' align='right'>Total SKS yang ditempuh</td><td><?php 
			echo $sks ?></td><td colspan=3></td></tr>


	</tfoot>
</table>
<?php
if ($sks>24){
    	echo "<script>window.alert('Peringatan!! SKS melebihi syarat maksimal!!!')</script>";
}
?>