<div class="container-fluid">
    <div class="row">
    <h3><a href="<?= $_url ?><?= in_array($_access, array('fakultas')) ? '' : '' ?>" class="nav-button transform"><span></span></a>Daftar Dosen Fakultas</h3>
        <div class="col-md-6">
            <?php
            $load = mysqli_query($koneksi,  "SELECT * FROM app_dosen
                                            LEFT JOIN akademik_jadwal_kuliah ON akademik_jadwal_kuliah.dosen_id=app_dosen.dosen_id
                                            LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=akademik_jadwal_kuliah.konsentrasi_id
                                            WHERE akademik_konsentrasi.nama_konsentrasi='$_username' GROUP BY nama_lengkap");
            ?>
<table id="dtHorizontalExample" class="table table-striped table-bordered table-sm" cellspacing="0"
  width="100%">
	<thead>
		<tr>
		    <th>No.</th>
		    <th>NIDN</th>
		    <th>Nama Lengkap</th>
		    <th>Aksi</th>
		</tr>
	</thead>
	<tbody>
	<?php
	    $no=1;
		if (mysqli_num_rows($load) > 0):
			while($field = mysqli_fetch_array($load)):
	?>
	<tr>
	        <td><?= $no++ ?></td>
		    <td><?= $field['nidn'] ?></td>
			<td><?= $field['nama_lengkap'] ?></td>
			<td>
			<div class="inline-block">
				    <button class="button mini-button dropdown-toggle">Aksi</button>
				    <ul class="split-content d-menu" data-role="dropdown">
		
					<li><a href="<?= $_url ?>nilai_fakultas/makul_dosen/<?= $field['nidn'] ?>" class="place-right"><span class="mif-checkmark">Lihat Makul</span></a></li>
					</ul>
			</div>
			</td>
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