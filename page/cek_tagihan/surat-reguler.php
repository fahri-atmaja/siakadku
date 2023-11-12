<?php
    //  $sql = mysqli_query($koneksi,"SELECT * FROM student_mahasiswa WHERE nim='$_id' AND KPT!=1");
     $sql = mysqli_query($koneksi,   "SELECT student_mahasiswa.*, akademik_konsentrasi.nama_konsentrasi FROM student_mahasiswa
                                LEFT JOIN akademik_konsentrasi ON student_mahasiswa.konsentrasi_id=akademik_konsentrasi.konsentrasi_id
                                WHERE nim='$_id' AND kpt!=1");
     $gen = mysqli_fetch_array($sql);
     $konsentrasi = $gen['konsentrasi_id'];
     $angkatan = $gen['angkatan_id'];
     $semester = $gen['semester'];
    if ($gen['status_angsur']==0){
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
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>UNIVERSITAS DARUL ULUM ISLAMIC CENTRE SUDIRMAN GUPPI (UNDARIS)</title>
</head>
<a href="javascript:printDiv('cetak');"><span style="color: red; font-size: 50;"><b><i><u>PRINT</u></i></b></span></a>
<div id="cetak">
<body>
	<center>
		<img src="../../assets/img/logo/logo.png" alt="UNIVERSITAS DARUL ULUM ISLAMIC CENTRE SUDIRMAN GUPPI (UNDARIS)" height="125" width="125">
		<h3>UNIVERSITAS DARUL ULUM ISLAMIC CENTRE SUDIRMAN GUPPI <br> (UNDARIS)</h3>
		<h4>Jl. Tentara Pelajar No.13 Ungaran Kab.Semarang, 50314 ,Jawa Tengah Telp.(024) 6923180 | Fax(022) 76911689</h4>
		<h4><b>_______________________________________________________________</b></h4>
	</center>
<div class="container">
    <div class="row">
        <center><h2>SURAT TAGIHAN MAHASISWA</h2></center>
        <br><br>
        <h4 align="right">Ungaran, <?php echo date('d-m-Y')?><br>
        Kepada Yth. Pengelola Fakultas, Prodi <?= $gen['nama_konsentrasi']; ?><br>
        di Tempat
        </h4>
        <h4 align="justify">Dengan hormat,<br>
        sehubungan dengan tagihan mahasiswa di bawah ini :</h4>
        <table border="0px" padding="1" align="center" style="width: 600px;" >
            <tr>
                <td>NIM</td><td>:</td><td><?= $gen['nim']; ?></td>
            </tr>
            <tr>
                <td>Nama</td><td>:</td><td><?= $gen['nama']; ?></td>
            </tr>
            <tr>
                <td>Fakultas</td><td>:</td><td><?= $gen['nama_konsentrasi']; ?></td>
            </tr>
            <tr>
                <td>Semester</td><td>:</td><td><?= $gen['semester']; ?></td>
            </tr>
        </table>
        <br>
    </div>
        <div class="row">
            <h3>Tagihan Mahasiswa</h3>
            <h4>Tagihan SPP Akademik</h4>
            <div class="table-responsive">
            <table border="1px" width="100%">
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
		    $bayar = mysqli_query($koneksi,"SELECT * FROM keuangan_pembayaran_detail WHERE nim='$_id' AND semester='$i' AND jenis_bayar_id=3");
		    $ar = mysqli_fetch_array($bayar);
		        if(empty($ar['jumlah'])){
		            echo "0";
		        }else{
		            echo "Rp ".$ar['jumlah'].",-";
		        } ?>
		    </td>
		    <td><?php
		    $bayar = mysqli_query($koneksi,"SELECT * FROM keuangan_pembayaran_detail WHERE nim='$_id' AND semester='$i' AND jenis_bayar_id=3");
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
            <h4>Tagihan Akademik</h4>
            <div class="table-responsive">
            <table border="1px" width="100%">
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
    		    WHERE nim='$_id' AND jenis_bayar_id='$fill'");
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
    		    WHERE nim='$_id' AND jenis_bayar_id='$fill'");
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
	<label>Note:</label><br>
	<span style="font-size: 10px;">SPI yang dibayar sesuai gelombang masing-masing mahasiswa.
	<br>SKS SMT S/M biaya tambahan untuk mahasiswa kelas sabtu dan minggu.
	<br>SKS Kelas F biaya tambahan untuk mahasiswa kelas jauh.
	<br>Khusus Mahasiswa Konversi Tagihan SKS tidak termasuk data di atas.
	<br>Abaikan biaya diatas, jika anda tidak sesuai dengan pernyataan di atas.</span>
            </div>
        </div>
    </div>
    <?php
    }
    ?>
    <h4 align="justify">Mengingat tagihan mahasiswa tersebut dimohon kerja sama untuk menyampaikan tagihan kepada mahasiswa yang bersangkutan.<br>
Demikian pemberitahuan ini kami sampaikan atas perhatiannya kami ucapkan terimakasih.</h4>
<table style="width: 600px;">

<tr>
	<td><h4>Mengetahui Biro Administrasi Umum</h4></td><td></td>
</tr>
<tr><td><br><br><br><br>__________________________________</td><td></td></tr>
</table>
    </div>
</div>
</body>
</div>
<textarea id="printing-css" style="display:none;">.no-print{display:none}</textarea>
<iframe id="printing-frame" name="print_frame" src="about:blank" style="display:none;"></iframe>
<script type="text/javascript">
function printDiv(elementId) {
 var a = document.getElementById('printing-css').value;
 var b = document.getElementById(elementId).innerHTML;
 window.frames["print_frame"].document.title = document.title;
 window.frames["print_frame"].document.body.innerHTML = '<style>' + a + '</style>' + b;
 window.frames["print_frame"].window.focus();
 window.frames["print_frame"].window.print();
}
</script>
</html>