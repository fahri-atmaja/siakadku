
<?php
	if ($_access == 'mahasiswa' && $_id != $_username) {
		header("location:{$_url}krs/view/{$_username}");
	}
$querya = mysqli_query($koneksi,"SELECT * FROM dosen_absen WHERE absen_id='$_id'");
$field = mysqli_fetch_array($querya);
?>
<h1>
<a href="<?= $_url ?>presensi_mahasiswa" class="nav-button transform"><span></span></a>
Edit Bahasan Dosen<br><?= $nama_makul ?>
</h1>


<?php
	
if (isset($_POST['submit'])) {
$materi        	= $_POST['materi'];
$absen_id	    = $_POST['absen_id'];

	$sql = "UPDATE dosen_absen SET materi='$materi' WHERE absen_id='$absen_id'";
	$queque = mysqli_query($koneksi, $sql);

	if ($queque) {
		echo "<script>$.Notify({
		    caption: 'Success',
		    content: 'Data Berhasil Diubah',
    		type: 'success'
		});
		setTimeout(function(){ window.location.href='{$_url}presensi_mahasiswa'; }, 2000);
		</script>";
	} else {
		echo "<script>$.Notify({
		    caption: 'Failed',
		    content: 'Data Gagal Diubah',
		    type: 'alert'
		});</script>";
	}
}
?>

<form Method="POST">
	<table class="table striped hovered border bordered">
		<tr>
<td>
		<label>Pokok Bahasan dan Sumber :</label>
		<input type="hidden" name="absen_id" value="<?= $_id ?>">
		<p><?= $field['materi'] ?></p>
</td>
</tr>
<tr>
<td>
		<label>Pokok Bahasan dan Sumber Terbaru :</label>
		<textarea name="materi" id="materi" cols="40" rows="5" required></textarea>
</td>
</tr>
<tr>
	<td>
	
		<button type="submit" name="submit" class="button primary">SUBMIT</button>
	
	</td>
	</tr>
	</table>
</form>