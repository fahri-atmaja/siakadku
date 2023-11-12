<?php
    $sql    ="SELECT * FROM student_mahasiswa WHERE nim='$_username'";
    $x      =mysqli_query($koneksi, $sql);
    $view   =mysqli_fetch_array($x);
    $angkatan = $view['angkatan_id'];
    $konsentrasi= $view['konsentrasi_id'];
    $status = $view['status_angsur'];
    $beasiswa = $view['beasiswa'];
	$sql1 ="SELECT * FROM tagihan_mahasiswa 
	        WHERE angkatan_id='$angkatan' AND konsentrasi_id='$konsentrasi' AND status='$status'
	        AND id_tagihan NOT IN (SELECT id_tagihan FROM proses_transaksi WHERE nim='$_username')  ORDER BY tagihan_mahasiswa.semester ASC";
	$query1 = mysqli_query($koneksi, $sql1);
	$loadbpd = mysqli_query($koneksi,"SELECT * FROM bpd_jateng WHERE nim='$_username' AND kode_bayar='01' AND status='n'");
	$cek = mysqli_num_rows($loadbpd);
	if ($cek > 0){
	    echo "<script>window.alert('KONFIRMASI PEMBAYARAN SPI ANDA!')
		    window.location.href='{$_url}transaksi/konfirmasi'</script>";
	}
