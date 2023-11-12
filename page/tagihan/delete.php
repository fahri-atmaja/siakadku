<?php

if (isset($_params[1]) && $_params[1] == 'yes') {
	$query = mysqli_query($koneksi, "DELETE FROM tagihan_mahasiswa WHERE id_tagihan='{$_id}'");

	if ($query) {
		echo "<script>$.Notify({
		    caption: 'Success',
		    content: 'Data Berhasil Dihapus',
			type: 'success'
		});
		setTimeout(function(){ window.location.href='{$_url}tagihan'; }, 1500);
		</script>";
	} else {
		echo "<script>$.Notify({
		    caption: 'Failed',
		    content: 'Data Gagal Dihapus',
		    type: 'alert'
		});</script>";
	}
}
?>

<h1>Hapus Tagihan</h1>
<h3>Apakah anda yakin akan menghapus tagihan ?</h3>
<a href="<?= $_url ?>tagihan/delete/<?= $_id ?>/yes" class="button primary">Yes</a>
<a href="<?= $_url ?>tagihan<?= $_id ?>" class="button danger">No</a>