<?php
include("config/main.php");
include("config/routing.php");
include "classes/class.phpmailer.php";
if (isset($_GET['nim'])){
$nim = $_GET['nim'];
$sql = mysqli_query($koneksi,   "SELECT student_mahasiswa.*, akademik_konsentrasi.nama_konsentrasi FROM student_mahasiswa
                                LEFT JOIN akademik_konsentrasi ON student_mahasiswa.konsentrasi_id=akademik_konsentrasi.konsentrasi_id
                                WHERE nim='$nim' AND kpt!=1");
$gen = mysqli_fetch_array($sql);
$konsentrasi = $gen['konsentrasi_id'];
$angkatan = $gen['angkatan_id'];
$semester = $gen['semester'];
$email = $gen['email'];
$mail = new PHPMailer; 
$mail->IsSMTP();
$mail->SMTPSecure = 'tls'; 
$mail->Host = "mail.undaris.ac.id"; //host masing2 provider email
$mail->SMTPDebug = 2;
$mail->Port = 26;
$mail->SMTPAuth = true;
$mail->Username = "tagihan@undaris.ac.id"; //user email
$mail->Password = ""; //password email
$mail->SetFrom("tagihan@undaris.ac.id","Tagihan Undaris"); //set email pengirim
$mail->Subject = "Pemberitahuan Tagihan Mahasiswa Undaris"; //subyek email
$mail->AddAddress("$email","Mahasiswa UNDARIS Ungaran"); //tujuan email
if ($gen['status_angsur']==0){
        $biaya = mysqli_query($koneksi,"SELECT keuangan_biaya_kuliah.*, keuangan_jenis_bayar.keterangan
                                        FROM keuangan_jenis_bayar
                                        LEFT JOIN keuangan_biaya_kuliah ON keuangan_jenis_bayar.jenis_bayar_id=keuangan_biaya_kuliah.jenis_bayar_id
                                        WHERE keuangan_biaya_kuliah.konsentrasi_id='$konsentrasi' AND
                                        keuangan_biaya_kuliah.angkatan_id='$angkatan' AND
                                        keuangan_biaya_kuliah.jumlah!=0 AND
                                        keuangan_biaya_kuliah.jenis_bayar_id!=3
                                        GROUP BY keuangan_biaya_kuliah.biaya_kuliah_id");
        
        $spp = mysqli_query($koneksi,"  SELECT * FROM keuangan_biaya_kuliah
                                        WHERE keuangan_biaya_kuliah.konsentrasi_id='$konsentrasi' AND
                                        keuangan_biaya_kuliah.angkatan_id='$angkatan' AND
                                        keuangan_biaya_kuliah.jenis_bayar_id=3");
        
		    $fspp   = $f['jumlah'];
		    $f      = mysqli_fetch_array($spp);
		    $fspp   = $f['jumlah'];
		    $date = date('d-m-Y');
		    
$body .='<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>UNIVERSITAS DARUL ULUM ISLAMIC CENTRE SUDIRMAN GUPPI (UNDARIS)</title>
</head>
<body>
	<center>
		<img src="https://drive.google.com/uc?export=view&amp;id=1GfRSWQIVoQVBM3EnrXuL3ZmZQ4qTVvxu" alt="UNIVERSITAS DARUL ULUM ISLAMIC CENTRE SUDIRMAN GUPPI (UNDARIS)" height="125" width="125">
		<h3>UNIVERSITAS DARUL ULUM ISLAMIC CENTRE SUDIRMAN GUPPI <br> (UNDARIS)</h3>
		<h4>Jl. Tentara Pelajar No.13 Ungaran Kab.Semarang, 50314 ,Jawa Tengah Telp.(024) 6923180 | Fax(022) 76911689</h4>
		<h4><b>____________________________________________________________________________________________________________</b></h4>
	</center>
<div class="container">
    <div class="row">
        <center><h2>SURAT TAGIHAN MAHASISWA</h2></center>
        <br><br>
        <h4 align="right">Ungaran, '.$date.'<br>
        Kepada Yth. Pengelola Fakultas, Prodi '.$gen[nama_konsentrasi].'<br>
        di Tempat
        </h4>
        <h4 align="justify">Dengan hormat,<br>
        sehubungan dengan tagihan mahasiswa di bawah ini :</h4>
        <table border="0px" padding="1" align="center" style="width: 600px;" >
            <tr>
                <td>NIM</td><td>:</td><td>'.$gen[nim].'</td>
            </tr>
            <tr>
                <td>Nama</td><td>:</td><td>'.$gen[nama].'</td>
            </tr>
            <tr>
                <td>Fakultas</td><td>:</td><td>'.$gen[nama_konsentrasi].'</td>
            </tr>
            <tr>
                <td>Semester</td><td>:</td><td>'.$gen[semester].'</td>
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
            	</thead>';
            	for($i = 1, $u = $fspp ; $i <= $semester;$i++){
$body .='<tbody>	    
	            <tr>
		    <td>'.$i.'</td>
		    <td>Rp '.$fspp.',-</td>
		    <td>';
		    $bayar = mysqli_query($koneksi,"SELECT * FROM keuangan_pembayaran_detail WHERE nim='$nim' AND semester='$i' AND jenis_bayar_id=3");
		    $ar = mysqli_fetch_array($bayar);
		        if(empty($ar['jumlah'])){
$body .='0';
		        }else{
$body .= 'Rp '.$ar['jumlah'].',-';
		        }
$body .='</td>
		    <td>';
 $bayar = mysqli_query($koneksi,"SELECT * FROM keuangan_pembayaran_detail WHERE nim='$nim' AND semester='$i' AND jenis_bayar_id=3");
		    $ar = mysqli_fetch_array($bayar);
		        if(empty($ar['jumlah'])){
$body .='<b>Tunggakan</b>';
		        }else{
$body .='LUNAS';
		        }
$body .= '</td>
		    </tr>	
	</tbody>';
            	}
$body .='</table>';
$body .='<h4>Tagihan Akademik</h4>
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
            	<tbody>';
$no = 1;
		if (mysqli_num_rows($biaya) > 0):
			while($field = mysqli_fetch_array($biaya)):
			    $fill = $field['jenis_bayar_id'];
$body .='	<tr>
		    <td>'.$no++.'</td>
		    <td>'.$field['keterangan'].'</td>
		    <td>Rp '.$field['jumlah'].',-</td>
		    <td>';
$load = mysqli_query($koneksi,"SELECT jumlah as bayar FROM keuangan_pembayaran_detail
    		    WHERE nim='$nim' AND jenis_bayar_id='$fill'");
    		    $arr = mysqli_fetch_array($load);
    		    if(empty($arr['bayar'])){
$body .='0';
    		    }else{
$body .='Rp '.$arr['bayar'].',-';
    		    }		    
$body .='</td>
		    <td>';
$load = mysqli_query($koneksi,"SELECT jumlah as bayar FROM keuangan_pembayaran_detail
    		    WHERE nim='$nim' AND jenis_bayar_id='$fill'");
    		    $arr = mysqli_fetch_array($load);
		        if(empty($arr['bayar'])){
$body .='<b>Tunggakan</b>';
		        }else{
$body .='LUNAS';
		        }
$body .='</td>
		</tr>';
endwhile;
			else:
$body .='<tr>
			<td colspan="4">
			Data tidak ditemukan
			</td>
		</tr>';
endif;
$body .='</tbody>
	</table>
	<label>Note:</label><br>
	<span style="font-size: 10px;">SPI yang dibayar sesuai gelombang masing-masing mahasiswa.
	<br>SKS SMT S/M biaya tambahan untuk mahasiswa kelas sabtu dan minggu.
	<br>SKS Kelas F biaya tambahan untuk mahasiswa kelas jauh.
	<br>Khusus Mahasiswa Konversi Tagihan SKS tidak termasuk data di atas.
	<br>Abaikan biaya diatas, jika anda tidak sesuai dengan pernyataan di atas.</span>
            </div>
        </div>
    </div>';
$body .='<h4 align="justify">Mengingat tagihan mahasiswa tersebut dimohon kerja sama untuk menyampaikan tagihan kepada mahasiswa yang bersangkutan.<br>
Demikian pemberitahuan ini kami sampaikan atas perhatiannya kami ucapkan terimakasih.</h4>
<table style="width: 600px;">

<tr>
	<td><h4>Mengetahui Biro Administrasi Umum</h4></td><td></td>
</tr>
<tr><td><br><br><br><br>__________________________________</td><td></td></tr>
</table>
    </div>
</div>
</body>';

}else{
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

$body.='<label>Tagihan Biaya Bulanan Mahasiswa</label>
    <p>Masuk angsuran ke - '.$angsuran.'</p>
    <p>Biaya Bulanan : Rp '.$bulanan.',-</p>
    <p>Tunggakan biaya bulanan : ';
    if ($tunggakan<$itung){
$body.='<b>Tidak Ada Tunggakan</b>';
    }else{
$body.=$tunggakan.' kali';
    } 
}
$mail->msgHTML($body);
if($mail->Send()) echo "Message has been sent";
else echo "Failed to sending message";
}
?>
