<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <H2><a href="<?= $_url ?>" class="nav-button transform"><span></span></a>Daftar Nilai Mahasiswa Konversi</H2>
            <div class="row">
            <div class="col-md-4">
                <label>Cari NIM Mahasiswa</label>
                <form action="#" method="GET">
                <input type="text" name="cari">&nbsp;<button class="button primary" type="submit">Cari</button>
                </form>
            <div class="col-md-4"><a href="<?= $_url ?>konversi_nilai/input"><button class="button success">Input Nilai</button></a></div>
                
                 <?php
if(isset($_GET['cari'])){
	$cari = $_GET['cari'];
	echo "<b>Hasil pencarian : ".$cari."</b>";
}
?>
<?php
if(isset($_GET['cari'])){
		$cari = $_GET['cari'];
                $load = mysqli_query($koneksi,"SELECT nilai_konversi.*, student_mahasiswa.nama, student_mahasiswa.status, akademik_konsentrasi.nama_konsentrasi, student_angkatan.keterangan
		                                FROM nilai_konversi
		                                LEFT JOIN student_mahasiswa ON student_mahasiswa.nim=nilai_konversi.nim
		                                LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=student_mahasiswa.konsentrasi_id
		                                LEFT JOIN student_angkatan ON student_angkatan.angkatan_id=student_mahasiswa.angkatan_id
		                                WHERE nilai_konversi.nim like '%".$cari."%'
		                                GROUP BY nim
		                                ORDER BY nim ASC");
}else{
    $load = mysqli_query($koneksi,"SELECT nilai_konversi.*, student_mahasiswa.nama, student_mahasiswa.status, akademik_konsentrasi.nama_konsentrasi, student_angkatan.keterangan
		                                FROM nilai_konversi
		                                LEFT JOIN student_mahasiswa ON student_mahasiswa.nim=nilai_konversi.nim
		                                LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=student_mahasiswa.konsentrasi_id
		                                LEFT JOIN student_angkatan ON student_angkatan.angkatan_id=student_mahasiswa.angkatan_id
		                                GROUP BY nim
		                                ORDER BY nim ASC");
}
                ?>
            </div>
            </div>
<table id="dtHorizontalExample" class="table table-striped table-bordered table-sm" cellspacing="0"
  width="100%">
    <thead>
		<tr>
		    <th>Tahun Angkatan</th>
			<th>NIM</th>
			<th>Nama</th>
			<th>Jurusan</th>
			<th>Aksi</th>
		</tr>
	</thead>
	<tbody>
	<?php
		if (mysqli_num_rows($load) > 0):
			while($field = mysqli_fetch_array($load)):
	?>
		<tr>
		    <td><?= $field['keterangan'] ?></td>
			<td><?= $field['nim'] ?></td>
			<td><?= $field['nama'] ?></td>
			<td><?= $field['nama_konsentrasi'] ?></td>
			<td>
			<div class="inline-block">
				    <button class="button mini-button dropdown-toggle">Aksi</button>
				    <ul class="split-content d-menu" data-role="dropdown">
		
					<li><a href="<?= $_url ?>konversi_nilai/view/<?= $field['nim']; ?>" class="place-right"><span class="mif-scope"> View Nilai </span></a></li>
					</ul>
			</div>
		</tr>
		
				
	<?php
			endwhile;
			else:
	?>
		<tr>
			<td colspan="4">
			Data tidak ditemukan
			</td>
		</tr>
	<?php
		endif;
	?>		
	</tbody>
    </table>
        </div>
    </div>
</div