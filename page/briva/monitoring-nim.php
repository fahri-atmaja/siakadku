<h2><a href="<?= $_url ?>briva" class="nav-button transform"><span></span></a>Monitoring by NIM</h2>

<div class="container">
    <div class="row">
        <div class="col-md-8">
                <form method="POST">
                    <div class="form-group">
                        <input type="number" class="form-control" name="nim">
                        <span>masukan nim angkatan pengguna briva</span>
                    </div>
                        <button type="submit" name="submit" class="btn btn-primary">Search</button>
                </form>
        </div>
    </div>
</div>
<?php
if($_POST['nim']){
    $nim = $_POST['nim'];
    $load = mysqli_query($koneksi,"SELECT * FROM proses_transaksi WHERE nim = '$nim' ORDER BY id_bayar ASC");
    ?>
    <div class="container">
    <div class="row">
        <div class="col-md-12">
                <div class="table-responsive">
                    <table id="dtHorizontalExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                	<thead>
                		<tr>
                			<th>No.</th>
                			<th>NIM</th>
                			<th>Nama</th>
                			<th>No. Briva</th>
                			<th>Jenis Tagihan</th>
                			<th>Nominal Dibayar</th>
                			<th>Tanggal Bayar</th>
                			<th>Status</th>
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
                			<td><?= $field['nim']; ?></td>
                			<td><?= $field['nama']; ?></td>
                			<td><?= $field['brivaNo']; ?><?= $field['custCode']; ?></td>
                			<td><?php
                			$id= $field['id_tagihan'];
                			$loadid = mysqli_query($koneksi,"SELECT * FROM tagihan_mahasiswa WHERE id_tagihan=$id");
                			$f = mysqli_fetch_array($loadid);
                			$jenis_bayar = $f['jenis_bayar'];
                			$loadkode = mysqli_query($koneksi,"SELECT * FROM kode_tagihan WHERE kode_bayar=$jenis_bayar");
                			$ff = mysqli_fetch_array($loadkode);
                			echo $ff['keterangan'];
                            ?></td>
                			<td><?= rupiah($field['amount']); ?></td>
                			<td><?php $tgl = date('Y-m-d',strtotime($field['tanggal_bayar'])); echo tgl_indo($tgl); ?></td>
                			<td><?php if ($field['status_bayar']==Y){
                			        echo "<b>LUNAS</b>";   
                			}else{
                			    echo "BELUM TERBAYAR";
                			}
                			        ?></td>
                			<!--<th><a href="update/<?= $datas['custCode']; ?>"><button class="button btn-primary">Update</button></a></th>-->
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
<?php
}
?>