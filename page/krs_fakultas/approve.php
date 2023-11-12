<?php

$query = mysqli_query($koneksi, "UPDATE akademik_krs SET accept=1 WHERE nim='{$_id}' AND konversi='{$_params[1]}'");
$ququ  = mysqli_query($koneksi, "UPDATE student_mahasiswa SET aktif_krs='t' WHERE nim='{$_id}'");
header("location:{$_url}krs_fakultas");