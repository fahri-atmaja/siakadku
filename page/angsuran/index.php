<?php
	if ($_access == 'mahasiswa' && $_id != $_username) {
		header("location:{$_url}krs/view/{$_username}");
	}
	if ($_access == 'dosen' && $_id != $_username) {
		header("location:{$_url}");
	}
?>

<style type="text/css">
	.input-control {
		border: 1px solid #d9d9d9;
		padding: 1px;
	}
</style>

<h1>
<a href="<?= $_url ?><?= in_array($_access, array('admin')) ? 'dashboard' : '' ?>" class="nav-button transform"><span></span></a>
Angsuran
</h1>
<form action="#" method="get">
	<label>Cari :</label>
	<input type="text" name="cari">
	<input type="submit" value="Cari">
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
	// $sql1 = "SELECT bsk.*,bs.biaya ,bs.jenis_sks, sm.nama ,ak.nama_konsentrasi FROM bayar_sks as bsk, biaya_sks as bs, student_mahasiswa as sm, akademik_konsentrasi as ak
	// 		 WHERE bsk.id_sks=bs.id_sks AND sm.id_sks=bs.id_sks AND sm.konsentrasi_id=ak.konsentrasi_id AND sm.nim=bsk.nim AND bsk.nim like '%".$cari."%'
	// 		 ORDER BY semester ASC, nama_konsentrasi ASC";
	$sql1 = "SELECT sm.*, ak.nama_konsentrasi, bs.jenis_sks, ba.total_biaya, ba.jumlah_angsur FROM student_mahasiswa as sm, biaya_sks as bs, akademik_konsentrasi as ak, biaya_angsuran as ba WHERE sm.konsentrasi_id=ak.konsentrasi_id AND ba.konsentrasi_id=ak.konsentrasi_id AND sm.id_sks=bs.id_sks AND sm.status_angsur='1' AND sm.id_sks='1' AND sm.kpt!='1' AND sm.beasiswa!='1' AND sm.nim like '%".$cari."%'";
	$query1 = mysqli_query($koneksi, $sql1);
}
  else {
$sql1 = "SELECT sm.*, ak.nama_konsentrasi, bs.jenis_sks, ba.total_biaya, ba.jumlah_angsur FROM student_mahasiswa as sm, biaya_sks as bs, akademik_konsentrasi as ak, biaya_angsuran as ba WHERE sm.konsentrasi_id=ak.konsentrasi_id AND ba.konsentrasi_id=ak.konsentrasi_id AND sm.id_sks=bs.id_sks AND sm.status_angsur='1' AND sm.id_sks='1' AND sm.kpt!='1' AND sm.beasiswa!='1'
			 ORDER BY nama_konsentrasi ASC ";
	$query1 = mysqli_query($koneksi, $sql1);
}
?>

<table class="table striped hovered border bordered">
	<thead>
		<tr>
			<th>No</th>
			<th>Nim</th>
			<th>Nama</th>
			<th>Semester</th>
			<th>Jenis SKS</th>
			<th>Konsentrasi</th>
			<th>Total Biaya</th>
			<th>Jumlah Angsuran</th>
			<th>Aksi</th>
		</tr>
	</thead>
	<tbody>

	<?php
		$no=1;
		if (mysqli_num_rows($query1) > 0):
			while($field1 = mysqli_fetch_array($query1)):
	 			$nim=$field1['nim'];
	$sql2 ="SELECT * FROM bayar_angsuran WHERE nim='$nim'" ;
	$query2 = mysqli_query($koneksi, $sql2);
	$hitung = mysqli_num_rows($query2);
	
	// 	if (mysqli_num_rows($query2) > 0):
	// 		while($field2 = mysqli_fetch_array($query2)):
	?>
		<tr>
			<td><?= $no++ ?></td>
			<td><?= $field1['nim'] ?></td>
			<td><?= $field1['nama'] ?></td>
			<td><?= $field1['semester'] ?></td>
			<td><?= $field1['jenis_sks'] ?></td>
			<td><?= $field1['nama_konsentrasi'] ?></td>
			<td><?= $field1['total_biaya'] ?></td>
			<td><?= $field1['jumlah_angsur'] - $hitung; ?></td>
			<td>
				<div class="inline-block">
				    <button class="button dropdown-toggle">Aksi</button>
				    <ul class="split-content d-menu" data-role="dropdown">
						<li><a href="<?= $_url ?>angsuran/bayar_angsuran/<?= $field1['nim'] ?>/<?= urlencode($field1['jumlah_angsur']) ?>"><span class="icon mif-school"></span> Bayar Angsur</a></li>
						<li><a href="<?= $_url ?>keuangan_sks/bayar/<?= $field1['biaya_id'] ?>/<?= urlencode($field1['nim']) ?>"><span class="icon mif-school"></span> Cetak Bukti Bayar</a></li>
				    </ul>
				</div>
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
	<!--  -->
		
	</tbody>
</table>
