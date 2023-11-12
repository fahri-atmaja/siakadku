<?php
// declare
$iCdel = 'F3UL3558642';
$brivaNodel = '12775'; 
// $load = "SELECT * FROM proses_transaksi WHERE custCode='$cc'";
// $query = mysqli_query($koneksi,$load);
// $fetch = mysqli_fetch_array($query);
// $tgl = $fetch['tanggal_bayar'];
// $now = date(Ymd);
// $now = '20211101';
// echo $tgl."/".$tgl;
/* Generate Token */
function BRIVAgenerateToken($client_id, $secret_id) {
    $url ="https://partner.api.bri.co.id/oauth/client_credential/accesstoken?grant_type=client_credentials";
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
?>
<h2><a href="<?= $_url ?>briva" class="nav-button transform"><span></span></a>Monitoring</h2>

<div class="container">
    <div class="row">
        <div class="col-md-8">
                <form method="POST">
                    <div class="form-group">
                        <input type="date" class="form-control" name="date">
                    </div>
                        <button type="submit" name="submit" class="btn btn-primary">Monitoring</button>
                </form>
        </div>
    </div>
</div>

<?php
if($_POST['date']){
    $format = $_POST['date'];
    $now = date('Ymd',strtotime($format));
    $client_id = "Ys1MQUgYAydR2epMA4y7JfxACuW8i6y3";
    $secret_id= "Dck3V2wfuGq7xP3s";
    $timestamp = gmdate("Y-m-d\TH:i:s.000\Z");
    $secret = $secret_id;
    $token = BRIVAgenerateToken($client_id, $secret_id);
    $brivaNo = "12775/";
    $institutionCode = "F3UL3558642/";
    $times = $now."/".$now;

    $payload = "";
    $path = "/v1/briva/report/".$institutionCode .$brivaNo .$times;
    $verb = "GET";
    $base64sign = BRIVAgenerateSignature($path, $verb, $token, $timestamp, $payload, $secret);
    $request_headers = array(
        "Content-Type:"."application/json",
        "Authorization:Bearer " . $token,
        "BRI-Timestamp:" . $timestamp,
        "BRI-Signature:" . $base64sign,
    );

    $urlGet ="https://partner.api.bri.co.id/v1/briva/report/".$institutionCode .$brivaNo .$times;
    $chGet = curl_init();
curl_setopt($chGet,CURLOPT_URL,$urlGet);

$request_headers = array(
                    "Authorization:Bearer " . $token,
                    "BRI-Timestamp:" . $timestamp,
                    "BRI-Signature:" . $base64sign
                );
                curl_setopt($chGet, CURLOPT_HTTPHEADER, $request_headers);
                curl_setopt($chGet, CURLINFO_HEADER_OUT, true);
                
                
                // curl_setopt($chGet, CURLOPT_CUSTOMREQUEST, "GET");  //for updating we have to use PUT method.
                curl_setopt($chGet, CURLOPT_RETURNTRANSFER, true);
                
                $resultGet = curl_exec($chGet);
                $httpCodeGet = curl_getinfo($chGet, CURLINFO_HTTP_CODE);
                // $info = curl_getinfo($chGet);
                // print_r($info);
                curl_close($chGet);
                
                $data = json_decode($resultGet, true);
                // echo "Response Post : ".$resultGet;
                $error = $data['errDesc'];
                $statusJSON = $data['status'];
                if($statusJSON===false){
                echo "<script>
                alert('$error');
                </script>";
                        }
}



// foreach($data['data'] as $datas){
// if ($datas['custCode']){
//                 $cc = $datas['custCode'];
//                 $command = mysqli_query($koneksi,"UPDATE proses_transaksi SET status_bayar='Y', del_endpoint='1' WHERE custCode='$cc'");
//                 if ($command) {
//             		echo "<h1>Transaksi Berhasil !</h1>
//             		<script>$.Notify({
//             		    caption: 'Success',
//             		    content: 'Data Transaksi Berhasil Direfresh',
//                 		type: 'success'
//             		});
//             		</script>";
//             		$payload = "institutionCode=".$iCdel."&brivaNo=".$brivaNodel."&custCode=".$cc;
//                     $path = "/v1/briva";
//                     $verb = "DELETE";
//                     $base64sign = BRIVAgenerateSignature($path, $verb, $token, $timestamp, $payload, $secret);
                
//                     $request_headers = array(
//                         "Authorization:Bearer " . $token,
//                         "BRI-Timestamp:" . $timestamp,
//                         "BRI-Signature:" . $base64sign,
                		
//                     );
                
//                     $urlPost ="https://partner.api.bri.co.id/v1/briva";
//                     $chPost = curl_init();
//                     curl_setopt($chPost, CURLOPT_URL, $urlPost);
//                     curl_setopt($chPost, CURLOPT_HTTPHEADER, $request_headers);
//                     curl_setopt($chPost, CURLOPT_POSTFIELDS, $payload);
//                     curl_setopt($chPost, CURLINFO_HEADER_OUT, true);
//                     curl_setopt($chPost, CURLOPT_CUSTOMREQUEST, "DELETE");
//                     curl_setopt($chPost, CURLOPT_RETURNTRANSFER, true);
                    
//                     $resultPost = curl_exec($chPost);
//                     $httpCodePost = curl_getinfo($chPost, CURLINFO_HTTP_CODE);
//                     curl_close($chPost);
//                     echo "Response Post : ".$resultPost;
//                     return json_decode($resultPost, true);
                    
            	
//         }
    
// } 
// else {
//             		echo "<h1>Transaksi Belum Selesai</h1>
//             		<script>$.Notify({
//             		    caption: 'Failed',
//             		    content: 'Transaksi Belum Selesai!',
//             		    type: 'alert'
//             		});
//             		</script>";
//             	}
// }
// }
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
                <div class="table-responsive">
                    <table id="dtHorizontalExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                	<thead>
                		<tr>
                			<th>No BRIVA</th>
                			<th>NIM</th>
                			<th>Nama</th>
                			<th>Keterangan</th>
                			<th>Nominal Dibayar</th>
                			<th>Tanggal Bayar</th>
                			<th>Teller Id</th>
                			<th>No Rekening</th>
                			<th>Aksi</th>
                		</tr>
                	</thead>
                	<tbody>
                
                	<?php
                		foreach($data['data'] as $datas):
                		$cc = $datas['custCode'];
                		$nim = substr($cc,0,8);
                	?>
                		<tr>
                			<td><?= $datas['brivaNo']; ?><?= $datas['custCode']; ?></td>
                			<td><?= $nim ?></td>
                			<td><?= $datas['nama']; ?></td>
                			<td><?= $datas['keterangan']; ?></td>
                			<td><?= $datas['amount']; ?></td>
                			<td><?= $datas['paymentDate']; ?></td>
                			<td><?= $datas['tellerid']; ?></td>
                			<td><?= $datas['no_rek']; ?></td>
                			<th><a target="_BLANK" href="update/<?= $datas['custCode']; ?>"><button class="button btn-primary">Update</button></a></th>
                		</tr>
                	<?php
                			endforeach;
                	?>
                		
                	</tbody>
                </table>
            </div>
        </div>
    </div>
</div>