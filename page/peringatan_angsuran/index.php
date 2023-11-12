<?php
if (isset($_POST['submit'])) {
$angkatan       = $_POST['angkatan'];
$angsuran	    = $_POST['angsuran'];
$jatuh_tempo	= $_POST['jatuh_tempo'];

$sql = mysqli_query($koneksi,"INSERT INTO peringatan_angsuran(angkatan_id, angsuran, jatuh_tempo) VALUES ('$angkatan','$angsuran','$jatuh_tempo')");

    if ($sql) {
		echo "<script>$.Notify({
		    caption: 'Success',
		    content: 'Data Peringatan Berhasil Diubah',
    		type: 'success'
		});
		setTimeout(function(){ window.location.href='{$_url}peringatan_angsuran'; }, 2000);
		</script>";
	} else {
		echo "<script>$.Notify({
		    caption: 'Failed',
		    content: 'Data Peringatan Gagal Diubah',
		    type: 'alert'
		});</script>";
	}
}
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <h2>Peringatan Angsuran</h2>
            <form Method="POST">
            <table width="80%">
            <tr>
            <td><label>Angkatan </label></td>
            <td>:</td>
            <td>
            <select name="angkatan" id="angkatan">
                <option name="angkatan" value="">--pilih--</option>
                <?php
                $result = mysqli_query($koneksi, "SELECT * FROM student_angkatan WHERE angkatan_id NOT IN (Select angkatan_id FROM peringatan_angsuran)
													ORDER BY angkatan_id ASC");
													while ($row= mysqli_fetch_array($result)) {
					echo '<option name="angkatan" value="' . $row['angkatan_id'] . '">' . $row['keterangan'] . '</option>';
													}
													?>
            </select>
            </td>
            </tr>
            <tr>
                <td><label>Angsuran Ke </label></td>
                <td>:</td>
                <td><input type="number" name="angsuran"></td>
            </tr>
            <tr>
                <td><label>Jatuh Tempo </label></td>
                <td>:</td>
                <td><input type="date" name="jatuh_tempo"></td>
            </tr>
            <tr>
                <td><button type="submit" name="submit">Simpan</button></td>
            </tr>
            </table>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <h2>Setting Angsuran</h2>
            <div class="table-responsive">
            <table id="dtHorizontalExample" class="table table-striped table-bordered table-sm" cellspacing="0"
              width="80%">
            	<thead>
            		<tr>
            		    <th>Tahun Angkatan</th>
            			<th>Angsuran Ke</th>
            			<th>Tanggal Jatuh Tempo</th>
            			<th>Aksi</th>
            		</tr>
            	</thead>
            	<tbody>
            	    <?php
            	    $query = mysqli_query($koneksi,"SELECT peringatan_angsuran.*,student_angkatan.keterangan FROM peringatan_angsuran
            	                                    LEFT JOIN student_angkatan ON student_angkatan.angkatan_id=peringatan_angsuran.angkatan_id");
                    if (mysqli_num_rows($query) > 0):
        			while($field = mysqli_fetch_array($query)):
            	    ?>
                    <tr>
            		    <td><?= $field['keterangan'] ?></td>
            			<td><?= $field['angsuran'] ?></td>
            			<td><?= $field['jatuh_tempo'] ?></td>
            			<td><div class="inline-block">
				    <button class="button mini-button dropdown-toggle">Aksi</button>
				    <ul class="split-content d-menu" data-role="dropdown">
		
					<li><a href="<?= $_url ?>peringatan_angsuran/edit/<?= $field['id_per'] ?>" class="place-right"><span class="mif-pencil"> Edit </span></a></li>
					</ul>
			</div></td>
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