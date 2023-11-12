<?php
	if ($_access == 'mahasiswa' && $_id != $_username) {
		header("location:{$_url}krs/view/{$_username}");
	}
?>
<h1>
<a href="<?= $_url ?>" class="nav-button transform"><span></span></a>
Pengajuan Judul Skripsi</h1>

<?php
	$sql = "SELECT ps.* from pengajuan_skripsi as ps, app_dosen as ad 
							where ps.dosen_id=ad.dosen_id and ad.nip = '$_username' and nim='$_id'";
	$query = mysqli_query($koneksi, $sql);
?>

<table class="table striped hovered border bordered">
	<thead>
		<tr>
			<th>Judul Skripsi Mahasiswa</th>
			<th>Status</th>
			<th>Komentar</th>
			<th>Aksi</th>
		</tr>
	</thead>
	<tbody>

	<?php
		if (mysqli_num_rows($query) > 0):
			while($field = mysqli_fetch_array($query)):
	?>
		<tr>
			<td><?= $field['judul'] ?></td>
			<td><?= $field['status']==1?'sudah disetujui':'belum disetujui'; ?></td>
			<td><?= $field['revisi'] ?></td>
			<td>
				<div class="inline-block">
				    <button class="button mini-button dropdown-toggle">Aksi</button>
				    <ul class="split-content d-menu" data-role="dropdown">
						<li><a href="<?= $_url ?>pengajuan-skripsi/revisi-judul/<?= $field['nim'] ?>">
						<span class="mif-pencil"></span> REVISI</a></li>
						<li><a href="<?= $_url ?>pengajuan-skripsi/approve-judul/<?= $field['nim'] ?>">
						<span class="mif-pencil"></span> ACC</a></li>
				    </ul>
				</div>
			</td>
		</tr>
	<?php
			endwhile;
		else:
	?>
		<tr>
			<td colspan="6">
			Data tidak ditemukan
			</td>
		</tr>
	<?php
		endif;
	?>
		
	</tbody>
</table>