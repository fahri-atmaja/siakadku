<?php
$sql = mysqli_query($koneksi,"SELECT * FROM bayar_sks WHERE biaya_id='$_id'");
$dis = mysqli_fetch_array($sql);
$nim = $dis['nim'];

$mhs = mysqli_query($koneksi,   "SELECT student_mahasiswa.*, akademik_konsentrasi.nama_konsentrasi FROM student_mahasiswa
                                LEFT JOIN akademik_konsentrasi ON student_mahasiswa.konsentrasi_id=akademik_konsentrasi.konsentrasi_id
                                WHERE nim='$nim'");
$fill= mysqli_fetch_array($mhs);
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
		<h4><b>____________________________________________________________________________________________________________</b></h4>
	</center>
<div class="container">
    <div class="row">
        <center><h2>SURAT TAGIHAN MAHASISWA</h2></center>
        <br><br>
        <h4 align="right">Ungaran, <?php echo date('d-m-Y')?><br>
        Kepada Yth. Pengelola Fakultas, Prodi <?= $fill['nama_konsentrasi']; ?><br>
        di Tempat
        </h4>
        <h4 align="justify">Dengan hormat,<br>
        sehubungan dengan tagihan mahasiswa di bawah ini :</h4>
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
        <table border="1px" padding="1" align="center" style="width: 600px;">
	<thead>
		<tr>
		    <th>Tagihan Semester</th>
			<th>SKS diambil</th>
			<th>Total Tagihan</th>
			<th>Status</th>
		</tr>
	</thead>
	<tbody>

	<?php
				
	?>
		<tr>
		    <td><?= $dis['semester'] ?></td>
			<td><?= $dis['jumlah_sks'] ?></td>
			<td><?= $dis['jumlah_bayar'] ?></td>
			<td><?= $dis['status']==0?'<b>Belum Lunas</b>':'<i>Lunas</i>'?></td>
		</tr>
		
	</tbody>
</table>
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