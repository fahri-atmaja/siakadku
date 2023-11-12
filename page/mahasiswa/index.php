<h1>
<a href="<?= $_url ?>" class="nav-button transform"><span></span></a>
Mahasiswa

</h1>
<div class="container-fluid">
    <div class="row">
<form action="#" method="GET" name="nim-mhs">
<div class="panel" data-role="panel">
    <div class="heading">
        <span class="title">Cari Mahasiswa</span>
    </div>
    <div class="grid">
        <label>NIM</label>
    	<input  type="text" name="cari" value="">
    </div>
    <input class="button primary" type="submit" value="Cari">
  </div>
</form>
</div>
<div class="row">
    <form action="#" method="GET" name="filter">
        <label>Tahun Masuk</label>
    	<select name="tahun_masuk" id="tahun_masuk" class="form-control">
    	    <?php
    	    $tahun = mysqli_query($koneksi,"SELECT * FROM student_angkatan");
    	    while ($roww= mysqli_fetch_array($tahun)) {
			echo '<option name="tahun_masuk" value="' . $roww['angkatan_id'] . '">' . $roww['keterangan'] . '</option>';
    	    }
    	    ?>
    	</select>
        <label>Fakultas</label>
    	<select name="fakultas" id="fakultas" class="form-control">
    	    <?php
    	    if($_access=='admin'){
    	    $ld = mysqli_query($koneksi,"SELECT * FROM akademik_konsentrasi");
    	    while ($row= mysqli_fetch_array($ld)) {
			echo '<option name="fakultas" value="' . $row['konsentrasi_id'] . '">' . $row['nama_konsentrasi'] . '</option>';
    	    }
    	    }if($_access=='keuangan'){
    	    $ld = mysqli_query($koneksi,"SELECT * FROM akademik_konsentrasi");
    	    while ($row= mysqli_fetch_array($ld)) {
			echo '<option name="fakultas" value="' . $row['konsentrasi_id'] . '">' . $row['nama_konsentrasi'] . '</option>';
    	    }
    	    }else{
    	    $load = mysqli_query($koneksi,"SELECT * FROM app_users WHERE username='$_username'");
    	    $cek  = mysqli_fetch_array($load);
    	    $ket = $cek['keterangan'];
    	    $ld = mysqli_query($koneksi,"SELECT * FROM akademik_konsentrasi WHERE prodi_id='$ket'");
    	    while ($row=mysqli_fetch_array($ld)){
    	    echo '<option name="fakultas" value="' . $row['konsentrasi_id'] . '">' . $row['nama_konsentrasi'] . '</option>'; 
    	    }
    	    }
    	    ?>
    	</select>
    <input class="button primary" type="submit" value="Cari">
</form>
    </div>
    
</div>
 <?php
if(isset($_GET['cari'])){
	$cari = $_GET['cari'];
	echo "<b>Hasil pencarian : ".$cari."</b>";
}
?>
<?php
    if(isset($_GET['cari'])){
		$cari = $_GET['cari'];
		if($_access=='admin'){
	$sql = "SELECT student_mahasiswa.*, akademik_kelas.nama_kelas,student_angkatan.keterangan, akademik_konsentrasi.nama_konsentrasi FROM student_mahasiswa 
			LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=student_mahasiswa.konsentrasi_id
			LEFT JOIN student_angkatan ON student_angkatan.angkatan_id=student_mahasiswa.angkatan_id
			LEFT JOIN akademik_kelas ON akademik_kelas.id_kelas=student_mahasiswa.id_kelas
			WHERE student_mahasiswa.nim like '%".$cari."%'
			ORDER BY akademik_kelas.nama_kelas ASC, student_mahasiswa.nim ASC";
	$query = mysqli_query($koneksi, $sql);
}else{
    $load = mysqli_query($koneksi,"SELECT * FROM app_users WHERE username='$_username'");
    $row  = mysqli_fetch_array($load);
    $ket = $row['keterangan'];
    $sql = "SELECT student_mahasiswa.*, akademik_kelas.nama_kelas,student_angkatan.keterangan, akademik_konsentrasi.nama_konsentrasi FROM student_mahasiswa 
			LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=student_mahasiswa.konsentrasi_id
			LEFT JOIN student_angkatan ON student_angkatan.angkatan_id=student_mahasiswa.angkatan_id
			LEFT JOIN akademik_kelas ON akademik_kelas.id_kelas=student_mahasiswa.id_kelas
			WHERE student_mahasiswa.nim like '%".$cari."%' AND akademik_konsentrasi.prodi_id='$ket'
			ORDER BY akademik_kelas.nama_kelas ASC, student_mahasiswa.nim ASC";
	$query = mysqli_query($koneksi, $sql);
}
}
elseif(isset($_GET['tahun_masuk'])){
		$fakultas = $_GET['fakultas'];
		$tahun_masuk = $_GET['tahun_masuk'];
	$sql = "SELECT student_mahasiswa.*, akademik_kelas.nama_kelas,student_angkatan.keterangan, akademik_konsentrasi.nama_konsentrasi FROM student_mahasiswa 
			LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=student_mahasiswa.konsentrasi_id
			LEFT JOIN student_angkatan ON student_angkatan.angkatan_id=student_mahasiswa.angkatan_id
			LEFT JOIN akademik_kelas ON akademik_kelas.id_kelas=student_mahasiswa.id_kelas
			WHERE student_angkatan.angkatan_id='$tahun_masuk' AND akademik_konsentrasi.konsentrasi_id='$fakultas'
			ORDER BY student_mahasiswa.nim ASC, student_mahasiswa.semester ASC";
	$query = mysqli_query($koneksi, $sql);
}

