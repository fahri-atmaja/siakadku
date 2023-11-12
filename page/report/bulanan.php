<?php
	if ($_access == 'mahasiswa' && $_id != $_username) {
		header("location:{$_url}krs/view/{$_username}");
	}
?>

<style type="text/css">
	.input-control {
		border: 1px solid #d9d9d9;
		padding: 1px;
	}
</style>
<h1>
<a href="<?= $_url ?><?= in_array($_access, array('admin','yayasan')) ? 'dashboard' : '' ?>" class="nav-button transform"><span></span></a>
LAPORAN ANGSURAN BIAYA KULIAH BULANAN
</h1>
<form method="GET">
Bulan
<select name="bulan">
<option value="01">Januari</option>
<option value="02">Februari</option>
<option value="03">Maret</option>
<option value="04">April</option>
<option value="05">Mei</option>
<option value="06">Juni</option>
<option value="07">Juli</option>
<option value="08">Agustus</option>
<option value="09">September</option>
<option value="10">Oktober</option>
<option value="11">November</option>
<option value="12">Desember</option>
</select>
Tahun
<select name="tahun">
<?php
$mulai= date('Y') - 50;
for($i = $mulai;$i<$mulai + 100;$i++){
    $sel = $i == date('Y') ? ' selected="selected"' : '';
    echo '<option value="'.$i.'"'.$sel.'>'.$i.'</option>';
}
?>
</select>
<input type="submit" value="FILTER">
</form>
<?php
if(isset($_GET['bulan'])):
$bulan = $_GET['bulan'];
$tahun = $_GET['tahun'];
?>
<a target="_BLANK" href="<?= $_url ?>report/cetak-bulanan/<?= $bulan?>/<?= urlencode($tahun) ?>" class="button success">Cetak</a>
<?php
endif;
?>
<?php
if(isset($_GET['bulan']))
{
				$bulan = $_GET['bulan'];
				$tahun = $_GET['tahun'];
				$sql1 = "SELECT ba.*, sm.nama FROM bayar_angsuran as ba, student_mahasiswa as sm 
				WHERE sm.nim=ba.nim and month(ba.tanggal)='$bulan' and year(ba.tanggal)='$tahun'";
				$query1 = mysqli_query($koneksi, $sql1);
				}else{
				$sql1 = "SELECT ba.*, sm.nama FROM bayar_angsuran as ba, student_mahasiswa as sm 
				WHERE sm.nim=ba.nim";	
				$query1 = mysqli_query($koneksi, $sql1);	
				}
	
	
?>

<table class="table striped hovered border bordered">
	<thead>
		<tr>
			<th>No</th>
			<th>Tanggal</th>
			<th>NIM</th>
			<th>Nama</th>
			<th>Angsuran ke-</th>
			<th>Jumlah Bayar</th>
		</tr>
	</thead>
	<tbody>

	<?php
		$no=1;
		if (mysqli_num_rows($query1) > 0):
			while($field1 = mysqli_fetch_array($query1)):
			    $total = $total+$field1['bayar'];
	?>
		<tr>
			<td><?= $no++ ?></td>
			<td><?php echo tgl_indo($field1['tanggal']) ?></td>
			<td><?= $field1['nim'] ?></td>
			<td><?= $field1['nama'] ?></td>
			<td><?= $field1['angsuran'] ?></td>
			<td><?= $field1['bayar'] ?></td>
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
	<tr><td colspan='5' align='right'>Total</td><td><?php 
			echo $total ?></td></tr>
	</tbody>
</table>
