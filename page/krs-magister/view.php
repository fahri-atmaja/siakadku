<style type="text/css">
	.input-control {
		border: 1px solid #d9d9d9;
		padding: 10px;
	}
</style>
<?php
$cek = mysqli_query($koneksi,"SELECT konsentrasi_id, beasiswa FROM student_mahasiswa WHERE nim='$_username'");
$validasi = mysqli_fetch_array($cek);
if ($validasi['konsentrasi_id']!='25'){
    echo "<script>window.alert('MAAF HALAMAN TIDAK BISA DIAKSSES')
		    window.location.href='{$_url}'</script>";
}elseif ($validasi['beasiswa']=='1'){
    echo "<script>window.alert('Redirect...')
		    window.location.href='{$_url}krs-beasiswa/view/{$_username}'</script>";
}

?>
<h1>
<a href="<?= $_url ?><?= in_array($_access, array('admin','dosen')) ? '' : '' ?>" class="nav-button transform"><span></span></a>
KRS Mahasiswa
</h1>

<?php
$querya = mysqli_query($koneksi, "SELECT student_mahasiswa.*, akademik_kelas.nama_kelas, biaya_sks.id_sks,biaya_sks.jenis_sks, student_angkatan.keterangan, akademik_konsentrasi.nama_konsentrasi as nama_konsentrasi FROM student_mahasiswa 
	LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=student_mahasiswa.konsentrasi_id
	LEFT JOIN student_angkatan ON student_angkatan.angkatan_id=student_mahasiswa.angkatan_id
	LEFT JOIN akademik_kelas ON akademik_kelas.id_kelas=student_mahasiswa.id_kelas
	LEFT JOIN biaya_sks ON biaya_sks.id_sks=student_mahasiswa.id_sks
	WHERE nim='{$_id}'");
$field = mysqli_fetch_array($querya);
$saatini = $field['semester'];
extract($field);
$loadtahun = mysqli_query($koneksi,"SELECT * FROM akademik_tahun_akademik WHERE status='y'");
$tahun = mysqli_fetch_array($loadtahun);
?>
<div class="grid">
<span style="color: blue">Anda terdaftar di kelas <?= $jenis_sks ?> <?= $nama_kelas ?><br>
Tahun Akademik Saat Ini :<b> <?= $tahun['keterangan']; ?> </b></span>
<br>
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
<form method="POST">
<?php
 $sks=0;
 $loadkrs = mysqli_query($koneksi,"SELECT sum(mm.sks) as value_sks FROM makul_matakuliah as mm, akademik_krs as ak, akademik_jadwal_kuliah as jk 
			WHERE mm.makul_id=jk.makul_id AND jk.jadwal_id=ak.jadwal_id AND ak.nim='$_username' AND ak.konversi='$semester' ");
			
$query13 = mysqli_query($koneksi,"SELECT accept FROM akademik_krs WHERE nim='$_username' AND konversi='$semester'");
$acc = mysqli_fetch_array($query13);
$sumsks = mysqli_fetch_array($loadkrs);
// $ququ= mysqli_query($koneksi,"select aktif_krs from student_mahasiswa where nim='$nim'");
// $row= mysqli_fetch_array($ququ);
// if ($row['aktif_krs']=="y"){
$loadmhs = mysqli_query($koneksi,"SELECT angkatan_id, status_angsur,semester FROM student_mahasiswa WHERE nim='$_username'");
$kondisi= mysqli_fetch_array($loadmhs);
$loaduang=mysqli_query($koneksi,"SELECT jenis_bayar_id, semester FROM keuangan_pembayaran_detail WHERE nim='$_username' AND jenis_bayar_id='3'");
if (mysqli_num_rows($loaduang)){
while ($status= mysqli_fetch_array($loaduang)){
if ($status['jenis_bayar_id']=='3' and $status['semester']=='1' and $kondisi['status_angsur']=='0' and $kondisi['semester']=='1' and $acc['accept']!='1'):
?>
<a href= "<?= $_url ?>krs-magister/add-krs/<?= $_id ?>" class="button primary">Pilih Matakuliah</a>
<?php
elseif ($status['jenis_bayar_id']=='3' and $status['semester']=='2' and $kondisi['status_angsur']=='0' and $kondisi['semester']=='2' and $acc['accept']!='1'):
?>
<a href= "<?= $_url ?>krs-magister/add-krs/<?= $_id ?>" class="button primary">Pilih Matakuliah</a>
<?php
elseif ($status['jenis_bayar_id']=='3' and $status['semester']=='3' and $kondisi['status_angsur']=='0' and $kondisi['semester']=='3' and $acc['accept']!='1'):
?>
<a href= "<?= $_url ?>krs-magister/add-krs/<?= $_id ?>" class="button primary">Pilih Matakuliah</a>
<?php
elseif ($status['jenis_bayar_id']=='3' and $status['semester']=='4' and $kondisi['status_angsur']=='0' and $kondisi['semester']=='4' and $acc['accept']!='1'):
?>
<a href= "<?= $_url ?>krs-magister/add-krs/<?= $_id ?>" class="button primary">Pilih Matakuliah</a>
<?php
elseif ($status['jenis_bayar_id']=='3' and $status['semester']=='5' and $kondisi['status_angsur']=='0' and $kondisi['semester']=='5' and $acc['accept']!='1'):
?>
<a href= "<?= $_url ?>krs-magister/add-krs/<?= $_id ?>" class="button primary">Pilih Matakuliah</a>
<?php
elseif ($status['jenis_bayar_id']=='3' and $status['semester']=='6' and $kondisi['status_angsur']=='0' and $kondisi['semester']=='6' and $acc['accept']!='1'):
?>
<a href= "<?= $_url ?>krs-magister/add-krs/<?= $_id ?>" class="button primary">Pilih Matakuliah</a>
<?php
elseif ($status['jenis_bayar_id']=='3' and $status['semester']=='7' and $kondisi['status_angsur']=='0' and $kondisi['semester']=='7' and $acc['accept']!='1'):
?>
<a href= "<?= $_url ?>krs-magister/add-krs/<?= $_id ?>" class="button primary">Pilih Matakuliah</a>
<?php
elseif ( $sumsks['value_sks'] > 24):
?>
<p><span style="color: red">SKS melebihi syarat batas : <?php echo $sumsks['value_sks'] ?>. Hapus beberapa KRS</span></p>
<?php
		endif;
?>

<?php } ?>

    <?php } ?>
    
<?php
	
// 	$sql = "select ak.*,mm.kode_makul,mm.nama_makul,mm.sks,ad.nama_lengkap
//             FROM makul_matakuliah as mm,akademik_jadwal_kuliah as jk,akademik_krs as ak,app_dosen as ad
//             WHERE mm.makul_id=jk.makul_id and ad.dosen_id=jk.dosen_id and jk.jadwal_id=ak.jadwal_id and ak.nim='$nim'
//             and jk.semester='$semester'";
    $sql = "SELECT akademik_krs.*, akademik_kelas.nama_kelas, akademik_tahun_akademik.keterangan,
	        makul_matakuliah.kode_makul, makul_matakuliah.nama_makul, makul_matakuliah.sks, 
	        app_dosen.nama_lengkap,makul_kelompok.kode_kelompok,akademik_konsentrasi.nama_konsentrasi as jurusan
	        FROM akademik_krs
            LEFT JOIN akademik_jadwal_kuliah ON akademik_jadwal_kuliah.jadwal_id=akademik_krs.jadwal_id
            LEFT JOIN makul_matakuliah ON makul_matakuliah.makul_id=akademik_jadwal_kuliah.makul_id
            LEFT JOIN app_dosen ON app_dosen.dosen_id=akademik_jadwal_kuliah.dosen_id
            LEFT JOIN akademik_kelas ON akademik_kelas.id_kelas=akademik_jadwal_kuliah.id_kelas
            LEFT JOIN student_mahasiswa ON student_mahasiswa.nim=akademik_krs.nim
            LEFT JOIN akademik_tahun_akademik ON akademik_tahun_akademik.tahun_akademik_id=akademik_jadwal_kuliah.tahun_akademik_id
            LEFT JOIN makul_kelompok ON makul_kelompok.kelompok_id=makul_matakuliah.kelompok_id
            LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=makul_matakuliah.konsentrasi_id
            WHERE student_mahasiswa.nim='$_username' and akademik_krs.konversi=student_mahasiswa.semester";
	$query = mysqli_query($koneksi, $sql);
?>
<?php 
if ($kondisi['angkatan_id'] > 16):
    ?>
    <a href= "<?= $_url ?>krs-magister/add-krs/<?= $_id ?>" class="button primary">Pilih Matakuliah</a>
<?php
endif;
?>
<?php
if ($acc['accept']==1):
    ?>
<a target="_BLANK" href="<?= $_url ?>krs/cetak/<?= $_id ?>/<?= urlencode($semester) ?>" class="button success">Cetak</a>
<?php
endif;
?>
<div class="table-responsive">
<table id="dtHorizontalExample" class="table table-striped table-bordered table-sm" cellspacing="0"
  width="100%">
	<thead>
		<tr>
		    <th>Tahun Akademik</th>
			<!--<th>Kode</th>-->
			<!--<th>Kurikulum</th>-->
			<th>Matakuliah</th>
			<th>SKS</th>
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
		    <td><?= $field['keterangan'] ?></td>
			<!--<td><?= $field['kode_makul'] ?></td>-->
			<!--<td><?= $field['kode_kelompok'] ?></td>-->
			<td><?= $field['nama_makul'] ?></td>
			<td><?= $field['sks'] ?></td>
			<td><?= $field['nama_lengkap'] ?></td>
			<td><?= $field['accept']==1?'sudah disetujui':'belum disetujui'; ?></td>
			<td><?php
			$quququ = mysqli_query($koneksi,"Select accept from akademik_krs where nim='$nim' and konversi='$semester'");
			$rowe= mysqli_fetch_array($quququ);
			if ($rowe['accept']==0): ?>
			<div class="inline-block">
				    <button class="button mini-button dropdown-toggle">Aksi</button>
				    <ul class="split-content d-menu" data-role="dropdown">
		
					<li><a href="<?= $_url ?>krs/delete/<?= $_id ?>/<?= $field['krs_id'] ?>/<?= urlencode($field['nim']) ?>" class="place-right"><span class="mif-cross"> Hapus KRS </span></a></li>
					</ul>
			</div>
			<?php
			else:
			?>
			<p>Anda Sudah KRS</p>
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
	<tfoot><tr><td colspan='3' align='right'>Total SKS yang ditempuh</td><td><?php 
			echo $sks ?></td><td colspan=3></td></tr>


	</tfoot>

</table>
</div>
