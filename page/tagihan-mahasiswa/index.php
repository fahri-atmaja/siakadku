<?php
    $sql    ="SELECT * FROM student_mahasiswa WHERE nim='$_username'";
    $x      =mysqli_query($koneksi, $sql);
    $view   =mysqli_fetch_array($x);
    $angkatan = $view['angkatan_id'];
    $konsentrasi= $view['konsentrasi_id'];
    $status = $view['status_angsur'];
	$sql1 ="SELECT * FROM tagihan_mahasiswa 
	        WHERE angkatan_id='$angkatan' AND konsentrasi_id='$konsentrasi' AND status='$status'
	        AND id_tagihan NOT IN (SELECT id_tagihan FROM proses_transaksi WHERE nim='$_username')  ORDER BY tagihan_mahasiswa.id_tagihan ASC";
	$query1 = mysqli_query($koneksi, $sql1);
	
?>
<h1>
<a href="<?= $_url ?>" class="nav-button transform"><span></span></a>
TAGIHAN-MU
</h1>
<div class="container"> 
<div class="table-responsive">
            <table id="dtHorizontalExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th>No</th>
			<th>Jenis Bayar</th>
			<th>Semester</th>
			<th>Nominal Biaya</th>
			<th>Jatuh Tempo</th>
			<th>Aksi</th>
		</tr>
	</thead>
	<tbody>

	<?php
		$no=1;
		if (mysqli_num_rows($query1) > 0):
			while($field1 = mysqli_fetch_array($query1)):
	?>
		<tr>
			<td><?= $no++ ?></td>
			<td>
			    <?php 
			    $jenis_bayar = $field1['jenis_bayar'];
			    $select=mysqli_query($koneksi,"SELECT * FROM kode_tagihan WHERE kode_bayar='$jenis_bayar'");
			    $view = mysqli_fetch_array($select);
			    echo $view['keterangan'];
			    ?>
			</td>
			<td><?= 'Semester '. $field1['semester'] ?></td>
			<td><?= rupiah($field1['jumlah']) ?></td>
			<td><?= tgl_indo($field1['batas_bayar']) ?></td>
			<td>
				<div class="inline-block">
				    <button class="button dropdown-toggle">Aksi</button>
				    <ul class="list-group" data-role="dropdown">
						<li class="list-group-item"><a href="<?= $_url ?>tagihan-mahasiswa/proses/<?= $field1['id_tagihan'] ?>"> Proses</a></li>
						<!--<li><a href="<?= $_url ?>jadwal/edit/<?= $field1['jadwal_id'] ?>/<?= urlencode($field1['nama_makul']) ?>"><span class="mif-pencil"></span> Edit</a></li>-->
						<!--<li><a href="<?= $_url ?>dosen/list_absensi/<?= $field1['jadwal_id'] ?>/<?= urlencode($field1['nama_makul']) ?>"><span class="mif-pencil"></span> List Absen</a></li>-->
					
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

<!-- PROSES TAGIHAN -->

<?php

    $proses = mysqli_query($koneksi,"SELECT proses_transaksi.brivaNo, proses_transaksi.custCode, proses_transaksi.status_bayar, tagihan_mahasiswa.* FROM proses_transaksi
                                        LEFT JOIN tagihan_mahasiswa ON tagihan_mahasiswa.id_tagihan=proses_transaksi.id_tagihan
                                        WHERE nim='$_username' ORDER BY id_tagihan ASC");

?>


<h1>Proses Tagihan</h1>
<div class="container"> 
<div class="table-responsive">
            <table id="dtHorizontalExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th>No</th>
			<th>Briva No</th>
			<th>Customer Code</th>
			<th>Jenis Bayar</th>
			<th>Jumlah Bayar</th>
			<th>Jatuh Tempo</th>
			<th>Status</th>
		</tr>
	</thead>
	<tbody>

	<?php
		$no=1;
		if (mysqli_num_rows($proses) > 0):
			while($field = mysqli_fetch_array($proses)):
	?>
		<tr>
			<td><?= $no++ ?></td>
			<td><?= $field['brivaNo']; ?></td>
			<td><?= $field['custCode']; ?></td>
			<td>
			    <?php
			    $jenis_bayar = $field['jenis_bayar'];
			    $select=mysqli_query($koneksi,"SELECT * FROM kode_tagihan WHERE kode_bayar='$jenis_bayar'");
			    $view = mysqli_fetch_array($select);
			    echo $view['keterangan'].' Semester '. $field['semester']; 
			    ?>
			
			</td>
			<td><?= rupiah($field['jumlah']); ?></td>
			<td><?= tgl_indo($field['batas_bayar']) ?></td>
			<td>
			<?php 
		    if ($field['status_bayar']=='n'){
			    echo "<i>BELUM TERBAYAR</i>";
			}else{
			    echo "<b>LUNAS</b>";
			}
			?>
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