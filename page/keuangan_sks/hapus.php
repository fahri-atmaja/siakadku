<?php

if (isset($_params[1]) && $_params[1] == 'yes') {
	$query = mysqli_query($koneksi, "DELETE FROM bayar_sks WHERE biaya_id='{$_id}'");

	if ($query) {
		echo "<script>$.Notify({
		    caption: 'Success',
		    content: 'Data Bayar SKS Berhasil Dihapus',
			type: 'success'
		});
		setTimeout(function(){ window.location.href='{$_url}keuangan_sks'; }, 1500);
		</script>";
	} else {
		echo "<script>$.Notify({
		    caption: 'Failed',
		    content: 'Data Bayar SKS Gagal Dihapus',
		    type: 'alert'
		});</script>";
	}
}
?>
<?php
$load = mysqli_query($koneksi,"SELECT * FROM bayar_sks WHERE biaya_id='{$_id}'");
$qq = mysqli_fetch_array($load);
?>
<h1>Hapus Data Pembayaran SKS<br>
Nim : <?= $qq['nim']; ?><br>
Jumlah SKS : <?= $qq['jumlah_sks']; ?><br>
Total Bayar : <?= $qq['jumlah_bayar']; ?><br>
Waktu Bayar : <?= $qq['tanggal_bayar']; ?></h1>
<h3>Apakah anda yakin akan menghapus ?</h3>
<a href="<?= $_url ?>keuangan_sks/hapus/<?= $_id ?>/yes" class="button primary">Yes</a>
<a href="<?= $_url ?>keuangan_sks/<?= $_id ?>" class="button danger">No</a>