
<h1>
<a href="<?= $_url ?>briva" class="nav-button transform"><span></span></a>
Tagihan Mahasiswa
</h1>
<div class="container-fluid">
    <h2>Pilih Prodi</h2>
    <form method="POST" action="tagihan/atur-tagihan">
    	<div class="form-group">
    	<label>Pilih Prodi</label>
    			<select class="form-control" name="konsentrasi_id" id="konsentrasi_id" onchange='changeValue(this.value)' required>
    				<option value="">-- pilih --</option>
    				<?php
    					$result = mysqli_query($koneksi, "SELECT * FROM akademik_konsentrasi");
    					while ($row= mysqli_fetch_array($result)) {
    					echo '<option name="konsentrasi_id" value="' . $row['konsentrasi_id'] . '">' . $row['nama_konsentrasi'] . '</option>';
    				}
    				?>
    			</select>
    	</div>
	    <div class="form-group">
    	<label>Pilih Angkatan</label>
    			<select class="form-control" name="angkatan_id" id="angkatan_id" onchange='changeValue(this.value)' required>
    				<option value="">-- pilih --</option>
    				<?php
    					$result = mysqli_query($koneksi, "SELECT * FROM student_angkatan");
    					while ($row= mysqli_fetch_array($result)) {
    					echo '<option name="angkatan_id" value="' . $row['angkatan_id'] . '">' . $row['keterangan'] . '</option>';
    				}
    				?>
    			</select>
    	</div>
    	<div class="form-group">
    	<label>Status Bayar</label>
    			<select class="form-control" name="status" id="status" onchange='changeValue(this.value)' required>
    				<option value="0">Reguler</option>
    				<option value="1">Bulanan</option>
    			</select>
    	</div>
    	<div class="form-group">
    	    <button type="submit" name="submit" class="button primary">SUBMIT</button>
    	</div>
    </form
	
</div>
</div>