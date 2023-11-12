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
<a href="<?= $_url ?><?= in_array($_access, array('admin')) ? '' : '' ?>" class="nav-button transform"><span></span></a>
Angsuran
</h1>
<?php
date_default_timezone_set("Asia/Jakarta");
$tanggal = date('Y-m-d');
if (isset($_POST['submit'])) {
	$nim = $_POST['nim'];
	$semester = $_POST['semester'];
	$sks = $_POST['sks'];
	$spi = $_POST['spi'];
	$spp = $_POST['spp'];
	$heregristrasi = $_POST['heregristrasi'];
	$ospek = $_POST['ospek'];
	$angsur = $_POST['angsur'];
	$bulanan = $_POST['bulanan'];

	$sqlu = "INSERT INTO angsuran_konversi SET nim='$nim',semester='$semester',sks='$sks',spi='$spi',spp='$spp',
	         heregristrasi='$heregristrasi',ospek='$ospek',angsuran='$angsur',angsuran_aktif='$angsur',bulanan='$bulanan'";
	$que = mysqli_query($koneksi, $sqlu);

	if ($que) {
		echo "<script>$.Notify({
		    caption: 'Success',
		    content: 'Data Angsuran Berhasil',
    		type: 'success'
		});
		setTimeout(function(){ window.location.href='{$_url}konversi_bulanan/biaya_angsuran'; }, 2000);
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
		<select class="form-control" name="nim" id="nim" required>
		    <option name="nim" value="">---Pilih Mahasiswa Konversi Bulanan---</option>
			<?php 
			$loadkon=mysqli_query($koneksi,"SELECT sm.*,ak.nama_konsentrasi FROM student_mahasiswa as sm, akademik_konsentrasi as ak 
			                                WHERE sm.konsentrasi_id=ak.konsentrasi_id and id_sks='2' and status_angsur='1' ORDER BY konsentrasi_id ASC");
			while ($row= mysqli_fetch_array($loadkon)) {
					echo '<option name="nim" value="' . $row['nim'] . '">' . $row['nama_konsentrasi'] . ' - ' . $row['nim'] . ' - ' . $row['nama'] . '</option>';
				}
			?>
				

		</select>
  </div>
  <div class="col-5">
    <label for="exampleInputEmail1">Bulanan Semester</label>
    <select class="form-control" name="semester" id="semester" required>
		    <option name="semester" value="">---Pilih Semester---</option>
		    <option name="semester" value="1">Semester 1</option>
		    <option name="semester" value="2">Semester 2</option>
		    <option name="semester" value="3">Semester 3</option>
		    <option name="semester" value="4">Semester 4</option>
		    <option name="semester" value="5">Semester 5</option>
		    <option name="semester" value="6">Semester 6</option>
		    <option name="semester" value="7">Semester 7</option>
		    <option name="semester" value="8">Semester 8</option>
		    <option name="semester" value="9">Semester 9</option>
		    <option name="semester" value="10">Semester 10</option>
		    <option name="semester" value="11">Semester 11</option>
		    <option name="semester" value="12">Semester 12</option>
		    <option name="semester" value="13">Semester 13</option>
		    <option name="semester" value="14">Semester 14</option>
  </div>
  <div class="col-5">
    <label for="exampleInputEmail1">Total Biaya SKS</label>
    <input type="text" class="form-control" id="sks" name="sks" value="" required>
  </div>
  <div class="col-5">
    <label for="exampleInputPassword1">SPI</label>
    <input type="text" class="form-control" id="spi" name="spi" value="" required>
  </div>
    <div class="col-5">
    <label for="exampleInputPassword1">SPP</label>
    <input type="text" class="form-control" id="spp" name="spp" value="" required>
  </div>
    <div class="col-5">
    <label for="exampleInputPassword1">HEREGISTRASI</label>
    <input type="text" class="form-control" id="heregristrasi" name="heregristrasi" value="" required>
  </div>
      <div class="col-5">
    <label for="exampleInputPassword1">OSPEK</label>
    <input type="text" class="form-control" id="ospek" name="ospek" value="" required>
  </div>
      <div class="col-5">
    <label for="exampleInputPassword1">BERAPA KALI ANGSUR</label>
    <input type="text" class="form-control" id="angsur" name="angsur" value="" required>
  </div>
  <div class="col-5">
    <label for="exampleInputPassword1">BAYAR BULANAN</label>
    <input type="text" class="form-control" id="bulanan" name="bulanan" value="" required>
  </div>
	<div class="col-5">
  <button type="submit" name="submit" class="btn btn-primary">Submit</button>
  </div>
</form>

<?php
$sql1 = "SELECT ak.*, sm.nama FROM angsuran_konversi as ak, student_mahasiswa as sm 
         WHERE ak.nim=.sm.nim ORDER BY nim ASC";
$query1 = mysqli_query($koneksi, $sql1);
?>

<table class="table striped hovered border bordered">
	<thead>
		<tr>
			<th>No</th>
			<th>NIM</th>
			<th>Semester</th>
			<th>Nama</th>
			<th>SKS</th>
			<th>SPI</th>
			<th>SPP</th>
			<th>HEREGISTRASI</th>
			<th>OSPEK</th>
			<th>JUMLAH ANGSURAN</th>
			<th>ANGSURAN AKTIF KE</th>
			<th>BIAYA BULANAN</th>
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
	//$bulanan = ($field1['sks']+$field1['spi']+$field1['spp']+$field1['heregristrasi']+$field1['ospek'])/$field1['angsuran'];
	?>
	
		<tr>
			<td><?= $no++ ?></td>
			<td><?= $field1['nim'] ?></td>
			<td><?= $field1['semester'] ?></td>
			<td><?= $field1['nama'] ?></td>
			<td><?= $field1['sks'] ?></td>
			<td><?= $field1['spi'] ?></td>
			<td><?= $field1['spp'] ?></td>
			<td><?= $field1['heregristrasi'] ?></td>
			<td><?= $field1['ospek'] ?></td>
			<td><?= $field1['angsuran'] ?></td>
			<td><?= $field1['angsuran_aktif'] ?></td>
			<td><?= $field1['bulanan'] ?></td>
			<!--<td><?= $bulanan ?></td>-->
			<td>
				<div class="inline-block">
					<a href="<?= $_url ?>konversi_bulanan/delete/<?= $field1['id_angsur'] ?>" class="place-right"><span class="mif-cross"> Hapus </span></a>
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
