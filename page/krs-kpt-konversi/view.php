<?php
	if ($_access == 'mahasiswa' && $_id != $_username) {
		header("location:{$_url}krs/view/{$_username}");
	}
	$cek = mysqli_query($koneksi,"SELECT id_sks,kpt FROM student_mahasiswa WHERE nim='$_username'");
$validasi = mysqli_fetch_array($cek);
if ($validasi['id_sks']!='2'){
    echo "<script>window.alert('MAAF HALAMAN TIDAK BISA DIAKSSES')
		    window.location.href='{$_url}'</script>";
}elseif ($validasi['kpt']!='1'){
    echo "<script>window.alert('ANDA TERDAFTAR DIKELAS KONVERSI UNIVERSITAS.')
		    window.location.href='{$_url}krs-kpt-konversi/view/$username'</script>";
}
?>
<style type="text/css">
	.input-control {
		border: 1px solid #d9d9d9;
		padding: 10px;
	}
</style>

<h1>
<a href="<?= $_url ?><?= in_array($_access, array('admin','dosen')) ? '' : '' ?>" class="nav-button transform"><span></span></a>
KRS Mahasiswa
</h1>

<?php
$querya = mysqli_query($koneksi, "SELECT student_mahasiswa.*, akademik_kelas.nama_kelas, student_angkatan.keterangan,biaya_sks.id_sks,biaya_sks.jenis_sks, akademik_konsentrasi.nama_konsentrasi as nama_konsentrasi FROM student_mahasiswa 
	LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=student_mahasiswa.konsentrasi_id
	LEFT JOIN student_angkatan ON student_angkatan.angkatan_id=student_mahasiswa.angkatan_id
	LEFT JOIN akademik_kelas ON akademik_kelas.id_kelas=student_mahasiswa.id_kelas
	LEFT JOIN biaya_sks ON biaya_sks.id_sks=student_mahasiswa.id_sks
	WHERE nim='{$_username}'");
$field = mysqli_fetch_array($querya);
// $saatini = $field['semester'];
extract($field);
?>

<div class="grid">
<span style="color: blue">Anda terdaftar di kelas <?= $jenis_sks ?> <?= $nama_kelas ?></span>
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
			WHERE mm.makul_id=jk.makul_id AND jk.jadwal_id=ak.jadwal_id AND ak.nim='$_username' AND semester='$semester' AND ak.konversi='$semester'");
$sumsks = mysqli_fetch_array($loadkrs);
// $ququ= mysqli_query($koneksi,"select aktif_krs from student_mahasiswa where nim='$nim'");
// $row= mysqli_fetch_array($ququ);
// if ($row['aktif_krs']=="y"){
?>
<?php

?>


<!-- <a href= "<?= $_url ?>krs-kpt-konversi/add-krs/<?= $_id ?>" class="button primary">Pilih Matakuliah</a> -->
<?php 
$accept = mysqli_query($koneksi,"select ak.*,mm.semester,mm.kode_makul,mm.nama_makul,mm.sks,ad.nama_lengkap
            FROM makul_matakuliah as mm,akademik_jadwal_kuliah as jk,akademik_krs as ak,app_dosen as ad
            WHERE mm.makul_id=jk.makul_id and ad.dosen_id=jk.dosen_id and jk.jadwal_id=ak.jadwal_id and ak.nim='$nim' and ak.konversi='$semester'");
$loadmhs = mysqli_query($koneksi,"SELECT status FROM bayar_sks WHERE nim='$_username' and semester='$semester'");
$loadkpt = mysqli_query($koneksi,"SELECT kpt FROM student_mahasiswa WHERE nim='$_username'");
$kondisi= mysqli_fetch_array($loadmhs);
$acc = mysqli_fetch_array($accept);
$kpt = mysqli_fetch_array($loadkpt);

if ($kpt['kpt']=='0' and $kondisi['status']=='1'):
	?>	
	<!--<a href= "<?= $_url ?>krs-konversi/add-krs/<?= $_id ?>" class="button primary">Pilih Matakuliah</a>-->

	<a href= "<?= $_url ?>krs-kpt-konversi/add-krs/<?= $_id ?>" class="button primary">Pilih Matakuliah</a>
		<a target="_BLANK" href="<?= $_url ?>krs-kpt-konversi/cetak/<?= $_id ?>/<?= urlencode($semester) ?>" class="button success">Cetak</a>
		<?php
		elseif ($kpt['kpt']=='1' and $acc['accept']=='1'):
		?>
		<a target="_BLANK" href="<?= $_url ?>krs-kpt-konversi/cetak/<?= $_id ?>/<?= urlencode($semester) ?>" class="button success">Cetak</a>
		
<?php
elseif ($kpt['kpt']=='0' and $acc['accept']=='1'):
?>
<a href= "<?= $_url ?>krs-kpt-konversi/bayar/<?= $_id ?>/<?= urlencode($semester) ?>"><button type="submit" name=submit>Bayar SKS</button></a>
<?php
else:
	?>
	<a href= "<?= $_url ?>krs-kpt-konversi/add-krs/<?= $_id ?>" class="button primary">Pilih Matakuliah</a>
	<br>
<span style="color: red">Konsultasikan kepada dosen wali.<br>
Jika KRS sudah selesai dipilih,<br>Silahkan meminta persetujuan KRS lalu melakukan pembayaran.
catatan untuk kelas KPT langsung dpt mencetak KRS setelah disetujui dosen wali. </span>
<br>
	
<?php
endif;
?>
		<?php
	$sql    = "SELECT akademik_krs.*, akademik_kelas.nama_kelas, makul_matakuliah.kode_makul, 
    	    makul_matakuliah.nama_makul, makul_matakuliah.sks, app_dosen.nama_lengkap FROM
            akademik_krs
            INNER JOIN akademik_jadwal_kuliah ON akademik_jadwal_kuliah.jadwal_id=akademik_krs.jadwal_id
            LEFT JOIN makul_matakuliah ON makul_matakuliah.makul_id=akademik_jadwal_kuliah.makul_id
            LEFT JOIN app_dosen ON app_dosen.dosen_id=akademik_jadwal_kuliah.dosen_id
            LEFT JOIN akademik_kelas ON akademik_kelas.id_kelas=akademik_jadwal_kuliah.id_kelas
            LEFT JOIN student_mahasiswa ON student_mahasiswa.nim=akademik_krs.nim
            WHERE student_mahasiswa.nim='$_username' and akademik_krs.konversi='$semester'";
	$query = mysqli_query($koneksi, $sql);
?>
<div class="table-responsive">
<table id="dtHorizontalExample" class="table table-striped table-bordered table-sm" cellspacing="0"
  width="100%">
	<thead>
		<tr>
			<th>Kode</th>
			<th>Matakuliah</th>
			<th>Semester</th>
			<th>Kelas</th>
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
			<td><?= $field['kode_makul'] ?></td>
			<td><?= $field['nama_makul'] ?></td>
			<td><?= $field['semester'] ?></td>
			<td><?= $field['nama_kelas'] ?></td>
			<td><?= $field['sks'] ?></td>
			<td><?= $field['nama_lengkap'] ?></td>
			<td><?= $field['accept']==1?'sudah disetujui':'belum disetujui'; ?></td>
			<td><?php
// 			$quququ = mysqli_query($koneksi,"Select accept from akademik_krs where nim='$nim'");
// 			$rowe= mysqli_fetch_array($quququ);
			if ($field['accept']==0): ?>
			<div class="inline-block">
				    <a href="<?= $_url ?>krs-kpt-konversi/delete/<?= $_id ?>/<?= $field['krs_id'] ?>/<?= urlencode($field['nim']) ?>" class="place-right"><span class="mif-cross"> Hapus KRS </span></a>
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
	<tfoot><tr><td colspan='4' align='right'>Total SKS yang ditempuh</td><td><?php 
			echo $sks ?></td><td colspan=3></td></tr>


	</tfoot>

</table>
</div>



			<?php 
$loadsks=mysqli_query($koneksi,"SELECT bs.* FROM biaya_sks as bs, student_mahasiswa as sm
						WHERE sm.id_sks=bs.id_sks and nim='$_username'");
$query_sks  = mysqli_fetch_array($loadsks);
$jenis_sks  = $query_sks['id_sks'];
$biaya 		= $query_sks['biaya'];
$bayar  	= $biaya*$sks;

?>

<input type="hidden" name="nim" value="<?php echo $_username?>">
<input type="hidden" name="semester" value="<?php echo $semester?>">
<input type="hidden" name="jenis_sks" value="<?php echo $jenis_sks?>">
<input type="hidden" name="jumlah_sks" value="<?php echo $sks?>">
<input type="hidden" name="biaya" value="<?php echo $bayar?>">

<?php
if (isset($_POST['submit'])) {
	$cekdulu = mysqli_num_rows(mysqli_query($koneksi,"SELECT * from bayar_sks where nim = '$nim' and semester ='$semester'"));
	if ($cekdulu > 0){
		echo "<script>window.alert('ANDA SUDAH KRS, SILAHKAN MELAKUKAN PEMBAYARAN')
    window.location.href='{$_url}krs-kpt-konversi/bayar/$_username'</script>";
	}else{

	$postnim	 = $_POST['nim'];
	$postsemester= $_POST['semester'];
	$jenis   	 = $_POST['jenis_sks'];
	$jmlsks   	 = $_POST['jumlah_sks'];
	$bayar_sks	 = $_POST['biaya'];
	$sqlsks 		 = "INSERT INTO bayar_sks SET nim='$postnim', semester='$postsemester', id_sks='$jenis', jumlah_sks='$jmlsks', jumlah_bayar='$bayar_sks'";
	$queque 	 = mysqli_query($koneksi, $sqlsks);
	if ($queque) {
		echo "<script>$.Notify({
		    caption: 'Success',
		    content: 'Data Bayar SKS Berhasil Ditambah',
    		type: 'success'
		});
		setTimeout(function(){ window.location.href='{$_url}krs-kpt-konversi/bayar'; }, 2000);
		</script>";
	} else {
		echo "<script>$.Notify({
		    caption: 'Failed',
		    content: 'Data Bayar SKS Gagal Ditambah',
		    type: 'alert'
		});</script>";
	}
}
}
?>
</form>

