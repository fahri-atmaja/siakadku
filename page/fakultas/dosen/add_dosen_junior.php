<h1>
<a href="<?= $_url ?>" class="nav-button transform"><span></span></a>
Pilih Dosen
</h1>

<?php
	$npk = $_id;
	if (isset($_POST['submit'])) {
		$dosen_id = $_POST['dosen_id'];
		$ambil = "Select nama_lengkap from app_dosen where dosen_id='$dosen_id'";
		$quequ= mysqli_query($koneksi, $ambil);
		$nama = mysqli_fetch_array($quequ);
		$sqlin = "INSERT INTO dosen_junior(dosen_id,nama_dos) VALUES('{$dosen_id}','{$nama['nama_lengkap']}')";
		$query = mysqli_query($koneksi, $sqlin);

		if ($query) {
			echo "<script>$.Notify({
			    caption: 'Success',
			    content: 'Data Dosen Junior Berhasil Ditambah',
	    		type: 'success'
			});
			setTimeout(function(){ window.location.href='{$_url}dosen/add_dosen_junior'; }, 2000);
			</script>";
		} else {
			echo "<script>$.Notify({
			    caption: 'Failed',
			    content: 'Data Dosen Junior Gagal Ditambah',
			    type: 'alert'
			});</script>";
		}
	}

	$dosen_prodi = mysqli_query($koneksi, "SELECT dosen_id FROM dosen_junior");
	$dm = array();
	while ($prodi = mysqli_fetch_array($dosen_prodi)) {
		$dm[] = "'{$prodi['dosen_id']}'";
	}
	$dm = implode(',', $dm);

	$sql = "SELECT * FROM app_dosen";

	if ($dm!='')
		$sql .= " WHERE dosen_id not in ({$dm})";

	$query= mysqli_query($koneksi, $sql);
?>

<form method="post">

<table class="table striped hovered border bordered">
	<thead>
		<tr>
			<th></th>
			<th>Id_dosen</th>
			<th>NIP</th>
		</tr>
	</thead>
	<tbody>

	<?php
		if (mysqli_num_rows($query) > 0):
			while($field = mysqli_fetch_array($query)):
	?>
		<tr>
			<td><input type="radio" name="dosen_id" value="<?= $field['dosen_id'] ?>"></td>
			<td><?= $field['dosen_id'] ?></td>
			<td><?= $field['nama_lengkap'] ?></td>
		</tr>
	<?php
			endwhile;
		else:
	?>
		<tr>
			<td colspan="3">
			Data tidak ditemukan
			</td>
		</tr>
	<?php
		endif;
	?>
		
	</tbody>
</table>

<button type="submit" name="submit" class="button primary">SUBMIT</button>

</form>