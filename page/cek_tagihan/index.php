<div class="container">
    <div class="row">
        <h1>
<a href="<?= $_url ?><?= in_array($_access, array('admin','dosen')) ? '' : '' ?>" class="nav-button transform"><span></span></a>
Cek Tagihan Mahasiswa
</h1>
        <form method="GET">
        <label>NIM :</label><br>
        <input type="text" name="nim" id="nim" value=""><br>
        <button type="submit">Cek Tagihan</button>
        </form>
    </div>
    <?php
    if (isset($_GET['nim'])){
     $nim = $_GET['nim'];
     $sql = mysqli_query($koneksi,"SELECT * FROM student_mahasiswa WHERE nim='$nim' AND KPT!=1");
     $gen = mysqli_fetch_array($sql);
     $konsentrasi = $gen['konsentrasi_id'];
     $angkatan = $gen['angkatan_id'];
     $semester = $gen['semester'];
        }
        ?>
    <?php
    if (mysqli_num_rows($sql) > 0){?>
    <div class="row">
        <table border='0px' width='80%'>
            <tr>
                <td>Nama</td><td>:</td><td><?= $gen['nama'];?></td>
            </tr>
            <tr>
                <td>Semester</td><td>:</td><td><?= $gen['semester']; ?></td>
            </tr>
        </table>
    </div>
    <!-- mahasiswa reguler -->
    <?php
    if ($gen['id_sks']==1 AND $gen['status_angsur']==0){
        $biaya = mysqli_query($koneksi,"SELECT keuangan_biaya_kuliah.*, keuangan_jenis_bayar.keterangan
                                        FROM keuangan_jenis_bayar
                                        LEFT JOIN keuangan_biaya_kuliah ON keuangan_jenis_bayar.jenis_bayar_id=keuangan_biaya_kuliah.jenis_bayar_id
                                        WHERE keuangan_biaya_kuliah.konsentrasi_id='$konsentrasi' AND
                                        keuangan_biaya_kuliah.angkatan_id='$angkatan' AND
                                        keuangan_biaya_kuliah.jumlah!=0 AND
                                        keuangan_biaya_kuliah.jenis_bayar_id!=3
                                        GROUP BY keuangan_biaya_kuliah.biaya_kuliah_id");
        
        $spp = mysqli_query($koneksi,   "SELECT * FROM keuangan_biaya_kuliah
                                        WHERE keuangan_biaya_kuliah.konsentrasi_id='$konsentrasi' AND
                                        keuangan_biaya_kuliah.angkatan_id='$angkatan' AND
                                        keuangan_biaya_kuliah.jenis_bayar_id=3");
        
       
		    
		    $fspp = $f['jumlah'];
		    $f = mysqli_fetch_array($spp);
		    $fspp = $f['jumlah'];
    ?>
    <div class="container">
        <div class="row">
            <div class="col-md">
            <button class="button success"><a target="_BLANK" href="<?= $_url ?>cek_tagihan/surat-reguler/<?= $nim ?>">Cetak Surat Tagihan</a></button>
            </div>
            <div class="col-md">
            <label>Note:</label><br>
	<p style="font-size: 10px;">SPI yang dibayar sesuai gelombang masing-masing mahasiswa.</p>
	<p style="font-size: 10px;">SKS SMT S/M biaya tambahan untuk mahasiswa kelas sabtu dan minggu. </p>
	<p style="font-size: 10px;">SKS Kelas F biaya tambahan untuk mahasiswa kelas jauh.</p>
	<p style="font-size: 10px;">Khusus Mahasiswa Konversi Tagihan SKS tidak termasuk data di bawah.</p>
	<p style="font-size: 10px;">Abaikan biaya di bawah, jika anda tidak sesuai dengan pernyataan di bawah.</p>
	</div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <h3>Tagihan Mahasiswa</h3>
            <label>Tagihan SPP Akademik</label>
            <div class="table-responsive">
            <table id="dtHorizontalExample" class="table table-striped table-bordered table-sm" cellspacing="0"
              width="100%">
            	<thead>
            	    <tr>
            	        <td>Semester</td>
            	        <td>Tagihan</td>
            	        <td>Jumlah Bayar</td>
            	        <td>Status</td>
            	    </tr>
            	</thead>
            	<?php
            	
            	for($i = 1, $u = $fspp ; $i <= $semester;$i++){
            	    ?>
            	<tbody>	    
	            <tr>
		    <td><?php echo "$i"; ?></td>
		    <td><?php echo "Rp ".$fspp.",-"; ?></td>
		    <td><?php
		    $bayar = mysqli_query($koneksi,"SELECT * FROM keuangan_pembayaran_detail WHERE nim='$nim' AND semester='$i' AND jenis_bayar_id=3");
		    $ar = mysqli_fetch_array($bayar);
		        if(empty($ar['jumlah'])){
		            echo "0";
		        }else{
		            echo "Rp ".$ar['jumlah'].",-";
		        } ?>
		    </td>
		    <td><?php
		    $bayar = mysqli_query($koneksi,"SELECT * FROM keuangan_pembayaran_detail WHERE nim='$nim' AND semester='$i' AND jenis_bayar_id=3");
		    $ar = mysqli_fetch_array($bayar);
		        if(empty($ar['jumlah'])){
		            echo "<b>Tunggakan</b>";
		        }else{
		            echo "LUNAS";
		        } ?>
		    </td>
		    </tr>	
	</tbody>
		    <?php
		    } 
		    ?>
	</table>
	        
<!-- Tagihan Akademik -->            	    
            <label>Tagihan Akademik</label>
            <div class="table-responsive">
            <table id="dtHorizontalExample" class="table table-striped table-bordered table-sm" cellspacing="0"
              width="100%">
            	<thead>
            	    <tr>
            	        <td>No.</td>
            	        <td>Jenis Biaya</td>
            	        <td>Tagihan</td>
            	        <td>Jumlah Bayar</td>
            	        <td>Status</td>
            	    </tr>
            	</thead>
            	<tbody>
	<?php
		$no = 1;
		if (mysqli_num_rows($biaya) > 0):
			while($field = mysqli_fetch_array($biaya)):
			    $fill = $field['jenis_bayar_id'];
	?>
		<tr>
		    <td><?= $no++ ?></td>
		    <td><?= $field['keterangan']; ?></td>
		    <td><?= "Rp ".$field['jumlah'].",-"; ?></td>
		    <td>
    		    <?php 
    		    $load = mysqli_query($koneksi,"SELECT jumlah as bayar FROM keuangan_pembayaran_detail
    		    WHERE nim='$nim' AND jenis_bayar_id='$fill'");
    		    $arr = mysqli_fetch_array($load);
    		    if(empty($arr['bayar'])){
    		        echo "0";
    		    }else{
    		        echo "Rp ".$arr['bayar'].",-";
    		    } ?>
		    </td>
		    <td>
		        <?php
		        $load = mysqli_query($koneksi,"SELECT jumlah as bayar FROM keuangan_pembayaran_detail
    		    WHERE nim='$nim' AND jenis_bayar_id='$fill'");
    		    $arr = mysqli_fetch_array($load);
		        if(empty($arr['bayar'])){
		            echo "<b>Tunggakan</b>";
		        }else{
		            echo "LUNAS";
		        } ?>
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
        </div>
    </div>
    <?php
    }
    ?>
    <!-- mahasiswa konversi -->
    <?php
    if ($gen['id_sks']==2 AND $gen['status_angsur']==0){
        $krs = mysqli_query($koneksi,   "SELECT * FROM bayar_sks
                                        WHERE nim='$nim'");
        $sql    = "SELECT akademik_krs.*, akademik_tahun_akademik.keterangan, sum(makul_matakuliah.sks) as sum FROM
            akademik_krs
            LEFT JOIN akademik_jadwal_kuliah ON akademik_jadwal_kuliah.jadwal_id=akademik_krs.jadwal_id
            LEFT JOIN makul_matakuliah ON makul_matakuliah.makul_id=akademik_jadwal_kuliah.makul_id
            LEFT JOIN student_mahasiswa ON student_mahasiswa.nim=akademik_krs.nim
            LEFT JOIN akademik_tahun_akademik ON akademik_tahun_akademik.tahun_akademik_id=akademik_jadwal_kuliah.tahun_akademik_id
            WHERE student_mahasiswa.nim='$nim' GROUP BY akademik_krs.konversi";
	    $query = mysqli_query($koneksi, $sql);
    ?>
    <div class="container">
        <div class="row">
            <h3>MAHASISWA KONVERSI</h3>
    <label>Riwayat KRS Mahasiswa</label>
    <div class="table-responsive">
<table id="dtHorizontalExample" class="table table-striped table-bordered table-sm" cellspacing="0"
  width="100%">
	<thead>
		<tr>
		    <th>Tahun Akademik</th>
			<th>Semester</th>
			<th>SKS</th>
			<th>Disetujui</th>
			<th>Aksi</th>
		</tr>
	</thead>
	<tbody>
	<?php
		
		if (mysqli_num_rows($query) > 0):
			while($field = mysqli_fetch_array($query)):
				$sks=$sks+$field['sum'];
				$sem = $field['konversi'];
	?>
		<tr>
		    <td><?= $field['keterangan'] ?></td>
			<td><?= $field['konversi'] ?></td>
			<td><?= $field['sum'] ?></td>
			<td><?= $field['accept']==1?'sudah disetujui':'belum disetujui'; ?></td>
			<td>
			<div class="inline-block">
			    <?php
			    if ($field['accept']==1):
			    ?>
				    <a href="<?= $_url ?>cek_tagihan/insert?nim=<?= $field['nim'] ?>&semester=<?= $field['konversi'] ?>&id_sks=2&jumlah_sks=<?= $field['sum'] ?>" class="place-right"><span class="mif-pencil">Masukan Tagihan</span></a>
			    <?php else: ?>
			    <b>Belum Disetujui</b>
			    <?php endif; ?>
			</div></td>
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
	<tfoot>
	<tr><td colspan='2' align='right'>Total SKS yang ditempuh</td><td><?php 
			echo $sks ?></td><td colspan=3></td></tr>
	</tfoot>
</table>
</div>
    <label>Riwayat Pembayaran</label>
    <table class="table striped hovered border bordered">
	<thead>
		<tr>
			<th>Semester</th>
			<th>Jumlah SKS</th>
			<th>Jumlah Bayar</th>
			<th>Tanggal Bayar</th>
			<th>Status</th>
			<th>Aksi</th>
		</tr>
	</thead>
	<tbody>

	<?php
		if (mysqli_num_rows($krs) > 0):
			while($field = mysqli_fetch_array($krs)):
	?>
		<tr>
			<td><?= $field['semester'] ?></td>
			<td><?= $field['jumlah_sks'] ?></td>
			<td><?= $field['jumlah_bayar'] ?></td>
			<td><?= $field['tanggal_bayar'] ?></td>
			<td><?= $field['status']==1?'<i>Sudah Lunas</i>':'<b>Belum Lunas</b>'; ?></td>
			<td><?php if($field['status']==0): ?>
			<a target="_BLANK" href="<?= $_url ?>cek_tagihan/surat/<?= $field['biaya_id'] ?>">Cetak Surat Tagihan</a>
			<?php endif; ?>
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
</div>
    <?php
    }
    // Mahasiswa Reguler Bulanan
    if ($gen['id_sks']==1 AND $gen['status_angsur']==1){
        $angkatan = $gen['angkatan_id'];
        $sql = mysqli_query($koneksi,"SELECT * FROM peringatan_angsuran WHERE angkatan_id='$angkatan'");
        $cek = mysqli_query($koneksi,"SELECT * FROM bayar_angsuran WHERE nim='$nim'");
        $cek1 = mysqli_query($koneksi,"SELECT * FROM bayar_angsuran WHERE nim='$nim'");
        $biaya = mysqli_query($koneksi,"SELECT * FROM biaya_angsuran WHERE konsentrasi_id='$gen[konsentrasi_id]'");
        $disbiaya = mysqli_fetch_array($biaya);
        $bulanan = $disbiaya['total_biaya']/$disbiaya['jumlah_angsur'];
        $dissql = mysqli_fetch_array($sql);
        $itung = mysqli_num_rows($cek);
        $angsuran = $dissql['angsuran'];
        $tunggakan = $angsuran-$itung;
        $discek = mysqli_fetch_array($cek);
        ?>
    <label>Tagihan Biaya Bulanan Mahasiswa</label>
    <p>Masuk angsuran ke - <?= $angsuran ?></p>
    <p>Biaya Bulanan : Rp <?= $bulanan ?>,-</p>
    <p>Tunggakan biaya bulanan : 
    <?php if ($tunggakan<$itung){
    echo "<b>Tidak Ada Tunggakan</b>";
    }else{
    echo $tunggakan." kali";
    } 
    ?></p>
    <p><a target="_BLANK" href="<?= $_url ?>cek_tagihan/surat-bulanan?nim=<?= $nim ?>&angsuran=<?= $angsuran ?>&bulanan=<?= $bulanan ?>&tunggakan=<?= $tunggakan ?>">Cetak Surat Tagihan</a></p>
    <br>
    <label>Riwayat Pembayaran Bulanan</label>
        <table class="table striped hovered border bordered">
	<thead>
		<tr>
			<th>Angsuran Ke -</th>
			<th>Jumlah Bayar</th>
			<th>Tanggal Bayar</th>
		</tr>
	</thead>
	<tbody>

	<?php
		if (mysqli_num_rows($cek1) > 0):
			while($field = mysqli_fetch_array($cek1)):
	?>
		<tr>
			<td><?= $field['angsuran'] ?></td>
			<td><?= rupiah($field['bayar']); ?></td>
			<td><?= tgl_indo($field['tanggal']); ?></td>
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
        
    <?php
    }
    // Mahasiswa Konversi Bulanan
    $angkatan = $gen['angkatan_id'];
    if ($gen['id_sks']==2 AND $gen['status_angsur']==1){
        $fak = mysqli_query($koneksi,   "SELECT angsuran_konversi.*, angsuran_konversi_bayar.angsuran, 
                                        angsuran_konversi_bayar.tanggal,angsuran_konversi_bayar.bayar FROM angsuran_konversi
                                        INNER JOIN angsuran_konversi_bayar ON angsuran_konversi_bayar.id_angsur=angsuran_konversi.id_angsur
                                        WHERE angsuran_konversi.nim='$nim' ORDER BY angsuran_konversi.semester ASC,angsuran_konversi_bayar.angsuran ASC");
        $sqll = mysqli_query($koneksi,   "SELECT angsuran_konversi.*, angsuran_konversi_bayar.angsuran, 
                                        angsuran_konversi_bayar.tanggal,angsuran_konversi_bayar.bayar FROM angsuran_konversi
                                        INNER JOIN angsuran_konversi_bayar ON angsuran_konversi_bayar.id_angsur=angsuran_konversi.id_angsur
                                        WHERE angsuran_konversi.nim='$nim' ORDER BY angsuran_konversi.semester ASC,angsuran_konversi_bayar.angsuran ASC");
        // $fak = mysqli_query($koneksi,   "SELECT * FROM `angsuran_konversi_bayar` WHERE nim=19610011");
        $hitung = mysqli_num_rows($sqll);
        $p = mysqli_fetch_array($sqll);
        $angkatan = mysqli_query($koneksi,"SELECT * FROM peringatan_angsuran WHERE angkatan_id='$angkatan'");
        $angsuran = mysqli_fetch_array($angkatan);
        $tagihan = $angsuran['angsuran'];
        $jumlah =  $tagihan-$hitung;
        $biaya = $p['bulanan']*$jumlah;
        ?>
    <label>Tagihan Mahasiswa Konversi Bulanan</label>    
    <p>Masuk angsuran bulan ke - <?= $tagihan; ?></p>
    <p>Biaya per bulan : <?= rupiah($p['bulanan']); ?></p>
    <p>Tunggakan : <?= $jumlah; ?> bulan</p>
    <p>Jumlah Tagihan : <?= rupiah($biaya); ?> </p>
     <p><a target="_BLANK" href="<?= $_url ?>cek_tagihan/surat-bulanan-konversi?nim=<?= $nim ?>">Cetak Surat Tagihan</a></p>
    <br>
    <label>Riwayat Pembayaran Bulanan</label>
        <table class="table striped hovered border bordered">
            <thead>
        		<tr>
        		    <th>Semester</th>
        			<th>Angsuran Ke -</th>
        			<th>Jumlah Bayar</th>
        			<th>Tanggal Bayar</th>
        		</tr>
        	</thead>
	        <tbody>
	            <?php
        		if (mysqli_num_rows($fak) > 0):
        			while($field = mysqli_fetch_array($fak)):
        	    ?>
        		<tr>
        		    <td><?= $field['semester'] ?></td>
        			<td><?= $field['angsuran'] ?></td>
        			<td><?= rupiah($field['bayar']); ?></td>
        			<td><?= tgl_indo($field['tanggal']); ?></td>
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
    
        <?php
    }
    }
    
    ?>
</div>