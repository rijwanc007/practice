<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Content-Type: application/json; charset=UTF-8");

// ini_set('display_errors', '1');
// error_reporting(E_ALL); 
error_reporting(0);


class api{ 
    private $maxLeads;

    public function __construct()
    { 
        require 'db_conf.php';
        date_default_timezone_set('Asia/Dhaka');
        db_conn();
        $this->maxLeads = 10;
        
    }

    private function getApiUser($username){
        global $mysqli;
        $data = [];
        if(strlen($username) <= 15 && ctype_alnum($username) && ctype_alpha(substr($username,0,1)) ){
            $sql = "SELECT * FROM api_users WHERE username = ? AND status = 'A' LIMIT 1";
            $stmt = $mysqli->prepare($sql); 
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result(); 
            if($result->num_rows > 0) {
                $data = $result->fetch_assoc();
            }
            $stmt->close();
        }
        
        return $data;

    }

    public function uploadLeads(){
        global $mysqli;
        $currentTimestamp = time();
        $response = [
            'result' => false,
            'responseTimestamp' => $currentTimestamp,
            'resultCode' => 406,
            'message' => ["Invalid header request!"],
        ];
        $headerRequest =  apache_request_headers();
        $inputData = file_get_contents("php://input");
        $request = json_decode($inputData);
        
        if(!empty($request) && isset($headerRequest['keyHash']) && !empty($headerRequest['keyHash']) && isset($headerRequest['Content-Type']) && $headerRequest['Content-Type'] == "application/json"){
            $keyHash = trim($headerRequest['keyHash']);
            $authInfo = $this->getApiUser($request->username);

            if(!empty($authInfo) &&  md5($authInfo['username'].":".$authInfo['password'].":".$request->requestTimestamp) == $keyHash 
            && (abs($currentTimestamp - $request->requestTimestamp) <= 120 )){

                $leads = $request->leads;
                $validate = $this->validateLeadsData($leads);
                if($validate['result'] == true){ 
                    foreach($leads as $lead){ 
                        $sql = "INSERT INTO `leads` SET `id` = ?, `skill_id` = ?, `first_name` = ?, `number_1` = ?, `custom_value_1` = ?";
                        
                        $id = $this->generateId();
                        $customerId = substr(bin2hex(random_bytes(8)), 0, 16);
                        $customerNum = substr($lead->customerContactNo, -12);
                        $skillId = $lead->skillId;
                        $stmt = $mysqli->prepare($sql);
                        $stmt->bind_param("issss", $id, $skillId,  $lead->customerName, $customerNum, $lead->customerEmail);
                        $stmt->execute();
                        $stmt->close();
                    }
                    $response = [
                        'result' => true,
                        'responseTimestamp' => $currentTimestamp,
                        'resultCode' => 200,
                        'message' => ["Leads uploaded successfully!"],
                    ];
                }else{
                    $response = $validate;
                }
            }else{
                $response = [
                    'result' => false,
                    'responseTimestamp' => $currentTimestamp,
                    'resultCode' => 401,
                    'message' => ["Authentication failed!"],
                ];
            }
            

        }
       
        echo json_encode( $response );
        
    } 

    private function validateLeadsData($leads){
        $currentTimestamp = time();
        $result = [
            'result' => false,
            'responseTimestamp' => $currentTimestamp,
            'resultCode' => 400,
            'message' => ["Invalid request"],
        ];
        if(!empty($leads) && $leads != null){
            $result = [
                'result' => true,
                'responseTimestamp' => $currentTimestamp,
                'resultCode' => 202,
                'message' => ["Leads request successfull"],
            ];
            if(count($leads) > $this->maxLeads){
                $result = [
                    'result' => false,
                    'responseTimestamp' => $currentTimestamp,
                    'resultCode' => 413,
                    'message' => ["Leads upload limit exceed"],
                ];
            }
            $errorMsg = [];
            array_filter($leads, function($lead, $key) use(&$errorMsg){
                if(!isset($lead->customerContactNo) || empty($lead->customerContactNo) || !is_numeric($lead->customerContactNo) 
                || strlen($lead->customerContactNo) < 11 || strlen($lead->customerContactNo) > 20 || $this->hasSpecialChar($lead->customerContactNo) == true){
                    $errorMsg[] = "Customer Contact no {$lead->customerContactNo} is invalid";
    
                }
                if(!isset($lead->skillId) || empty($lead->skillId) || strlen($lead->skillId) != 2 || $this->hasSpecialChar($lead->skillId) == true){
                    $errorMsg[] = "Skill id {$lead->skillId} is invalid";
                }
                if( (!empty($lead->customerName) && strlen($lead->customerName) > 30)  || $this->hasSpecialChar($lead->customerName) == true){
                    $errorMsg[] = "Customer name {$lead->customerName} is invalid";
                }
                if( !empty($lead->customerEmail) && strlen($lead->customerName) > 100 && !filter_var($lead->customerEmail, FILTER_VALIDATE_EMAIL) ){
                    $errorMsg[] = "Customer email {$lead->customerEmail} is invalid";
                }
                
            }, ARRAY_FILTER_USE_BOTH);

            if(!empty($errorMsg)){
                $result = [
                    'result' => false,
                    'responseTimestamp' => $currentTimestamp,
                    'resultCode' => 400,
                    'message' => $errorMsg
                ];
            }
            
        }
        
        return $result;
        
    }
    private function hasSpecialChar($value){
        $regex = "/[`'\"~!#$^&%*(){}<>,?;:\|+=]/";
        return preg_match($regex, $value); 
    }
    private function generateId(){
        $digits = 4;
        $rand = rand(pow(10, $digits-1), pow(10, $digits)-1);
        $tstmp = substr(time(), -6);
        return $str = $tstmp.$rand;
    }
    
    private function dump($data){
        echo "<pre>";
            print_r($data);
        echo "</pre>";    
    }
    private function dd($data){
        echo "<pre>";
            print_r($data);
        echo "</pre>";   
        die(); 
    }
}

$obj = new api();


$inputData = file_get_contents("php://input");
$request = json_decode($inputData);

if(isset($request->requestType) && !empty($request->requestType) && $_REQUEST['path'] == "request" && method_exists('api',$request->requestType)){
    $obj->{$request->requestType}();
}else{
    echo json_encode(
        [
            'result' => false,
            'responseTimestamp' => time(),
            'resultCode' => 400,
            'message' => ["Invalid request"],
        ]
    );
}

?>