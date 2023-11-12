<?php
include("config/main.php");
include("config/routing.php");
include "classes/class.phpmailer.php";
?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="google-site-verification" content="BZRfIrhxghwPfVI8dpLkuaxSBbOu3x8Qp606tDfJmXM" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="UNDARIS Online Apps yang digunakan untuk mengatur kegiatan mandiri mahasiswa">
    <meta name="keywords" content="Siakad Undaris, Siakad Undaris Mahasiswa">
    <meta name="author" content="Fahri Atmaja">
    
    
    <link rel="favicon" href="https://siakad.undaris.ac.id/assets/img/undaris-min.png">
	<link rel="shortcut icon" href="https://siakad.undaris.ac.id/assets/img/undaris-min.png">
    <title>SIAKAD UNDARIS</title>
    <link rel="stylesheet" href="https://cdn.korzh.com/metroui/v4/css/metro-icons.min.css">
    <link href="<?= $_url ?>css/metro.css" rel="stylesheet">
    <link href="<?= $_url ?>css/metro-icons.css" rel="stylesheet">
    <link href="<?= $_url ?>css/docs.css" rel="stylesheet">
    <link href="<?= $_url ?>css/chat.css" rel="stylesheet">
    <!--<link href="<?= $_url ?>assets/bootstrap/bootstrap.min.css" rel="stylesheet">-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="<?= $_url ?>assets/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?= $_url ?>assets/ionicons/css/ionicons.min.css" rel="stylesheet">
    <link href="<?= $_url ?>assets/dist/AdminLTE.min.css" rel="stylesheet">
    <!--<script src="<?= $_url ?>js/jquery.min.js"></script>-->
    <!--<script src="<?= $_url ?>js/jquery-2.1.3.min.js"></script>-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script type="text/javascript">
$(window).load(function() {
    $(".loader").fadeOut("slow");
});
</script>
    <script src="<?= $_url ?>js/metro.js"></script>
    <script src="<?= $_url ?>js/fungsi.js"></script>
    <script src="<?= $_url ?>js/progressbar.js"></script>
    <script>
$(document).ready(function () {
$('#dtHorizontalExample').DataTable({
"scrollX": true
});
$('.dataTables_length').addClass('bs-select');
});
</script>

<style>
.loader {
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: url('../assets/img/poi.gif') 50% 50% no-repeat rgb(249,249,249);
    opacity: .8;
}
    .dtHorizontalExampleWrapper {
max-width: 600px;
margin: 0 auto;
}
#dtHorizontalExample th, td {
white-space: nowrap;
}

table.dataTable thead .sorting:after,
table.dataTable thead .sorting:before,
table.dataTable thead .sorting_asc:after,
table.dataTable thead .sorting_asc:before,
table.dataTable thead .sorting_asc_disabled:after,
table.dataTable thead .sorting_asc_disabled:before,
table.dataTable thead .sorting_desc:after,
table.dataTable thead .sorting_desc:before,
table.dataTable thead .sorting_desc_disabled:after,
table.dataTable thead .sorting_desc_disabled:before {
bottom: .5em;
}
</style>
    <style type="text/css">
    body {
      /*background-image:url(../assets/img/office.jpg);*/
      /*background-size:cover;*/
      /*background-attachment: fixed;*/
    }
    {
        font-family: "Verdana";
    }
    /* Sticky footer styles
    -------------------------------------------------- */

    html,
    body {
      height: 100%;
      /* The html and body elements cannot have any padding or margin. */
    }

    /* Wrapper for page content to push down footer */
    #wrap {
      min-height: 100%;
      height: auto;
      /* Negative indent footer by its height */
      margin: 0 auto -60px;
      /* Pad bottom by footer height */
      padding: 60px 0 60px;
    }

    /* Set the fixed height of the footer here */
    #footer {
      height: 60px;
      background-color: #f5f5f5;
    }
    </style>
    <?php
function tgl_indo($tanggal){
  $bulan = array (
    1 => 'Januari',
    2 => 'Februari',
    3 => 'Maret',
    4 => 'April',
    5 => 'Mei',
    6 => 'Juni',
    7 => 'Juli',
    8 => 'Agustus',
    9 => 'September',
    10 => 'Oktober',
    11 => 'November',
    12 => 'Desember'
  );
  $pecahkan = explode('-', $tanggal);
  
  // variabel pecahkan 0 = tanggal
  // variabel pecahkan 1 = bulan
  // variabel pecahkan 2 = tahun
 
  return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}

function rupiah($angka){
	
	$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
	return $hasil_rupiah;
 
}
//menampilkan ip address menggunakan function getenv()

