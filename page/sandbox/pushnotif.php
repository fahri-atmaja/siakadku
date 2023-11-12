
<?php
    $tgl_skrg       = date("Ymd");
    // $tgl_exp        = date('Ymd', strtotime('+6 days', strtotime($tgl_skrg)));
    $today          = date("Y-m-d");
    $tambah         = date('Y-m-d', strtotime('+6 days', strtotime($today)));
    $exp            = date("H:m:s");
    $today_id       = date("Ym");
    $sql            = "SELECT * FROM student_mahasiswa WHERE nim='$_username'";
    $x              = mysqli_query($koneksi, $sql);
    $view           = mysqli_fetch_array($x);
    $nim            = $view['nim'];
    $nama           = $view['nama'];
    $angkatan       = $view['angkatan_id'];
    $konsentrasi    = $view['konsentrasi_id'];
    $status         = $view['status_angsur'];
	$sql1           = "SELECT * FROM tagihan_mahasiswa WHERE id_tagihan='$_id'";
	$query1         = mysqli_query($koneksi, $sql1);
    $item = mysqli_fetch_array($query1);
    $jenis_bayar = $item['jenis_bayar'];
    
	// cari id transaksi terakhir yang berawalan tanggal hari ini
	$que = "SELECT max(custCode) as maxCode FROM proses_transaksi";
    $hasil = mysqli_query($koneksi,$que);
    $dt  = mysqli_fetch_array($hasil);
    $lastNoTransaksi = $dt['maxCode'];
	
	// baca nomor urut transaksi dari id transaksi terakhir 
	$lastNoUrut = (int)substr($lastNoTransaksi, 6, 4); 
	
	// nomor urut ditambah 1
    $nextNoUrut = $lastNoUrut + 1;
     
    // membuat format nomor transaksi berikutnya
    $nextNoTransaksi = $today_id.sprintf('%04s', $nextNoUrut);
?>
<h1>
<a href="<?= $_url ?>transaksi" class="nav-button transform"><span></span></a>
PROSES TAGIHAN-MU
</h1>

<?php
    $load       = mysqli_query($koneksi,"SELECT * FROM proses_transaksi WHERE nim='$_username' AND id_tagihan='$_id'");
    $cek        = mysqli_num_rows($load);
        if($cek > 0){
            echo "<script>window.alert('TRANSAKSI SUDAH ADA!')
		    window.location.href='{$_url}sandbox'</script>";
        }
?>

<div class="container">
    <div class="row">
        <div class="col-md-6">
           <h3>Proses Push Notif</h3>
           <form Method="POST">
           <div class="table-responsive">
            <label>NO BRIVA</label>
            <input type="text" class="form-control" name="brivaNo" value="">
            <label>AMOUNT</label>
            <input type="text" class="form-control" name="amount" value="">
            <!--
            
            -->
            <button type="submit" name="submit" class="button success">Proses</button>
           </div>
           </form>
        </div>
    </div>
</div>

<?php
	
if (isset($_POST['submit'])) {
$brivaNo   		= $_POST['brivaNo'];
$amount 		= $_POST['amount'];
// $client_id = "4y0fz9VFU5LLAbJKRGgPXeMUhLaddYSX";
// $secret_id= "Ttama2OL82xpdvvY";

/* Generate Token */
function BRIVAgenerateToken($client_id, $secret_id) {
    $url ="https://sandbox.partner.api.bri.co.id/oauth/client_credential/accesstoken?grant_type=client_credentials";
    $data = "client_id=".$client_id."&client_secret=".$secret_id;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch,CURLOPT_POSTFIELDS, $data);
    
    $result = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $json = json_decode($result, true);
    $accesstoken = $json['access_token'];

    return $accesstoken;
}

/* Generate signature */
function BRIVAgenerateSignature($path, $verb, $token, $timestamp, $payload, $secret) {
    $payloads = "path=$path&verb=$verb&token=Bearer $token&timestamp=$timestamp&body=$payload";
    $signPayload = hash_hmac('sha256', $payloads, $secret, true);
    return base64_encode($signPayload);
}


    $client_id = "hEXMUhwvUpHfZsEqXOBH1FrOlYq540nA";
    $secret_id= "4eq4F3RpePRLhk7c";
    $timestamp = gmdate("Y-m-d\TH:i:s.000\Z");
    $secret = $secret_id;
    $token = "Bearer 4eq4F3RpePRLhk7c";

    $institutionCode = "J104408";
    
    $datas = array(
        'brivaNo' => $brivaNo,
        'amount' => $amount
    );
    $payload = json_encode($datas, true);
    $path = "http://webservice.undaris.ac.id/api/v1.0/notification";
    $verb = "POST";
    $base64sign = BRIVAgenerateSignature($path, $verb, $token, $timestamp, $payload, $secret);

    $request_headers = array(
        "Content-Type:"."application/json",
        "Authorization:Bearer " . $token,
        "BRI-Timestamp:" . $timestamp,
        "BRI-Signature:" . $base64sign,
        "X-API-KEY:16081995"
    );

    $urlPost ="http://webservice.undaris.ac.id/api/v1.0/notification";
    $chPost = curl_init();
    curl_setopt($chPost, CURLOPT_URL, $urlPost);
    curl_setopt($chPost, CURLOPT_HTTPHEADER, $request_headers);
    curl_setopt($chPost, CURLOPT_CUSTOMREQUEST, "POST"); 
    curl_setopt($chPost, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($chPost, CURLINFO_HEADER_OUT, true);
    curl_setopt($chPost, CURLOPT_RETURNTRANSFER, true);

    $resultPost = curl_exec($chPost);
    $httpCodePost = curl_getinfo($chPost, CURLINFO_HTTP_CODE);
    curl_close($chPost);

    echo "Response Post : ".$resultPost;
    $json = json_decode($resultPost, true);
    return json_decode($resultPost, true);


// BrivaUpdate($brivaNo, $custCode, $nama, $amount, $keterangan, $expiredDate);
// $result = file_get_contents($resultPost);
// $json = json_decode($result, true);
$error = $json['errDesc'];
$statusJSON = $json['status'];
// echo "ERROR ->". $error;
// echo "STATUS ->". $status;

if($statusJSON===false){
        echo "<script>
alert('$error');
exit();
</script>";
        }



    

    
        else{
            $custCode = substr($noBriva,5);
            $cmd = mysqli_query($koneksi,"SELECT * FROM proses_transaksi WHERE custCode='$custCode' AND del_endpoint='0'");
            $cek = mysqli_num_rows($cmd);
            if($cek > 0){   
            echo "<script>$.Notify({
    		    caption: 'Failed',
    		    content: 'CustCode Sudah Terpakai, Silahkan coba lagi!!',
    		    type: 'alert'
    		});
    		setTimeout(function(){ window.location.href='{$_url}sandbox'; }, 2000);
    		</script>";
            }else{
            $custCode = substr($noBriva,5);
        	$sql = "UPDATE proses_transaksi SET status='Y' WHERE custCode='$custCode'";
        	$queque = mysqli_query($koneksi, $sql);
    
        	if ($queque) {
        		echo "<script>$.Notify({
        		    caption: 'Success',
        		    content: 'Data Transaksi Berhasil Ditambah',
            		type: 'success'
        		});
         		setTimeout(function(){ window.location.href='{$_url}sandbox'; }, 2000);
        		</script>";
        	} else {
        		echo "<script>$.Notify({
        		    caption: 'Failed',
        		    content: 'Data Gagal Ditambah',
        		    type: 'alert'
        		});</script>";
        	}
        }
    }
}
?>