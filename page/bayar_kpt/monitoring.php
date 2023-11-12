
<h2><a href="<?= $_url ?>bayar_kpt" class="nav-button transform"><span></span></a>Monitoring Pembayaran KPT</h2>

<div class="container">
    <div class="row">
        <div class="col-md-8">
                <form method="POST">
                    <div class="form-group">
                        <input type="date" class="form-control" name="date">
                    </div>
                        <button type="submit" name="submit" class="btn btn-primary">Monitoring</button>
                </form>
        </div>
    </div>
</div>

<?php
if($_POST['date']){
    $format = $_POST['date'];
    $now = date('Y-m-d',strtotime($format));
    echo $now;
    $load = mysqli_query($koneksi,"SELECT student_mahasiswa.nama,push_kpt.* FROM push_kpt
                                    LEFT JOIN student_mahasiswa ON student_mahasiswa.nim=push_kpt.nim
                                    WHERE push_kpt.tanggal='$now'");
}
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
                <div class="table-responsive">
                    <table id="dtHorizontalExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                	<thead>
                		<tr>
                			<th>NIM</th>
                			<th>Nama</th>
                			<th>Semester</th>
                			<th>Angsuran Ke</th>
                			<th>Smt bayar</th>
                			<th>Nominal Dibayar</th>
                			<th>Item</th>
                			<th>Tanggal Bayar</th>
                			<th>User Id</th>
                			
                		</tr>
                	</thead>
                	<tbody>
                
                	<?php
                		if (mysqli_num_rows($load) > 0):
		            	while($datas = mysqli_fetch_array($load)):
                	?>
                		<tr>
                			
                			<td><?= $datas['nim']; ?></td>
                			<td><?= $datas['nama']; ?></td>
                			<td><?= $datas['smt']; ?></td>
                			<td><?= $datas['angsuran_ke']; ?></td>
                			<td><?= $datas['smt_bayar']; ?></td>
                			<td><?= $datas['nominal']; ?></td>
                			<td><?= $datas['item']; ?></td>
                			<td><?= $datas['tanggal']; ?></td>
                			<td><?= $datas['user']; ?></td>
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