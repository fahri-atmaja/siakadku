<?php

if (isset($_params[2]) && $_params[2] == 'yes') {
$query = mysqli_query($koneksi, "DELETE FROM jadwal_kuliah WHERE jadwal_id='{$_id}'");

	if ($query) {
		echo "<script>$.Notify({
		    caption: 'Success',
		    content: 'Data Jadwal Berhasil Dihapus',
			type: 'success'
		});
		setTimeout(function(){ window.location.href='{$_url}jadwal_uas'; }, 2000);
		</script>";
	} else {
		echo "<script>$.Notify({
		    caption: 'Failed',
		    content: 'Data Jadwal Gagal Dihapus',
		    type: 'alert'
		});</script>";
	}
}
?>

<h1>Hapus Jadwal UAS</h1>
<h3>Apakah anda yakin akan menghapus jadwal dengan id <?= $_id ?> yang bernama <?= urldecode($_params[1]) ?>?</h3>
<a href="<?= $_url ?>jadwal_uas/delete/<?= $_id ?>/<?= $_params[1] ?>/yes" class="button primary">Yes</a> <a href="<?= $_url ?>jadwal_uas" class="button danger">No</a>