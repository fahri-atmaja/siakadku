<?php
     $nim = $_id;;
     $sql = mysqli_query($koneksi,"SELECT * FROM student_mahasiswa WHERE nim='$nim' AND KPT!=1");
     $gen = mysqli_fetch_array($sql);
     $konsentrasi = $gen['konsentrasi_id'];
     $angkatan = $gen['angkatan_id'];
     $semester = $gen['semester'];
     $email = $gen['email'];
$mail = new PHPMailer; 
$mail->IsSMTP();
$mail->SMTPSecure = 'tls'; 
$mail->Host = "localhost"; //host masing2 provider email
$mail->SMTPDebug = 2;
$mail->Port = 587;
$mail->SMTPAuth = true;
$mail->Username = "tagihan@undaris.ac.id"; //user email
$mail->Password = "und4r15!$"; //password email
$mail->SetFrom("tagihan@undaris.ac.id","Tagihan Biaya Akademik Undaris"); //set email pengirim
$mail->Subject = "Pemberitahuan Email dari Website"; //subyek email
$mail->AddAddress("$email","Tagihan Biaya Akademik Undaris"); //tujuan email
    $mail->MsgHTML("Test Tagihan");
if($mail->Send()) echo "Message has been sent";
else echo "Failed to sending message";
?>