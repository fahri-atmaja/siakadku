<div class="container">
    <div class="row">
        <h1>
<a href="<?= $_url ?><?= in_array($_access, array('admin','dosen')) ? '' : '' ?>" class="nav-button transform"><span></span></a>
Cek Pembayaran SPP Mahasiswa
</h1>
        <form method="GET">
        <label>Angkatan :</label><br>
        <select type="text" class="form-control" name="angkatan_id" id="angkatan_id">
				<?php
					$quedos = mysqli_query($koneksi, "SELECT * FROM student_angkatan WHERE briva=1 ORDER BY keterangan");
					while ($field = mysqli_fetch_array($quedos)) {
						echo "<option value='{$field['angkatan_id']}'>{$field['keterangan']}</option>";
					}
				?>
        </select>    
        <hr>
        <button type="submit" name="submit" class="button primary">Cek</button>
        </form>
    </div>
</div>
<?php
    if (isset($_GET['angkatan_id'])){
        $id = $_GET['angkatan_id'];
?>
<html>
<style type="text/css">
	.input-control {
		border: 1px solid #d9d9d9;
		padding: 10px;
	}
</style>

<h1>
<a href="<?= $_url ?>presensi_mahasiswa" class="nav-button transform"><span></span></a>
</h1>
<?php
$loadang = mysqli_query($koneksi,"SELECT * FROM student_angkatan WHERE angkatan_id = '$id'");
$ff = mysqli_fetch_array($loadang);
?>
<a href="javascript:printDiv('cetak');"><span style="color: red; font-size: 50;"><b><i><u>PRINT</u></i></b></span></a>
<div id="cetak">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>UNIVERSITAS DARUL ULUM ISLAMIC CENTRE SUDIRMAN GUPPI (UNDARIS)</title>
</head>
<body>
	<center>
		<img src="https://siakad.undaris.ac.id/assets/img/header.png" alt="UNIVERSITAS DARUL ULUM ISLAMIC CENTRE SUDIRMAN GUPPI (UNDARIS)">
	</center>
<center>
<h4><b>CEK PEMBAYARAN ANGKATAN <?= $ff['keterangan'] ?></b></h4>

</center>
</center>
<table border="1px" align="center" width="100%">
	<thead>
		<tr>
			<th>No.</th>
			<th>NIM</th>
			<th>NAMA</th>
			<th>SPP</th>
			<th>JURUSAN</th>
		</tr>
	</thead>
	<tbody>
			<?php
	$sqll = "SELECT student_mahasiswa.nim, student_angkatan.spp, student_mahasiswa.nama, student_mahasiswa.beasiswa,student_mahasiswa.kpt, akademik_konsentrasi.nama_konsentrasi FROM student_mahasiswa
	         LEFT JOIN akademik_konsentrasi ON student_mahasiswa.konsentrasi_id=akademik_konsentrasi.konsentrasi_id
	         LEFT JOIN student_angkatan ON student_angkatan.angkatan_id=student_mahasiswa.angkatan_id
	         WHERE student_mahasiswa.angkatan_id='$id' AND student_mahasiswa.kpt=0 AND student_mahasiswa.beasiswa=0 and student_mahasiswa.status='mahasiswa'
	         ORDER BY student_mahasiswa.nim ASC";
	$querya = mysqli_query($koneksi, $sqll);
		$no=1;
		if (mysqli_num_rows($querya) > 0):
			while($field = mysqli_fetch_array($querya)):
			    
	?>
	
		<tr>
		    <?php
		    $load = mysqli_query($koneksi,"SELECT * FROM proses_transaksi
			                                    LEFT JOIN tagihan_mahasiswa ON tagihan_mahasiswa.id_tagihan=proses_transaksi.id_tagihan
			                                    WHERE tagihan_mahasiswa.jenis_bayar='03' AND proses_transaksi.nim='$field[nim]' AND proses_transaksi.status_bayar='Y'");
			    $c = mysqli_num_rows($load);
		    ?>
			<td><?= $no++ ?></td>
			<td> <?php if($field['spp'] > $c){ echo "<s>".$field['nim']."</s>";}else echo $field['nim']; 
			?>
			</td>
			<td><?php if($field['spp'] > $c){ echo "<s>".strtoupper($field['nama'])."</s>";}else echo strtoupper($field['nama']); 
			?>
			</td>
			<td> <?= $c ?></td>
			<td><?= $field['nama_konsentrasi'] ?></td>
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
</body>
</body>
</div>
<textarea id="printing-css" style="display:none;">.no-print{display:none}</textarea>
<iframe id="printing-frame" name="print_frame" src="about:blank" style="display:none;"></iframe>
<script type="text/javascript">
function printDiv(elementId) {
 var a = document.getElementById('printing-css').value;
 var b = document.getElementById(elementId).innerHTML;
 window.frames["print_frame"].document.title = document.title;
 window.frames["print_frame"].document.body.innerHTML = '<style>' + a + '</style>' + b;
 window.frames["print_frame"].window.focus();
 window.frames["print_frame"].window.print();
}
</script>
</html>
<?php
}
?>