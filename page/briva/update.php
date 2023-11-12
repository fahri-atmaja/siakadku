<?php
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
$cc = $_id;
$iCdel = 'F3UL3558642';
$brivaNodel = '12775'; 
$timestamp = gmdate("Y-m-d\TH:i:s.000\Z");
$client_id = "Ys1MQUgYAydR2epMA4y7JfxACuW8i6y3";
$secret= "Dck3V2wfuGq7xP3s";
$command = mysqli_query($koneksi,"UPDATE proses_transaksi SET status_bayar='Y', del_endpoint='1' WHERE custCode='$cc'");
                if ($command) {
            		echo "<h1>Transaksi Berhasil !</h1>
            		<script>$.Notify({
            		    caption: 'Success',
            		    content: 'Data Transaksi Berhasil Direfresh',
                		type: 'success'
            		});
             		setTimeout(function(){ window.location.href='{$_url}briva/monitoring'; }, 2000);
            		</script>";
            		$payload = "institutionCode=".$iCdel."&brivaNo=".$brivaNodel."&custCode=".$cc;
                    $path = "/v1/briva";
                    $verb = "DELETE";
                    $base64sign = BRIVAgenerateSignature($path, $verb, $token, $timestamp, $payload, $secret);
                
                    $request_headers = array(
                        "Authorization:Bearer " . $token,
                        "BRI-Timestamp:" . $timestamp,
                        "BRI-Signature:" . $base64sign,
                		
                    );
                
                    $urlPost ="https://partner.api.bri.co.id/v1/briva";
                    $chPost = curl_init();
                    curl_setopt($chPost, CURLOPT_URL, $urlPost);
                    curl_setopt($chPost, CURLOPT_HTTPHEADER, $request_headers);
                    curl_setopt($chPost, CURLOPT_POSTFIELDS, $payload);
                    curl_setopt($chPost, CURLINFO_HEADER_OUT, true);
                    curl_setopt($chPost, CURLOPT_CUSTOMREQUEST, "DELETE");
                    curl_setopt($chPost, CURLOPT_RETURNTRANSFER, true);
                    
                    $resultPost = curl_exec($chPost);
                    $httpCodePost = curl_getinfo($chPost, CURLINFO_HTTP_CODE);
                    curl_close($chPost);
                
                    // echo "<br/> <br/>";
                    // echo "Response Post : ".$resultPost;
                    return json_decode($resultPost, true);
                    
            	
        }else {
            		echo "<h1>Transaksi Belum Selesai</h1>
            		<script>$.Notify({
            		    caption: 'Failed',
            		    content: 'Transaksi Belum Selesai!',
            		    type: 'alert'
            		});
            		setTimeout(function(){ window.location.href='{$_url}briva/monitoring'; }, 2000);
            		</script>";
            	}
?>