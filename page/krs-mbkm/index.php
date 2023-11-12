<h1>
<a href="<?= $_url ?>" class="nav-button transform"><span></span></a>
Pengajuan KRS MBKM
</h1>

<div class="grid">
    <div class="row">
        <?php
        $load = mysqli_query($koneksi,"SELECT * FROM krs_mbkm WHERE nim='$_username'");
        
        if(mysqli_num_rows($load) > 0){
            $field = mysqli_fetch_array($load);
            if($field['status']=='n'){
                echo "<h3>Status Belum Dikonfirmasi</h3><p>Silahkan hubungi admin fakultas</p>";
            }else{
                echo "<script>setTimeout(function(){ window.location.href='{$_url}krs-mbkm/view/<?= $_id ?>'; }, 2000);
		</script>";
            }
        }else{
            $mhs = mysqli_query($koneksi,"SELECT student_mahasiswa.*, akademik_konsentrasi.nama_konsentrasi, student_angkatan.keterangan FROM student_mahasiswa
                                            LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=student_mahasiswa.konsentrasi_id
                                            LEFT JOIN student_angkatan ON student_angkatan.angkatan_id=student_mahasiswa.angkatan_id
                                            WHERE student_mahasiswa.nim='$_username'");
            $data = mysqli_fetch_array($mhs);
        ?>
        
        <form Method="POST">
        <input type='hidden' name='nim' value='<?= $_username ?>'>
        <input type="hidden" name="konsentrasi_id" value="<?= $data['konsentrasi_id'] ?>">
        <input type='hidden' name='status' value='n'>
        <div class="row cells2">
            <div class="cell">
            		<label>NIM</label>
            		<div class="form-group">
            			<b><?= $data['nim'] ?></b>
            		</div>
	       </div>
	   </div>
	   <div class="row cells2">
            <div class="cell">
            		<label>NAMA</label>
            		<div class="form-group">
            			<b><?= $data['nama'] ?></b>
            		</div>
	       </div>
	   </div>
	   <div class="row cells2">
            <div class="cell">
            		<label>JURUSAN</label>
            		<div class="form-group">
            		<b>	<?= $data['nama_konsentrasi'] ?></b>
            		</div>
	       </div>
	   </div>
	   <div class="row cells2">
            <div class="cell">
            		<label>SEMESTER</label>
            		<div class="form-group">
            		<b>	<?= $data['semester'] ?></b>
            		</div>
	       </div>
	   </div>
	   <div class="row cells2">
            <div class="cell">
            		<label>ANGKATAN</label>
            		<div class="form-group">
            		<b>	<?= $data['keterangan'] ?></b>
            		</div>
	       </div>
	   </div>
    	<div class="cell">
    		<button type="submit" name="submit" class="button primary">DAFTAR KRS MBKM</button>
    	</div>
    	</div>
        </form>
        
        <?php
        if (isset($_POST['submit'])) {
            $nim = $_POST['nim'];
            $status = $_POST['status'];
            $kon = $_POST['konsentrasi_id'];
            $insert = mysqli_query($koneksi,"INSERT INTO krs_mbkm VALUES ('','$nim','$status','$kon')");
            if ($insert) {
        		echo "<script>$.Notify({
        		    caption: 'Success',
        		    content: 'Data Pengajuan Terkirim',
            		type: 'success'
        		});
        		setTimeout(function(){ window.location.href='{$_url}krs-mbkm'; }, 2000);
        		</script>";
        	} else {
        		echo "<script>$.Notify({
        		    caption: 'Failed',
        		    content: 'Data Pengajuan Gagal Ditambah',
        		    type: 'alert'
        		});</script>";
        	}
        }
        }
        ?>
    </div>
</div>