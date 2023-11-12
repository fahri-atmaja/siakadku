<?php
    $nim = $_GET['nim'];
    $mhs = mysqli_query($koneksi,   "SELECT student_mahasiswa.*, akademik_konsentrasi.nama_konsentrasi FROM student_mahasiswa
                                LEFT JOIN akademik_konsentrasi ON student_mahasiswa.konsentrasi_id=akademik_konsentrasi.konsentrasi_id
                                WHERE nim='$nim'");
        $fill= mysqli_fetch_array($mhs);
     $sql = mysqli_query($koneksi,"SELECT * FROM student_mahasiswa WHERE nim='$nim' AND KPT!=1");
     $gen = mysqli_fetch_array($sql);
     $konsentrasi = $gen['konsentrasi_id'];
     $angkatan = $gen['angkatan_id'];
     $semester = $gen['semester'];
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
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>UNIVERSITAS DARUL ULUM ISLAMIC CENTRE SUDIRMAN GUPPI (UNDARIS)</title>
</head>
<a href="javascript:printDiv('cetak');"><span style="color: red; font-size: 50;"><b><i><u>PRINT</u></i></b></span></a>
<div id="cetak">
<body>
	<center>
		<img src="../../assets/img/logo/logo.png" alt="UNIVERSITAS DARUL ULUM ISLAMIC CENTRE SUDIRMAN GUPPI (UNDARIS)" height="100" width="100">
		<h3>UNIVERSITAS DARUL ULUM ISLAMIC CENTRE SUDIRMAN GUPPI <br> (UNDARIS)</h3>
		<h4>Jl. Tentara Pelajar No.13 Ungaran Kab.Semarang, 50314 ,Jawa Tengah Telp.(024) 6923180 | Fax(022) 76911689</h4>
		<h4><b>____________________________________________________________________________________________________________</b></h4>
	</center>
<div class="container">
    <div class="row">
        <center><h3>SURAT TAGIHAN BULANAN MAHASISWA</h3></center>
        <h4 align="right">Ungaran, <?php echo tgl_indo(date('Y-m-d'))?></h4><br>
        <h4>Kepada Yth. Sdr/Sdri <b><?= $fill['nama']; ?></b><br>
        di Tempat
        </h4>
        <h4 align="justify">Dengan hormat,<br>
        sehubungan dengan tagihan biaya bulanan mahasiswa ke- <?= $tagihan; ?>, bahwa mahasiswa di bawah ini :</h4>
        <table border="0px" padding="1" align="center" style="width: 600px;" >
            <tr>
                <td>NIM</td><td>:</td><td><?= $fill['nim']; ?></td>
            </tr>
            <tr>
                <td>Nama</td><td>:</td><td><?= $fill['nama']; ?></td>
            </tr>
            <tr>
                <td>Fakultas</td><td>:</td><td><?= $fill['nama_konsentrasi']; ?></td>
            </tr>
            <tr>
                <td>Semester</td><td>:</td><td><?= $fill['semester']; ?></td>
            </tr>
        </table>
        <br>
        
        
    <label>Tagihan Mahasiswa Konversi Bulanan</label>    
    <p>Masuk angsuran bulan ke - <?= $tagihan; ?></p>
    <p>Biaya per bulan : <?= rupiah($p['bulanan']); ?></p>
    <p>Tunggakan : <?= $jumlah; ?> bulan</p>
    <p>Jumlah Tagihan : <b><?= rupiah($biaya); ?></b> </p>
    <h4 align="justify">Mengingat tagihan mahasiswa diatas dimohon untuk segera melunasi pembayaran tersebut guna dapat mengikuti UTS/UAS, 
    jika belum maka mahasiswa mendapatkan sanksi tidak dapat mengikuti UTS/UAS atau mendapatkan denda.<br>
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
<?php     
    }
?>