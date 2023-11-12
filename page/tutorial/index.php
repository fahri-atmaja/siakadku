<h1>
<a href="<?= $_url ?>" class="nav-button transform"><span></span></a>
Tutorial SIAKAD
</h1>
<?php
$query = mysqli_query($koneksi,"SELECT * FROM tutorial WHERE akses='$_access' ORDER BY id DESC");
?>
<div class="container">
	<?php
		$no =1;
		if (mysqli_num_rows($query) > 0):
			while($field = mysqli_fetch_array($query)):
	?>
	<div class="row">
	    <div class="col-md-6">
		<?= $field['url'] ?><br><b><?= $field['keterangan'] ?></b><br>
		</div>
	</div>
			<hr>	
	<?php
			endwhile;
			else:
	?>
			Data tidak ditemukan
	<?php
		endif;
	?>		
</div>