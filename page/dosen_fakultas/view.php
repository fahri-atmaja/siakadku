<?php
	if ($_access == 'dosen' && $_id != $_username) {
		header("location:{$_url}dosen/view/{$_username}");
	}
?>
<style type="text/css">
	.input-control {
		border: 1px solid #d9d9d9;
		padding: 10px;
	}
</style>

<?php
$querya = mysqli_query($koneksi, "SELECT * FROM app_dosen WHERE nip='{$_id}'");
$field = mysqli_fetch_array($querya);
extract($field);
?>
<h1>
<a href="<?= $_url ?><?= $_access == 'admin' ? 'dosen' : '' ?>" class="nav-button transform"><span></span></a>
Dosen <br> <?= $nama_lengkap ?>
</h1>
<div class="grid">

<div class="row cells2">
	<div class="cell">
		<label>NIP / NIDN</label>
		<div class="form-group">
			<?= $nip ?>
		</div>
	</div>
	
	<div class="cell">
		<label>Nama</label>
		<div class="form-group">
			<?= $nama_lengkap ?>
		</div>
	</div>
</div>

<div class="row cells2">
	<div class="cell">
		<label>Alamat</label>
		<div class="form-group">
			<?= $alamat ?>
		</div>
	</div>

</div>

<div class="panel" data-role="panel">
    <div class="heading">
        <span class="title">Program Studi</span>
    </div>
    <div class="content">
        <?php if ($_access == 'admin'): ?>
		<a href="<?= $_url ?>dosen/add-prodi/<?= $_id ?>" class="button">Tambahkan Program Studi</a>
		<?php endif; ?>
		<?php
			$sqla = "SELECT ad.prodi_id, ap.nama_prodi FROM app_dosen as ad,akademik_prodi as ap
			WHERE ad.prodi_id=ap.prodi_id and ad.nip='{$_id}'";
			$querya = mysqli_query($koneksi, $sqla);

		?>
		<table class="table striped hovered border bordered">
			<thead>
				<tr>
					<th>Kode</th>
					<th>Nama</th>
				</tr>
			</thead>
			<tbody>

			<?php
				if (mysqli_num_rows($querya) > 0):
					while($field = mysqli_fetch_array($querya)):
			?>
				<tr>
					<td><?= $field['prodi_id'] ?></td>
					<td><?= $field['nama_prodi'] ?>
					<?php if ($_access == 'admin'): ?>
					<a href="<?= $_url ?>dosen/delete-prodi/<?= $_id ?>/<?= $field['prodi_kode'] ?>/<?= urlencode($field['prodi_nama']) ?>" class="place-right"><span class="mif-cross"></span></a>
					<?php endif; ?>
					</td>
				</tr>
			<?php
					endwhile;
				else:
			?>
				<tr>
					<td colspan="3">
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

<div class="panel" data-role="panel">
    <div class="heading">
        <span class="title">Mengajar Matakuliah</span>
    </div>
    <div class="content">
		<?php
			//$sqlb = "SELECT matakuliah.*, prodi.nama as prodi_nama FROM matakuliah 
			//LEFT JOIN prodi ON matakuliah.prodi_kode=prodi.kode
			//INNER JOIN dosen_matakuliah ON dosen_matakuliah.matakuliah_kode=matakuliah.kode
			//WHERE dosen_matakuliah.dosen_npk='{$_id}'
			//ORDER BY matakuliah.kode ASC";
			$sqlb = "select jk.jadwal_id,ak.nama_konsentrasi,mm.kode_makul,mm.nama_makul,mm.sks,mm.semester,ad.nama_lengkap
			FROM akademik_jadwal_kuliah as jk,akademik_konsentrasi as ak,makul_matakuliah as mm,app_dosen as ad
			WHERE jk.konsentrasi_id=ak.konsentrasi_id and jk.makul_id=mm.makul_id and jk.dosen_id=ad.dosen_id and ad.nip='{$_username}'";
			$queryb = mysqli_query($koneksi, $sqlb);
		?>

		<table class="table striped hovered border bordered">
			<thead>
				<tr>
					<th>Jadwal ID</th>
					<th>Kode Makul</th>
					<th>Nama Makul</th>
					<th>Nama Konsentrasi</th>					
					<th>SKS</th>
					<th>Semester</th>
					<th>Dosen Pengampu</th>
				</tr>
			</thead>
			<tbody>

			<?php
				if (mysqli_num_rows($queryb) > 0):
					while($field = mysqli_fetch_array($queryb)):
			?>
				<tr>
					<td><?= $field['jadwal_id'] ?></td>
					<td><?= $field['kode_makul'] ?></td>
					<td><?= $field['nama_makul'] ?></td>
					<td><?= $field['nama_konsentrasi'] ?></td>
					<td><?= $field['sks'] ?></td>
					<td><?= $field['semester'] ?></td>
					<td><?= $field['nama_lengkap'] ?></td>
				</tr>
			<?php
					endwhile;
				else:
			?>
				<tr>
					<td colspan="5">
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
<!--
<?php if ($_access == 'admin') : ?>
<div class="panel" data-role="panel">
    <div class="heading">
        <span class="title">WALI dari Mahasiswa</span>
    </div>
    <div class="content">
        <?php if ($_access == 'admin'): ?>
		<a href="<?= $_url ?>dosen/add-mahasiswa/<?= $_id ?>" class="button">Tambahkan Mahasiswa</a>
		<?php endif; ?>

		<?php
			$sqlb = "SELECT mahasiswa.*, prodi.nama as prodi_nama FROM dosen_wali 
			LEFT JOIN mahasiswa ON mahasiswa.nim=dosen_wali.mahasiswa_nim
			LEFT JOIN prodi ON prodi.kode=mahasiswa.prodi_kode
			WHERE dosen_wali.dosen_npk='{$_id}'
			ORDER BY mahasiswa.nim ASC";
			$queryb = mysqli_query($koneksi, $sqlb);
		?>

		<table class="table striped hovered border bordered">
			<thead>
				<tr>
					<th>NIM</th>
					<th>Nama</th>
					<th>Tahun Masuk</th>
					<th>Program Studi</th>
					<th></th>
				</tr>
			</thead>
			<tbody>

			<?php
				if (mysqli_num_rows($queryb) > 0):
					while($field = mysqli_fetch_array($queryb)):
			?>
				<tr>
					<td><?= $field['nim'] ?></td>
					<td><?= $field['nama'] ?></td>
					<td><?= $field['tahun_masuk'] ?></td>
					<td><?= $field['prodi_nama'] ?></td>
					<td>
					<?php if ($_access == 'admin'): ?>
					<a href="<?= $_url ?>dosen/delete-mahasiswa/<?= $_id ?>/<?= $field['nim'] ?>/<?= urlencode($field['nama']) ?>"><span class="mif-cross"></span></a>
					<?php endif; ?>
					</td>
				</tr>
			<?php
					endwhile;
				else:
			?>
				<tr>
					<td colspan="5">
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
<?php endif; ?>
-->