<?php
$select = mysqli_query($koneksi,"SELECT * FROM student_mahasiswa WHERE nim='$_username'");
$view = mysqli_fetch_array($select);
?>
<div class="grid">
    <div class="container-fluid">
        <div class="row">
            <h3>Verifikasi Email Anda</h3>
            <form method="POST">
                <div class="form-group">
                    <label>Email Anda</label>
                    <input type="text" name="email" id="email" value="<?= $view['email']; ?>">
                </div>
                <div class="form-group">
                    <button class="button primary" type="submit">Proses</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php

if (isset($_POST['email'])) {
$angka = range(0,9);
shuffle($angka);
$ambilangka=array_rand($angka,6);
$angkastring=implode("-",$ambilangka);
$code=$angkastring;
    $email = $_POST['email'];
    $cek = mysqli_query($koneksi,"SELECT email FROM email_verifikasi WHERE email='$email'");
    if (mysqli_num_rows($cek) > 0){
        echo "<script>window.alert('Email Anda Sudah terdaftar! Silahkan verifikasi cek kode di inbox anda.')
		    window.location.href='{$_url}email/verifikasi'</script>";
    }else{
    $input = mysqli_query($koneksi,"INSERT INTO email_verifikasi(nim,email,code,status) VALUES('$_username','$email','$code','0')");
    if($input){
        include "../../classes/class.phpmailer.php";
        $mail = new PHPMailer; 
        $mail->IsSMTP();
        $mail->SMTPSecure = 'tls'; 
        $mail->Host = "mail.undaris.ac.id"; //host masing2 provider email
        $mail->SMTPDebug = 2;
        $mail->Port = 26;
        $mail->SMTPAuth = true;
        $mail->Username = "tagihan@undaris.ac.id"; //user email
        $mail->Password = "und4r15!$"; //password email
        $mail->SetFrom("tagihan@undaris.ac.id","SIAKAD Undaris"); //set email pengirim
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
                <h4>Kode Verifikasi Anda : '.$code.'</h4>
            </center>
            </div>
        </div>
        </body>
        </html>
        ';
        $mail->msgHTML($body);
		echo "<script>$.Notify({
		    caption: 'Success',
		    content: 'Email Berhasil ditambah',
    		type: 'success'
		});
		setTimeout(function(){ window.location.href='{$_url}email/verifikasi'; }, 2000);
		</script>";
		
	} else {
		echo "<script>$.Notify({
		    caption: 'Failed',
		    content: 'Email Gagal Ditambah',
		    type: 'alert'
		});</script>";
	}

}
}
?>