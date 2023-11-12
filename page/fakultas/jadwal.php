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



<?php
if (isset($_POST['submit'])){
    $semester = $_POST['semester'];
    $akademik = $_POST['akademik'];
    $sql1 ="SELECT akademik_jadwal_kuliah.*,akademik_kelas.nama_kelas,makul_matakuliah.kode_makul,makul_matakuliah.nama_makul,
            makul_matakuliah.kelompok_id, app_dosen.nama_lengkap, app_hari.hari, dosen_junior.nama_dos,
            akademik_tahun_akademik.keterangan as tahun, makul_kelompok.kode_kelompok
            FROM akademik_jadwal_kuliah
            LEFT JOIN akademik_tahun_akademik ON akademik_tahun_akademik.tahun_akademik_id=akademik_jadwal_kuliah.tahun_akademik_id
            LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=akademik_jadwal_kuliah.konsentrasi_id
            LEFT JOIN akademik_kelas ON akademik_kelas.id_kelas=akademik_jadwal_kuliah.id_kelas
            LEFT JOIN makul_matakuliah ON makul_matakuliah.makul_id=akademik_jadwal_kuliah.makul_id
            LEFT JOIN makul_kelompok ON makul_kelompok.kelompok_id=makul_matakuliah.kelompok_id
            LEFT JOIN app_dosen ON app_dosen.dosen_id=akademik_jadwal_kuliah.dosen_id
            LEFT JOIN dosen_junior ON dosen_junior.dosen_id=akademik_jadwal_kuliah.dosen_id2
            LEFT JOIN app_hari ON app_hari.hari_id=akademik_jadwal_kuliah.hari_id
            WHERE akademik_konsentrasi.nama_konsentrasi='$_username' AND akademik_jadwal_kuliah.semester='$semester' 
            AND akademik_tahun_akademik.tahun_akademik_id='$akademik' ORDER by akademik_tahun_akademik.tahun_akademik_id ASC, 
            akademik_jadwal_kuliah.semester ASC, akademik_jadwal_kuliah.id_kelas ASC, app_hari.hari_id ASC ";
	$query1 = mysqli_query($koneksi, $sql1);
}
// else{
//     $sql1 ="SELECT akademik_jadwal_kuliah.*,akademik_kelas.nama_kelas,makul_matakuliah.kode_makul,makul_matakuliah.nama_makul,
//             makul_matakuliah.kelompok_id, app_dosen.nama_lengkap, app_hari.hari, dosen_junior.nama_dos,
//             akademik_tahun_akademik.keterangan as tahun
//             FROM akademik_jadwal_kuliah
//             LEFT JOIN akademik_tahun_akademik ON akademik_tahun_akademik.tahun_akademik_id=akademik_jadwal_kuliah.tahun_akademik_id
//             LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=akademik_jadwal_kuliah.konsentrasi_id
//             LEFT JOIN akademik_kelas ON akademik_kelas.id_kelas=akademik_jadwal_kuliah.id_kelas
//             LEFT JOIN makul_matakuliah ON makul_matakuliah.makul_id=akademik_jadwal_kuliah.makul_id
//             LEFT JOIN app_dosen ON app_dosen.dosen_id=akademik_jadwal_kuliah.dosen_id
//             LEFT JOIN dosen_junior ON dosen_junior.dosen_id=akademik_jadwal_kuliah.dosen_id2
//             LEFT JOIN app_hari ON app_hari.hari_id=akademik_jadwal_kuliah.hari_id
//             WHERE akademik_konsentrasi.nama_konsentrasi='$_username' ORDER by akademik_tahun_akademik.tahun_akademik_id ASC, 
//             akademik_jadwal_kuliah.semester ASC, akademik_jadwal_kuliah.id_kelas ASC, app_hari.hari_id ASC ";
// 	$query1 = mysqli_query($koneksi, $sql1);
// }
	
?>
<div class="container">
<table class="table striped hovered border bordered">
    <a href="<?= $_url ?>fakultas/input-jadwal"><button class="button primary">Input Jadwal</button></a>
</table>
<form method="POST">

    <div class="row">
    <label for="semester">Semester</label>
    </div>
    <div class="row">
    <select name="semester" id="semester">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="7">7</option>
        <option value="8">8</option>
    </select>
    </div>
    <div class="row">
        <label for="semester">Tahun Akademik</label>
        </div>
        <div class="row">
    <select name="akademik" id="akademik">
       <option value="">-- pilih --</option>
				<?php
					$result = mysqli_query($koneksi, "SELECT * FROM akademik_tahun_akademik");
					while ($row= mysqli_fetch_array($result)) {
					echo '<option name="akademik" value="' . $row['tahun_akademik_id'] . '">'. $row['keterangan'].'</option>';
				}
				?>
    </select>
    <button type="submit" name="submit" class="button primary">Submit</button>
        </div>

</form>
</div>
<div class="table-responsive">
<table id="dtHorizontalExample" class="table table-striped table-bordered table-sm" cellspacing="0"
  width="100%">
	<thead>
		<tr>
		    <th>Aksi</th>
			<th>No</th>
			<th>Kode Kelompok</th>
			<th>Tahun Akademik</th>
			<th>Kelas</th>
			<th>Matakuliah</th>
			<th>Dosen Pengajar</th>
			<th>Dosen Pengajar 2</th>
			<th>Semester</th>
			<th>Hari</th>
			<th>Jam Mulai</th>
			
		</tr>
	</thead>
	<tbody>

	<?php
		$no=1;
		if (mysqli_num_rows($query1) > 0):
			while($field1 = mysqli_fetch_array($query1)):
	?>
		<tr>
		    <td>
				<div class="inline-block">
				    <button class="button dropdown-toggle">Aksi</button>
				    <ul class="split-content d-menu" data-role="dropdown">
				        <li><a href="<?= $_url ?>fakultas/view-nilai/<?= $field1['jadwal_id'] ?>/<?= $field1['kode_makul'] ?>"><span class="mif-zoom"></span> Daftar Nilai</a></li>
				        <li><a href="<?= $_url ?>jadwal_uas"><span class="mif-pencil"></span> Jadwal UAS</a></li>
						<li><a href="<?= $_url ?>fakultas/delete/<?= $field1['jadwal_id'] ?>"><span class="mif-cross"></span> Delete</a></li>
						<li><a href="<?= $_url ?>fakultas/edit/<?= $field1['jadwal_id'] ?>"><span class="mif-pencil"></span> Edit</a></li>
					
				    </ul>
				</div>
			</td>
			<td><?= $no++ ?></td>
			<td><?= $field1['kode_kelompok'] ?></td>
			<td><?= $field1['tahun'] ?></td>
			<td><?= $field1['nama_kelas'] ?></td>
			<td><?= $field1['nama_makul'] ?></td>
			<td><?= $field1['nama_lengkap'] ?></td>
			<td><?php if ($field1['dosen_id2']==0){
				echo "Not Set";
				}else{
				echo $field1['nama_dos'];
			}  ?></td>
			<td><?= $field1['semester'] ?></td>
			<td><?= $field1['hari'] ?></td>
			<td><?= $field1['jam_mulai'] ?></td>
			
		</tr>
	<?php
			endwhile;
		else:
	?>
		<tr>
			<td colspan="4">
			Masukan semester dan tahun akademik.
			</td>
		</tr>
	<?php
		endif;
	?>
		
	</tbody>
</table>
</div>
