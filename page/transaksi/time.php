<?php
// declare
$cc = $_id;
$iCdel = 'J104408';
$brivaNodel = '77777'; 
$load = "SELECT * FROM proses_transaksi WHERE custCode='$cc'";
$query = mysqli_query($koneksi,$load);
$fetch = mysqli_fetch_array($query);
// $tgl = $fetch['tanggal_bayar'];
$tgl = "2021-08-24/";
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
    $brivaNo = "77777/";
    $institutionCode = "J104408/";
    $times = $tgl;
    $time1 ="09:00/";
    $time2 ="13:00";
    
    $payload = "";
    $path = "/v1/briva/report_time/".$institutionCode .$brivaNo .$times .$time1 .$times .$time2;
    $verb = "GET";
    $base64sign = BRIVAgenerateSignature($path, $verb, $token, $timestamp, $payload, $secret);
    $request_headers = array(
        "Content-Type:"."application/json",
        "Authorization:Bearer " . $token,
        "BRI-Timestamp:" . $timestamp,
        "BRI-Signature:" . $base64sign,
    );

    $urlGet ="https://sandbox.partner.api.bri.co.id/v1/briva/report_time/".$institutionCode .$brivaNo .$times .$time1 .$times .$time2;
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
                echo "Response Post : ".$resultGet;
// foreach($data['data'] as $datas){
// if ($datas['custCode'] == $cc){
                   
//                 $command = mysqli_query($koneksi,"UPDATE proses_transaksi SET status_bayar='Y', del_endpoint='1' WHERE custCode='$cc'");
//                 if ($command) {
//             		echo "<script>$.Notify({
//             		    caption: 'Success',
//             		    content: 'Data Transaksi Berhasil Direfresh',
//                 		type: 'success'
//             		});
//             		setTimeout(function(){ window.location.href='{$_url}transaksi'; }, 2000);
//             		</script>";
// //            		setTimeout(function(){ window.location.href='{$_url}transaksi'; }, 2000);
//             		$payload = "institutionCode=".$iCdel."&brivaNo=".$brivaNodel."&custCode=".$cc;
//                     $path = "/v1/briva";
//                     $verb = "DELETE";
//                     $base64sign = BRIVAgenerateSignature($path, $verb, $token, $timestamp, $payload, $secret);
                
//                     $request_headers = array(
//                         "Authorization:Bearer " . $token,
//                         "BRI-Timestamp:" . $timestamp,
//                         "BRI-Signature:" . $base64sign,
                		
//                     );
                
//                     $urlPost ="https://sandbox.partner.api.bri.co.id/v1/briva";
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
                
//                     // echo "<br/> <br/>";
//                     echo "Response Post : ".$resultPost;
//                     return json_decode($resultPost, true);
                    
            	
//         }
    
// } 
// elseif($datas['custCode'] != $cc) {
//             		echo "<script>$.Notify({
//             		    caption: 'Failed',
//             		    content: 'Transaksi Belum Selesai!',
//             		    type: 'alert'
//             		});
//             		setTimeout(function(){ window.location.href='{$_url}transaksi'; }, 2000);
//             		</script>";
//             	}
// }
?>
