<div class="container-fluid">
    <div class="row">
        <h3><a href="<?= $_url ?>nilai_fakultas/makul_dosen/<?= $_params[1] ?>" class="nav-button transform"><span></span></a>Nilai Mahasiswa</h3>
        <div class="col-md-6">
            <?php
            $makul = mysqli_query($koneksi,"SELECT akademik_jadwal_kuliah.*, makul_matakuliah.nama_makul FROM akademik_jadwal_kuliah
                                            LEFT JOIN makul_matakuliah ON makul_matakuliah.makul_id=akademik_jadwal_kuliah.makul_id
                                            WHERE akademik_jadwal_kuliah.jadwal_id='$_id'");
            $field = mysqli_fetch_array($makul);
            ?>
            <h4>Makul : <b><?= $field['nama_makul'] ?></b></h4>
            <table id="dtHorizontalExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
        	<thead>
        		<tr>
        		    <th>No.</th>
        		    <th>NIM</th>
        		    <th>Nama</th>
        		    <th>Nilai Akhir</th>
        		    <th>Bobot</th>
        		    <th>Grade</th>
        		</tr>
        	</thead>
        	<?php
        	$load = mysqli_query($koneksi,"SELECT akademik_khs.*, akademik_krs.nim, student_mahasiswa.nama FROM akademik_khs
        	                                LEFT JOIN akademik_krs ON akademik_krs.krs_id=akademik_khs.krs_id
        	                                LEFT JOIN student_mahasiswa ON student_mahasiswa.nim=akademik_krs.nim
        	                                WHERE akademik_krs.jadwal_id='$_id'");
        // 	$load = mysqli_query($koneksi,"SELECT * FROM akademik_khs WHERE krs_id='Q007522'");
        	?>
        	<tbody>
        	    	<?php
                		$no=1;
                		if (mysqli_num_rows($load) > 0):
                			while($field1 = mysqli_fetch_array($load)):
                	?>
		<tr>
			<td><?= $no++ ?></td>
			<td><?= $field1['nim'] ?></td>
			<td><?= $field1['nama'] ?></td>
			<td><?= round($field1['nilai_akhir'],2) ?></td>
			<td><?= $field1['bobot'] ?></td>
			<td><?= $field1['grade'] ?></td>
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