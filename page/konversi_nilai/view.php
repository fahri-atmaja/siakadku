<?php
$querya = mysqli_query($koneksi, "SELECT student_mahasiswa.*, student_angkatan.keterangan,akademik_konsentrasi.nama_konsentrasi as nama_konsentrasi FROM student_mahasiswa 
	LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=student_mahasiswa.konsentrasi_id
	LEFT JOIN student_angkatan ON student_angkatan.angkatan_id=student_mahasiswa.angkatan_id
	WHERE nim='{$_id}'");
$field = mysqli_fetch_array($querya);
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h2><a href="<?= $_url ?>konversi_nilai" class="nav-button transform"><span></span></a>Nilai Konversi</h2>
            <div class="grid">
            <div class="col-md-6">
                <div class="row cells2">
                	<div class="cell">
                		<label>NIM</label>
                		<div class="form-group">
                			<?= $field['nim']; ?>
                		</div>
                	</div>
                	
                	<div class="cell">
                		<label>Nama</label>
                		<div class="form-group">
                			<?= $field['nama']; ?>
                		</div>
                	</div>
                </div>
                <div class="row cells2">
                	<div class="cell">
                		<label>Tahun Angkatan</label>
                		<div class="form-group">
                			<?= $field['keterangan']; ?>
                		</div>
                	</div>
                
                	<div class="cell">
                		<label>Program Studi</label>
                		<div class="form-group">
                			<?= $field['nama_konsentrasi']; ?>
                		</div>
                	</div>
                </div>
            </div>
            </div>
            <div class="col-md-6">
            <a target="_BLANK" href="<?= $_url ?>khs/laporan-khs/<?= $_id ?>/<?= $sem ?>" class="button success">Cetak / Detail</a>
<table id="dtHorizontalExample" class="table table-striped table-bordered table-sm" cellspacing="0"
  width="100%">
	<thead>
		<tr>
			<th>No</th>
			<th>Matakuliah</th>
			<th>Nilai Akhir</th>
			<th>Bobot</th>
			<th>Grade</th>
		</tr>
	</thead>
	<tbody>

	<?php
	$no=1;
	    $query = mysqli_query($koneksi,"SELECT * FROM nilai_konversi WHERE nim='$_id'");
		if (mysqli_num_rows($query) > 0):
			while($f = mysqli_fetch_array($query)):
			    
	?>
		<tr>
			<td><?= $no++ ?></td>
			<td><?= $f['mapel'] ?></td>
			<td><?= $f['nilai'] ?></td>
			<td><?= $f['bobot'] ?></td>
			<td><?= $f['grade'] ?></td>
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
    </div>
</div>