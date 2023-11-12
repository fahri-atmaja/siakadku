<?php
	if ($_access == 'mahasiswa' && $_id != $_username) {
		header("location:{$_url}krs/view/{$_username}");
	}
?>
<style type="text/css">
	.input-control {
		border: 1px solid #d9d9d9;
		padding: 1px;
	}
</style>

<h1>
<a href="<?= $_url ?><?= in_array($_access, array('admin','dosen')) ? 'persentase' : '' ?>" class="nav-button transform"><span></span></a>
Set Persentase
</h1>
	<script>
		function hanyaAngka(evt) {
		  var charCode = (evt.which) ? evt.which : event.keyCode
		   if (charCode > 31 && (charCode < 48 || charCode > 57))
 
		    return false;
		  return true;
		}
	</script>
<?php

if (isset($_POST['submit'])) {

	extract($_POST);
	$cek = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM setpersentase WHERE nip='$nip' and jadwal_id='$jadwal_id'"));
	$total=$uas+$uts+$kehadiran+$tugas+$praktik;
	if ($total > 100)
	{
    echo "<script>window.alert('Persentase Salah, Total Tidak Boleh Lebih dari 100')
    window.location='set-persentase'</script>";
    }
    elseif ($total < 100)
	{
    echo "<script>window.alert('Persentase Salah, Total Tidak Boleh Kurang dari 100')
    window.location='set-persentase'</script>";
    }
	
	elseif ($cek > 0){
    echo "<script>window.alert('Anda sudah setting persentase')
    window.location='set-persentase'</script>";
    }else{
	$sqlu = "INSERT INTO setpersentase(id_persentase,uts,uas,kehadiran,tugas,praktik,nip,jadwal_id) VALUES('','$uts','$uas','$kehadiran','$tugas','$praktik','$nip','$jadwal_id')";
	$que = mysqli_query($koneksi, $sqlu);

	if ($que) {
		echo "<script>$.Notify({
		    caption: 'Success',
		    content: 'Data Set Persentase Berhasil Ubah',
    		type: 'success'
		});
		setTimeout(function(){ window.location.href='{$_url}persentase/set-persentase'; }, 2000);
		</script>";
	} else {
		echo "<script>$.Notify({
		    caption: 'Failed',
		    content: 'Data Set Persentase Gagal Ubah',
		    type: 'alert'
		});</script>";
	}
}
}
?>
<form Method="POST">
	<table class="table striped hovered border bordered">
	<td>

			<input type="hidden" name="nip" id="nip" value="<?php echo $_username ?>" readonly>

	<td>
	<div class="form-group">
		
		<label for="semester">MAKUL YANG DIAMPU :</label>
			<select class="form-control" name="jadwal_id" id="jadwal_id">
				<option value="" selected="selected">-</option>
				<?php 
		$sqlx = mysqli_query($koneksi,"select jk.*,ak.nama_konsentrasi,ah.hari,mm.nama_makul,ad.nama_lengkap
				FROM akademik_jadwal_kuliah as jk,akademik_konsentrasi as ak,makul_matakuliah as mm,app_dosen as ad,app_hari as ah
				WHERE jk.hari_id=ah.hari_id and jk.konsentrasi_id=ak.konsentrasi_id and jk.makul_id=mm.makul_id and jk.dosen_id=ad.dosen_id and ad.nip='{$_username}'
				ORDER BY jk.hari_id ASC");
		while ($row = mysqli_fetch_array($sqlx))
		{
			echo "<option value='".$row['jadwal_id']."'>".$row['jadwal_id']."-".$row['nama_makul']."</option>";
		}
		?>
			</select>
			<br>
		<label for="semester">KEHADIRAN :</label>
			<input class="form-control" type="text" name="kehadiran" id="kehadiran" onkeypress="return hanyaAngka(event)" maxlength="2">
		<label for="semester">TUGAS :</label>
			<input class="form-control" type="text" name="tugas" id="tugas" onkeypress="return hanyaAngka(event)" maxlength="2">	
			
	</td>
	<br>
	<td>
	<div class="form-group">
		<label for="semester">PRAKTIK :</label>
			<input class="form-control" type="text" name="praktik" id="praktik" onkeypress="return hanyaAngka(event)" maxlength="2">
		<label for="semester">UTS :</label>
			<input class="form-control" type="text" name="uts" id="uts" onkeypress="return hanyaAngka(event)" maxlength="2">
		<label for="semester">UAS :</label>
			<input class="form-control" type="text" name="uas" id="uas" onkeypress="return hanyaAngka(event)" maxlength="2">
	</div>
	</td>
	<td>
	<div class="row cells2">
	<div class="cell">
		<button type="submit" name="submit" class="button primary">SUBMIT</button>
	</div>
	</div>
	</td>
	</table>
	
	
<h2> DAFTAR SET PERSENTASE </h2>
	<table class="table striped hovered border bordered">
		<thead>
		<tr>
			<th>Mata Kuliah</th>
			<th>Kehadiran</th>
			<th>Tugas</th>
			<th>Praktik</th>
			<th>UTS</th>
			<th>UAS</th>
			<th></th>
		</tr>
		</thead>
		<tbody>
		<?php 
	$call = mysqli_query($koneksi,"Select sp.*, mm.nama_makul from setpersentase as sp, akademik_jadwal_kuliah as jk, makul_matakuliah as mm, app_dosen as ad
									where sp.nip=ad.nip and ad.dosen_id=jk.dosen_id and sp.jadwal_id=jk.jadwal_id and mm.makul_id=jk.makul_id and sp.nip = '$_username'");
		$no=1;
		if (mysqli_num_rows($call) > 0):
			while($field = mysqli_fetch_array($call)):
	?>
	
	<tr>
		<td><?= $field['nama_makul'] ?></td>
		<td><?= $field['kehadiran'] ?>%</td>
		<td><?= $field['tugas'] ?>%</td>
		<td><?= $field['praktik'] ?>%</td>
		<td><?= $field['uts'] ?>%</td>
		<td><?= $field['uas'] ?>%</td>
		<td>
			<div class="inline-block">
					<button class="button mini-button dropdown-toggle">Aksi</button>
				<ul class="split-content d-menu" data-role="dropdown">
				<li><a href="<?= $_url ?>persentase/update-persentase/<?= $field['jadwal_id'] ?>/<?= urlencode($field['nama_makul']) ?>"><span class="mif-zoom-in"></span> Update Persentase</a></li>
				</ul>
			</div>
		</td>
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
</form>
