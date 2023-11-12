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
<a href="<?= $_url ?><?= in_array($_access, array('admin','dosen')) ? '' : '' ?>" class="nav-button transform"><span></span></a>
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
    window.location='persentase'</script>";
    }
    elseif ($total < 100)
	{
    echo "<script>window.alert('Persentase Salah, Total Tidak Boleh Kurang dari 100')
    window.location='persentase'</script>";
    }
	
	elseif ($cek > 0){
    echo "<script>window.alert('Anda sudah setting persentase')
    window.location='persentase'</script>";
    }else{
	$sqlu = "INSERT INTO setpersentase(id_persentase,uts,uas,kehadiran,tugas,praktik,nip,jadwal_id) VALUES('','$uts','$uas','$kehadiran','$tugas','$praktik','$nip','$jadwal_id')";
	$que = mysqli_query($koneksi, $sqlu);

	if ($que) {
		echo "<script>$.Notify({
		    caption: 'Success',
		    content: 'Data Set Persentase Berhasil Ubah',
    		type: 'success'
		});
		setTimeout(function(){ window.location.href='{$_url}persentase'; }, 2000);
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
	    <p>Isikan angka saja</p>
	<div class="form-group">
		
		<label for="semester">MAKUL YANG DIAMPU :</label>
			<select class="form-control" name="jadwal_id" id="jadwal_id">
				<option value="" selected="selected">-</option>
				<?php 
		$sqlx = mysqli_query($koneksi,"select jk.*,ak.nama_konsentrasi,ah.hari,mm.kode_makul,mm.nama_makul,ad.nama_lengkap,akls.nama_kelas
				FROM akademik_jadwal_kuliah as jk,akademik_konsentrasi as ak,makul_matakuliah as mm,app_dosen as ad,app_hari as ah,akademik_kelas as akls
				WHERE jk.hari_id=ah.hari_id and jk.konsentrasi_id=ak.konsentrasi_id and jk.id_kelas=akls.id_kelas and jk.makul_id=mm.makul_id and jk.dosen_id=ad.dosen_id and ad.nip='{$_username}' and jk.jadwal_id not in(SELECT jadwal_id FROM setpersentase) ORDER BY jk.semester ASC, akls.nama_kelas ASC");
// 		$sqlx = mysqli_query($koneksi,"SELECT akademik_jadwal_kuliah.*, akademik_konsentrasi.nama_konsentrasi, app_hari.hari, makul_matakuliah.kode_makul, makul_matakuliah.nama_makul, app.dosen.nama_lengkap, akademik_kelas.nama_kelas FROM akademik_jadwal_kuliah
// 		    LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=akademik_jadwal_kuliah.konsentrasi_id
// 		    LEFT JOIN app_hari ON app_hari.hari_id=akademik_jadwal_kuliah.hari_id
// 		    LEFT JOIN akademik_kelas ON akademik_kelas.id_kelas=akademik_jadwal_kuliah.id_kelas
// 		    LEFT JOIN makul_matakuliah ON makul_matakuliah.makul_id=akademik_jadwal_kuliah.makul_id
// 		    LEFT JOIN app_dosen ON app_dosen.dosen_id=akademik_jadwal_kuliah.dosen_id
// 		    WHERE app_dosen.nip='{$_username}' AND akademik_jadwal_kuliah.jadwal_id NOT IN(SELECT jadwal_id FROM setpersentase)");
		while ($row = mysqli_fetch_array($sqlx))
		{
			echo "<option value='".$row['jadwal_id']."'>Prodi:".$row['nama_konsentrasi']." -  Kelas: ".$row['nama_kelas']."  -  Semester : ".$row['semester']."  -  Makul: ".$row['nama_makul']."</option>";
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
			<input class="form-control" type="text" name="uas" id="uas" onkeypress="return hanyaAngka(event)" maxlength="3">
	</div>
	</td>
	
	</table>
		<button type="submit" name="submit" class="button primary">SUBMIT</button>
	
	
	
<h2> DAFTAR SET PERSENTASE </h2>
	<table class="table striped hovered border bordered">
		<thead>
		<tr>
		    <th>Prodi</th>
		    <th>Nama Kelas</th>
		    <th>Semester</th>
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
	$call = mysqli_query($koneksi,"Select sp.*,akls.nama_kelas,ak.nama_konsentrasi, mm.nama_makul, jk.semester from setpersentase as sp, akademik_jadwal_kuliah as jk, makul_matakuliah as mm, app_dosen as ad, akademik_konsentrasi as ak,akademik_kelas as akls
									where akls.id_kelas=jk.id_kelas and sp.nip=ad.nip and ad.dosen_id=jk.dosen_id and jk.konsentrasi_id=ak.konsentrasi_id and sp.jadwal_id=jk.jadwal_id and mm.makul_id=jk.makul_id and sp.nip = '$_username'
									order by semester ASC");
		$no=1;
		if (mysqli_num_rows($call) > 0):
			while($field = mysqli_fetch_array($call)):
	?>
	
	<tr>
	    <td><?= $field['nama_konsentrasi'] ?></td>
	    <td><?= $field['nama_kelas'] ?></td>
	    <td><?= $field['semester'] ?></td>
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
				<li><a href="<?= $_url ?>persentase/delete/<?= $field['jadwal_id'] ?>/<?= urlencode($field['nama_makul']) ?>"><span class="mif-delete"></span> Delete</a></li>
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
