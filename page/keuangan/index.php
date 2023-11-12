<?php
	if ($_access == 'mahasiswa' && $_id != $_username) {
		header("location:{$_url}krs/view/{$_username}");
	}
	if (empty($_access)) {
		header("location:{$_url}");
	}
?>
<h1>
<a href="<?= $_url ?>" class="nav-button transform"><span></span></a>
Keuangan
</h1>
<form action="#" method="GET">
<div class="panel" data-role="panel">
    <div class="heading">
        <span class="title">Masukan NIM</span>
    </div>
    <div class="grid">
    	<input type="text" name="cari" value="">
    	<input type="submit" value="Cari NIM">
    </div>
  </div>
</form>
  <?php
if(isset($_GET['cari'])){
	$cari = $_GET['cari'];
	echo "<b>Hasil pencarian : ".$cari."</b>";
}
?>
<?php
if(isset($_GET['cari'])){
		$cari = $_GET['cari'];
	$sql = "SELECT student_mahasiswa.*, akademik_kelas.nama_kelas,student_angkatan.keterangan, akademik_konsentrasi.nama_konsentrasi, biaya_sks.jenis_sks FROM student_mahasiswa 
			LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=student_mahasiswa.konsentrasi_id
			LEFT JOIN student_angkatan ON student_angkatan.angkatan_id=student_mahasiswa.angkatan_id
			LEFT JOIN akademik_kelas ON akademik_kelas.id_kelas=student_mahasiswa.id_kelas
			LEFT JOIN biaya_sks ON biaya_sks.id_sks
			    =student_mahasiswa.id_sks
			WHERE student_mahasiswa.nim like '%".$cari."%'";
	$query = mysqli_query($koneksi, $sql);
	$field = mysqli_fetch_array($query);
	extract($field);
	if ($status_angsur==1){
	    $angsur="Bulanan";
	}else{
	    $angsur="Semesteran";
	}
	echo "<center>
<table style='width: 600px;'>
<tr><td>NIM</td><td>:</td><td>".$nim."</td><td></td><td>Semester</td><td>:</td><td>".$semester."</td></tr>
<tr><td>Nama</td><td>:</td><td>".$nama."</td><td></td><td>Tahun Akademik</td><td>:</td><td>".$keterangan."</td></tr>
<tr><td>Progdi</td><td>:</td><td>".$nama_konsentrasi."</td><td></td><td>Kelas</td><td>:</td><td>".$nama_kelas."</td></tr>
<tr><td>Metode SKS</td><td>:</td><td>".$jenis_sks."</td><td></td><td>Metode Bayar</td><td>:</td><td>".$angsur."</td></tr>
</table>
</center>";
 $sqll = "SELECT keuangan_jenis_bayar.keterangan,keuangan_pembayaran_detail.jumlah,keuangan_pembayaran_detail.pembayara_detail_id,keuangan_pembayaran_detail.semester FROM keuangan_pembayaran_detail
        LEFT JOIN keuangan_jenis_bayar ON keuangan_jenis_bayar.jenis_bayar_id=keuangan_pembayaran_detail.jenis_bayar_id
        WHERE keuangan_pembayaran_detail.nim='$nim' AND keuangan_pembayaran_detail.status!=1";
 $queryy= mysqli_query($koneksi,$sqll);
  $sqlll = "SELECT kjb.*,kbk.jumlah FROM keuangan_biaya_kuliah as kbk, keuangan_jenis_bayar as kjb
            WHERE kjb.jenis_bayar_id=kbk.jenis_bayar_id AND 
            kbk.konsentrasi_id='$konsentrasi_id' AND kbk.angkatan_id='$angkatan_id' AND
            kbk.jumlah!=0";
 $queryyy= mysqli_query($koneksi,$sqlll);
  $queryyy1= mysqli_query($koneksi,$sqlll);
?>

<form method="POST">
  <div class="panel" data-role="panel">
    <div class="heading">
        <span class="title">Jenis Pembayaran</span>
    </div>
    <div class="grid">
        <label>Jenis Bayar</label>
        <select name="jenis_bayar">
				<option name="jenis_bayar" value="">-- pilih --</option>
				<?php
				while ($field1 = mysqli_fetch_array($queryyy1)) {
						echo "<option value='{$field1['jenis_bayar_id']}'>{$field1['keterangan']}</option>";
					}
				?>
		</select>
    	<label>Semester</label>
    	<input type="text" name="semester" value="" onkeypress="return hanyaAngka(event)"/>
		<label>Jumlah Bayar</label>
    	<input type="text" name="jumlah" value="" onkeypress="return hanyaAngka(event)"/>
    	<button type="submit" name="submit">Bayar</button>
    </div>
  </div>  
</form>
<?php
$tanggalskrg = date("Y-m-d");	
if (isset($_POST['submit'])) {
$jenis_bayar    = $_POST['jenis_bayar'];
$jumlah	        = $_POST['jumlah'];
$semester		= $_POST['semester'];

	$sql = "INSERT INTO keuangan_pembayaran_detail SET tanggal='$tanggalskrg', nim='$cari',id_users='1', jenis_bayar_id='$jenis_bayar', jumlah='$jumlah',
semester='$semester',status='0'";
	$queque = mysqli_query($koneksi, $sql);

	if ($queque) {
		echo "<script>$.Notify({
		    caption: 'Success',
		    content: 'Data Pembayaran Berhasil Ditambah',
    		type: 'success'
		});
		setTimeout(function(){ window.location.href='{$_url}keuangan?cari=$cari#'; }, 2000);
		</script>";
		header("Refresh:0");
	} else {
		echo "<script>$.Notify({
		    caption: 'Failed',
		    content: 'Data Pembayaran Gagal Ditambah',
		    type: 'alert'
		});</script>";
	}
}
?>

