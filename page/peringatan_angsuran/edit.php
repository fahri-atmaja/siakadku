<?php
$query = mysqli_query($koneksi,"SELECT peringatan_angsuran.*, student_angkatan.keterangan FROM peringatan_angsuran
                                LEFT JOIN student_angkatan ON student_angkatan.angkatan_id=peringatan_angsuran.angkatan_id 
                                WHERE id_per='$_id'");
$row = mysqli_fetch_array($query);


if (isset($_POST['submit'])) {
$angkatan       = $_POST['angkatan'];
$angsuran	    = $_POST['angsuran'];
$jatuh_tempo	= $_POST['jatuh_tempo'];

$sql = mysqli_query($koneksi,"UPDATE peringatan_angsuran SET angsuran='$angsuran', jatuh_tempo='$jatuh_tempo'
                             WHERE id_per='$_id'");
                             
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
            <h2>Edit Peringatan Angsuran</h2>
            <form Method="POST">
            <table width="80%">
            <tr>
            <td><label>Angkatan </label></td>
            <td>:</td>
            <td>
                <!--<select name="angkatan" id="angkatan" readonly>-->
                <!--<option name="angkatan" value="<?= $row['angkatan_id']; ?>"><?= $row['keterangan']; ?></option>-->
                <!--</select>-->
                <input type="hidden" name="angkatan" value="<?= $row['angkatan_id']; ?>" readonly>
                <input type="text" name="keterangan" value="<?= $row['keterangan']; ?>" readonly>
            </td>
            </tr>
            <tr>
                <td><label>Angsuran Ke </label></td>
                <td>:</td>
                <td><input type="number" name="angsuran" value="<?= $row['angsuran']; ?>"></td>
            </tr>
            <tr>
                <td><label>Jatuh Tempo </label></td>
                <td>:</td>
                <td><input type="date" name="jatuh_tempo" value="<?= $row['jatuh_tempo']; ?>"></td>
            </tr>
            </table>
            <button type="submit" name="submit">Simpan</button>
            </form>
        </div>
    </div>
</div>