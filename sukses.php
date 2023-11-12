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

<body>
  <!-- Navigation -->
  <nav class="navbar navbar-light bg-light static-top">
    <div class="container">
      <a class="navbar-brand" href="#">UNDARIS Online SIAKAD Apps</a>
      <!--<a class="btn btn-primary" href="#">Sign In</a>-->
    </div>
  </nav>
  <header class="masthead text-white text-center">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-xl-9 mx-auto">
          <h1 class="mb-5">Email Sudah Terverifikasi!</h1>
              <div class="col-12 col-md-3">
                <a href="https://siakad.undaris.ac.id"><button class="btn btn-block btn-lg btn-primary">Mulai SIAKAD UNDARIS</button></a>
              </div>
        </div>
      </div>
    </div>
  </header>  
  
  
  
  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>