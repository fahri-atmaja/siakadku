<?php
	if ($_access == 'mahasiswa' && $_id != $_username) {
		header("location:{$_url}krs/view/{$_username}");
	}
	
?>

<?php 
function hari_ini(){
	$hari = date ("D");
 
	switch($hari){
		case 'Sun':
			$hari_ini = "Minggu";
		break;
 
		case 'Mon':			
			$hari_ini = "Senin";
		break;
 
		case 'Tue':
			$hari_ini = "Selasa";
		break;
 
		case 'Wed':
			$hari_ini = "Rabu";
		break;
 
		case 'Thu':
			$hari_ini = "Kamis";
		break;
 
		case 'Fri':
			$hari_ini = "Jumat";
		break;
 
		case 'Sat':
			$hari_ini = "Sabtu";
		break;
		
		default:
			$hari_ini = "Tidak di ketahui";		
		break;
	}
 
	return "<b>" . $hari_ini . "</b>";
 
}
 
echo "Hari ini adalah " . hari_ini();
 
?>

<?php
			$tanggalskrg = date("d-m-y");
			$jamskrg = date('h:i');
$cekdosen = mysqli_query($koneksi,"SELECT * FROM app_dosen WHERE nidn='$_username'");
$vv = mysqli_fetch_array($cekdosen);
$dosen_id = $vv['dosen_id'];
$alert = mysqli_query($koneksi,"SELECT * FROM akademik_jadwal_kuliah WHERE dosen_id='$dosen_id' AND jadwal_id='$_id'");
if(mysqli_num_rows($alert) == 0){
    echo "<script>window.alert('Maaf bukan jadwal anda!')
    window.location='{$_url}presensi_mahasiswa'</script>";
}
		?>
<?php

$querya = mysqli_query($koneksi, 
			"select jk.*,ak.nama_konsentrasi,mm.nama_makul,ad.nama_lengkap,ah.hari_id,ah.hari,ar.ruangan_id,
			ar.nama_ruangan,ata.keterangan,ata.tahun_akademik_id
			FROM akademik_jadwal_kuliah as jk,app_hari as ah,akademik_konsentrasi as ak,makul_matakuliah as mm,app_dosen as ad,app_ruangan as ar,
			akademik_tahun_akademik as ata
			WHERE jk.konsentrasi_id=ak.konsentrasi_id and jk.hari_id=ah.hari_id
			and jk.makul_id=mm.makul_id and jk.dosen_id=ad.dosen_id and jk.ruangan_id=ar.ruangan_id and jk.tahun_akademik_id=ata.tahun_akademik_id  
			and jk.jadwal_id='$_id'");
$field = mysqli_fetch_array($querya);
extract($field);
?>
<h1>
<a href="<?= $_url ?><?= in_array($_access, array('admin','fakultas'))?'absen_dosen' : '' ?>" class="nav-button transform"><span></span></a>
Presensi Dosen Jadwal<br><?= $nama_makul ?>
</h1>
<?php 
	$hariskrg				= hari_ini(); 
	$meet = $field['pertemuan_mhs'] - $field['pertemuan'] + 1;
	$cekmhs1 = mysqli_query($koneksi,"SELECT * FROM mhs_absen WHERE jadwal_id='$id'");
	$fill = mysqli_fetch_array($cekmhs1);
	echo $fill['nim'];
    // if ($per['pertemuan'] != $meet){
    //     echo "<script>window.alert('MAAF PERTEMUAN $meet INVALID')
    // window.location.href='{$_url}'</script>";
    // }
	?>

<?php
	
if (isset($_POST['submit'])) {
	$tanggalabsen       	= $_POST['tanggalabsen'];
	$jamabsen				= $_POST['jamabsen'];
	$materi					= $_POST['materi'];
	$hariskrg				= hari_ini();
	$pertemuan = $meet;
	$harijadwal				= $_POST['hari'];
	$cekdulu = mysqli_num_rows(mysqli_query($koneksi,"SELECT * from dosen_absen where tanggalabsen ='$tanggalabsen' and jadwal_id='$_id'"));
	//$prosescek = mysqli_query($koneksi, $cekdulu);
	//if (mysqli_num_rows($prosescek)>0){
	//	echo "<script>window.alert('Anda Sudah Absen') window.location='{$_url}absen_dosen' </script>";
	
// 	$per = mysqli_fetch_array($cekmhs);
// 	$pertemuann= $per['pertemuan'];
// 	if ($cekdulu > 0){
// 		echo "<script>window.alert('MAAF HARI INI DOSEN SUDAH INPUT JURNAL')
//     window.location.href='{$_url}absen_dosen'</script>";
// 	}else{
    $sql = "UPDATE akademik_jadwal_kuliah SET pertemuan=pertemuan-1 WHERE jadwal_id='$_id'";
	$sql2= "INSERT into dosen_absen (absen_id,jadwal_id,pertemuan,tanggalabsen,jamabsen,materi) values ('','$_id','$pertemuan','$tanggalabsen','$jamabsen','$materi')";
	$queque = mysqli_query($koneksi, $sql);
 	$queque2 = mysqli_query($koneksi, $sql2);
	if ($queque) {
		echo "<script>$.Notify({
		    caption: 'Success',
		    content: 'Data Jadwal Berhasil Diubah',
    		type: 'success'
		});
		setTimeout(function(){ window.location.href='{$_url}presensi_mahasiswa'; }, 2000);
		</script>";
	} else {
		echo "<script>$.Notify({
		    caption: 'Failed',
		    content: 'Data Jadwal Gagal Diubah',
		    type: 'alert'
		});</script>";
	}
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
// }
?>

