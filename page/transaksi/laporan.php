<?php
$load = mysqli_query($koneksi,"SELECT * FROM proses_transaksi");
$f = mysqli_fetch_array($load);
?>
<div class="table-responsive">
<table id="dtHorizontalExample" class="table table-striped table-bordered table-sm" cellspacing="0"
  width="100%">
	<thead>
		<tr>
		    <th>NO</th>
			<th>NIM</th>
			<th>BRIVA NO</th>
			<th>BIAYA</th>
			<th>Dosen</th>
			<th>Disetujui</th>
			<th>Aksi</th>
		</tr>
	</thead>
	<tbody>
	<?php
		
		if (mysqli_num_rows($query) > 0):
			while($field = mysqli_fetch_array($query)):
			    $no ==1;
				// $sks=$sks+$field['sks'];
	?>
		<tr>
		    <td><?= $no++ ?></td>
		    <td><?= $field['nim'] ?></td>
			<td><?= $field['nama'] ?></td>
			<td><?= $field['brivaNo'] ?><?= $field['custCode'] ?></td>
			<td><?= $field['amount'] ?></td>
			<td></td>
			<td></td>
			<td></td>
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