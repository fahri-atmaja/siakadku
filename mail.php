<?php
$visitor_email = "tagihan@undaris.ac.id";
$name 		   = "TAGIHAN BIAYA AKADEMIK UNDARIS";
$user_message  = "Jika anda menerima pesan ini berarti anda berhasil bangsat";
		   require 'classes/class.phpmailer.php'; // path to the PHPMailer class
       	   require 'classes/class.smtp.php';
           $mail = new PHPMailer();
           $mail->IsSMTP();  // telling the class to use SMTP
           $mail->SMTPDebug = 2;
           $mail->Mailer = "smpt";
           $mail->Host = "mail.undaris.ac.id";
           $mail->Port = 26;
           $mail->SMTPAuth = true; // turn on SMTP authentication
           $mail->Username = "tagihan@undaris.ac.id"; // SMTP username
           $mail->Password = "und4r15!$"; // SMTP password
           $mail->Priority = 1;
           $mail->AddAddress("fahrizalaziz54@gmail.com","Hai Test Message");
           $mail->SetFrom($visitor_email, $name);
           $mail->AddReplyTo($visitor_email,$name);
           $mail->Subject  = "This is a Test Message";
           $mail->Body     = $user_message;
           $mail->WordWrap = 50;
           if(!$mail->Send()) {
           echo 'Message was not sent.';
           echo 'Mailer error: ' . $mail->ErrorInfo;
           } else {
           echo 'Message has been sent.';
           }
?>