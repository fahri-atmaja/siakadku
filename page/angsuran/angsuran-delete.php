<?php

if (isset($_params[1]) && $_params[1] == 'yes') {
$query = mysqli_query($koneksi, "DELETE FROM bayar_angsuran WHERE bayar_id='{$_id}'");

	if ($query) {
		echo "<script>$.Notify({
		    caption: 'Success',
		    content: 'Data Biaya Berhasil Dihapus',
			type: 'success'
		});
		setTimeout(function(){ window.location.href='{$_url}angsuran; }, 2000);
		</script>";
	} else {
		echo "<script>$.Notify({
		    caption: 'Failed',
		    content: 'Data Biaya Gagal Dihapus',
		    type: 'alert'
		});</script>";
	}
}
?>

<h1>Hapus Biaya</h1>
<h3>Apakah anda yakin akan menghapus biaya dengan id <?= $_id ?></h3>
<a href="<?= $_url ?>angsuran/angsuran-delete/<?= $_id ?>/yes" class="button primary">Yes</a> <a href="<?= $_url ?>angsuran" class="button danger">No</a>