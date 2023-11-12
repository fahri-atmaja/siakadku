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
<a href="<?= $_url ?><?= in_array($_access, array('admin')) ? 'angsuran' : '' ?>" class="nav-button transform"><span></span></a>
Angsuran
</h1>
<?php
date_default_timezone_set("Asia/Jakarta");
$tanggal = date('Y-m-d');
if (isset($_POST['submit'])) {
	$bayar = $_POST['bayar'];
	$angsuran = $_POST['angsuran'];
	$konsentrasi = $_POST['konsentrasi'];	

	$sqlu = "INSERT INTO biaya_angsuran SET konsentrasi_id='$konsentrasi',total_biaya='$bayar',jumlah_angsur='$angsuran'";
	$que = mysqli_query($koneksi, $sqlu);

	if ($que) {
		echo "<script>$.Notify({
		    caption: 'Success',
		    content: 'Data Angsuran Berhasil',
    		type: 'success'
		});
		setTimeout(function(){ window.location.href='{$_url}angsuran/biaya_angsuran'; }, 2000);
		</script>";
	} else {
		echo "<script>$.Notify({
		    caption: 'Failed',
		    content: 'Data Angsuran Gagal',
		    type: 'alert'
		});</script>";
	}
  }
?>

<form method="POST">
	<div class="col-5">
		<select class="form-control" name="konsentrasi" id="konsentrasi" required>
			<?php 
			$loadkon=mysqli_query($koneksi,"SELECT * FROM akademik_konsentrasi WHERE konsentrasi_id NOT IN (SELECT konsentrasi_id FROM biaya_angsuran)");
			while ($row= mysqli_fetch_array($loadkon)) {
					echo '<option name="konsentrasi" value="' . $row['konsentrasi_id'] . '">' . $row['nama_konsentrasi'] . '</option>';
				}
			?>
				

		</select>
  </div>
  <div class="col-5">
    <label for="exampleInputEmail1">Jumlah Angsuran</label>
    <input type="text" class="form-control" id="angsuran" name="angsuran" value="" required>
  </div>
  <div class="col-5">
    <label for="exampleInputPassword1">Total Biaya</label>
    <input type="text" class="form-control" id="bayar" name="bayar" value="" required>
  </div>
	<div class="col-5">
  <button type="submit" name="submit" class="btn btn-primary">Submit</button>
  </div>
</form>

<?php
$sql1 = "SELECT biaya_angsuran.*, akademik_konsentrasi.nama_konsentrasi FROM biaya_angsuran
	LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=biaya_angsuran.konsentrasi_id";
$query1 = mysqli_query($koneksi, $sql1);
?>

<table class="table striped hovered border bordered">
	<thead>
		<tr>
			<th>No</th>
			<th>Prodi</th>
			<th>Total Biaya</th>
			<th>Jumlah Angsuran</th>
			<th></th>
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
					<a href="<?= $_url ?>angsuran/delete/<?= $field1['id'] ?>" class="place-right"><span class="mif-cross"> Hapus </span></a>
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
