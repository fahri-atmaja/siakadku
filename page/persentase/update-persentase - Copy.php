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
<a href="<?= $_url ?><?= in_array($_access, array('admin','dosen')) ? 'persentase' : '' ?>" class="nav-button transform"><span></span></a>
Update Persentase
</h1>
	<script>
		function hanyaAngka(evt) {
		  var charCode = (evt.which) ? evt.which : event.keyCode
		   if (charCode > 31 && (charCode < 48 || charCode > 57))
 
		    return false;
		  return true;
		}
	</script>
<?php
$makul = $_params[1];
?>
<?php

if (isset($_POST['submit'])) {

	extract($_POST);
	$total=$uas+$uts+$kehadiran+$tugas+$praktik;
	if ($total > 100)
	{
    echo "<script>window.alert('Persentase Salah, Total Tidak Boleh Lebih dari 100')
    window.location='set-persentase'</script>";
    }
    elseif ($total < 100)
	{
    echo "<script>window.alert('Persentase Salah, Total Tidak Boleh Kurang dari 100')
    window.location='set-persentase'</script>";
    }else{
	$sqlu = "UPDATE setpersentase SET uts='{$uts}', uas='{$uas}', kehadiran='{$kehadiran}', tugas='{$tugas}', praktik='{$praktik}' WHERE nip='$_username' and jadwal_id='$_id'";
	$que = mysqli_query($koneksi, $sqlu);

	if ($que) {
		echo "<script>$.Notify({
		    caption: 'Success',
		    content: 'Data Persentase Berhasil Ubah',
    		type: 'success'
		});
		setTimeout(function(){ window.location.href='{$_url}persentase'; }, 2000);
		</script>";
	} else {
		echo "<script>$.Notify({
		    caption: 'Failed',
		    content: 'Data Persentase Gagal Ubah',
		    type: 'alert'
		});</script>";
	}
}
}
?>
<form Method="POST">
	<h2><?php echo $makul ?></h2>
	<table class="table striped hovered border bordered">
	<td>

			<input type="hidden" name="nip" id="nip" value="<?php echo $_username ?>" readonly>

	<td>
	<div class="form-group">
		<label for="semester">KEHADIRAN :</label>
			<input class="form-control" type="text" name="kehadiran" id="kehadiran" onkeypress="return hanyaAngka(event)" maxlength="2">
		<label for="semester">TUGAS :</label>
			<input class="form-control" type="text" name="tugas" id="tugas" onkeypress="return hanyaAngka(event)" maxlength="2">
		<label for="semester">PRAKTIK :</label>
			<input class="form-control" type="text" name="praktik" id="praktik" onkeypress="return hanyaAngka(event)" maxlength="2">		
	</td>
	<br>
	<td>
	<div class="form-group">
		<label for="semester">UTS :</label>
			<input class="form-control" type="text" name="uts" id="uts" onkeypress="return hanyaAngka(event)" maxlength="2">
		<label for="semester">UAS :</label>
			<input class="form-control" type="text" name="uas" id="uas" onkeypress="return hanyaAngka(event)" maxlength="2">
	</div>
	</td>
	<td>
	<div class="row cells2">
	<div class="cell">
		<button type="submit" name="submit" class="button primary">SUBMIT</button>
	</div>
	</div>
	</td>
	</table>
</form>
