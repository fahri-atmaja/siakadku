<h1>
<a href="<?= $_url ?><?= in_array($_access, array('admin')) ? 'dashboard' : '' ?>" class="nav-button transform"><span></span></a>
Laporan KRS Mahasiswa 
</h1>
<a href="<?= $_url ?>laporan_krs/krs_mhs"><button class="button primary">VIEW KRS</button></a>
<div class="container">
    <div class="row">
        <form method="POST">
        <div class="form-control">
        <label>Kelas</label>
        <select name="id_kelas">
            <option name="id_kelas" value="">-- pilih --</option>
            <?php
					$quekelas = mysqli_query($koneksi, "SELECT * FROM akademik_kelas ORDER BY id_kelas ASC");
					while ($fillkelas = mysqli_fetch_array($quekelas)) {
						echo "<option value='{$fillkelas['id_kelas']}'>{$fillkelas['nama_kelas']}</option>";
					}
				?>
        </select>
        </div>
        <div class="form-control">
            <label>Semester</label>
        <select name="semester">
            <option name="semester" value="">-- pilih --</option>
            <?php
					$quekelas = mysqli_query($koneksi, "SELECT semester FROM student_mahasiswa GROUP BY semester ORDER BY semester ASC");
					while ($fillkelas = mysqli_fetch_array($quekelas)) {
						echo "<option value='{$fillkelas['semester']}'>{$fillkelas['semester']}</option>";
					}
				?>
        </select>
        </div>
        <div class="form-control">
            <label>Jurusan</label>
        <select name="konsentrasi_id">
            <option name="konsentrasi_id" value="">-- pilih --</option>
            <?php
					$quekelas = mysqli_query($koneksi, "SELECT * FROM akademik_konsentrasi ORDER BY konsentrasi_id ASC");
					while ($fillkelas = mysqli_fetch_array($quekelas)) {
						echo "<option value='{$fillkelas['konsentrasi_id']}'>{$fillkelas['nama_konsentrasi']}</option>";
					}
				?>
        </select>
        </div>
        <div class="form-control">
            <label>Tahun Angkatan</label>
        <select name="tahun_angkatan">
            <option name="tahun_angkatan" value="">-- pilih --</option>
            <?php
					$quekelas = mysqli_query($koneksi, "SELECT * FROM student_angkatan ORDER BY angkatan_id ASC");
					while ($fillkelas = mysqli_fetch_array($quekelas)) {
						echo "<option value='{$fillkelas['angkatan_id']}'>{$fillkelas['keterangan']}</option>";
					}
				?>
        </select>
        </div>
        <hr>
        <div class="form-control">
            <button type="submit" name="submit" class="button primary">SUBMIT</button>
        </div>
        </form>
    </div>
