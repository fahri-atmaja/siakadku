<?php
	if ($_access == 'mahasiswa' && $_id != $_username) {
		header("location:{$_url}krs/view/{$_username}");
	}
	if (empty($_access)) {
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
Keuangan SKS
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
	$sql1 = "SELECT bsk.*,bs.biaya ,bs.jenis_sks, sm.nama ,ak.nama_konsentrasi FROM bayar_sks as bsk, biaya_sks as bs, student_mahasiswa as sm, akademik_konsentrasi as ak
			 WHERE bsk.id_sks=bs.id_sks AND sm.id_sks=bs.id_sks AND sm.konsentrasi_id=ak.konsentrasi_id AND sm.nim=bsk.nim AND bsk.nim like '%".$cari."%'
			 ORDER BY semester ASC, nama_konsentrasi ASC";
	//$sql1 = "SELECT bsk.*, bs.jenis_sks, bs.biaya, sm.nama, sm.nim, sm.nama_konsentrasi FROM bayar_sks as bsk, biaya_sks as bs, student_mahasiswa as sm
	//					WHERE bsk.id_sks=bs.id_sks and sm.id_sks=bs.id_sks";
	$query1 = mysqli_query($koneksi, $sql1);
} else {
	$sql1 = "SELECT bsk.*,bs.biaya ,bs.jenis_sks, sm.nama ,ak.nama_konsentrasi FROM bayar_sks as bsk, biaya_sks as bs, student_mahasiswa as sm, akademik_konsentrasi as ak
			 WHERE bsk.id_sks=bs.id_sks AND sm.id_sks=bs.id_sks AND sm.konsentrasi_id=ak.konsentrasi_id AND sm.nim=bsk.nim
			 ORDER BY semester ASC, nama_konsentrasi ASC";
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
			<th>Konsentrasi</th>
			<th>Jenis SKS</th>
			<th>SKS diambil</th>
			<th>Harga/SKS</th>
			<th>Total Bayar</th>
			<th>Status</th>
			<th>Aksi</th>
		</tr>
	</thead>
	<tbody>

	<?php
		$no=1;
		if (mysqli_num_rows($query1) > 0):
			while($field1 = mysqli_fetch_array($query1)):
	?>
		<tr>
			<td><?= $no++ ?></td>
			<td><?= $field1['nim'] ?></td>
			<td><?= $field1['nama'] ?></td>
			<td><?= $field1['semester'] ?></td>
			<td><?= $field1['nama_konsentrasi'] ?></td>
			<td><?= $field1['jenis_sks'] ?></td>
			<td><?= $field1['jumlah_sks'] ?></td>
			<td><?= $field1['biaya'] ?></td>
			<td><?= $field1['jumlah_bayar'] ?></td>
			<td><?= $field1['status']==1?'Lunas':'Belum Dibayar'; ?></td>
			<td>
				<div class="inline-block">
				    <button class="button mini-button dropdown-toggle">Aksi</button>
				    <ul class="split-content d-menu" data-role="dropdown">
						<li><a href="<?= $_url ?>keuangan_sks/approved/<?= $field1['biaya_id'] ?>/<?= urlencode($field1['nim']) ?>"><span class="icon mif-school"></span> Bayar</a></li>
						<li><a href="<?= $_url ?>keuangan_sks/bayar/<?= $field1['biaya_id'] ?>/<?= urlencode($field1['nim']) ?>"><span class="icon mif-school"></span> Cetak Bukti Bayar</a></li>
						<li><a href="<?= $_url ?>keuangan_sks/hapus/<?= $field1['biaya_id'] ?>"><span class="icon mif-cross"></span> Hapus</a></li>
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
		
	</tbody>
</table>
