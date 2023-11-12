
<?php
include 'koneksi.php';
$krs_id = $_GET['krs_id'];
$query = mysqli_query($koneksi, "select * from akademik_krs where krs_id='$krs_id'");
$akademik_krs = mysqli_fetch_array($query);
$data = array(
            'nim'      =>  $akademik_krs['nim']);
 echo json_encode($data);
?>