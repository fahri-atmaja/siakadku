<?php
include("config/main.php");
include("config/routing.php");
include "classes/class.phpmailer.php";

$angka = range(0,9);
shuffle($angka);
$ambilangka=array_rand($angka,6);
$angkastring=implode("-",$ambilangka);
$code=$angkastring;
    $email = "gandrunx.day@gmail.com";
        $mail = new PHPMailer; 
        $mail->IsSMTP();
        $mail->SMTPSecure = 'tls'; 
        $mail->Host = "mail.undaris.ac.id"; //host masing2 provider email
        $mail->SMTPDebug = 2;
        $mail->Port = 26;
        $mail->SMTPAuth = true;
        $mail->Username = "siakad@undaris.ac.id"; //user email
        $mail->Password = "und4r15!$"; //password email
        $mail->SetFrom("siakad@undaris.ac.id","SIAKAD Undaris"); //set email pengirim
        $mail->Subject = "Verifikasi Email"; //subyek email
        $mail->AddAddress($email,"Mahasiswa UNDARIS Ungaran");
        $body =
        '<html>
        <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        	<title>UNIVERSITAS DARUL ULUM ISLAMIC CENTRE SUDIRMAN GUPPI (UNDARIS)</title>
        </head>
        <body>
        	<center>
        		<img src="https://drive.google.com/uc?export=view&amp;id=1GfRSWQIVoQVBM3EnrXuL3ZmZQ4qTVvxu" alt="UNIVERSITAS DARUL ULUM ISLAMIC CENTRE SUDIRMAN GUPPI (UNDARIS)" height="100" width="100">
        		<h3>UNIVERSITAS DARUL ULUM ISLAMIC CENTRE SUDIRMAN GUPPI (UNDARIS)</h3>
        		<h4>Jl. Tentara Pelajar No.13 Ungaran Kab.Semarang, 50314 ,Jawa Tengah Telp.(024) 6923180 | Fax(022) 76911689</h4>
        		<h4><b>____________________________________________________________________________________________________________</b></h4>
        	</center>
        <div class="container">
            <div class="row">
            <center>
                <h3>Copy Kode dibawah:</h3>
                <h2>Kode Verifikasi Anda : '.$code.'</h2>
                <h3> Gunakan Strip "-"</h3>
            </center>
            </div>
        </div>
        </body>
        </html>
        ';
        $mail->msgHTML($body);
        echo $mail->Send();