<?php
$nim = $_id;
$load = mysqli_query($koneksi,"SELECT * FROM student_mahasiswa WHERE nim='$nim'");
$row  = mysqli_fetch_array($load);
?>
<h1>
<a href="<?= $_url ?>mahasiswa" class="nav-button transform"><span></span></a>
Mahasiswa

</h1>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <table border='0px'>
                <tr>
                    <td><?= $row['nim']; ?></td>
                    <td> - </td>
                    <td><?= $row['nama']; ?></td>
                </tr>
            </table>
            <hr>
            <form method="POST">
                <input type="hidden" name="nim" value="<?= $row['nim'] ?>">
            <label>Ubah Kelas</label>    
            <select name="id_kelas" id="id_kelas" class="form-control">
                <?php
                $kelasini = mysqli_query($koneksi,"SELECT * FROM akademik_kelas WHERE id_kelas='$row[id_kelas]'");
                $kelas = mysqli_fetch_array($kelasini);
                echo "<option value=". $kelas['id_kelas'] .">". $kelas['nama_kelas'] ."</option>";
                
                $cekkelas = mysqli_query($koneksi,"SELECT * FROM akademik_kelas");
                $cek = mysqli_num_rows($cekkelas);
                if($cek>0){
                    while ($field = mysqli_fetch_array($cekkelas)) {
						echo "<option value='{$field['id_kelas']}'>{$field['nama_kelas']}</option>";
					}
                }else{
                    echo "<option>Kelas Tidak Ditemukan</option>";
                }
                ?>
            </select>
            <label>Ubah Status</label>
            <select name="status" id="status" class="form-control">
                <option value="<?= $row['status'] ?>">Status sekarang : <?= $row['status'] ?></option>
                <option value="mahasiswa">Mahasiswa</option>
                <option value="lulus">Lulus</option>
                <option value="nonaktif">Nonaktif</option>
                <option value="cuti">Cuti</option>
                <option value="mengundurkan diri">Mengundurkan Diri</option>
            </select>
            <button type="submit" class="button primary">Update</button>
            </form>
        </div>
    </div>
</div>
<?php
if(isset($_POST['status'])){
    $nim = $_POST['nim'];
    $status = $_POST['status'];
    $id_kelas = $_POST['id_kelas'];
    $update = mysqli_query($koneksi,"UPDATE student_mahasiswa SET status='$status', id_kelas='$id_kelas' WHERE nim='$nim'");
    if($update){
		echo "<script>$.Notify({
		    caption: 'Success',
		    content: 'Data Mahasiswa Berhasil Ubah',
    		type: 'success'
		});
		setTimeout(function(){ window.location.href='{$_url}mahasiswa'; }, 2000);
		</script>";
	} else {
		echo "<script>$.Notify({
		    caption: 'Failed',
		    content: 'Data Mahasiswa Gagal Ubah',
		    type: 'alert'
		});</script>";
	}
}
?>