<?php
$username = "PDchaldal235";
$password = "GECD_PLYsUJTd@83";
$currentTimestamp = time();

$authCode = md5($username.":".$password.":".$currentTimestamp);

$header = array(
    "keyHash: ".$authCode,
    "Content-Type: application/json"
);

$apiUrl = "http://192.168.50.2/leadsapi/request";

$postData = '{
    "requestType":"uploadLeads",
    "username":"' . $username . '",
    "requestTimestamp":"' . $currentTimestamp . '",
    "leads":[
        {
            "customerContactNo":"601714007805",
            "skillId":"AM",
            "customerName":"Md. Razu Haolader",
            "customerEmail":"razu@genusys.us"
        },   
        {
            "customerContactNo":"601714007805",
            "skillId":"AM",
            "customerName":"A.S.M Sanaul Ishaque",
            "customerEmail":"sanaul@genusys.us"
        }
    ]
}';
echo "<pre>";
echo "requestTimestamp: ".$currentTimestamp;
echo "\n\n";
var_dump($header);
echo "</pre>";
//die();

$ch = curl_init();
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_URL,$apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

$result = curl_exec($ch);
echo "<pre>"; print_r($result); 
curl_close($ch);

$data = json_decode($result,true);

echo "<pre>"; print_r($data); 

?>
