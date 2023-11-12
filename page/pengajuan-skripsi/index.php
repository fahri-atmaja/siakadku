
        <?php
        $load    =mysqli_query($koneksi,"SELECT semester FROM student_mahasiswa WHERE nim='$_username'");
        $display =mysqli_fetch_array($load);
        $semester=$display['semester']; 
            if ($semester<8){
            	echo "<script>window.alert('MAAF SEMESTER ANDA BELUM VALID')
    			window.location.href='{$_url}'</script>";
            }
        ?>
<h1>
<a href="<?= $_url ?>" class="nav-button transform"><span></span></a>
Pengajuan Judul Skripsi</h1>
<?php 
$cekdulu = mysqli_num_rows(mysqli_query($koneksi,"SELECT * from pengajuan_skripsi where nim = '$_username'"));
if ($cekdulu > 0):
?>
<p>ANDA SUDAH PENGAJUAN</p>
<?php
else:
?>
<span class="place-right">
	<a href="<?= $_url ?>pengajuan-skripsi/ajukan" class="button">Ajukan Judul</a>
</span>
<?php
endif;
?>


<?php
	$sql = "SELECT * FROM pengajuan_skripsi WHERE nim='$_username'";
	$query = mysqli_query($koneksi, $sql);
?>

<table class="table striped hovered border bordered">
	<thead>
		<tr>
			<th>Judul Skripsimu</th>
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
				<?php
					if ($field['status']=='2'):
				?>
				<div class="inline-block">
				    <button class="button mini-button dropdown-toggle">Aksi</button>
				    <ul class="split-content d-menu" data-role="dropdown">
						<li><a href="<?= $_url ?>pengajuan-skripsi/edit">
						<span class="mif-pencil"></span> Edit</a></li>
				    </ul>
				</div>
				<?php
					elseif ($field['status']=='1'):
				?>
				<p>Selamat Judul Anda Sudah Di ACC</p>
				<?php
					else:
				?>
				<p>Tunggu Konfirmasi Akademik</p>
				<?php
					endif;
				?>
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