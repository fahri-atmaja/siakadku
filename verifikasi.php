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
<div class='alert alert-succes' role='alert'>
        Berhasil, kode dikirim ke email anda.
        </div>
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
          <h1 class="mb-5">Cek <b>Inbox atau Spam Email</b> dan Masukan Kode Verifikasi Email Anda!</h1>
        </div>
        <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">
          <form method="POST">
            <div class="form-row">
              <div class="col-12 col-md-9 mb-2 mb-md-0">
                <input type="text" name="kode" class="form-control form-control-lg" placeholder="Enter your code..." value="<?php echo isset($_GET["code"]) && !empty($_GET["code"]) ? $_GET["code"] : '';  ?>">
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
if(isset($_POST['kode'])){
    $ass = mysqli_query($koneksi,"SELECT * FROM email_verifikasi WHERE nim='$_username'");
    if(mysqli_num_rows($ass) > 0){
        $real = mysqli_fetch_array($ass);
        $kode = $_POST['kode'];
        $code = $real['code'];
        $email = $real['email'];
        if($kode===$code){
            $update .= mysqli_query($koneksi,"UPDATE email_verifikasi SET status=1 WHERE nim='$_username'");
            $update .= mysqli_query($koneksi,"UPDATE student_mahasiswa SET email='$email' WHERE nim='$_username'");
            if($update){
                echo "
        <script>window.location.href='https://siakad.undaris.ac.id/sukses.php'</script>";
            }else{
                echo "<div class='alert alert-danger' role='alert'>
        Email Gagal.
        </div>";
            }
        }else{
            echo "<script>window.alert('Kode Salah.. Silahkan Cek Inbox Email Anda..!')</script>";
        }
    }else{
        echo "<script>window.alert('Email anda belum terdaftar! Silahkan verifikasi email anda.')
		    window.location.href='https://siakad.undaris.ac.id/input-email.php'</script>";
    }
}
?>
  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>