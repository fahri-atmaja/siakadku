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
<a href="<?= $_url ?>konversi_bulanan" class="nav-button transform"><span></span></a>
Angsuran
</h1>
<?php
$jmlangsur=$_params[1];
date_default_timezone_set("Asia/Jakarta");
$tanggal = date('Y-m-d');
if (isset($_POST['submit'])) {
    $nim = $_POST['nim'];
    $id_angsur = $_POST['id_angsur'];
	$bayar = $_POST['bayar'];
	$angsuran = $_POST['angsuran'];
	$tanggal = $_POST['tanggal'];
// 	$cekdulu = mysqli_num_rows(mysqli_query($koneksi,"SELECT * from bayar_angsuran where nim = '$_id' and tanggal='$tanggal'"));
// if ($cekdulu > 0){
// 		echo "<script>window.alert('MAAF MAHASISWA SUDAH BAYAR ANGSURAN HARI INI')
//     window.location.href='{$_url}angsuran'</script>";
// 	}else{
// 		$cekdulu = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * from bayar_angsuran where nim = '$_id' and angsuran='$angsuran' ORDER BY angsuran DESC LIMIT 1"));
// 		$cektgl = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * from bayar_angsuran where nim = '$_id' and tanggal='$tanggal1' ORDER BY tanggal DESC LIMIT 1"));
// 		$cek = mysqli_fetch_array(mysqli_query($koneksi,"SELECT *,DATE_ADD(tanggal, INTERVAL 30 DAY) as jatuh tempo FROM bayar_angsuran ORDER BY tanggal DESC LIMIT 1"));
// if ($cekdulu > 0){
// 		echo "<script>window.alert('MAAF MAHASISWA SUDAH LUNAS')
//     window.location.href='{$_url}angsuran'</script>";
// 	}elseif ($cektgl > 0){
// 		echo "<script>window.alert('MAAF MAHASISWA SUDAH ANGSUR HARI INI')
// 		    window.location.href='{$_url}angsuran'</script>";
// 	}else{
	

	$sqlu = "INSERT INTO angsuran_konversi_bayar SET id_angsur='$id_angsur', nim='$nim',bayar='$bayar',angsuran='$angsuran',tanggal='$tanggal'";
	$sqli = "UPDATE angsuran_konversi SET angsuran_aktif=angsuran_aktif - 1 WHERE id_angsur='$id_angsur'";
	$que = mysqli_query($koneksi, $sqlu);
	$que = mysqli_query($koneksi, $sqli);

	if ($que) {
		echo "<script>$.Notify({
		    caption: 'Success',
		    content: 'Data Angsuran Berhasil',
    		type: 'success'
		});
		setTimeout(function(){ window.location.href='{$_url}konversi_bulanan/bayar_angsuran/$id_angsur/$nim'; }, 2000);
		</script>";
	} else {
		echo "<script>$.Notify({
		    caption: 'Failed',
		    content: 'Data Angsuran Gagal',
		    type: 'alert'
		});</script>";
	}
  }
// }
?>
<?php

$sql = "SELECT ak.*, sm.nama FROM angsuran_konversi as ak, student_mahasiswa as sm WHERE ak.nim=.sm.nim and ak.id_angsur='$_id'";
$query = mysqli_query($koneksi, $sql);
$row = mysqli_fetch_array($query);
if ($row['angsuran_aktif']==0){
    echo "<script>window.alert('Angsuran sudah lunas!')
		    window.location.href='{$_url}konversi_bulanan'</script>";
}
// $sql1 = "SELECT nim,nama,konsentrasi_id FROM student_mahasiswa WHERE nim='$_id'";
// $query1 = mysqli_query($koneksi, $sql1);
// $row1 = mysqli_fetch_array($query1);
// $konsen = $row1['konsentrasi_id'];
?>
<form method="POST">
	<div class="col-5">
    <label for="exampleInputEmail1">NIM : </label>
    <input type="text" class="form-control" id="nim" name="nim" value="<?php echo $row['nim'] ?>" readonly>
    <input type="hidden" class="form-control" id="id_angsur" name="id_angsur" value="<?php echo $_id ?>" readonly>
  </div>
  <div class="col-5">
    <label for="exampleInputEmail1">Nama : <?php echo $row['nama'] ?></label>
  </div>
  <div class="col-5">
    <label for="exampleInputEmail1">Semester : </label>
    <input type="text" class="form-control" id="semester" name="semester" value="<?php echo $row['semester'] ?>" readonly>
  </div>
  <div class="col-5">
    <label for="exampleInputEmail1">Bayar Angsuran Ke</label>
    <input type="text" class="form-control" id="angsuran" name="angsuran" value="<?php echo $row['angsuran']-$row['angsuran_aktif']+1 ?>" readonly >
  </div>
  <div class="col-5">
    <label for="exampleInputPassword1">Total Bayar</label>
    <input type="text" class="form-control" id="bayar" name="bayar" value="<?php echo $row['bulanan'] ?>" >
  </div>
  <div class="col-5">
    <label for="exampleInputPassword1">Tanggal Bayar</label>
    <input type="date" class="form-control" id="tanggal" name="tanggal" value="">
  </div>
	<div class="col-5">
  <button type="submit" name="submit" class="btn btn-primary">Bayar</button>
  </div>
</form>

<?php
$sql1 = "SELECT angsuran_konversi_bayar.*, angsuran_konversi.semester FROM angsuran_konversi_bayar
        LEFT JOIN angsuran_konversi ON angsuran_konversi.id_angsur = angsuran_konversi_bayar.id_angsur
        WHERE angsuran_konversi.id_angsur='$_id'";
$query1 = mysqli_query($koneksi, $sql1);
?>

<table class="table striped hovered border bordered">
	<thead>
		<tr>
			<th>No</th>
			<th>Angsuran Ke</th>
			<th>Semester</th>
			<th>Bayar Angsur</th>
			<th>Tanggal Bayar</th>
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
			<td><?= $field1['angsuran'] ?></td>
			<td><?= $field1['semester'] ?></td>
			<td><?= $field1['bayar'] ?></td>
			<td><?= (tgl_indo($field1['tanggal'])) ?></td>
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
