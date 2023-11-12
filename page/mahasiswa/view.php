<?php
	if ($_access == 'mahasiswa' && $_id != $_username) {
		header("location:{$_url}mahasiswa/view/{$_username}");
	}
?>
<style type="text/css">
	.input-control {
		border: 1px solid #d9d9d9;
		padding: 10px;
	}
</style>

<?php
$querya = mysqli_query($koneksi, "SELECT student_mahasiswa.*, student_angkatan.keterangan, app_agama.keterangan as agama,app_dosen.nama_lengkap as nama_dosen, akademik_konsentrasi.nama_konsentrasi as nama_konsentrasi FROM student_mahasiswa 
	LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=student_mahasiswa.konsentrasi_id
	LEFT JOIN student_angkatan ON student_angkatan.angkatan_id=student_mahasiswa.angkatan_id
	LEFT JOIN app_agama ON app_agama.agama_id=student_mahasiswa.agama_id
	LEFT JOIN app_dosen ON app_dosen.dosen_id=student_mahasiswa.dosen_id
	WHERE student_mahasiswa.nim='{$_username}'");

$field = mysqli_fetch_array($querya);

?>
<h1>
<a href="<?= $_url ?><?= $_access == 'admin' ? 'mahasiswa' : '' ?>" class="nav-button transform"><span></span></a>
Mahasiswa <br> <?= $nama ?>
</h1>
 


<div class="panel" data-role="panel">
    <div class="heading">
        <span class="title">Profil</span>
    </div>
<div class="grid">
	<div class="content">
<table class="table striped hovered border bordered">
<tr>
	<td>
<div class="row cells2">
	<div class="cell">
		<label>NIM</label>
		<div class="form-group">
			<?= $field['nim']; ?>
		</div>
	</div>
	
	<div class="cell">
		<label>Nama</label>
		<div class="form-group">
			<?= $field['nama']; ?>
		</div>
	</div>
</div>
	</td>
</tr>
<tr>
<td>
<div class="row cells2">
	<div class="cell">
		<label>Alamat</label>
		<div class="form-group">
			<?= $field['alamat'] ?>
		</div>
	</div>

	<div class="cell">
		<label>Telepon</label>
		<div class="form-group">
			<?= $field['no_hp_ortu'] ?>
		</div>
	</div>
</div>
</td>
</tr>
<tr><td>
<div class="row cells2">
	<div class="cell">
		<label>Tempat Lahir</label>
		<div class="form-group">
			<?= $field['tempat_lahir'] ?>
		</div>
	</div>

	<div class="cell">
		<label>Tanggal Lahir</label>
		<div class="form-group">
			<?= tgl_indo($field['tanggal_lahir']) ?>
		</div>
	</div>
</div>
</td></tr>
<tr><td>
<div class="row cells2">
	<div class="cell">
		<label>Agama</label>
		<div class="form-group">
			<?= $field['agama']; ?>
		</div>
	</div>

	<div class="cell">
		<label>Jenis Kelamin</label>
		<div class="form-group">
			<?php if($field['gender']==1){
			echo "Laki-laki"; 
			}else{
			echo "Perempuan"; 
			} ?>
		</div>
	</div>
</div>
</td></tr>
<tr><td>
<div class="row cells2">
	<div class="cell">
		<label>Tahun Masuk</label>
		<div class="form-group">
			<?= $field['keterangan'] ?>
		</div>
	</div>

	<div class="cell">
		<label>Program Studi</label>
		<div class="form-group">
			<?= $field['nama_konsentrasi'] ?>
		</div>
	</div>
</div>
</td></tr>
<tr><td>
<div class="row cells2">
	<div class="cell">
		<label>Dosen Wali</label>
		<div class="form-group">
			<?= $field['nama_dosen'] ?>
		</div>
	</div>

	<!--<div class="cell">-->
	<!--	<label>Program Studi</label>-->
	<!--	<div class="form-group">-->
	<!--		<?= $field['nama_konsentrasi'] ?>-->
	<!--	</div>-->
	<!--</div>-->
</div>
</td></tr>
</table>
</div>
</div>
</div>

<?php 
// 	$loadmhs= mysqli_query($koneksi,"SELECT beasiswa, status_angsur FROM student_mahasiswa WHERE nim='$_id'");
// 	$lol = mysqli_query($koneksi,"SELECT kpd.tanggal,kpd.jumlah ,kjb.keterangan FROM keuangan_pembayaran_detail as kpd, keuangan_jenis_bayar as kjb
// 			 WHERE kpd.jenis_bayar_id=kjb.jenis_bayar_id and kpd.nim='$_id'");
// 	$mhs = mysqli_fetch_array($loadmhs);
// 	if ($mhs['status_angsur']==0 || $mhs['beasiswa']!=1):
?>
<!--<div class="panel" data-role="panel">-->
<!--    <div class="heading">-->
<!--        <span class="title">History Pembayaran</span>-->
<!--    </div>-->
<!--<div class="grid">-->
<!--	<div class="content">-->
<!--<table class="table striped hovered border bordered">-->
<!--	<thead>-->
<!--	<tr>-->
<!--		<th>Tanggal</th>-->
<!--		<th>Jenis Bayar</th>-->
<!--		<th>Jumlah Bayar</th>-->
<!--	</tr>-->
<!--	</thead>-->
<!--	<tbody>-->
	<?php
// 	$no=1;
// 		if (mysqli_num_rows($lol) > 0):
// 			while($sheet = mysqli_fetch_array($lol)):
	?>
	<!--<tr>-->
	<!--	<td><?= $sheet['tanggal'] ?></td>-->
	<!--	<td><?= $sheet['keterangan'] ?></td>-->
	<!--	<td><?= $sheet['jumlah'] ?></td>-->
	<!--</tr>-->
	<?php
// 			endwhile;
// 		else:
	?>
		<!--<tr>-->
		<!--	<td colspan="4">-->
		<!--	Data tidak ditemukan-->
		<!--	</td>-->
		<!--</tr>-->
	<?php
// 		endif;
	?>
		
<!--	</tbody>-->
<!--	</tbody>-->
<!--</table>-->
<!--</div>-->
<!--</div>-->
<!--</div>-->
<?php
// 	$lol2 = mysqli_query($koneksi,"SELECT kjb.keterangan, kbk.jumlah
// 								   FROM student_mahasiswa as sm, akademik_konsentrasi as ak, akademik_prodi as ap, keuangan_biaya_kuliah as kbk, keuangan_jenis_bayar as kjb
// 								   WHERE sm.konsentrasi_id=kbk.konsentrasi_id AND sm.angkatan_id=kbk.angkatan_id AND kbk.jenis_bayar_id=kjb.jenis_bayar_id 
// 								   AND ak.konsentrasi_id=sm.konsentrasi_id AND ap.prodi_id=ak.prodi_id AND kbk.jenis_bayar_id NOT IN (SELECT jenis_bayar_id FROM keuangan_pembayaran_detail WHERE nim='$_id') AND sm.nim='$_id'");
?>
<!--<div class="panel" data-role="panel">-->
<!--    <div class="heading">-->
<!--        <span class="title">Tagihan Pembayaran</span>-->
<!--    </div>-->
<!--<div class="grid">-->
<!--	<div class="content">-->
<!--<table class="table striped hovered border bordered">-->
<!--	<thead>-->
<!--	<tr>-->
<!--		<th>Jenis Bayar</th>-->
<!--		<th>Jumlah Bayar</th>-->
<!--	</tr>-->
<!--	</thead>-->
<!--	<tbody>-->
	<?php
// 	$no=1;
// 		if (mysqli_num_rows($lol2) > 0):
// 			while($sheet1 = mysqli_fetch_array($lol2)):
	?>
	<!--<tr>-->
	<!--	<td><?= $sheet1['keterangan'] ?></td>-->
	<!--	<td><?= $sheet1['jumlah'] ?></td>-->
	<!--</tr>-->
	<?php
// 			endwhile;
// 		else:
	?>
		<!--<tr>-->
		<!--	<td colspan="4">-->
		<!--	Data tidak ditemukan-->
		<!--	</td>-->
		<!--</tr>-->
	<?php
// 		endif;
	?>
		
<!--	</tbody>-->
<!--</table>-->
<!--</div>-->
<!--</div>-->
<!--</div>-->
<?php
// elseif ($mhs['status_angsur']=='1' || $mhs['beasiswa']!=1):
?>
<?php
// $lolol= mysqli_query($koneksi,"SELECT * FROM bayar_angsuran WHERE nim='$_id'")
?>
<!--<div class="panel" data-role="panel">-->
<!--    <div class="heading">-->
<!--        <span class="title">History Angsuran</span>-->
<!--    </div>-->
<!--<div class="grid">-->
<!--	<div class="content">-->
<!--<table class="table striped hovered border bordered">-->
<!--	<thead>-->
<!--	<tr>-->
<!--		<th>Tanggal</th>-->
<!--		<th>Angsuran Ke</th>-->
<!--		<th>Total Jumlah Bayar</th>-->
<!--	</tr>-->
<!--	</thead>-->
<!--	<tbody>-->
	<?php
// 	$no=1;
// 		if (mysqli_num_rows($lolol) > 0):
// 			while($sheet = mysqli_fetch_array($lolol)):
	?>
	<!--<tr>-->
	<!--	<td><?= tgl_indo($sheet['tanggal']) ?></td>-->
	<!--	<td><?= $sheet['angsuran'] ?></td>-->
	<!--	<td><?= $sheet['bayar'] ?></td>-->
	<!--</tr>-->
	<?php
// 			endwhile;
// 		else:
	?>
		<!--<tr>-->
		<!--	<td colspan="4">-->
		<!--	Data tidak ditemukan-->
		<!--	</td>-->
		<!--</tr>-->
	<?php
// 		endif;
	?>
		
<!--	</tbody>-->
<!--	</tbody>-->
<!--</table>-->
<!--</div>-->
<!--</div>-->
<!--</div>-->
<?php
// $lolol2= mysqli_query($koneksi,"SELECT ba.*,sm.status_angsur FROM biaya_angsuran as ba, student_mahasiswa as sm WHERE ba.konsentrasi_id=sm.konsentrasi_id AND sm.nim='$_id'")
?>
<!--<div class="panel" data-role="panel">-->
<!--    <div class="heading">-->
<!--        <span class="title">Tagihan Pembayaran</span>-->
<!--    </div>-->
<!--<div class="grid">-->
<!--	<div class="content">-->
<!--<table class="table striped hovered border bordered">-->
<!--	<thead>-->
<!--	<tr>-->
<!--		<th>Jumlah Angsuran</th>-->
<!--		<th>Jumlah Bayar</th>-->
<!--	</tr>-->
<!--	</thead>-->
<!--	<tbody>-->
	<?php
// 	$no=1;
// 		if (mysqli_num_rows($lolol2) > 0):
// 			while($sheet2 = mysqli_fetch_array($lolol2)):
	?>
	<!--<tr>-->
	<!--	<td><?= $sheet2['jumlah_angsur'] ?></td>-->
	<!--	<td><?= $sheet2['total_biaya'] ?></td>-->
	<!--</tr>-->
	<?php
// 			endwhile;
// 		else:
	?>
		<!--<tr>-->
		<!--	<td colspan="4">-->
		<!--	Data tidak ditemukan-->
		<!--	</td>-->
		<!--</tr>-->
	<?php
// 		endif;
	?>
		
<!--	</tbody>-->
<!--</table>-->
<!--</div>-->
<!--</div>-->
<!--</div>-->
<?php
// endif;
?>