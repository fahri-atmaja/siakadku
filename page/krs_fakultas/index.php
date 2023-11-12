<h1>
<a href="<?= $_url ?>" class="nav-button transform"><span></span></a>
KRS Mahasiswa
</h1>
<form action="#" method="GET">
<div class="panel" data-role="panel">
    <div class="heading">
        <span class="title">Cari Mahasiswa</span>
    </div>
    <div class="grid">
    	<input type="text" name="cari" value="">
    	<input type="submit" value="Cari NIM / NAMA">
    </div>
  </div>
</form>
  <?php
if(isset($_GET['cari'])){
	$cari = $_GET['cari'];
	echo "<b>Hasil pencarian : ".$cari."</b><br>";
}
?>
<?php
	    if(isset($_GET['cari'])){
		$cari = $_GET['cari'];
		$sql = "SELECT student_mahasiswa.*, akademik_konsentrasi.nama_konsentrasi as nama_konsentrasi, akademik_krs.accept as acc, akademik_krs.konversi as aksemester FROM akademik_krs
			LEFT JOIN student_mahasiswa ON student_mahasiswa.nim=akademik_krs.nim
			LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=student_mahasiswa.konsentrasi_id
			WHERE nama_konsentrasi='$_username' AND student_mahasiswa.nim like '%".$cari."%' OR student_mahasiswa.nama like '%".$cari."%'
			GROUP by akademik_krs.nim";
	$query = mysqli_query($koneksi, $sql);
	    }else{
                    $query   = mysqli_query($koneksi, "SELECT student_mahasiswa.*, akademik_konsentrasi.nama_konsentrasi as nama_konsentrasi, akademik_krs.accept as acc, akademik_krs.konversi as aksemester FROM akademik_krs 
			LEFT JOIN student_mahasiswa ON student_mahasiswa.nim=akademik_krs.nim AND student_mahasiswa.semester=akademik_krs.konversi
			LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=student_mahasiswa.konsentrasi_id
			WHERE akademik_konsentrasi.nama_konsentrasi='$_username'
			GROUP by akademik_krs.nim");
	    }
?>
<label>Hanya mahasiswa yang sudah mengambil KRS disemesternya akan tampil disini!<br></label>

<div class="table-responsive">
<table id="dtHorizontalExample" class="table table-striped table-bordered table-sm" cellspacing="0"
  width="100%">
	<thead>
		<tr>
			<th>NIM</th>
			<th>Nama</th>
			<th>Semester KRS</th>
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
			<td><?= $field['aksemester'] ?></td>
			<td><?= $field['nama_konsentrasi'] ?></td>
			<td><?= $field['acc']==1?'<i>Sudah Disetujui</i>':'<b>Belum Disetujui</b>'; ?></td>
			<td>
				<div class="inline-block">
				    <button class="button mini-button dropdown-toggle">Aksi</button>
				    <ul class="split-content d-menu" data-role="dropdown">
						<li><a href="<?= $_url ?>krs_fakultas/krs-mhs/<?= $field['nim'] ?>/<?= urlencode($field['nama']) ?>"><span class="mif-zoom-in"></span> View</a></li>
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
<!--<nav>-->
<!--                <ul class="pagination">-->
<!--                    <li class="page-item">-->
<!--                        <a class="page-link" <?php if($halaman > 1){ echo "href='?halaman=$sebelum'"; } ?>>Previous</a>-->
<!--                    </li>-->
                    <?php 
                        // for($x = 1; $x <= $total_halaman; $x++){
                    ?> 
                    <!--<li class="page-item"><a class="page-link" href="?halaman=<?php echo $x ?>"> <?php echo $x; ?></a></li>-->
                    <?php
                        // }
                    ?> 
            <!--        <li class="page-item">-->
            <!--            <a  class="page-link" <?php  if($halaman < $total_halaman) { echo "href='?halaman=$setelah'"; } ?>>Next</a>-->
            <!--        </li>-->
            <!--    </ul>-->
            <!--</nav>-->
</div>