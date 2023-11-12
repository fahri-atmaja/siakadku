<?php
$load = mysqli_query($koneksipmb,"SELECT * FROM pendaftar 
                                    LEFT JOIN regist ON regist.email=pendaftar.email
                                    WHERE regist.nim='$_username'");
?>
<h1>
<a href="<?= $_url ?>" class="nav-button transform"><span></span></a>
PMB UNDARIS
</h1>
<hr>
<div class="container">
    <div class="row">
<h3>Jadilah pelopor "UNDARIS GUMREGAH" dengan membangun bersama agar UNDARIS semakin dikenal masyarakat luas<br>
Ajak saudara, teman, kerabat, masyarakat luas untuk kuliah di UNDARIS<br>
Dapatkan bonus/fee dari Universitas dengan mendaftarkan mahasiswa kelas reguler<br>
berikut link anda :
</h3>
<input class="form-copy" id="text-copy" value="https://pmb.undaris.ac.id/pendaftaran.php?ref=<?= $_username ?>" readonly>
<button class="button primary" onclick="copyText()">
    <span class="fa fa-copy"></span> COPY
</button>
    </div>
</div>
<hr>
<h1>Daftar Member Anda :</h1>
<div class="container"> 
<div class="table-responsive">
<table id="dtHorizontalExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th>No</th>
			<th>NIK</th>
			<th>Nama</th>
			<th>Prodi</th>
			<th>Progress</th>
			<!--<th>Jatuh Tempo</th>-->
			<!--<th>Aksi</th>-->
		</tr>
	</thead>
	<tbody>

	<?php
		$no=1;
		if (mysqli_num_rows($load) > 0):
			while($f = mysqli_fetch_array($load)):
	?>
		<tr>
			<td><?= $no++ ?></td>
			<td><?= $f['nik']; ?></td>
			<td><?= $f['nama']; ?></td>
			<?php
			$loadprodi = mysqli_query($koneksi,"SELECT nama_konsentrasi FROM akademik_konsentrasi WHERE konsentrasi_id='$f[konsentrasi_id]'");
			$v = mysqli_fetch_array($loadprodi);
			?>
			<td><?= $v['nama_konsentrasi']; ?></td>
			<td>
          <?php
           $loadtransaksi = mysqli_query($koneksipmb,"SELECT * FROM proses_transaksi WHERE email='$f[email]' and status='Y'");
           $progres = mysqli_num_rows($loadtransaksi);
           ?>
           <?php
           if(empty($progres)):
           ?>
           0%
            <?php
            elseif($progres==1):
            ?>
            25%
            <?php
            elseif($progres==2):
            ?>
            50%
            <?php
            elseif($progres==3):
            ?>
            75%
            <?php
            elseif($progres==4):
            ?>
            100%
            <?php
            endif;
            ?>
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
    </div>
    <h3>Klaim Bonus Untuk Progress 100%</h3>
</div>
</div>

<script>
    function copyText() {  
    var copyText = document.getElementById("text-copy");  
    copyText.select();  
    document.execCommand("copy");
}
</script>