?>
<center>
		<a target="_blank" href="export/export-mahasiswa.php?tahun_masuk=<?= $tahun_masuk ?>&fakultas=<?= $fakultas ?>">EXPORT KE EXCEL (khusus pencarian angkatan)</a>
</center><br>
<center>
		<a target="_blank" href="export/export.php?tahun_masuk=<?= $tahun_masuk ?>&fakultas=<?= $fakultas ?>">EXPORT WEB (khusus pencarian angkatan)</a>
</center>
<div class="table-responsive">
<table id="dtHorizontalExample" class="table table-striped table-bordered table-sm" cellspacing="0"
  width="100%">
	<thead>
		<tr>
		    <th>Aksi</th>
			<th>NIM</th>
			<th>Nama</th>
			<th>Program Studi</th>
			<th>Kelas</th>
			<th>Semester</th>
			<th>Tahun Masuk</th>
			
			<th>Status</th>
		</tr>
	</thead>
	<tbody>

	<?php
		if (mysqli_num_rows($query) > 0):
			while($field = mysqli_fetch_array($query)):
	?>
		<tr>
		    <td>
				<div class="inline-block">
				    <button class="button mini-button dropdown-toggle">Aksi</button>
				    <ul class="split-content d-menu" data-role="dropdown">
				        <?php
				        if($_access=='admin'){
				        ?>
						<li><a href="<?= $_url ?>mahasiswa/view/<?= $field['nim'] ?>/<?= urlencode($field['nama']) ?>"><span class="mif-zoom-in"></span> View</a></li>
						<li><a href="<?= $_url ?>mahasiswa/status/<?= $field['nim'] ?>/<?= urlencode($field['nama']) ?>"><span class="mif-pencil"></span> Status Mahasiswa </a></li>
						<li><a href="<?= $_url ?>mahasiswa/editstatus/<?= $field['nim'] ?>/<?= urlencode($field['nama']) ?>"><span class="mif-pencil"></span> Edit Status Mahasiswa </a></li>
						<?php
				        }else{
						?>
						<li><a href="<?= $_url ?>mahasiswa/status/<?= $field['nim'] ?>/<?= urlencode($field['nama']) ?>"><span class="mif-pencil"></span> Status Mahasiswa </a></li>
						<?php
				        }
						?>
				    </ul>
				</div>
			</td>
			<td><?= $field['nim'] ?></td>
			<td><?= $field['nama'] ?></td>
			<td><?= $field['nama_konsentrasi'] ?></td>
			<td><?= $field['nama_kelas'] ?></td>
			<td><?= $field['semester'] ?></td>
			<td><?= $field['keterangan'] ?></td>
			<td><?= $field['status'] ?></td>
			
		</tr>
	<?php
			endwhile;
		else:
	?>
		<tr>
			<td colspan="6">
			Pilih Data Pencarian
			</td>
		</tr>
	<?php
		endif;
	?>
		
	</tbody>
</table>
</div>