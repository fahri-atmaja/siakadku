<?php
// 	header("Content-type: application/vnd-ms-excel");
// 	header("Content-Disposition: attachment; filename=mahasiswa.xls");
?>
<script>
$(document).ready(function () {
$('#dtHorizontalExample').DataTable({
"scrollX": true
});
$('.dataTables_length').addClass('bs-select');
});
</script>

<style>
    .dtHorizontalExampleWrapper {
max-width: 600px;
margin: 0 auto;
}
#dtHorizontalExample th, td {
white-space: nowrap;
}

table.dataTable thead .sorting:after,
table.dataTable thead .sorting:before,
table.dataTable thead .sorting_asc:after,
table.dataTable thead .sorting_asc:before,
table.dataTable thead .sorting_asc_disabled:after,
table.dataTable thead .sorting_asc_disabled:before,
table.dataTable thead .sorting_desc:after,
table.dataTable thead .sorting_desc:before,
table.dataTable thead .sorting_desc_disabled:after,
table.dataTable thead .sorting_desc_disabled:before {
bottom: .5em;
}
</style>
<?php
	$koneksi = mysqli_connect("localhost","smilefoo_siakad","Sina_atmaja666","smilefoo_siakad");
	$sql 	 = "SELECT student_mahasiswa.*, student_angkatan.keterangan, app_agama.keterangan as namaagama, akademik_konsentrasi.nama_konsentrasi, akademik_kelas.nama_kelas FROM student_mahasiswa 
				LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=student_mahasiswa.konsentrasi_id
				LEFT JOIN student_angkatan ON student_angkatan.angkatan_id=student_mahasiswa.angkatan_id
				LEFT JOIN akademik_kelas ON akademik_kelas.id_kelas=student_mahasiswa.id_kelas
				LEFT JOIN app_agama ON app_agama.agama_id=student_mahasiswa.agama_id
				WHERE akademik_konsentrasi.nama_konsentrasi='$_username'
				ORDER BY akademik_kelas.nama_kelas ASC, student_mahasiswa.nim ASC";
	$query 	 = mysqli_query($koneksi, $sql);
?>
<div class="table-responsive">
<table id="dtHorizontalExample" class="table table-striped table-bordered table-sm" cellspacing="0"
  width="100%">
    <thead>
		<tr>
			<th>NIK</th>
			<th>NIM</th>
			<th>Nama</th>
			<th>Agama</th>
			<th>Tempat Lahir</th>
			<th>Tanggal Lahir</th>
			<th>Jenis Kelamin</th>
			<th>Alamat</th>
			<th>Program Studi</th>
			<th>Semester</th>
			<th>Tahun Masuk</th>
			<th>NIK Ibu</th>
			<th>Nama Ibu</th>
			<th>NIK Ayah</th>
			<th>Nama Ayah</th>
			<th>No HP Orang Tua</th>
			<th>Pekerjaan Ibu</th>
			<th>Pekerjaan Ayah</th>
			<th>Alamat Ayah</th>
			<th>Alamat Ibu</th>
			<th>Penghasilan Ayah</th>
			<th>Penghasilan Ibu</th>
			<th>Nama Sekolah</th>
			<th>Telpon Sekolah</th>
			<th>Alamat Sekolah</th>
			<th>Jurusan Sekolah</th>
			<th>Asal Kampus</th>
			<th>Telpon Asal Kampus</th>
			<th>Alamat Asal Kampus</th>
			<th>Jurusan Asal Kampus</th>
			<th>Tahun Lulus Asal Kampus</th>
			<th>Institusi Yang Mengusulkan</th>
			<th>Telpon Institusi</th>
			<th>Alamat Institusi</th>
			<th>Instansi Yang Mengusulkan</th>
			<th>Telpon Instansi</th>
			<th>Alamat Instansi</th>
			<th>Mulai Instansi</th>
			<th>Selesai Instansi</th>
			<th></th>
		</tr>
</thead>
	<?php

		if (mysqli_num_rows($query) > 0):
			while($field = mysqli_fetch_array($query)):
	?>
	<tbody>
	<tr>
			<td><?= $field['nikmhs'] ?></td>
			<td><?= $field['nim'] ?></td>
			<td><?= $field['nama'] ?></td>
			<td><?= $field['namaagama'] ?></td>
			<td><?= $field['tempat_lahir'] ?></td>
			<td><?= $field['tanggal_lahir'] ?></td>
			<td><?= $field['gender']==1?'laki-laki':'perempuan'; ?></td>
			<td><?= $field['alamat'] ?></td>
			<td><?= $field['nama_konsentrasi'] ?></td>
			<td><?= $field['semester'] ?></td>
			<td><?= $field['keterangan'] ?></td>
			<td><?= $field['nikibu'] ?></td>
			<td><?= $field['nama_ibu'] ?></td>
			<td><?= $field['nikayah'] ?></td>
			<td><?= $field['nama_ayah'] ?></td>
			<td><?= $field['no_hp_ortu'] ?></td>
			<td><?= $field['pekerjaan_id_ibu']==1?'TIDAK BEKERJA':'BEKERJA'; ?></td>
			<td><?= $field['pekerjaan_id_ayah']==1?'TIDAK BEKERJA':'BEKERJA'; ?></td>
			<td><?= $field['alamat_ayah'] ?></td>
			<td><?= $field['alamat_ibu'] ?></td>
			<td><?= $field['penghasilan_ayah'] ?></td>
			<td><?= $field['penghasilan_ibu'] ?></td>
			<td><?= $field['sekolah_nama'] ?></td>
			<td><?= $field['sekolah_telpon'] ?></td>
			<td><?= $field['sekolah_alamat'] ?></td>
			<td><?= $field['sekolah_jurusan'] ?></td>
			<td><?= $field['kampus_nama'] ?></td>
			<td><?= $field['kampus_telpon'] ?></td>
			<td><?= $field['kampus_alamat'] ?></td>
			<td><?= $field['kampus_jurusan'] ?></td>
			<td><?= $field['kampus_tahun_lulus'] ?></td>
			<td><?= $field['institusi_nama'] ?></td>
			<td><?= $field['institusi_telpon'] ?></td>
			<td><?= $field['institusi_alamat'] ?></td>
			<td><?= $field['instansi_nama'] ?></td>
			<td><?= $field['instansi_telpon'] ?></td>
			<td><?= $field['instansi_alamat'] ?></td>
			<td><?= $field['instansi_mulai'] ?></td>
			<td><?= $field['instansi_sampai'] ?></td>
		</tr>
	<?php
			endwhile;
		else:
	?>
		<tr>
			<td colspan="6">
			Data tidak ditemukan
			</td>
		</tr>
	<?php
		endif;
	?>
</tbody>		
</table>
</div>