function getClientIP() {
 
    if (isset($_SERVER)) {
 
        if (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
            return $_SERVER["HTTP_X_FORWARDED_FOR"];
 
        if (isset($_SERVER["HTTP_CLIENT_IP"]))
            return $_SERVER["HTTP_CLIENT_IP"];
 
        return $_SERVER["REMOTE_ADDR"];
    }
 
    if (getenv('HTTP_X_FORWARDED_FOR'))
        return getenv('HTTP_X_FORWARDED_FOR');
 
    if (getenv('HTTP_CLIENT_IP'))
        return getenv('HTTP_CLIENT_IP');
 
    return getenv('REMOTE_ADDR');
}


function get_client_browser() {
    $browser = '';
    if(strpos($_SERVER['HTTP_USER_AGENT'], 'Netscape'))
        $browser = 'Netscape';
    else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox'))
        $browser = 'Firefox';
    else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome'))
        $browser = 'Chrome';
    else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Opera'))
        $browser = 'Opera';
    else if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE'))
        $browser = 'Internet Explorer';
    else
        $browser = 'Other';
    return $browser;
}
?>
</head>
<!-- <body style="background-image: url(assets/img/gedung.jpg);
            background-size:cover;
			background-attachment: fixed;"> -->
			
        
<body>
    <!--<div class="loader"></div>-->
    <header class="app-bar fixed-top" data-role="appbar">
    <div class="container">
        <!--<a href="<?= $_url ?>" class="app-bar-element branding"> SIAKAD Online UNDARIS </a> -->
            <a class="navbar-brand" href="<?= $_url ?>">
      <img src="https://siakad.undaris.ac.id/assets/img/undaris-min.png" alt="" width="30" height="24" class="d-inline-block align-text-top">
      <span style="color : white;">SIAKAD Online UNDARIS</span>
    </a>
        <?php if ($_access != ''): ?>
        
    <ul class="app-bar-menu place-right" data-flexdirection="reverse">
            <li>
                <a href="#" class="dropdown-toggle"><?= $_name ?> (<?= $_username ?>)</a>
                <ul class="d-menu place-right" data-role="dropdown" data-no-close="true">
                <?php if ($_access == 'dosen'): ?>
                    <li><a href="<?= $_url ?>dosen/view/<?= $_username ?>/<?= urlencode($_name) ?>">Profile</a></li>
                    <li><a href="<?= $_url ?>dosen/change-password">Change Password</a></li> 
                <?php elseif ($_access == 'mahasiswa'): ?>
                    <li><a href="<?= $_url ?>mahasiswa/view/<?= $_username ?>/<?= urlencode($_name) ?>">Profile</a></li>
                    <li><a href="<?= $_url ?>user/change-password">Change Password</a></li> 
                <?php elseif ($_access == 'fakultas'): ?>
                    <li><a href="<?= $_url ?>fakultas/view/<?= $_username ?>/<?= urlencode($_name) ?>">Profile</a></li>
                    <li><a href="<?= $_url ?>fakultas/change-password">Change Password</a></li> 
                <?php endif; ?>
                    
                    <li class="divider"></li>
                    <li><a href="<?= $_url ?>sign/out">Sign Out</a></li>

                </ul>
            </li>
        </ul>

        <span class="app-bar-pull"></span>
        <?php endif; ?>

    </div>
    </header>

    <div id="wrap">
    <div class="container page-content">
         <?php
        // echo "Your IP Address ".$_SERVER['REMOTE_ADDR']."";
// echo "Browser : ".get_client_browser()."<br>";
// echo "Sistem Operasi : ".$_SERVER['HTTP_USER_AGENT'];
// if ($_SERVER['REMOTE_ADDR'] !== '180.246.212.190'){
//     echo "<script>window.alert('MAAF HALAMAN SEDANG MAINTENANCE')
// 		    window.location.href='maintenance.php'</script>";
// }
         echo $_content;

        ?>
        <!--<img src="../../under-maintenance.png">-->

    </div>
    </div>

    <footer id="footer" style="background-color: #EFEAE3">
        <div class="lockscreen-footer text-center">
               <small>UNDARIS Online App versi 0.1.2 (beta) </small>
               <br><small>Hak Cipta &copy; 2019 - <?php echo date('Y'); ?> <a target="blank" href="https://www.instagram.com/fahri_atmaja">IT Division</a> . <a target="blank" href="http://undaris.ac.id">U N D A R I S </a>. All rights reserved.<small>
            </div>
    </div>
    </footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script language="javascript" type="text/javascript">
function limitText(limitField, limitNum) {
    if (limitField.value.length > limitNum) {
        limitField.value = limitField.value.substring(0, limitNum);
    }
}
</script>
</body>
</html>