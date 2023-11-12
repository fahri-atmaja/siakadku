<?php

if (isset($_params[3]) && $_params[3] == 'yes') {
	$query = mysqli_query($koneksi, "DELETE FROM keuangan_pembayaran_detail WHERE pembayara_detail_id='{$_id}' AND nim='{$_params[1]}'");
	if ($query) {
		echo "<script>$.Notify({
		    caption: 'Success',
		    content: 'Data Transaksi Berhasil Dihapus',
			type: 'success'
		});
		setTimeout(function(){ window.location.href='{$_url}keuangan?cari=$_params[1]'; }, 2000);
		</script>";
	} else {
		echo "<script>$.Notify({
		    caption: 'Failed',
		    content: 'Data Transaksi Gagal Dihapus',
		    type: 'alert'
		});</script>";
	}
}
?>

<h1>Hapus Transaksi</h1>
<h3>Apakah anda yakin akan Transaksi <?= urldecode($_params[2]) ?>?</h3>
<a href="<?= $_url ?>keuangan/delete/<?= $_id ?>/<?= $_params[1] ?>/<?= $_params[2] ?>/yes" class="button primary">Yes</a>
<a href="<?= $_url ?>keuangan" class="button danger">No</a>