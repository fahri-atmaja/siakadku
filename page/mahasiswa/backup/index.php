<h1>
<a href="<?= $_url ?>" class="nav-button transform"><span></span></a>
Mahasiswa
<!--
<span class="place-right">
	<a href="<?= $_url ?>mahasiswa/synchronize" class="button"><span class="mif-sync-problem"></span> Sinkronisasi Data</a>
	<a href="<?= $_url ?>mahasiswa/add" class="button">Tambah Mahasiswa</a>
</span>
-->

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
    	<input type="text" name="cari" value="">
    </div>
    <input type="submit" value="Cari">
  </div>
</form>
</div>
<div class="row">
    <form action="#" method="GET" name="filter">
        <label>Tahun Masuk</label>
    	<select name="tahun_masuk" id="tahun_masuk">
    	    <?php
    	    $tahun = mysqli_query($koneksi,"SELECT * FROM student_angkatan");
    	    while ($roww= mysqli_fetch_array($tahun)) {
			echo '<option name="tahun_masuk" value="' . $roww['angkatan_id'] . '">' . $roww['keterangan'] . '</option>';
    	    }
    	    ?>
    	</select>
        <label>Fakultas</label>
    	<select name="fakultas" id="fakultas">
    	    <?php
    	    $ld = mysqli_query($koneksi,"SELECT * FROM akademik_konsentrasi");
    	    while ($row= mysqli_fetch_array($ld)) {
			echo '<option name="fakultas" value="' . $row['konsentrasi_id'] . '">' . $row['nama_konsentrasi'] . '</option>';
    	    }
    	    ?>
    	</select>
    <input type="submit" value="Cari">
</form>
    </div>
    
</div>
 <?php
if(isset($_GET['cari'])){
	$cari = $_GET['cari'];
	echo "<b>Hasil pencarian : ".$cari."</b>";
}
?>
<?php if ($_access == 'fakultas'): ?>
        <?php 
        $loadmhs  = "SELECT sm.* FROM student_mahasiswa as sm, akademik_konsentrasi as ak WHERE sm.konsentrasi_id=ak.konsentrasi_id AND ak.nama_konsentrasi='$_username' AND kpt='0'";
        $querymhs = mysqli_query($koneksi,$loadmhs);
        $count = mysqli_num_rows($querymhs);
        ?>
        	<form action="#" method="GET">
        	    <input type="hidden" name="kpt2" value="0">
        	    <button type="submit" name="tombol">
        	<div class="tile-wide bg-yellow fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-users"><?php echo $count; ?></span>
                    </div>
                    <span class="tile-label">MAHASISWA UNIVERSITAS</span>
        	</div>
        	</button>
            </form>
        	<?php 
        $loadmhs1  = "SELECT sm.* FROM student_mahasiswa as sm, akademik_konsentrasi as ak WHERE sm.konsentrasi_id=ak.konsentrasi_id AND ak.nama_konsentrasi='$_username' AND kpt='1'";
        $querymhs1 = mysqli_query($koneksi,$loadmhs1);
        $count1 = mysqli_num_rows($querymhs1);
        ?>
            <form action="#" method="GET">
                    <input type="hidden" name="kpt" value="1">
                <button type="submit" name="tombol">
            <div class="tile-wide bg-lightRed fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-users"><?php echo $count1; ?></span>
                    </div>
                    <span class="tile-label">MAHASISWA KPT</span>
        	</div>
        	</button>
        	</form>
