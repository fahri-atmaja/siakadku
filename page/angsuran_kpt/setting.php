<?php
	if ($_access == 'mahasiswa' && $_id != $_username) {
		header("location:{$_url}krs/view/{$_username}");
	}
	if ($_access == 'dosen' && $_id != $_username) {
		header("location:{$_url}");
	}
	if ($_access == 'fakultas' && $_id != $_username) {
		header("location:{$_url}");
	}
?>

<style type="text/css">
	.input-control {
		border: 1px solid #d9d9d9;
		padding: 1px;
	}
</style>
	<script>
		function hanyaAngka(evt) {
		  var charCode = (evt.which) ? evt.which : event.keyCode
		   if (charCode > 31 && (charCode < 48 || charCode > 57))
 
		    return false;
		  return true;
		}
	</script>
<h1>
<a href="<?= $_url ?><?= in_array($_access, array('admin')) ? 'dashboard' : '' ?>" class="nav-button transform"><span></span></a>
Angsuran
</h1>
<form action="#" method="POST">
<div class="form-group">
		<select class="form-control" name="konsentrasi_id" id="konsentrasi_id" required>
				<option value="" selected="selected">-</option>
				<?php 
		$sqlx = mysqli_query($koneksi,"SELECT * FROM akademik_konsentrasi ORDER BY konsentrasi_id");
		while ($row = mysqli_fetch_array($sqlx))
		{
			echo "<option value='".$row['konsentrasi_id']."'>".$row['konsentrasi_id']."-".$row['nama_konsentrasi']."</option>";
		}
		?>
			</select>
		<label for="semester">Total Biaya :</label>
			<input class="form-control" type="text" name="total_biaya" id="total_biaya" onkeypress="return hanyaAngka(event)" maxlength="8" required>
		<label for="semester">Jumlah Angsur :</label>
			<input class="form-control" type="text" name="jumlah_angsur" id="jumlah_angsur" onkeypress="return hanyaAngka(event)" maxlength="2" required>
	</div>
	<div class="form-group">
		<button type="submit" name="submit" class="button primary">SUBMIT</button>
	</div>
</form>
<?php
if (isset($_POST['submit'])) {
	extract($_POST);
	$cek = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM biaya_angsuran WHERE konsentrasi_id='$konsentrasi_id'"));
	if ($cek > 0)
		{
    echo "<script>window.alert('Anda sudah setting Konsentrasi ini')
    window.location='{$_url}angsuran'</script>";
    }else{
	$sqlu = "INSERT INTO biaya_angsuran(id,konsentrasi_id,total_biaya,jumlah_angsur) VALUES('','$konsentrasi_id','$total_biaya','$jumlah_angsur')";
	$que = mysqli_query($koneksi, $sqlu);

	if ($que) {
		echo "<script>$.Notify({
		    caption: 'Success',
		    content: 'Data Setting Berhasil Ditambah',
    		type: 'success'
		});
		setTimeout(function(){ window.location.href='{$_url}angsuran'; }, 2000);
		</script>";
	} else {
		echo "<script>$.Notify({
		    caption: 'Failed',
		    content: 'Data Setting Gagal Ubah',
		    type: 'alert'
		});</script>";
	}
}
}
?>
<?php
$sql1 = "SELECT ba.*, ak.nama_konsentrasi FROM biaya_angsuran as ba, akademik_konsentrasi as ak WHERE ba.konsentrasi_id=ak.konsentrasi_id
			 ORDER BY nama_konsentrasi ASC ";
	$query1 = mysqli_query($koneksi, $sql1);
?>

<table class="table striped hovered border bordered">
	<thead>
		<tr>
			<th>No</th>
			<th>Nama Konsentrasi</th>
			<th>Total Biaya</th>
			<th>Total Angsuran</th>
			<th>Aksi</th>
		</tr>
	</thead>
	<tbody>

	<?php
		$no=1;
		if (mysqli_num_rows($query1) > 0):
			while($field1 = mysqli_fetch_array($query1)):
	// 			$nim=$field1['nim'];
	// $sql2 ="SELECT * FROM bayar_angsuran WHERE nim='$nim'" ;
	// $query2 = mysqli_query($koneksi, $sql2);
	// 	if (mysqli_num_rows($query2) > 0):
	// 		while($field2 = mysqli_fetch_array($query2)):
	?>
		<tr>
			<td><?= $no++ ?></td>
			<td><?= $field1['nama_konsentrasi'] ?></td>
			<td><?= $field1['total_biaya'] ?></td>
			<td><?= $field1['jumlah_angsur'] ?></td>
			<td>
				<div class="inline-block">
				    <button class="button mini-button dropdown-toggle">Aksi</button>
				    <ul class="split-content d-menu" data-role="dropdown">
						<li><a href="<?= $_url ?>angsuran/approved/<?= $field1['nim'] ?>/<?= urlencode($field1['jumlah_angsur']) ?>"><span class="icon mif-school"></span> Bayar</a></li>
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
