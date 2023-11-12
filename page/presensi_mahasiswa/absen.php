<?php
	if ($_access == 'mahasiswa' && $_id != $_username) {
		header("location:{$_url}krs/view/{$_username}");
	}
?>
<?php
$nimshow = $_params[1];
$querya = mysqli_query($koneksi,"select jk.*, akrs.jadwal_id, sm.nama, mm.nama_makul FROM
			akademik_krs as akrs, student_mahasiswa as sm, makul_matakuliah as mm, akademik_jadwal_kuliah as jk WHERE
			sm.nim=akrs.nim and jk.makul_id=mm.makul_id and jk.jadwal_id=akrs.jadwal_id and akrs.jadwal_id='$_id' and sm.nim='$_params[1]'");
$field = mysqli_fetch_array($querya);
extract($field);
?>
<?php
$pertemuan = $field['pertemuan_mhs'];
$perjalan = $field['pertemuan'];
$hitung = $pertemuan - $perjalan ;
?>
<h1>
<a href="<?= $_url ?>presensi_mahasiswa/<?= in_array($_access, array('admin','fakultas'))?'presensi_mahasiswa' : '' ?>" class="nav-button transform"><span></span></a>
Absen Jadwal <?= $field['nama_makul'] ?><br>
</h1>

<p>Pertemuan Ke <?php echo $hitung ?></p>
<?php
	
if (isset($_POST['submit'])) {
	$nim					= $_POST['nim'];
	$tanggalabsen       	= $_POST['tanggalabsen'];
	$jamabsen				= $_POST['jamabsen'];
	$kehadiran				= $_POST['kehadiran'];

	$cekdulu = mysqli_num_rows(mysqli_query($koneksi,"SELECT * from mhs_absen where nim = '$nim' and tanggalabsen ='$tanggalabsen' and jadwal_id='$_id'"));
	$cekacc = mysqli_fetch_array(mysqli_query($koneksi,"select akrs.accept FROM
			akademik_krs as akrs, student_mahasiswa as sm WHERE
			sm.nim=akrs.nim and akrs.jadwal_id='$_id' and sm.nim='$_params[1]'"));
	//$prosescek = mysqli_query($koneksi, $cekdulu);
	//if (mysqli_num_rows($prosescek)>0){
	//	echo "<script>window.alert('Anda Sudah Absen') window.location='{$_url}absen_dosen' </script>";
	if ($cekdulu > 0){
		echo "<script>window.alert('MAAF HARI INI MAHASISWA SUDAH ABSEN')
    window.location.href='{$_url}presensi_mahasiswa'</script>";
	}
	if ($cekacc['accept'] == 0){
		echo "<script>window.alert('MAAF MAHASISWA BELUM TERDAFTAR')
    window.location.href='{$_url}presensi_mahasiswa'</script>";
	}
	
	else {

	//$sql = "UPDATE akademik_jadwal_kuliah SET pertemuan_mhs=pertemuan_mhs-1 WHERE jadwal_id='$_id'";
	$sql2= "INSERT into mhs_absen (absen_id,jadwal_id,nim,tanggalabsen,jamabsen,kehadiran) values ('','$_id','$nim','$tanggalabsen','$jamabsen','$kehadiran')";
	//$queque = mysqli_query($koneksi, $sql);
 	$queque2 = mysqli_query($koneksi, $sql2);
	//if ($queque) {
	//	echo "<script>$.Notify({
	//	    caption: 'Success',
	//	    content: 'Data Jadwal Berhasil Diubah',
    //		type: 'success'
	//	});
	//	setTimeout(function(){ window.location.href='{$_url}dosen/list'; }, 2000);
	//	</script>";
	//} else {
	//	echo "<script>$.Notify({
	//	    caption: 'Failed',
	//	    content: 'Data Jadwal Gagal Diubah',
	//	    type: 'alert'
	//	});</script>";
	//}
	if ($queque2) {
		echo "<script>$.Notify({
		    caption: 'Success',
		    content: 'Data Absen Berhasil Ditambah',
    		type: 'success'
		});
		setTimeout(function(){ window.location.href='{$_url}presensi_mahasiswa'; }, 2000);
		</script>";
	} else {
		echo "<script>$.Notify({
		    caption: 'Failed',
		    content: 'Data Absen Gagal Ditambah',
		    type: 'alert'
		});</script>";
	}
}
}
?>
<form Method="POST">
	<div class="form-group">
	<div class="cell">
		<input type="hidden" name="jadwal_id" id="jadwal_id" value="<?= $_id ?>" readonly>
	</div>
	</div>
	<table class="table striped hovered border bordered">
		<tr>
<td>
		<div class="form-group">
		<div class="cell">
		<label>NIM</label>
		<input type="text" name="nim" id="nim" value="<?= $_params[1] ?>" readonly>
		</div>
</td>
<td>
		<div class="form-group">
		<div class="cell">
		<label>Nama</label>
		<input type="text" name="nama" id="nama" value="<?= $field['nama'] ?>" readonly>
		</div>
</td>
		<td>
		<div class="cell">
		<?php
			$tanggalskrg = date("d-m-y");
			$jamskrg = date('h:i')

		?>
		<label>Jam Absen</label>
			<input type="text" name="jamabsen" id="jamabsen" value="<?php echo $jamskrg ?>" readonly>
		</div>
		</td>
		</tr>
		
		<td>
		<div class="cell">
		<label>Tanggal Absen</label>
		<input type="text" name="tanggalabsen" id="tanggalabsen" value="<?php echo $tanggalskrg ?>" readonly>
		</div>
		</td>

		<td>
		<div class="cell">
		<label>Kehadiran </label>
		<select name="kehadiran" id="kehadiran" value="" required>
			<option value="">--Kehadiran--</option>
			<option value="hadir">Hadir</option>
			<option value="hadir">Ijin</option>
			<option value="hadir">Sakit</option>
			<option value="mangkir">Mangkir</option>
		</select>
		<!-- <input type="text" name="kehadiran" id="kehadiran" value="" required> -->
		</div>
		</td>
			
		</tr>
	<td>
	
		<button type="submit" name="submit" class="button primary">SUBMIT</button>
	
	</td>
	</table>
</form>
<?php
	$sql3	= "SELECT * FROM mhs_absen WHERE jadwal_id = '$_id' and nim = '$_params[1]'";
	$query3 = mysqli_query($koneksi, $sql3);
?>
<a href="<?= $_url ?>dosen/cetak-absen/<?= $_id ?>/<?= urlencode($_params[1]) ?>"" class="button success">Cetak</a>
<table class="table striped hovered border bordered">
	<thead>
		<tr>
			<th>No</th>
			<th>Tanggal Absen</th>
			<th>Jam Absen</th>
			<th>Materi</th>
		</tr>
	</thead>
	<tbody>

	<?php
		$noo=1;
		if (mysqli_num_rows($query3) > 0):
			while($field3 = mysqli_fetch_array($query3)):
	?>

		<tr>
			<td><?= $noo++ ?></td>
			<td><?= $field3['tanggalabsen'] ?></td>
			<td><?= $field3['jamabsen'] ?></td>
			<td><?= $field3['kehadiran'] ?></td>
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