</div>
<?php
if (isset($_POST['submit'])){
    $id_kelas = $_POST['id_kelas'];
    $semester = $_POST['semester'];
    $konsentrasi_id = $_POST['konsentrasi_id'];
    $tahun_angkatan = $_POST['tahun_angkatan'];

    $sql = "SELECT student_mahasiswa.*, akademik_konsentrasi.nama_konsentrasi, 
            akademik_kelas.nama_kelas, student_angkatan.keterangan as angkatan
            FROM student_mahasiswa
            LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=student_mahasiswa.konsentrasi_id
            LEFT JOIN akademik_kelas ON akademik_kelas.id_kelas=student_mahasiswa.id_kelas
            LEFT JOIN student_angkatan ON student_angkatan.angkatan_id=student_mahasiswa.angkatan_id
            WHERE student_mahasiswa.konsentrasi_id='$konsentrasi_id' 
            AND student_mahasiswa.id_kelas='$id_kelas'
            AND student_mahasiswa.angkatan_id='$tahun_angkatan'
            GROUP BY nim";
            
    $proses = mysqli_query($koneksi, $sql);
    $t = mysqli_fetch_array($proses);
?>
<label>Hasil penelusuran :</label><br>
<a href="javascript:printDiv('cetak');"><button class="btn btn-success">PRINT</button></a>
<div id="cetak">
<div class="container">
    <div class="row">
        
        <table width=50%>
        <b><tr>
        <td>Jurusan</td><td>:</td><td><?= $t['nama_konsentrasi']; ?></td>
        </tr><tr>
        <td>Semester</td><td>:</td><td><?= $semester; ?></td>
        </tr><tr>
        <td>Kelas</td><td>:</td><td><?= $t['nama_kelas']; ?></td>
        </tr><tr>
         <td>Angkatan</td><td>:</td><td><?= $t['angkatan']; ?></td>   
        </tr>
        <!--<b><span style="color : red;">*Jika ada mahasiswa tidak tercantum dibawah, <br>-->
        <!--maka mahasiswa tsb belum melakukan KRS sama sekali</span></b>-->
        </b>
        </table>
    </div>
    <div class="row">
    	<div class="table-responsive">
<table id="dtHorizontalExample" class="table table-striped table-bordered table-sm" cellspacing="0"
  width="100%">
    	    <thead>
    	        <tr>
    	        <th>No.</th>
    	        <th>NIM</th>
    	        <th>Nama</th>
    	        <th>Status KRS</th>
    	        <th>Aksi</th>
    	        </tr>
    	    </thead>
    	    <tbody>
    	        <?php
            		$no=1;
            		$sql1 = "SELECT student_mahasiswa.*, akademik_konsentrasi.nama_konsentrasi, 
                        akademik_kelas.nama_kelas, student_angkatan.keterangan as angkatan
                        FROM student_mahasiswa
                        LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=student_mahasiswa.konsentrasi_id
                        LEFT JOIN akademik_kelas ON akademik_kelas.id_kelas=student_mahasiswa.id_kelas
                        LEFT JOIN student_angkatan ON student_angkatan.angkatan_id=student_mahasiswa.angkatan_id
                        WHERE student_mahasiswa.konsentrasi_id='$konsentrasi_id' 
                        AND student_mahasiswa.id_kelas='$id_kelas'
                        AND student_mahasiswa.angkatan_id='$tahun_angkatan'
                        GROUP BY nim";
                $proses1 = mysqli_query($koneksi, $sql1);
            		if (mysqli_num_rows($proses1) > 0):
            		while($tampil = mysqli_fetch_array($proses1)):
            	?>
    	    <tr>
    	        <td><?= $no++ ?></td>
    	        <td><?= $tampil['nim']; ?></td>
    	        <td><?= $tampil['nama']; ?></td>
    	        <td><?php
    	        $krs = mysqli_query($koneksi,"SELECT * FROM akademik_krs WHERE nim='$tampil[nim]' AND konversi='$semester'");
    	        $cek = mysqli_num_rows($krs);
    	        if($cek > 0){
    	            echo "<b>SUDAH KRS</b>";
    	        }else{
    	            echo "<i>BELUM KRS</i>";
    	        }
    	        ?></td>
    	        <td><a target="_BLANK" href="/krs_fakultas/krs-mhs/<?= $tampil['nim']; ?>"><button class="btn btn-primary">CEK KRS</button></a></td>
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
<?php
}
?>
<textarea id="printing-css" style="display:none;">.no-print{display:none}</textarea>
<iframe id="printing-frame" name="print_frame" src="about:blank" style="display:none;"></iframe>
<script type="text/javascript">
function printDiv(elementId) {
 var a = document.getElementById('printing-css').value;
 var b = document.getElementById(elementId).innerHTML;
 window.frames["print_frame"].document.title = document.title;
 window.frames["print_frame"].document.body.innerHTML = '<style>' + a + '</style>' + b;
 window.frames["print_frame"].window.focus();
 window.frames["print_frame"].window.print();
}
</script>