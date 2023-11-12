<?php
	if ($_access == 'mahasiswa' && $_id != $_username) {
		header("location:{$_url}krs/view/{$_username}");
	}
?>

<h1>
<a href="<?= $_url ?>" class="nav-button transform"><span></span></a>
Tambah Info
</h1>

<?php
if (isset($_POST['submit'])) {

	extract($_POST);

	$sql = "INSERT INTO akademik_info (judul_info,isi_info,tanggal_info)
			VALUES ('".$_POST["judul_info"]."','".$_POST["isi_info"]."','".$_POST["tanggal_info"]."')";
	$query = mysqli_query($koneksi, $sql);

	if ($query) {
		echo "<script>$.Notify({
		    caption: 'Success',
		    content: 'Data Info Berhasil Ditambah',
    		type: 'success'
		});
		setTimeout(function(){ window.location.href='{$_url}info/add'; }, 2000);</script>";
	} else {
		echo "<script>$.Notify({
		    caption: 'Failed',
		    content: 'Data Info Gagal Ditambah',
		    type: 'alert'
		});</script>";
	}
}
?>

<form method="post">



<div class="row cells2">
	<div class="cell">
		<label>JUDUL INFORMASI</label>
		<div class="form-group">
			<input type="text" name="judul_info" value="" required>
			<input type="hidden" name="siapa" value="$_id" required>
		</div>
	</div>
	
	<div class="cell">
		<label>ISI INFORMASI</label>
		<div class="form-group">
			<!--<input type="text" name="isi_info" value="" required>-->
		<textarea rows = "5" cols = "50" name = "isi_info">
            Enter The Information
        </textarea>
		</div>
	</div>
	<div class="cell">
		<label>TANGGAL POSTING</label>
		<div class="form-group">
			<input type="date" name="tanggal_info" value="" required>
		</div>
	</div>
</div>


	

<div class="row cells2">
	<div class="cell">
		<button type="submit" name="submit" class="button primary">SUBMIT</button>
	</div>
</div>

</div>
<div class="grid">
<?php
$sql1 = "SELECT * from akademik_info ORDER BY info_id DESC";
$query1 = mysqli_query($koneksi, $sql1);
	$no=1;
?>

	<table class="table striped hovered border bordered">
	<thead>
		<tr>
			<th>JUDUL INFO</th>
			<th>ISI INFO</th>
			<th>TANGGAL INFO</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php
		if (mysqli_num_rows($query1) > 0):
			while($field1 = mysqli_fetch_array($query1)):
	?>
		<tr>
				<td><?= $field1['judul_info'] ?> </td>
				<td><?= $field1['isi_info'] ?> </td>
				<td><?= $field1['tanggal_info'] ?> </td>
				<td></td>
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
</div>
</form>