<?php endif; ?>
<?php
if ($_access == 'fakultas'){
if(isset($_GET['cari'])){
		$cari = $_GET['cari'];
	$sql = "SELECT student_mahasiswa.*, akademik_kelas.nama_kelas,student_angkatan.keterangan, akademik_konsentrasi.nama_konsentrasi FROM student_mahasiswa 
			LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=student_mahasiswa.konsentrasi_id
			LEFT JOIN student_angkatan ON student_angkatan.angkatan_id=student_mahasiswa.angkatan_id
			LEFT JOIN akademik_kelas ON akademik_kelas.id_kelas=student_mahasiswa.id_kelas
			WHERE student_mahasiswa.nim like '%".$cari."%' and akademik_konsentrasi.nama_konsentrasi='$_username'
			ORDER BY akademik_kelas.nama_kelas ASC, student_mahasiswa.nim ASC";
	$query = mysqli_query($koneksi, $sql);
}else{
	$sql = "SELECT student_mahasiswa.*, student_angkatan.keterangan,akademik_kelas.nama_kelas ,akademik_konsentrasi.nama_konsentrasi FROM student_mahasiswa 
			LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=student_mahasiswa.konsentrasi_id
			LEFT JOIN student_angkatan ON student_angkatan.angkatan_id=student_mahasiswa.angkatan_id
			LEFT JOIN akademik_kelas ON akademik_kelas.id_kelas=student_mahasiswa.id_kelas
			WHERE akademik_konsentrasi.nama_konsentrasi='$_username'
			ORDER BY akademik_kelas.nama_kelas ASC, student_mahasiswa.nim ASC";
	$query = mysqli_query($koneksi, $sql);
}
if(isset($_GET['kpt'])){
		$kpt = $_GET['kpt'];
    	$sql = "SELECT student_mahasiswa.*, student_angkatan.keterangan,akademik_kelas.nama_kelas ,akademik_konsentrasi.nama_konsentrasi FROM student_mahasiswa 
			LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=student_mahasiswa.konsentrasi_id
			LEFT JOIN student_angkatan ON student_angkatan.angkatan_id=student_mahasiswa.angkatan_id
			LEFT JOIN akademik_kelas ON akademik_kelas.id_kelas=student_mahasiswa.id_kelas
			WHERE akademik_konsentrasi.nama_konsentrasi='$_username' and student_mahasiswa.kpt='$kpt'
			ORDER BY akademik_kelas.nama_kelas ASC, student_mahasiswa.nim ASC";
	$query = mysqli_query($koneksi, $sql);
	
		$count = mysqli_num_rows($query);
	echo "<b>Hasil pencarian kpt : ".$count."</b>";
}
if(isset($_GET['kpt2'])){
		$kpt2 = $_GET['kpt2'];
    	$sql = "SELECT student_mahasiswa.*, student_angkatan.keterangan,akademik_kelas.nama_kelas ,akademik_konsentrasi.nama_konsentrasi FROM student_mahasiswa 
			LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=student_mahasiswa.konsentrasi_id
			LEFT JOIN student_angkatan ON student_angkatan.angkatan_id=student_mahasiswa.angkatan_id
			LEFT JOIN akademik_kelas ON akademik_kelas.id_kelas=student_mahasiswa.id_kelas
			WHERE akademik_konsentrasi.nama_konsentrasi='$_username' and student_mahasiswa.kpt='$kpt2'
			ORDER BY akademik_kelas.nama_kelas ASC, student_mahasiswa.nim ASC";
	$query = mysqli_query($koneksi, $sql);
	
		$count = mysqli_num_rows($query);
	echo "<b>Hasil pencarian universitas : ".$count."</b>";
}
if(isset($_GET['tahun_masuk'])){
		$tahun_masuk = $_GET['tahun_masuk'];
	$sql = "SELECT student_mahasiswa.*, akademik_kelas.nama_kelas,student_angkatan.keterangan, akademik_konsentrasi.nama_konsentrasi FROM student_mahasiswa 
			LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=student_mahasiswa.konsentrasi_id
			LEFT JOIN student_angkatan ON student_angkatan.angkatan_id=student_mahasiswa.angkatan_id
			LEFT JOIN akademik_kelas ON akademik_kelas.id_kelas=student_mahasiswa.id_kelas
			WHERE student_angkatan.angkatan_id like '%".$tahun_masuk."%' and akademik_konsentrasi.nama_konsentrasi='$_username'
			ORDER BY akademik_kelas.nama_kelas ASC, student_mahasiswa.nim ASC";
	$query = mysqli_query($koneksi, $sql);
}
if(isset($_GET['fakultas'])){
		$fakultas= $_GET['fakultas'];
	$sql = "SELECT student_mahasiswa.*, akademik_kelas.nama_kelas,student_angkatan.keterangan, akademik_konsentrasi.nama_konsentrasi FROM student_mahasiswa 
			LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=student_mahasiswa.konsentrasi_id
			LEFT JOIN student_angkatan ON student_angkatan.angkatan_id=student_mahasiswa.angkatan_id
			LEFT JOIN akademik_kelas ON akademik_kelas.id_kelas=student_mahasiswa.id_kelas
			WHERE akademik_konsentrasi.konsentrasi_id='$tahun_masuk' and akademik_konsentrasi.nama_konsentrasi='$_username'
			ORDER BY akademik_kelas.nama_kelas ASC, student_mahasiswa.nim ASC";
	$query = mysqli_query($koneksi, $sql);
}
}
if ($_access == 'admin'){
    if(isset($_GET['cari'])){
		$cari = $_GET['cari'];
		
	$sql = "SELECT student_mahasiswa.*, akademik_kelas.nama_kelas,student_angkatan.keterangan, akademik_konsentrasi.nama_konsentrasi FROM student_mahasiswa 
			LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=student_mahasiswa.konsentrasi_id
			LEFT JOIN student_angkatan ON student_angkatan.angkatan_id=student_mahasiswa.angkatan_id
			LEFT JOIN akademik_kelas ON akademik_kelas.id_kelas=student_mahasiswa.id_kelas
			WHERE student_mahasiswa.nim like '%".$cari."%'
			ORDER BY akademik_kelas.nama_kelas ASC, student_mahasiswa.nim ASC";
	$query = mysqli_query($koneksi, $sql);
}else{
	$sql = "SELECT student_mahasiswa.*, student_angkatan.keterangan,akademik_kelas.nama_kelas ,akademik_konsentrasi.nama_konsentrasi FROM student_mahasiswa 
			LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=student_mahasiswa.konsentrasi_id
			LEFT JOIN student_angkatan ON student_angkatan.angkatan_id=student_mahasiswa.angkatan_id
			LEFT JOIN akademik_kelas ON akademik_kelas.id_kelas=student_mahasiswa.id_kelas
			ORDER BY akademik_kelas.nama_kelas ASC, student_mahasiswa.nim ASC";
	$query = mysqli_query($koneksi, $sql);
}
if(isset($_GET['tahun_masuk'])){
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

if(isset($_GET['kpt'])){
		$kpt = $_GET['kpt'];
    	$sql = "SELECT student_mahasiswa.*, student_angkatan.keterangan,akademik_kelas.nama_kelas ,akademik_konsentrasi.nama_konsentrasi FROM student_mahasiswa 
			LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=student_mahasiswa.konsentrasi_id
			LEFT JOIN student_angkatan ON student_angkatan.angkatan_id=student_mahasiswa.angkatan_id
			LEFT JOIN akademik_kelas ON akademik_kelas.id_kelas=student_mahasiswa.id_kelas
			WHERE student_mahasiswa.kpt='$kpt'
			ORDER BY akademik_kelas.nama_kelas ASC, student_mahasiswa.nim ASC";
	$query = mysqli_query($koneksi, $sql);		
	$count = mysqli_num_rows($query);
	echo "<b>Hasil pencarian kpt : ".$count."</b>";
}
if(isset($_GET['kpt2'])){
		$kpt = $_GET['kpt2'];
    	$sql = "SELECT student_mahasiswa.*, student_angkatan.keterangan,akademik_kelas.nama_kelas ,akademik_konsentrasi.nama_konsentrasi FROM student_mahasiswa 
			LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=student_mahasiswa.konsentrasi_id
			LEFT JOIN student_angkatan ON student_angkatan.angkatan_id=student_mahasiswa.angkatan_id
			LEFT JOIN akademik_kelas ON akademik_kelas.id_kelas=student_mahasiswa.id_kelas
			WHERE student_mahasiswa.kpt='$kpt2'
			ORDER BY akademik_kelas.nama_kelas ASC, student_mahasiswa.nim ASC";
	$query = mysqli_query($koneksi, $sql);
	
		$count = mysqli_num_rows($query);
	echo "<b>Hasil pencarian universitas : ".$count."</b>";
}
}
?>
<?php
if ($_access == 'keuangan'){
    if(isset($_GET['cari'])){
		$cari = $_GET['cari'];
	$sql = "SELECT student_mahasiswa.*, akademik_kelas.nama_kelas,student_angkatan.keterangan, akademik_konsentrasi.nama_konsentrasi FROM student_mahasiswa 
			LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=student_mahasiswa.konsentrasi_id
			LEFT JOIN student_angkatan ON student_angkatan.angkatan_id=student_mahasiswa.angkatan_id
			LEFT JOIN akademik_kelas ON akademik_kelas.id_kelas=student_mahasiswa.id_kelas
			WHERE student_mahasiswa.nim like '%".$cari."%'
			ORDER BY akademik_kelas.nama_kelas ASC, student_mahasiswa.nim ASC";
	$query = mysqli_query($koneksi, $sql);
}else{
	$sql = "SELECT student_mahasiswa.*, student_angkatan.keterangan,akademik_kelas.nama_kelas ,akademik_konsentrasi.nama_konsentrasi FROM student_mahasiswa 
			LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=student_mahasiswa.konsentrasi_id
			LEFT JOIN student_angkatan ON student_angkatan.angkatan_id=student_mahasiswa.angkatan_id
			LEFT JOIN akademik_kelas ON akademik_kelas.id_kelas=student_mahasiswa.id_kelas
			
			ORDER BY akademik_kelas.nama_kelas ASC, student_mahasiswa.nim ASC";
	$query = mysqli_query($koneksi, $sql);
}
if(isset($_GET['kpt'])){
		$kpt = $_GET['kpt'];
    	$sql = "SELECT student_mahasiswa.*, student_angkatan.keterangan,akademik_kelas.nama_kelas ,akademik_konsentrasi.nama_konsentrasi FROM student_mahasiswa 
			LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=student_mahasiswa.konsentrasi_id
			LEFT JOIN student_angkatan ON student_angkatan.angkatan_id=student_mahasiswa.angkatan_id
			LEFT JOIN akademik_kelas ON akademik_kelas.id_kelas=student_mahasiswa.id_kelas
			WHERE student_mahasiswa.kpt='$kpt'
			ORDER BY akademik_kelas.nama_kelas ASC, student_mahasiswa.nim ASC";
	$query = mysqli_query($koneksi, $sql);		
	$count = mysqli_num_rows($query);
	echo "<b>Hasil pencarian kpt : ".$count."</b>";
}
if(isset($_GET['kpt2'])){
		$kpt = $_GET['kpt2'];
    	$sql = "SELECT student_mahasiswa.*, student_angkatan.keterangan,akademik_kelas.nama_kelas ,akademik_konsentrasi.nama_konsentrasi FROM student_mahasiswa 
			LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=student_mahasiswa.konsentrasi_id
			LEFT JOIN student_angkatan ON student_angkatan.angkatan_id=student_mahasiswa.angkatan_id
			LEFT JOIN akademik_kelas ON akademik_kelas.id_kelas=student_mahasiswa.id_kelas
			WHERE akademik_konsentrasi.nama_konsentrasi='$_username' and student_mahasiswa.kpt='$kpt2'
			ORDER BY akademik_kelas.nama_kelas ASC, student_mahasiswa.nim ASC";
	$query = mysqli_query($koneksi, $sql);
	
		$count = mysqli_num_rows($query);
	echo "<b>Hasil pencarian universitas : ".$count."</b>";
}
}
?>
<?php
if ($_access == 'fakultas'):
    ?>
<center>
		<a target="_blank" href="mahasiswa/export-mahasiswa-fakultas">EXPORT KE EXCEL</a>
</center>
<?php else:
?>
<center>
		<a target="_blank" href="export/export-mahasiswa.php">EXPORT KE EXCEL</a>
</center>
<?php
endif;
?>
<div class="table-responsive">
<table id="dtHorizontalExample" class="table table-striped table-bordered table-sm" cellspacing="0"
  width="100%">
	<thead>
		<tr>
			<th>NIM</th>
			<th>Nama</th>
			<th>Status</th>
			<th>Alamat</th>
			<th>Program Studi</th>
			<th>Kelas</th>
			<th>Semester</th>
			<th>Tahun Masuk</th>
			<th></th>
		</tr>
	</thead>
	<tbody>

	<?php
		if (mysqli_num_rows($query) > 0):
			while($field = mysqli_fetch_array($query)):
	?>
		<tr>
			<td><?= $field['nim'] ?></td>
			<td><?= $field['nama'] ?></td>
			<td><?= $field['kpt']==1?'KPT':'Universitas'; ?></td>
			<td><?= $field['alamat'] ?></td>
			<td><?= $field['nama_konsentrasi'] ?></td>
			<td><?= $field['nama_kelas'] ?></td>
			<td><?= $field['semester'] ?></td>
			<td><?= $field['keterangan'] ?></td>
			<td>
				<div class="inline-block">
				    <button class="button mini-button dropdown-toggle">Aksi</button>
				    <ul class="split-content d-menu" data-role="dropdown">
						<li><a href="<?= $_url ?>mahasiswa/view/<?= $field['nim'] ?>/<?= urlencode($field['nama']) ?>"><span class="mif-zoom-in"></span> View</a></li>
						<!--<li><a href="<?= $_url ?>status/mahasiswa/<?= $field['nim'] ?>/<?= urlencode($field['nama']) ?>"><span class="mif-pencil"></span> Set Status KRS</a></li>-->
						<li><a href="<?= $_url ?>mahasiswa/editstatus/<?= $field['nim'] ?>/<?= urlencode($field['nama']) ?>"><span class="mif-pencil"></span> Edit Status Mahasiswa </a></li>
						<!--<li><a href="<?= $_url ?>mahasiswa/delete/<?= $field['nim'] ?>/<?= urlencode($field['nama']) ?>"><span class="mif-cross"></span> Delete</a></li>
				   --> </ul>
				</div>
			</td>
		</tr>
	<?php
			endwhile;
		else:
	?>
		<tr>
			<td colspan="6">
			Data tidak ditemukan
			</td>
		</tr>
	<?php
		endif;
	?>
		
	</tbody>
</table>
</div>