<?php

$query = mysqli_query($koneksi, "UPDATE akademik_krs SET accept=0 WHERE nim='{$_id}' and konversi='{$_params[1]}'");
$ququ  = mysqli_query($koneksi, "UPDATE student_mahasiswa SET aktif_krs='y' WHERE nim='{$_id}'");

header("location:{$_url}dosen/krs-mhs/{$_id}/{$_params[1]}");