// 	if ($angkatan < 17){
// 	    echo "<script>window.alert('MAAF ANDA TIDAK DIIJINKAN AKSES!')
// 		    window.location.href='{$_url}'</script>";
// 	}
// 	if ($beasiswa==1){
// 	    echo "<script>window.alert('Anda Mahasiswa Beasiswa!')
// 		    window.location.href='{$_url}'</script>";
// 	}
// echo "<script>window.alert('UPDATE SIAKAD! TONTON DULU')
// window.open('https://youtu.be/OeTy6nwqDyo', '_blank')</script>";
?>
<br>
<h1>
<a href="<?= $_url ?>" class="nav-button transform"><span></span></a>
TAGIHAN-MU
</h1>
<div class="container"> 
<span><b>PENTING!! </b><br>
1. <u>Pastikan metode dan nominal pembayaran anda sudah benar antara kelas reguler dan karyawan.</u> <br>
2. <u>Pastikan Nomor BRIVA yang akan dibayarkan tidak sama dengan Nomor BRIVA yang sudah dibayarkan.</u> <br>
3. <u>Perhatikan tanggal jatuh tempo untuk menghindari denda.</u> <br>
4. <u>Jangan PROSES tagihan jika belum berniat membayar karena ada Masa Berlaku tagihan tsb.</u> <br>
5. <u>Simpan bukti transfer baik-baik dan jangan lupa untuk melakukan verifikasi tagihan yang sudah dibayarkan</u><br>
6. <u>Silahkan tonton video tutorial terbaru di sini -> <a href="https://youtu.be/OeTy6nwqDyo" target="_BLANK">Video Update Terbaru</a></u>
<div class="table-responsive">
            <table id="dtHorizontalExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th>No</th>
			<th>Jenis Bayar</th>
			<th>Semester / Angsuran</th>
			<th>Nominal Biaya</th>
			<th>Nominal Dibayar</th>
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
			<td><?php if ($status==0){
			echo 'Semester '. $field1['semester'];
			}else{
			echo 'Angsuran '. $field1['semester'];
			}?></td>
			<td><?= rupiah($field1['jumlah']) ?></td>
			<td>
			    <?php
			    $load = mysqli_query($koneksi,"SELECT * FROM bpd_jateng WHERE nim='$_username' AND kode_bayar='01' AND status='y'");
			    $v    = mysqli_fetch_array($load);
			    if($view['kode_bayar']=='01'){
			        $hutang = $field1['jumlah']-$v['jumlah_bayar'];
			        echo rupiah($hutang);
			    }else{
			        echo rupiah($field1['jumlah']);
			    }
			    ?>
			</td>
			<td><?= tgl_indo($field1['batas_bayar']) ?></td>
			<td>
				    <!--<button class="button dropdown-toggle">Aksi</button>-->
				    <!--<ul class="list-group" data-role="dropdown">-->
						<button type="button" class="btn btn-primary"><a href="<?= $_url ?>transaksi/proses/<?= $field1['id_tagihan'] ?>"><span style="color:white;">PROSES</span></a></button>
						<!--<li><a href="<?= $_url ?>jadwal/edit/<?= $field1['jadwal_id'] ?>/<?= urlencode($field1['nama_makul']) ?>"><span class="mif-pencil"></span> Edit</a></li>-->
						<!--<li><a href="<?= $_url ?>dosen/list_absensi/<?= $field1['jadwal_id'] ?>/<?= urlencode($field1['nama_makul']) ?>"><span class="mif-pencil"></span> List Absen</a></li>-->
					
				    <!--</ul>-->
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

    $proses = mysqli_query($koneksi,"SELECT proses_transaksi.id_bayar, proses_transaksi.brivaNo, proses_transaksi.amount, proses_transaksi.custCode, proses_transaksi.status_bayar, proses_transaksi.expiredDate, tagihan_mahasiswa.* FROM proses_transaksi
                                        LEFT JOIN tagihan_mahasiswa ON tagihan_mahasiswa.id_tagihan=proses_transaksi.id_tagihan
                                        WHERE nim='$_username' ORDER BY id_tagihan ASC");

?>


<h1>Proses Tagihan</h1>
<span><b>PENTING!!</b><br>Setelah melakukan pembayaran wajib untuk me-refresh proses tagihan dihari yang sama!!</span>
<div class="container"> 
<div class="table-responsive">
            <table id="dtHorizontalExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th>No</th>
			<th>Nomor BRI Virtual Account</th>
			<th>Jenis Bayar</th>
			<th>Jumlah Bayar</th>
			<th>Jatuh Tempo</th>
			<th>Status</th>
			<th>Aksi</th>
		</tr>
	</thead>
	<tbody>

	<?php
		$no=1;
		if (mysqli_num_rows($proses) > 0):
			while($field = mysqli_fetch_array($proses)):
	?>
		<tr>
		    <?php
		    $now = date("Y-m-d");
				        $exp = substr($field['expiredDate'],0,10);
				        ?>
			<td><?= $no++ ?></td>
			<td><?php echo $field['brivaNo']; echo $field['custCode']; ?></td>
			<td>
			    <?php
			    $jenis_bayar = $field['jenis_bayar'];
			    $select=mysqli_query($koneksi,"SELECT * FROM kode_tagihan WHERE kode_bayar='$jenis_bayar'");
			    $view = mysqli_fetch_array($select);
			    echo $view['keterangan'];
			    if ($status==0){
    			echo ' Semester '. $field['semester'];
    			}else{
    			echo ' Angsuran '. $field['semester'];
    			}
			    ?>
			
			</td>
			<td><?= rupiah($field['amount']); ?></td>
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
			<td>
				<div class="inline-block">
				    <?php
				        if($field['status_bayar']=='n'):
				        ?>
				  <!--  <button class="button mini-button dropdown-toggle">Aksi</button>-->
				  <!--  <ul class="split-content d-menu" data-role="dropdown">-->
						<!--<li><a href="<?= $_url ?>transaksi/refresh/<?= urlencode($field['custCode']) ?>"><span class="mif-near-me"></span>Refresh</a></li>-->
						<!--<li><a href="<?= $_url ?>transaksi/invoice/<?= urlencode($field['custCode']) ?>"><span class="mif-near-me"></span>Invoice</a></li>-->
						
						
						
						<?php
						
						if($now > $exp){
						    echo '<a href="'.$_url.'transaksi/verifikasi/'.$field[custCode].'"><button type="button" class="btn btn-primary">Verifikasi</button></a>';
						    echo '<a href="'.$_url.'transaksi/delete/'.$field[custCode].'"><button type="button" class="btn btn-danger">Delete</button></a><br>
						    <span>NO BRIVA EXPIRED!!<br>VERIFIKASI JIKA SUDAH MEMBAYAR</span>';
						}else{
						    echo '<a href="'.$_url.'transaksi/verifikasi/'.$field[custCode].'"><button type="button" class="btn btn-primary">Verifikasi</button></a>';
						    echo '<a href="'.$_url.'transaksi/invoice/'.$field[custCode].'"><button type="button" class="btn btn-success">Invoice</button></a>';
						    echo '<a href="'.$_url.'transaksi/delete/'.$field[custCode].'"><button type="button" class="btn btn-danger">Delete</button></a><br>';
						}
						?>
						<!--<a href="<?= $_url ?>transaksi/delete/<?= urlencode($field['custCode']) ?>"><button type="button" class="btn btn-danger">Delete</button></a>-->
						<?php
						else:
						?>
						<a target="_BLANK" href="<?= $_url ?>transaksi/invoice-pembayaran/<?= $field['id_bayar'] ?>"><button type="button" class="btn btn-info">Faktur</button></a>
						<?php
						endif;
						?>
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
<span>Jika mengalami kendala silahkan hubungi <a href="https://wa.me/6281328375307">TIM SIAKAD UNDARIS</a></span>