<b>Pertemuan ke - <?php echo $meet; ?> </b>
<p style="color : blue">Pastikan presensi mahasiswa <b> pertemuan ke <?php echo $meet ?> </b> sudah diinput sebelum mengisi jurnal dosen!!<br>
klik <a href="<?= $_url ?>presensi_mahasiswa">disini</a> </p>

<form Method="POST">
		<input type="hidden" name="jadwal_id" id="jadwal_id" value="<?= $field['jadwal_id'] ?>" readonly>
	
	<table class="table striped hovered border bordered">
		<tr>
	<td>
		<div class="form-group">
		<div class="cell">
		<label>Jadwal Hari</label>
		<input type="text" name="hari" id="hari" value="<?= $field['hari'] ?>" readonly>
		</div>
</td>
<td>
		<div class="form-group">
		<div class="cell">
		<label>Mata Kuliah</label>
		<input type="text" name="nama_makul" id="nama_makul" value="<?= $field['nama_makul'] ?>" readonly>
		</div>
</td><td>
		<div class="cell">
		<label>Semester</label>
		<input type="text" name="semester" id="semester" value="<?= $field['semester'] ?>" readonly>
		</div>
</td><td>
		<div class="cell">
		<label>Konsentrasi</label>
		<input type="hidden" name="konsentrasi_id" id="konsentrasi_id" value="<?= $field['konsentrasi_id'] ?>">
		<input type="text" name="nama_konsentrasi" id="nama_konsentrasi" value="<?= $field['nama_konsentrasi'] ?>" readonly>
		</div>
		</div>
</td>
		</tr>
		<tr>
		<td>
		<div class="cell">
		<label>Dosen Pengampu</label>
				<input type="text" name="dosen_id" value="<?= $field['nama_lengkap'] ?>" readonly> 
		</div>
		</td>
			<input type="hidden" name="jamabsen" id="jamabsen" value="<?php echo $jamskrg ?>" readonly>
		
		<input type="hidden" name="tanggalabsen" id="tanggalabsen" value="<?php echo $tanggalskrg ?>">
		
		
	</table>
		<label>Materi yang disampaikan </label>
		<!--<input type="text-area" name="materi" id="materi" value="" required>-->
		<textarea name="materi" id="materi" cols="40" rows="5" required></textarea>
		<?php if ($cek == "0"): ?>
		<p>Absen sudah selesai</p>
		<?php else: ?>
		<button type="submit" name="submit" class="button primary">SUBMIT</button>
		<?php endif; ?>
</form>
<?php
	$sql3	= "SELECT * FROM dosen_absen WHERE jadwal_id = '$_id'";
	$query3 = mysqli_query($koneksi, $sql3);
?>
<table class="table striped hovered border bordered">
	<thead>
		<tr>
			<th width="10%">Pertemuan</th>
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
			<td><?= $field3['materi'] ?></td>
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