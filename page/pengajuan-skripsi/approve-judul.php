<?php
	if ($_access == 'mahasiswa' && $_id != $_username) {
		header("location:{$_url}krs/view/{$_username}");
	}
$query = mysqli_query($koneksi, "UPDATE pengajuan_skripsi SET status=1 WHERE nim='{$_id}'");

header("location:{$_url}dosen/lihatnilai");