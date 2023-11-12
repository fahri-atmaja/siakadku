<h1>
<a href="<?= $_url ?>pengajuan-skripsi" class="nav-button transform"><span></span></a>
EDIT JUDUL
</h1>

<?php
if (isset($_POST['submit'])) {
	
	extract($_POST);
	$sql = "UPDATE pengajuan_skripsi SET judul='{$judul}', revisi='' where nim='{$_username}'";
	$query = mysqli_query($koneksi, $sql);

	if ($query) {
		echo "<script>$.Notify({
		    caption: 'Success',
		    content: 'Judul Berhasil Ditambah',
    		type: 'success'
		});
		setTimeout(function(){ window.location.href='{$_url}pengajuan-skripsi'; }, 2000);
		</script>";
	} else {
		echo "<script>$.Notify({
		    caption: 'Failed',
		    content: 'Judul Gagal Ditambah',
		    type: 'alert'
		});</script>";
	}
}

?>
<form method="post">

<div class="grid">

<div class="row cells2">
	<div class="cell">
		<label>JUDUL</label>
		<div class="input-control text full-size">
			<input type="text" name="judul">
		</div>
	</div>
</div>


<div class="row cells2">
	<div class="cell">
		<button type="submit" name="submit" class="button primary">SUBMIT</button>
	</div>
</div>

</div>

</form>