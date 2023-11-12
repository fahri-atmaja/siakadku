<?php
// declare
$cc = $_id;
$load = "SELECT * FROM proses_transaksi WHERE custCode='$cc'";
$query = mysqli_query($koneksi,$load);
$fetch = mysqli_fetch_array($query);
$tgl = $fetch['tanggal_bayar'];
// echo $tgl."/".$tgl;
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



    $client_id = "4y0fz9VFU5LLAbJKRGgPXeMUhLaddYSX";
    $secret_id= "Ttama2OL82xpdvvY";
    $timestamp = gmdate("Y-m-d\TH:i:s.000\Z");
    $secret = $secret_id;
    $token = BRIVAgenerateToken($client_id, $secret_id);
    $brivaNo = "77777";
    $institutionCode = "J104408";
    $times = $tgl."/".$tgl;

    $datas = array(
        'institutionCode' => $institutionCode,
        'brivaNo' => $brivaNo,
        'custCode' => $cc
    );

    $payload = json_encode($datas, true);
    $path = "/v1/briva";
    $verb = "DELETE";
    $base64sign = BRIVAgenerateSignature($path, $verb, $token, $timestamp, $payload, $secret);

   $request_headers = array(
        "Content-Type:"."application/json",
        "Authorization:Bearer " . $token,
        "BRI-Timestamp:" . $timestamp,
        "BRI-Signature:" . $base64sign
    );

    $urlPost ="https://sandbox.partner.api.bri.co.id/v1/briva";
    $chPost = curl_init();
    curl_setopt($chPost, CURLOPT_URL, $urlPost);
    curl_setopt($chPost, CURLOPT_HTTPHEADER, $request_headers);
    curl_setopt($chPost, CURLOPT_CUSTOMREQUEST, "DELETE"); 
    curl_setopt($chPost, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($chPost, CURLINFO_HEADER_OUT, true);
    curl_setopt($chPost, CURLOPT_RETURNTRANSFER, true);

    $resultPost = curl_exec($chPost);
    $httpCodePost = curl_getinfo($chPost, CURLINFO_HTTP_CODE);
    curl_close($chPost);

    echo "Response Post : ".$resultPost;
    return json_decode($resultPost, true);
                

foreach($data['data'] as $datas){
if ($datas['custCode'] == $cc){
                    //  echo "<br/> <br/>";
                    //  echo "Nama " .$datas['nama']. "<br>"; 
                    //  echo "Jumlah Bayar " .$datas['amount']. "<br>";
                    //  echo "Nomer VA " .$datas['no_rek']. "<br>";
                    //  echo "<br/> <br/>";
                   
                $command = mysqli_query($koneksi,"DELETE FROM proses_transaksi WHERE custCode='$cc'");
                if ($command) {
            		echo "<script>$.Notify({
            		    caption: 'Success',
            		    content: 'Data Transaksi Berhasil Direfresh',
                		type: 'success'
            		});
            		setTimeout(function(){ window.location.href='{$_url}transaksi'; }, 2000);
            		</script>";
            	} else {
            		echo "<script>$.Notify({
            		    caption: 'Failed',
            		    content: 'Data Gagal Direfresh',
            		    type: 'alert'
            		});</script>";
            	}
        }
}
?>
<div class="loadingio-spinner-double-ring-r94v1n1c94f"><div class="ldio-h2yhnc7pl8">
<div></div>
<div></div>
<div><div></div></div>
<div><div></div></div>
</div></div>
<style type="text/css">
@keyframes ldio-h2yhnc7pl8 {
  0% { transform: rotate(0) }
  100% { transform: rotate(360deg) }
}
.ldio-h2yhnc7pl8 div { box-sizing: border-box!important }
.ldio-h2yhnc7pl8 > div {
  position: absolute;
  width: 187.15px;
  height: 187.15px;
  top: 4.925px;
  left: 4.925px;
  border-radius: 50%;
  border: 13.79px solid #000;
  border-color: #b3c430 transparent #b3c430 transparent;
  animation: ldio-h2yhnc7pl8 1.282051282051282s linear infinite;
}

.ldio-h2yhnc7pl8 > div:nth-child(2), .ldio-h2yhnc7pl8 > div:nth-child(4) {
  width: 155.63px;
  height: 155.63px;
  top: 20.685px;
  left: 20.685px;
  animation: ldio-h2yhnc7pl8 1.282051282051282s linear infinite reverse;
}
.ldio-h2yhnc7pl8 > div:nth-child(2) {
  border-color: transparent #4f5245 transparent #4f5245
}
.ldio-h2yhnc7pl8 > div:nth-child(3) { border-color: transparent }
.ldio-h2yhnc7pl8 > div:nth-child(3) div {
  position: absolute;
  width: 100%;
  height: 100%;
  transform: rotate(45deg);
}
.ldio-h2yhnc7pl8 > div:nth-child(3) div:before, .ldio-h2yhnc7pl8 > div:nth-child(3) div:after { 
  content: "";
  display: block;
  position: absolute;
  width: 13.79px;
  height: 13.79px;
  top: -13.79px;
  left: 72.89px;
  background: #b3c430;
  border-radius: 50%;
  box-shadow: 0 173.35999999999999px 0 0 #b3c430;
}
.ldio-h2yhnc7pl8 > div:nth-child(3) div:after {
  left: -13.79px;
  top: 72.89px;
  box-shadow: 173.35999999999999px 0 0 0 #b3c430;
}

.ldio-h2yhnc7pl8 > div:nth-child(4) { border-color: transparent; }
.ldio-h2yhnc7pl8 > div:nth-child(4) div {
  position: absolute;
  width: 100%;
  height: 100%;
  transform: rotate(45deg);
}
.ldio-h2yhnc7pl8 > div:nth-child(4) div:before, .ldio-h2yhnc7pl8 > div:nth-child(4) div:after {
  content: "";
  display: block;
  position: absolute;
  width: 13.79px;
  height: 13.79px;
  top: -13.79px;
  left: 57.13px;
  background: #4f5245;
  border-radius: 50%;
  box-shadow: 0 141.84px 0 0 #4f5245;
}
.ldio-h2yhnc7pl8 > div:nth-child(4) div:after {
  left: -13.79px;
  top: 57.13px;
  box-shadow: 141.84px 0 0 0 #4f5245;
}
.loadingio-spinner-double-ring-r94v1n1c94f {
  width: 197px;
  height: 197px;
  display: inline-block;
  overflow: hidden;
  background: none;
}
.ldio-h2yhnc7pl8 {
  width: 100%;
  height: 100%;
  position: relative;
  transform: translateZ(0) scale(1);
  backface-visibility: hidden;
  transform-origin: 0 0; /* see note above */
}
.ldio-h2yhnc7pl8 div { box-sizing: content-box; }
/* generated by https://loading.io/ */
</style>
	