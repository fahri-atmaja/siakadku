<?php
$koneksi        = mysqli_connect('localhost','smilefoo_siakad','Sina_atmaja666','smilefoo_wp');
$email = $_GET['email'];
$load = mysqli_query($koneksi,"SELECT * FROM student_mahasiswa WHERE email='$email'");
$view = mysqli_fetch_array($load);
if(empty($email)){
    echo "<script>window.alert('Email anda kosong, silahkan login kembali')
		    window.location.href='https://pmb.undaris.ac.id/calonmahasiswa'</script>";
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
  <!-- Masthead -->
  <header class="masthead text-white text-center">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-xl-9 mx-auto">
            <h4 class="mb-5">DATA MAHASISWA BARU</h4>
          <h4 class="mb-5">Konfirmasi data anda berhasil!! Silahkan login dengan data dibawah ini :</h4>
        </div>
        <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">
            <div class="form-row">
              <div class="col-12 col-md-9 mb-2 mb-md-0">
                <table border='0px'>
                                            <tr>
                                                <td>NIM</td><td>:</td><td><input type="text" name="nim" class="form-control" value="<?= $view['nim'] ?>" readonly></td>
                                            </tr>
                                            <tr>
                                                <td>Password</td><td>:</td><td><input type='text' name='tgl_lahir' class="form-control" value='<?= $view['tanggal_lahir']; ?>' readonly></td>
                                            </tr>
                </table>
              </div>
              <div class="col-12 col-md-3">
                <a href="https://siakad.undaris.ac.id/sign"><button class="btn btn-block btn-lg btn-primary">Menuju SIAKAD Undaris!!</button></a>
              </div>
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