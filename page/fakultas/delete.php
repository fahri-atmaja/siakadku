<?php

if (isset($_params[2]) && $_params[2] == 'yes') {
$query = mysqli_query($koneksi, "DELETE FROM akademik_jadwal_kuliah WHERE jadwal_id='{$_id}'");

	if ($query) {
		echo "<script>$.Notify({
		    caption: 'Success',
		    content: 'Data Jadwal Berhasil Dihapus',
			type: 'success'
		});
		setTimeout(function(){ window.location.href='{$_url}fakultas/jadwal'; }, 2000);
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

<h1>Hapus Mahasiswa</h1>
<h3>PERINGATAN!!
    Apakah anda yakin akan menghapus jadwal dengan id <?= $_id ?> yang bernama <?= urldecode($_params[1]) ?>?<br>
    Menghapus jadwal yang sudah berjalan akan mempengaruhi KRS mahasiswa !!</h3>
<a href="<?= $_url ?>fakultas/delete/<?= $_id ?>/<?= $_params[1] ?>/yes" class="button primary">Yes</a> <a href="<?= $_url ?>fakultas/jadwal" class="button danger">No</a>