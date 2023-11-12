<?php
$check = mysqli_query($koneksi,"SELECT kode_tagihan.keterangan,tagihan_mahasiswa.* FROM tagihan_mahasiswa
                                LEFT JOIN kode_tagihan ON kode_tagihan.kode_bayar=tagihan_mahasiswa.jenis_bayar
                                WHERE tagihan_mahasiswa.id_tagihan='$_id'");
$arr = mysqli_fetch_array($check);
$kon = $arr['konsentrasi_id'];
$ang = $arr['angkatan_id'];

?>
<h1>
<a href="<?= $_url ?>tagihan" class="nav-button transform"><span></span></a>
List Tagihan
</h1>
<h3>Daftar Sudah Bayar Tagihan <?= $arr['keterangan'] ?>, Angsuran/Semester : <?= $arr['semester'] ?></h3>
<div class="container"> 
<table class="table striped hovered border bordered">
	<thead>
		<tr>
			<th>No</th>
			<th>Nim</th>
			<th>Nama</th>
			<th>Status</th>
			<!--<th>Nominal Biaya</th>-->
			<!--<th>Aksi</th>-->
		</tr>
	</thead>
	<tbody>

	<?php
	$load = mysqli_query($koneksi,"SELECT * FROM student_mahasiswa WHERE konsentrasi_id='$kon' AND angkatan_id='$ang'");
		$no=1;
		if (mysqli_num_rows($load) > 0):
			while($field1 = mysqli_fetch_array($load)):
	?>
		<tr>
			<td><?= $no++ ?></td>
			<td><?= $field1['nim'] ?></td>
		    <td><?= $field1['nama'] ?></td>
		    <td><?php
		    $cek = mysqli_query($koneksi,"SELECT * FROM proses_transaksi WHERE id_tagihan='$_id' AND status_bayar='Y' AND nim='$field1[nim]'");
		    if(mysqli_num_rows($cek) > 0){
		        echo "<b>LUNAS</b>";
		    }else{
		        echo "<i>BELUM BAYAR</i>";
		    }
		    ?></td>
			<!--<td><?= rupiah($field1['amount']) ?></td>-->
			<!--<td>-->
			<!--	<div class="inline-block">-->
			<!--	    <li><a href="<?= $_url ?>tagihan/list/<?= $field1['id_tagihan'] ?>"><span class="mif-list"></span> List</a></li>-->
			<!--	    <li><a href="<?= $_url ?>tagihan/delete/<?= $field1['id_tagihan'] ?>"><span class="mif-cross"></span> Delete</a></li>-->
			<!--	</div>-->
			<!--</td>-->
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