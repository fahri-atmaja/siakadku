<style type="text/css">
	.input-control {
		border: 1px solid #d9d9d9;
		padding: 10px;
	}
</style>
<?php
$cek = mysqli_query($koneksi,"SELECT angkatan_id, status_angsur, konsentrasi_id, semester FROM student_mahasiswa WHERE nim='$_username'");
$validasi = mysqli_fetch_array($cek);
if ($validasi['status_angsur']!='1'){
    echo "<script>window.alert('MAAF HALAMAN TIDAK BISA DIAKSSES')
		    window.location.href='{$_url}'</script>";
}
elseif ($validasi['semester']>1 && $validasi['konsentrasi_id']==23){
echo "<script>window.alert('REDIRECT FAKULTAS PETERNAKAN KARENA FAKULTAS ANDA MENERAPKAN METODE KRS BERDASARKAN IPK')
		    window.location.href='{$_url}krs-peternakan/view/$_username'</script>";
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
	WHERE nim='{$_username}'");
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
    <!--<a href= "<?= $_url ?>krs-cicilan/add-krs/<?= $_id ?>" class="button primary">Pilih Matakuliah</a>-->
<?php
 $sks=0;
 $loadkrs = mysqli_query($koneksi,"SELECT sum(mm.sks) as value_sks FROM makul_matakuliah as mm, akademik_krs as ak, akademik_jadwal_kuliah as jk 
			WHERE mm.makul_id=jk.makul_id AND jk.jadwal_id=ak.jadwal_id AND ak.nim='$_username' AND ak.konversi='$semester' ");
$sumsks = mysqli_fetch_array($loadkrs);
$query13 = mysqli_query($koneksi,"SELECT accept FROM akademik_krs WHERE nim='$_username' AND konversi='$semester' group by nim");
$acc = mysqli_fetch_array($query13);
?>
<?php
if ($id_sks=='1'){
$loadangsur=mysqli_query($koneksi,"SELECT angsuran FROM bayar_angsuran WHERE nim='$_username' order by angsuran ASC");
$mhsangsur= mysqli_num_rows($loadangsur);

if ($mhsangsur > 0 AND $acc['accept']==0):
?>
<a href= "<?= $_url ?>krs-cicilan/add-krs/<?= $_id ?>" class="button primary">Pilih Matakuliah</a>
<?php
elseif($mhsangsur > 0 AND $acc['accept']==1):
?>
<a target="_BLANK" href="<?= $_url ?>krs-cicilan/cetak/<?= $_id ?>/<?= urlencode($semester) ?>" class="button success">Cetak</a>
<?php
endif;
?>
<?php
}
?>
<?php
if ($id_sks=='2'){
    $loadangsur1=mysqli_query($koneksi,"SELECT angsuran FROM angsuran_konversi_bayar WHERE nim='$_username'");
$mhsangsur1= mysqli_num_rows($loadangsur1);
if ($mhsangsur1 > 0 AND $acc['accept']==0):
    ?>
    <a href= "<?= $_url ?>krs-cicilan/add-krs/<?= $_id ?>" class="button primary">Pilih Matakuliah</a>
    <?php
elseif($mhsangsur > 0 AND $acc['accept']==1):
?>
<a target="_BLANK" href="<?= $_url ?>krs-cicilan/cetak/<?= $_id ?>/<?= urlencode($semester) ?>" class="button success">Cetak</a>
<?php
endif;
}
?>
<?php
	if ($id_sks=='1'){
	$sql = "SELECT akademik_krs.*, makul_matakuliah.kode_makul,akademik_tahun_akademik.keterangan, makul_matakuliah.nama_makul, makul_kelompok.kode_kelompok, makul_matakuliah.sks, app_dosen.nama_lengkap FROM
        akademik_krs
        LEFT JOIN akademik_jadwal_kuliah ON akademik_jadwal_kuliah.jadwal_id=akademik_krs.jadwal_id
        LEFT JOIN makul_matakuliah ON makul_matakuliah.makul_id=akademik_jadwal_kuliah.makul_id
        LEFT JOIN app_dosen ON app_dosen.dosen_id=akademik_jadwal_kuliah.dosen_id
        LEFT JOIN akademik_tahun_akademik ON akademik_tahun_akademik.tahun_akademik_id=akademik_jadwal_kuliah.tahun_akademik_id
        LEFT JOIN makul_kelompok ON makul_kelompok.kelompok_id=makul_matakuliah.kelompok_id
        WHERE akademik_krs.nim='$nim' AND akademik_krs.konversi='$semester'";

	$query = mysqli_query($koneksi, $sql);
	} else {
	    $sql = "SELECT akademik_krs.*, makul_matakuliah.kode_makul, akademik_tahun_akademik.keterangan, makul_matakuliah.nama_makul, makul_kelompok.kode_kelompok, makul_matakuliah.sks, app_dosen.nama_lengkap, makul_kelompok.kode_kelompok FROM
        akademik_krs
        LEFT JOIN akademik_jadwal_kuliah ON akademik_jadwal_kuliah.jadwal_id=akademik_krs.jadwal_id
        LEFT JOIN makul_matakuliah ON makul_matakuliah.makul_id=akademik_jadwal_kuliah.makul_id
        LEFT JOIN app_dosen ON app_dosen.dosen_id=akademik_jadwal_kuliah.dosen_id
        LEFT JOIN akademik_tahun_akademik ON akademik_tahun_akademik.tahun_akademik_id=akademik_jadwal_kuliah.tahun_akademik_id
        LEFT JOIN makul_kelompok ON makul_kelompok.kelompok_id=makul_matakuliah.kelompok_id
        WHERE akademik_krs.nim='$nim' AND akademik_krs.konversi='$semester'";

	$query = mysqli_query($koneksi, $sql);
	}
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
			<th>Semester</th>
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
			<td><?= $field['semester'] ?></td>
			<td><?= $field['sks'] ?></td>
			<td><?= $field['nama_lengkap'] ?></td>
			<td><?= $field['accept']==1?'sudah disetujui':'belum disetujui'; ?></td>
			<td><?php
			$quququ = mysqli_query($koneksi,"Select accept from akademik_krs where nim='$nim' and konversi='$semester'");
			$rowe= mysqli_fetch_array($quququ);
			if ($rowe['accept']==0): ?>
					<a href="<?= $_url ?>krs-cicilan/delete/<?= $_id ?>/<?= $field['krs_id'] ?>/<?= urlencode($field['nim']) ?>" class="place-right"><span class="mif-cross"> Hapus KRS </span></a>
					
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
    window.location.href='{$_url}krs-cicilan/bayar/$_username'</script>";
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
		setTimeout(function(){ window.location.href='{$_url}krs-cicilan/bayar'; }, 2000);
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

