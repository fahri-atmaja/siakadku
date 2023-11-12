<?php
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

function BrivaUpdate() {
    $client_id = "4y0fz9VFU5LLAbJKRGgPXeMUhLaddYSX";
    $secret_id= "Ttama2OL82xpdvvY";
    $timestamp = gmdate("Y-m-d\TH:i:s.000\Z");
    $secret = $secret_id;
    $token = BRIVAgenerateToken($client_id, $secret_id);

    $institutionCode = "J104408";
    $brivaNo = "77777";
    $custCode = "939001";
    $nama = "Fahri";
    $amount="100000";
    $keterangan="Testing BRIVA";
    $expiredDate="2021-07-27 23:59:00";

    $datas = array(
        'institutionCode' => $institutionCode ,
        'brivaNo' => $brivaNo,
        'custCode' => $custCode,
        'nama' => $nama,
        'amount' => $amount,
        'keterangan' => $keterangan,
        'expiredDate' => $expiredDate
    );

    $payload = json_encode($datas, true);
    $path = "/v1/briva";
    $verb = "POST";
    $base64sign = BRIVAgenerateSignature($path, $verb, $token, $timestamp, $payload, $secret);

    $request_headers = array(
        "Content-Type:"."application/json",
        "Authorization:Bearer " . $token,
        "BRI-Timestamp:" . $timestamp,
        "BRI-Signature:" . $base64sign,
    );

    $urlPost ="https://sandbox.partner.api.bri.co.id/v1/briva";
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
    return json_decode($resultPost, true);
}

BrivaUpdate();