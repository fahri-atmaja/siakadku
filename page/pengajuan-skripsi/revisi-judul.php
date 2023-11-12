<?php
	if ($_access == 'mahasiswa' && $_id != $_username) {
		header("location:{$_url}krs/view/{$_username}");
	}
?>
<h1>
<a href="<?= $_url ?>pengajuan-skripsi" class="nav-button transform"><span></span></a>
AJUKAN JUDUL
</h1>

<?php
if (isset($_POST['submit'])) {
	
	extract($_POST);
	$sql = "UPDATE pengajuan_skripsi SET revisi='{$komentar}', status=2 where nim='{$_id}'";
	$query = mysqli_query($koneksi, $sql);

	if ($query) {
		echo "<script>$.Notify({
		    caption: 'Success',
		    content: 'Komentar Revisi Berhasil Ditambah',
    		type: 'success'
		});
		setTimeout(function(){ window.location.href='{$_url}dosen/lihatnilai'; }, 2000);
		</script>";
	} else {
		echo "<script>$.Notify({
		    caption: 'Failed',
		    content: 'Komentar Revisi Gagal Ditambah',
		    type: 'alert'
		});</script>";
	}
}

?>
<form method="post">

<div class="grid">

<div class="row cells2">
	<div class="cell">
		<label>KOMENTAR REVISI</label>
		<div class="input-control text full-size">
			<input type="text" name="komentar">
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