<?php
date_default_timezone_set('Asia/Dhaka');
$username = "fortis2244";
$password = "GLXS_FoRTiSa!!YHRs@6";
$currentTimestamp = time();
// echo "<br />";
$authCode = md5($username.":".$password.":".$currentTimestamp);
//die();

$header = array(
    "keyHash: ".$authCode,
    "Content-Type: application/json"
);

// $apiUrl = "http://127.0.0.1/city_leads_upload/request";
$apiUrl = "http://192.168.11.220/ccpro/api/datashare/request";

$postData = '{
    "requestType":"dataShare",
    "dataType":"inbound",
    "username":"' . $username . '",
    "requestTimestamp":"' . $currentTimestamp . '",
    "startDate" : "2025-02-01 00:00:00",
    "endDate" : "2025-02-28 00:00:00"
}';
// echo $postData; 

$ch = curl_init();
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_URL,$apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

$result = curl_exec($ch);
echo "<pre>"; print_r($result);
curl_close($ch);

/* $data = json_decode($result,true);

echo "<pre>"; print_r($data);  */

?>
