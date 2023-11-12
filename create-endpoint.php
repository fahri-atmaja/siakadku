<?php
$ch = curl_init();
$headers  = [
            'BRI-Timestamp: 2021-07-14T13:57:52.114Z',
            'BRI-Signature: avgqrcgwdoFks2AqgqNJgvRV3ALoKscWjlWzDDl4XU18=',
            'Authorization: Bearer kveJcl5XCGFVI1UiF1kkq5HDfePB',
            'Content-Type: text/plain'
        ];
$postData = [
    'institutionCode'=>'J104408',
    'brivaNo'=>'77777',
    'custCode'=>'787878',
    'nama'=>'fahri',
    'amount'=>'250000',
    'keterangan'=>'SKS',
    'expiredDate'=>'2019-10-29 09:57:26'
];
curl_setopt($ch, CURLOPT_URL,"https://sandbox.partner.api.bri.co.id/v1/briva");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));           
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$result     = curl_exec ($ch);
$statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

print_r($result);
?>