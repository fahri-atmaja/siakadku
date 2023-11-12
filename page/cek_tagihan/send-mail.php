<?php
$mail = new PHPMailer; 
$mail->IsSMTP();
$mail->SMTPSecure = 'tls'; 
$mail->Host = "undaris.ac.id"; //host masing2 provider email
$mail->SMTPDebug = 2;
$mail->Port = 26;
$mail->SMTPAuth = true;
$mail->Username = "tagihan@undaris.ac.id"; //user email
$mail->Password = "und4r15!$"; //password email
$mail->SetFrom("tagihan@undaris.ac.id","Tagihan Biaya Akademik Undaris"); //set email pengirim
$mail->Subject = "Pemberitahuan Email dari Website"; //subyek email
$mail->AddAddress("webable.id@gmail.com","Calon Mahasiswa Undaris"); //tujuan email
$mail->MsgHTML("Selamat!! Anda sudah terdaftar sebagai calon mahasiswa undaris. Berikut detail login anda untuk melengkapi biodata dan pembayaran<br>
                Email :  <br>
                Kode Login : <br>
                    Silahkan login di https://pmb.undaris.ac.id/calonmahasiswa/login.php");
if($mail->Send()) echo "Message has been sent";
else echo "Failed to sending message";
?>