    <?php
	if ($_access == 'mahasiswa' && $_id != $_username) {
		header("location:{$_url}");
	}
	function hari_angka(){
	$hari = date ("D");
 
	switch($hari){
		case 'Sun':
			$hari_angka = "7";
		break;
 
		case 'Mon':			
			$hari_angka = "1";
		break;
 
		case 'Tue':
			$hari_angka = "2";
		break;
 
		case 'Wed':
			$hari_angka = "3";
		break;
 
		case 'Thu':
			$hari_angka = "4";
		break;
 
		case 'Fri':
			$hari_angka = "5";
		break;
 
		case 'Sat':
			$hari_angka = "6";
		break;
		
		default:
			$hari_angka = "Tidak di ketahui";		
		break;
	}
 
	return $hari_angka;
 
}
 
    ?>
<h1>
<?php 
$loadmakul = mysqli_query($koneksi,"SELECT mm.nama_makul FROM akademik_jadwal_kuliah as jk, makul_matakuliah as mm WHERE mm.makul_id=jk.makul_id AND jk.jadwal_id='$_id'");
$makul = mysqli_fetch_array($loadmakul);
?>
<a href="<?= $_url ?>presensi_mahasiswa" class="nav-button transform"><span></span></a>
REALTIME ABSENSI <?php echo $makul['nama_makul'] ?>
</h1>
<?php
$nimshow = $_params[1];
$querya = mysqli_query($koneksi,"select jk.*, akrs.jadwal_id, sm.nama, mm.nama_makul,ah.hari FROM
			akademik_krs as akrs, student_mahasiswa as sm, makul_matakuliah as mm, akademik_jadwal_kuliah as jk,app_hari as ah WHERE
			jk.hari_id=ah.hari_id and sm.nim=akrs.nim and jk.makul_id=mm.makul_id and jk.jadwal_id=akrs.jadwal_id and akrs.jadwal_id='$_id' and akrs.accept=1");
$fieldd = mysqli_fetch_array($querya);
extract($field);
?>
<?php
$hari_jadwal = $fieldd['hari_id'];
$hari_angka = hari_angka();
$jam_mulai = $fieldd['jam_mulai'];
$jam_selesai = $fieldd['jam_selesai'];
$pertemuan = $fieldd['pertemuan_mhs'];
$perjalan = $fieldd['pertemuan'];
echo "Jadwal hari "; echo "<b>" . $fieldd['hari'] . "</b>";
$hitung = $pertemuan - $perjalan + 1 ;
?>

<form method="post">
<p><h1>Pertemuan Ke <?php echo $hitung ?></h1></p>
<?php
	$sql = "select akrs.*, sm.nama FROM
			akademik_krs as akrs, student_mahasiswa as sm WHERE
			sm.nim=akrs.nim and akrs.jadwal_id='$_id' ORDER BY akrs.nim ASC";
	$query = mysqli_query($koneksi, $sql);
	
	
?>
<div>
    <label><?= tgl_indo(date('Y-m-d')); ?></label>
    <input type="hidden" name="tanggalabsen" id="tanggalabsen" value="<?= date('d/m/Y'); ?>" readonly>
</div>
<table class="table striped hovered border bordered">
	<thead>
		<tr>
			<th>NIM</th>
			<th>NAMA MAHASISWA</th>
			<th>STATUS DOSEN WALI</th>
			<th>JAM ABSEN</th>
			<th>KEHADIRAN</th>
		</tr>
	</thead>
	<tbody>

 	<?php
	$no=1;
		if (mysqli_num_rows($query) > 0):
			while($field = mysqli_fetch_array($query)):
 	?>
	
		<tr>
			<td><input type="text" name="nim[]" value="<?= $field['nim'] ?>" readonly></td>
			<td><?= $field['nama'] ?></td>
			<td><?= $field['accept']==1?'Sudah disetujui':'<b>Belum disetujui</b>'; ?></td>
			<td>
        		<?php
        			$tanggalskrg = date("d-m-Y");
        			$jamskrg = date('h:i')
        		?>
    			<input type="text" name="jamabsen" id="jamabsen" value="<?php echo $jamskrg ?>" readonly>
        		</td>
			<td>
		<select name="kehadiran" id="kehadiran[]" value="" required>
			<!--<option value="">--Kehadiran--</option>-->
			<option value="hadir">Hadir</option>
			<option value="hadir">Ijin</option>
			<option value="hadir">Sakit</option>
			<option value="mangkir">Mangkir</option>
		</select>
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
</table>
<p>*Note : Jika status krs mahasiswa belum disetujui dosen wali maka absensi mahasiswa tsb tidak muncul direkap absen</p>
<button type="submit" name="submit" class="button primary">SUBMIT</button>
</form>
<?php
if (isset($_POST['submit'])) {
    $cek = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM mhs_absen WHERE jadwal_id='$_id' and pertemuan='$hitung'"));
    if ($cek > 0){
    echo "<script>window.alert('Pertemuan $hitung sudah diinput silahkan isi jurnal dosen')
    window.location='../../../absen_dosen/absen/$_id'</script>";
    }  elseif ($hari_jadwal===$hari_angka) {
    $nim					= $_POST['nim'];
	$tanggalabsen       	= $_POST['tanggalabsen'];
	$jamabsen				= $_POST['jamabsen'];
	$kehadiran				= $_POST['kehadiran'];
    $count                  = count($nim);
    for($i=0;$i<$count;$i++){

	$sql2= "INSERT into mhs_absen (absen_id,jadwal_id,nim,pertemuan,tanggalabsen,jamabsen,kehadiran) values('','$_id','$nim[$i]','$hitung','$tanggalabsen','$jamabsen','$kehadiran')";
	
 	$queque2 = mysqli_query($koneksi, $sql2);
	if ($queque2) {
		echo "<script>$.Notify({
		    caption: 'Success',
		    content: 'Data Absen Berhasil Ditambah, Silahkan mengisi jurnal dosen.',
    		type: 'success'
		});
		setTimeout(function(){ window.location.href='{$_url}absen_dosen/absen/$_id'; }, 2000);
		</script>";
	} else {
		echo "<script>$.Notify({
		    caption: 'Failed',
		    content: 'Data Absen Gagal Ditambah',
		    type: 'alert'
		});</script>";
	}
}
} else {
    echo "<script>window.alert('Jadwal hari ini invalid!! Mohon diisi saat sesuai jadwal')
    window.location='presensi_mahasiswa'</script>";
}
}
?>





