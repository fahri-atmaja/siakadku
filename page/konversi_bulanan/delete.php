<?php
	if ($_access == 'mahasiswa' && $_id != $_username) {
		header("location:{$_url}krs/view/{$_username}");
	}
	if ($_access == 'dosen' && $_id != $_username) {
		header("location:{$_url}");
	}
	if ($_access == 'fakultas' && $_id != $_username) {
		header("location:{$_url}");
	}
	if (empty($_access)) {
		header("location:{$_url}");
	}

if (isset($_params[1]) && $_params[1] == 'yes') {
$query = mysqli_query($koneksi, "DELETE FROM angsuran_konversi WHERE id_angsur='{$_id}'");

	if ($query) {
		echo "<script>$.Notify({
		    caption: 'Success',
		    content: 'Data Biaya Berhasil Dihapus',
			type: 'success'
		});
		setTimeout(function(){ window.location.href='{$_url}konversi_bulanan/biaya_angsuran'; }, 2000);
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
<h3>Apakah anda yakin akan menghapus ?></h3>
<a href="<?= $_url ?>konversi_bulanan/delete/<?= $_id ?>/yes" class="button primary">Yes</a> <a href="<?= $_url ?>konversi_bulanan/biaya_angsuran" class="button danger">No</a>