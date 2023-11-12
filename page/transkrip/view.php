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
<a href="<?= $_url ?><?= in_array($_access, array('admin','dosen')) ? 'krs' : '' ?>" class="nav-button transform"><span></span></a>
Transkrip Nilai Mahasiswa
</h1>

<?php
$querya = mysqli_query($koneksi, "SELECT student_mahasiswa.*, student_angkatan.keterangan, akademik_konsentrasi.nama_konsentrasi as nama_konsentrasi FROM student_mahasiswa 
	LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=student_mahasiswa.konsentrasi_id
	LEFT JOIN student_angkatan ON student_angkatan.angkatan_id=student_mahasiswa.angkatan_id
	WHERE student_mahasiswa.nim='{$_id}'");
$field = mysqli_fetch_array($querya);
extract($field);
    if($id_sks==2){
        header("location:{$_url}transkrip/konversi/{$_username}");
    }
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
<!--	<div class="cell">
		<label>Semester</label>
		<div class="form-group">
			<?= $semester ?>
		</div>
	</div>
-->
	<div class="cell">
		<label>Program Studi</label>
		<div class="form-group">
			<?= $nama_konsentrasi ?>
		</div>
	</div>
</div>

</div>

<!-- <a href="<?= $_url ?>krs/add-krs/<?= $_id ?>" class="button primary">Pilih Matakuliah</a> -->
<a target="_BLANK" href="<?= $_url ?>transkrip/laporan/<?= $_id ?>" class="button success">Cetak</a>


<?php
	
		$sql = "select ak.*,ah.*,mm.makul_id,mm.nama_makul,mm.sks,ad.nama_lengkap
                            FROM akademik_khs as ah,makul_matakuliah as mm,akademik_jadwal_kuliah as jk,akademik_krs as ak,app_dosen as ad
                            WHERE ah.krs_id=ak.krs_id and mm.makul_id=jk.makul_id and ad.dosen_id=jk.dosen_id and jk.jadwal_id=ak.jadwal_id and ah.confirm='1' and ak.nim='$nim'";
	

	$query = mysqli_query($koneksi, $sql);
?>
<table class="table striped hovered border bordered">
	<thead>
		<tr>
			<th>No</th>
			<th>Matakuliah</th>
			<th>Semester</th>
			<th>SKS</th>
			<th>Dosen</th>
			<th>Nilai</th>
			<th>Bobot</th>
			<th>NB</th>
		</tr>
	</thead>
	<tbody>
	<?php
		$no=1;
		$sks=0;
		if (mysqli_num_rows($query) > 0):
			while($field = mysqli_fetch_array($query)):
				$sks=$sks+$field['sks'];
	?>
	<?php
	$bobot = $field['bobot'];
	$sksx = $field['sks'];
	$nbx = $bobot*$sksx;
	$nb= $nb+$nbx;
	$ip = $nb/$sks;
	?>
		<tr>
			<td><?= $no++ ?></td>
			<td><?= $field['nama_makul'] ?></td>
			<td><?= $field['semester']?></td>
			<td><?= $field['sks'] ?></td>
			<td><?= $field['nama_lengkap'] ?></td>
			<td><?= $field['grade']?></td>
			<td><?= $field['bobot']?></td>
			<td><?php echo $nbx ?></td>
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
	<tfoot><tr><td colspan='3' align='right'>Jumlah</td><td><?php 
			echo $sks ?></td><td colspan=3></td><td><?php echo $nb ?></td></tr>
			<tr><td colspan='3' align='right'>Indeks Prestasi</td><td></td><td colspan=3></td><td><?php echo number_format($ip,2) ?></td></tr>
	</tfoot>
</table>