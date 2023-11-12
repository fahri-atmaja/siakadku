<h2><a href="<?= $_url ?>bayar_kpt" class="nav-button transform"><span></span></a>Monitoring KPT by NIM</h2>

<div class="container">
    <div class="row">
        <div class="col-md-8">
                <form method="POST">
                    <div class="form-group">
                        <input type="number" class="form-control" name="nim">
                        <span>masukan nim angkatan pengguna KPT</span>
                    </div>
                        <button type="submit" name="submit" class="btn btn-primary">Search</button>
                </form>
        </div>
    </div>
</div>
<?php
if($_POST['nim']){
    $nim = $_POST['nim'];
    $load = mysqli_query($koneksi,"SELECT student_mahasiswa.nama,push_kpt.* FROM push_kpt
                                    LEFT JOIN student_mahasiswa ON student_mahasiswa.nim=push_kpt.nim
                                    WHERE push_kpt.nim = '$nim'");
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
                	$no=1;
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
<?php
}
?>