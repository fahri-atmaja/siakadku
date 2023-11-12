<?php
$querya = mysqli_query($koneksi, "SELECT * FROM student_mahasiswa WHERE nim='{$_id}'");
$field = mysqli_fetch_array($querya);
extract($field);

$query = mysqli_query($koneksi, "UPDATE akademik_krs SET accept=1 WHERE nim='{$_id}' AND konversi='$semester'");
$ququ  = mysqli_query($koneksi, "UPDATE student_mahasiswa SET aktif_krs='t' WHERE nim='{$_id}'");

header("location:{$_url}krs/krs-mhs/{$_id}");