<!DOCTYPE html>
<?php
include("config/main.php");
include("config/routing.php");
include "classes/class.phpmailer.php";
if(empty($_access)){
    echo "<script>window.alert('Halaman Tidak Dapat Diakses.')
		    window.location.href='https://siakad.undaris.ac.id'</script>";
}
?>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="UNDARIS Online Apps yang digunakan untuk mengatur kegiatan mandiri mahasiswa">
    <meta name="keywords" content="UNDARIS, Undaris Ungaran, Siakad Undaris, UNDARIS Siakad Online Apps, Undaris KRS, Undaris KHS, SIM Undaris, Mahasiswa Undaris">
    <meta name="author" content="Fahri Atmaja">

  <link rel='shortcut icon' type='image/x-icon' href='favicon.ico' />
    <title>UNDARIS Online SIAKAD Apps</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom fonts for this template -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

  <!-- Custom styles for this template -->
  <link href="css/landing-page.min.css" rel="stylesheet">

</head>
<?php
    $load = mysqli_query($koneksi,"SELECT * FROM email_verifikasi WHERE nim='$_username'");
    $view = mysqli_fetch_array($load);
    if($view['status']==1){
        echo "<script>window.alert('Anda sudah verifikasi email.')
		    window.location.href='https://siakad.undaris.ac.id'</script>";
    }
?>
<body>

  <!-- Navigation -->
  <nav class="navbar navbar-light bg-light static-top">
    <div class="container">
      <a class="navbar-brand" href="#">UNDARIS Online SIAKAD Apps</a>
      <!--<a class="btn btn-primary" href="#">Sign In</a>-->
    </div>
  </nav>
  <!-- Masthead -->
  <header class="masthead text-white text-center">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-xl-9 mx-auto">
            <h1 class="mb-5">Update Email!</h1>
          <h1 class="mb-5">Silahkan masukan email aktif anda!</h1>
        </div>
        <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">
          <form method="POST">
            <div class="form-row">
              <div class="col-12 col-md-9 mb-2 mb-md-0">
                <input type="text" name="email" class="form-control form-control-lg" placeholder="Enter your email..." value="">
              </div>
              <div class="col-12 col-md-3">
                <button type="submit" class="btn btn-block btn-lg btn-primary">Verifikasi!</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </header>

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
		    window.location.href='https://siakad.undaris.ac.id/verifikasi.php'</script>";
    }else{
    $input = mysqli_query($koneksi,"UPDATE email_verifikasi SET email='$email',code='$code' WHERE nim='$_username'");
    if($input){
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
                <h3>Copy Kode dibawah</h3>
                <h2>Kode Verifikasi Anda : '.$code.'</h2>
                <h3> Gunakan Strip "-"</h3>
            </center>
            </div>
        </div>
        </body>
        </html>
        ';
        $mail->msgHTML($body);
        if($mail->Send()) echo "
        <script>window.location.href='https://siakad.undaris.ac.id/verifikasi.php'</script>";
        else echo "Failed to sending message";
		
		
	} else {
		echo "<div class='alert alert-danger' role='alert'>
        Email Gagal.
        </div>";
	}

}
}
?>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>