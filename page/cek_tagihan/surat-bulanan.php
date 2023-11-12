<?php
include "../classes/class.phpmailer.php";
$nim = $_GET['nim'];
$angsuran = $_GET['angsuran'];
$bulanan = $_GET['bulanan'];
$tunggakan = $_GET['tunggakan'];

$mhs = mysqli_query($koneksi,   "SELECT student_mahasiswa.*, akademik_konsentrasi.nama_konsentrasi FROM student_mahasiswa
                                LEFT JOIN akademik_konsentrasi ON student_mahasiswa.konsentrasi_id=akademik_konsentrasi.konsentrasi_id
                                WHERE nim='$nim'");
                                
$fill= mysqli_fetch_array($mhs);

$angkatan = $fill['angkatan_id'];
        $sql = mysqli_query($koneksi,"SELECT * FROM peringatan_angsuran WHERE angkatan_id='$angkatan'");
        $cek = mysqli_query($koneksi,"SELECT * FROM bayar_angsuran WHERE nim='$nim'");
        $cek1 = mysqli_query($koneksi,"SELECT * FROM bayar_angsuran WHERE nim='$nim'");
        $biaya = mysqli_query($koneksi,"SELECT * FROM biaya_angsuran WHERE konsentrasi_id='$fill[konsentrasi_id]'");
        $disbiaya = mysqli_fetch_array($biaya);
        $bulanan1 = $disbiaya['total_biaya']/$disbiaya['jumlah_angsur'];
        $dissql = mysqli_fetch_array($sql);
        $itung = mysqli_num_rows($cek);
        $angsuran1 = $dissql['angsuran'];
        $tunggakan1 = $angsuran-$itung;
        $discek = mysqli_fetch_array($cek);
    // $mail = new PHPMailer;
    // $mail->IsSMTP();
    // $mail->SMTPSecure = ‘tls’;
    // $mail->Host = "localhost"; //hostname masing-masing provider email
    // $mail->SMTPDebug = 2;
    // $mail->Port = 587;
    // $mail->SMTPAuth = true;
    // $mail->Username = "pmb@undaris.ac.id"; //user email
    // $mail->Password = "und4r15!$"; //password email
    // $mail->SetFrom("pmb@undaris.ac.id","PMB Undaris"); //set email pengirim
    // $mail->Subject = "Pemberitahuan Email dari Website"; //subyek email
    // $mail->AddAddress("fahrizalaziz54@gmail.com","Calon Mahasiswa Undaris"); //tujuan email
    // $mail->MsgHTML("Selamat!! Anda sudah terdaftar sebagai calon mahasiswa undaris. Berikut detail login anda untuk melengkapi biodata dan pembayaran<br>
    //                 Email : fixemail <br>
    //                 Kode Login : hasil1<br>
    //                 Silahkan login di https://pmb.undaris.ac.id/calonmahasiswa/login.php
    //                 ");
    // if($mail->Send()) echo "Message has been sent";
    // else echo "Failed to sending message";
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
        <h4 align="right">Ungaran, <?php echo date('d-m-Y')?><br>
        Kepada Yth. Pengelola Fakultas, Prodi <?= $fill['nama_konsentrasi']; ?><br>
        di Tempat
        </h4>
        <h4 align="justify">Dengan hormat,<br>
        sehubungan dengan tagihan bulanan mahasiswa ke- <?= $angsuran1 ?> di bawah ini :</h4>
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
		    <th>Jenis Tagihan</th>
			<th>Biaya</th>
			<th>Tunggakan</th>
		</tr>
	</thead>
	<tbody>

	<?php
				
	?>
		<tr>
		    <td>Biaya Bulanan</td>
			<td>Rp <?= $bulanan ?>,-</td>
			<td><?php if ($tunggakan<$itung){
    echo "<b>Tidak Ada Tunggakan</b>";
    }else{
    echo $tunggakan." kali";
    }  ?></td>
		</tr>
		
	</tbody>
</table>
<label>Riwayat Pembayaran Bulanan</label>
        <table border="1px" width="70%">
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