<table style='width: 20%;' border="1" align="left">
    <p align="left">Jenis Pembayaran</p>
       
<tr>
    <td>Jenis Bayar</td>
    <td>Jumlah</td>
</tr>
<?php
 if (mysqli_num_rows($queryyy) > 0):
			while($fielddd = mysqli_fetch_array($queryyy)):
			    ?>
<tr>
    <center>
    <td><?= $fielddd['keterangan'] ?></td>
    <td><?= $fielddd['jumlah'] ?></td>
    </center>
</tr>
<?php
endwhile;
			else:
			    ?>
	<tr>
			<td colspan='4'>
			Data tidak ditemukan
			</td>
		</tr>
<?php
		endif;
?>
</table>

<table style='width: 40%;' border="1" align="right">
    <th>
    <label>Pembayaran</label>
     <a target="_BLANK" href="<?= $_url ?>keuangan/cetak/<?= $cari ?>" class="button success">Cetak Pembayaran</a>
     </th>
<tr>
    <td>Jenis Bayar</td>
    <td>Semester</td>
    <td>Jumlah</td>
    <td>Aksi</td>

</tr>
<?php
 if (mysqli_num_rows($queryy) > 0):
			while($fieldd = mysqli_fetch_array($queryy)):
			    ?>
<tr>
    <td><?= $fieldd['keterangan'] ?></td>
    <td><?= $fieldd['semester'] ?></td>
    <td><?= $fieldd['jumlah'] ?></td>
    <td>
        <div class="inline-block">
				    <button class="button dropdown-toggle">Aksi</button>
				    <ul class="split-content d-menu" data-role="dropdown">
		
					<li><a href="<?= $_url ?>keuangan/delete/<?= $fieldd['pembayara_detail_id'] ?>/<?= urlencode($cari) ?>/<?= urlencode($fieldd['keterangan']) ?>" class="place-right"><span class="mif-cross"> Hapus Transaksi </span></a></li>
					</ul>
			</div>
    </td>
</tr>
<?php
endwhile;
			else:
			    ?>
	<tr>
			<td colspan='4'>
			Data tidak ditemukan
			</td>
		</tr>
<?php
		endif;
?>

</table>
<?php
}
	?>
	<script>
		function hanyaAngka(evt) {
		  var charCode = (evt.which) ? evt.which : event.keyCode
		   if (charCode > 31 && (charCode < 48 || charCode > 57))
 
		    return false;
		  return true;
		}
	</script>