<h1>
<a href="<?= $_url ?>" class="nav-button transform"><span></span></a>
Cek KHS Mahasiswa
</h1>
<form action="#" method="GET">
<div class="panel" data-role="panel">
    <div class="heading">
        <span class="title">Cari Mahasiswa</span>
    </div>
    <div class="grid">
    	<input type="text" name="cari" value="">
    	<input type="submit" value="Cari NIM">
    </div>
  </div>
</form>
  <?php
if(isset($_GET['cari'])){
	$cari = $_GET['cari'];
	echo "<b>Hasil pencarian : ".$cari."</b>";
}
?>
<?php
	if ($_access == 'fakultas') {
	    if(isset($_GET['cari'])){
		$cari = $_GET['cari'];
		$sql = "SELECT DISTINCT student_mahasiswa.*, akademik_konsentrasi.nama_konsentrasi as nama_konsentrasi, akademik_krs.accept as acc, akademik_krs.konversi as aksemester FROM student_mahasiswa 
			INNER JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=student_mahasiswa.konsentrasi_id
			INNER JOIN akademik_krs ON student_mahasiswa.nim=akademik_krs.nim
			WHERE akademik_konsentrasi.nama_konsentrasi='$_username' AND student_mahasiswa.nim like '%".$cari."%'
			ORDER BY nim ASC, semester ASC";
	$query = mysqli_query($koneksi, $sql);
	    }else{
	        		$sql = "SELECT DISTINCT student_mahasiswa.*, akademik_konsentrasi.nama_konsentrasi as nama_konsentrasi, akademik_krs.konversi as aksemester , akademik_krs.accept as acc FROM student_mahasiswa 
			INNER JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=student_mahasiswa.konsentrasi_id
			INNER JOIN akademik_krs ON student_mahasiswa.nim=akademik_krs.nim
			WHERE akademik_konsentrasi.nama_konsentrasi='$_username' AND akademik_krs.konversi=student_mahasiswa.semester
			ORDER BY semester DESC, nim ASC";
	$query = mysqli_query($koneksi, $sql);
	    }
	}elseif ($_access == 'admin'){
	    if(isset($_GET['cari'])){
		$cari = $_GET['cari'];
		$sql = "SELECT DISTINCT student_mahasiswa.*, akademik_konsentrasi.nama_konsentrasi as nama_konsentrasi, akademik_krs.accept as acc, akademik_krs.konversi as aksemester FROM student_mahasiswa 
			INNER JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=student_mahasiswa.konsentrasi_id
			INNER JOIN akademik_krs ON student_mahasiswa.nim=akademik_krs.nim
			WHERE student_mahasiswa.nim like '%".$cari."%'
			ORDER BY nim ASC, semester ASC";
	$query = mysqli_query($koneksi, $sql);
	    }
	}
?>
<label>Hanya mahasiswa yang sudah mengambil KRS disemesternya akan tampil disini!</label>
<table class="table striped hovered border bordered">
	<thead>
		<tr>
			<th>NIM</th>
			<th>Nama</th>
			<th>Program Studi</th>
			<th>Status KRS</th>
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
			<td><?= $field['nama_konsentrasi'] ?></td>
			<td><?= $field['acc']==1?'Sudah KRS':'Belum KRS'; ?></td>
			<td>
				<div class="inline-block">
				    <button class="button mini-button dropdown-toggle">Aksi</button>
				    <ul class="split-content d-menu" data-role="dropdown">
						<li><a href="<?= $_url ?>khs/view/<?= $field['nim'] ?>/<?= urlencode($field['nama']) ?>"><span class="mif-zoom-in"></span> View</a></li>
						<!--<li><a href="<?= $_url ?>status/mahasiswa/<?= $field['nim'] ?>/<?= urlencode($field['nama']) ?>"><span class="mif-checkmark"></span> Approve KRS</a></li>-->
						<!-- <li><a href="<?= $_url ?>krs/edit/<?= $field['nim'] ?>/<?= urlencode($field['nama']) ?>"><span class="mif-pencil"></span> Edit</a></li> -->
				    </ul>
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