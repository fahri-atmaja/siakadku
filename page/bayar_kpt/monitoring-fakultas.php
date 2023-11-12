<h2><a href="<?= $_url ?>briva" class="nav-button transform"><span></span></a>Monitoring by Fakultas</h2>

<div class="container">
    <div class="row">
        <div class="col-md-8">
                <form method="POST">
                    <div class="form-group">
                        <span>Pilih Fakultas</span>
                        <select name="fakultas" class="form-control" require>
                            <?php
                            $loadfak = mysqli_query($koneksi,"SELECT * FROM akademik_konsentrasi");
                            while($view = mysqli_fetch_array($loadfak)){
                                echo "<option value='". $view['konsentrasi_id'] ."'>". $view['nama_konsentrasi'] ."</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <span>Pilih Angkatan</span>
                        <select name="angkatan" class="form-control" require>
                            <?php
                            $loadfak = mysqli_query($koneksi,"SELECT * FROM student_angkatan");
                            while($view = mysqli_fetch_array($loadfak)){
                                echo "<option value='". $view['angkatan_id'] ."'>". $view['keterangan'] ."</option>";
                            }
                            ?>
                        </select>
                    </div>
                        <button type="submit" name="submit" class="btn btn-primary">Search</button>
                </form>
        </div>
    </div>
</div>
<?php
if($_POST['fakultas']){
    $kon = $_POST['fakultas'];
    $ang = $_POST['angkatan'];
    $load = mysqli_query($koneksi,"SELECT * FROM proses_transaksi
                                  LEFT JOIN student_mahasiswa ON student_mahasiswa.nim=proses_transaksi.nim
                                    WHERE student_mahasiswa.konsentrasi_id = '$kon' AND student_mahasiswa.angkatan_id = '$ang'
                                    ORDER BY proses_transaksi.nim ASC");
    ?>
    <div class="container">
        <div class = "row">
            <div class="col-md-12">
                <?php
                $loadfakultas = mysqli_query($koneksi,"SELECT * FROM akademik_konsentrasi WHERE konsentrasi_id='$kon'");
                $textf = mysqli_fetch_array($loadfakultas);
                
                $loadangkatan = mysqli_query($koneksi,"SELECT * FROM student_angkatan WHERE angkatan_id='$ang'");
                $texta = mysqli_fetch_array($loadangkatan);
                ?>
                <h3>Jurusan  : <?= $textf['nama_konsentrasi']; ?></h3>
                <h3>Angkatan : <?= $texta['keterangan']; ?></h3>
            </div>
        </div>
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