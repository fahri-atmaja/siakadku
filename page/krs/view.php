<?php
$cek = mysqli_query($koneksi,"SELECT angkatan_id,id_sks,kpt,beasiswa,konsentrasi_id,semester FROM student_mahasiswa WHERE nim='$_username'");
$validasi = mysqli_fetch_array($cek);
if ($validasi['kpt']=='1'){
    echo "<script>window.alert('MAAF HALAMAN TIDAK BISA DIAKSSES')
		    window.location.href='{$_url}'</script>";
}
elseif ($validasi['beasiswa']=='1'){
    echo "<script>window.alert('MAAF HALAMAN TIDAK BISA DIAKSSES')
		    window.location.href='{$_url}'</script>";
}
elseif ($validasi['semester']>1 && $validasi['konsentrasi_id']==23 && $validasi['angkatan_id']<17 ){
echo "<script>window.alert('REDIRECT FAKULTAS PETERNAKAN KARENA FAKULTAS ANDA MENERAPKAN METODE KRS BERDASARKAN IPK')
		    window.location.href='{$_url}krs-peternakan/view/$_username'</script>";
}
elseif ($validasi['semester']>1 && $validasi['konsentrasi_id']==23 && $validasi['angkatan_id']>16 ){
echo "<script>window.alert('REDIRECT FAKULTAS PETERNAKAN KARENA FAKULTAS ANDA MENERAPKAN METODE KRS BERDASARKAN IPK')
		    window.location.href='{$_url}krs-peternakan-briva/view/$_username'</script>";
}
elseif($validasi['konsentrasi_id']==25){
    echo "<script>window.alert('REDIRECT FAKULTAS MAGISTER ILMU HUKUM');
		    window.location.href='{$_url}krs-magister/view/$_username'</script>";
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
$querya = mysqli_query($koneksi, "SELECT student_mahasiswa.*, akademik_kelas.nama_kelas, biaya_sks.id_sks,biaya_sks.jenis_sks, student_angkatan.keterangan, akademik_konsentrasi.nama_konsentrasi as nama_konsentrasi FROM student_mahasiswa 
	LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=student_mahasiswa.konsentrasi_id
	LEFT JOIN student_angkatan ON student_angkatan.angkatan_id=student_mahasiswa.angkatan_id
	LEFT JOIN akademik_kelas ON akademik_kelas.id_kelas=student_mahasiswa.id_kelas
	LEFT JOIN biaya_sks ON biaya_sks.id_sks=student_mahasiswa.id_sks
	WHERE student_mahasiswa.nim='{$_id}'");
$field = mysqli_fetch_array($querya);
$saatini = $field['semester'];
extract($field);
$loadtahun = mysqli_query($koneksi,"SELECT * FROM akademik_tahun_akademik WHERE status='y'");
$tahun = mysqli_fetch_array($loadtahun);
?>
<?php
	if ($id_sks=='2'){
		header("location:{$_url}krs-konversi/view/{$_username}");
	}
?>
<div class="grid">
<span style="color: blue">Anda terdaftar di kelas <?= $jenis_sks ?> <?= $nama_kelas ?></span><br>
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
$query13 = mysqli_query($koneksi,"SELECT accept FROM akademik_krs WHERE nim='$_username' AND konversi='$semester' group by nim");
$acc = mysqli_fetch_array($query13);
$sumsks = mysqli_fetch_array($loadkrs);
// $ququ= mysqli_query($koneksi,"select aktif_krs from student_mahasiswa where nim='$nim'");
// $row= mysqli_fetch_array($ququ);
// if ($row['aktif_krs']=="y"){
$loadmhs = mysqli_query($koneksi,"SELECT status_angsur,semester FROM student_mahasiswa WHERE nim='$_username'");
$kondisi= mysqli_fetch_array($loadmhs);
$loaduang=mysqli_query($koneksi,"SELECT jenis_bayar_id FROM keuangan_pembayaran_detail WHERE nim='$_username' AND jenis_bayar_id >= 34 AND jenis_bayar_id <= 40 ORDER BY jenis_bayar_id");
if (mysqli_num_rows($loaduang)){
while ($status= mysqli_fetch_array($loaduang)){
if ($status['jenis_bayar_id']=='34' and $kondisi['status_angsur']=='0' and $kondisi['semester']=='1' and $acc['accept']!='1'):
?>
<a href= "<?= $_url ?>krs/add-krs/<?= $_id ?>" class="button primary">Pilih Matakuliah</a>
<?php
elseif ($status['jenis_bayar_id']=='35' and $kondisi['status_angsur']=='0' and $kondisi['semester']=='2' and $acc['accept']!='1'):
?>
<a href= "<?= $_url ?>krs/add-krs/<?= $_id ?>" class="button primary">Pilih Matakuliah</a>
<?php
elseif ($status['jenis_bayar_id']=='36' and $kondisi['status_angsur']=='0' and $kondisi['semester']=='3' and $acc['accept']!='1'):
?>
<a href= "<?= $_url ?>krs/add-krs/<?= $_id ?>" class="button primary">Pilih Matakuliah</a>
<?php
elseif ($status['jenis_bayar_id']=='37' and $kondisi['status_angsur']=='0' and $kondisi['semester']=='4' and $acc['accept']!='1'):
?>
<a href= "<?= $_url ?>krs/add-krs/<?= $_id ?>" class="button primary">Pilih Matakuliah</a>
<?php
elseif ($status['jenis_bayar_id']=='38' and $kondisi['status_angsur']=='0' and $kondisi['semester']=='5' and $acc['accept']!='1'):
?>
<a href= "<?= $_url ?>krs/add-krs/<?= $_id ?>" class="button primary">Pilih Matakuliah</a>
<?php
elseif ($status['jenis_bayar_id']=='39' and $kondisi['status_angsur']=='0' and $kondisi['semester']=='6' and $acc['accept']!='1'):
?>
<a href= "<?= $_url ?>krs/add-krs/<?= $_id ?>" class="button primary">Pilih Matakuliah</a>
<?php
elseif ($status['jenis_bayar_id']=='40' and $kondisi['status_angsur']=='0' and $kondisi['semester']=='7' and $acc['accept']!='1'):
?>
<a href= "<?= $_url ?>krs/add-krs/<?= $_id ?>" class="button primary">Pilih Matakuliah</a>
<?php
elseif ($status['jenis_bayar_id']=='40' and $kondisi['status_angsur']=='0' and $kondisi['semester']=='8' and $acc['accept']!='1'):
?>
<a href= "<?= $_url ?>krs/add-krs/<?= $_id ?>" class="button primary">Pilih Matakuliah</a>
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
    $sql = "SELECT akademik_krs.*, akademik_tahun_akademik.keterangan, makul_matakuliah.kode_makul, makul_matakuliah.nama_makul, makul_matakuliah.sks, app_dosen.nama_lengkap,makul_kelompok.kode_kelompok FROM
        akademik_krs
        LEFT JOIN akademik_jadwal_kuliah ON akademik_jadwal_kuliah.jadwal_id=akademik_krs.jadwal_id
        LEFT JOIN makul_matakuliah ON makul_matakuliah.makul_id=akademik_jadwal_kuliah.makul_id
        LEFT JOIN app_dosen ON app_dosen.dosen_id=akademik_jadwal_kuliah.dosen_id
        LEFT JOIN akademik_tahun_akademik ON akademik_tahun_akademik.tahun_akademik_id=akademik_jadwal_kuliah.tahun_akademik_id
        LEFT JOIN makul_kelompok ON makul_kelompok.kelompok_id=makul_matakuliah.kelompok_id
        WHERE akademik_krs.nim='$nim' AND akademik_krs.konversi='$semester'";
	$query = mysqli_query($koneksi, $sql);
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
			<th>Kode</th>
			<th>Kurikulum</th>
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
			<td><?= $field['kode_makul'] ?></td>
			<td><?= $field['kode_kelompok'] ?></td>
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
    window.location.href='{$_url}krs/bayar/$_username'</script>";
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
		setTimeout(function(){ window.location.href='{$_url}krs/bayar'; }, 2000);
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

