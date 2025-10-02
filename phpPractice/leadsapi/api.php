<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Content-Type: application/json; charset=UTF-8");

ini_set('display_errors', '1');
error_reporting(E_ALL);
error_reporting(0);


class api{ 
    private $maxLeads;

    public function __construct() {

        require 'db_conf.php';
        date_default_timezone_set('Asia/Dhaka');
        db_conn();
        $this->maxLeads = 10;
    }

    private function getApiUser($username) {

        global $mysqli;
        $data = [];
        if(strlen($username) <= 15 && ctype_alnum($username) && ctype_alpha(substr($username,0,1)) ) {

            $sql    = "SELECT * FROM api_users WHERE username = ? AND status = 'A' LIMIT 1";
            $stmt   = $mysqli->prepare($sql);
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


    public function uploadLeads() {

        global $mysqli;

        $currentTimestamp   = time();
        $headerRequest      = apache_request_headers();
        $inputData          = file_get_contents("php://input");
        $request            = json_decode($inputData);

        $response = [
            'result'            => true,
            'responseTimestamp' => $currentTimestamp,
            'resultCode'        => 202,
            'message'           => ["Leads uploaded successfully"],
        ];

        #header validation
        if(empty($request) and !isset($headerRequest['keyHash']) and empty($headerRequest['keyHash']) and isset($headerRequest['Content-Type']) && $headerRequest['Content-Type'] != "application/json") {

            $response = [
                'result'            => false,
                'responseTimestamp' => $currentTimestamp,
                'resultCode'        => 406,
                'message'           => ["Invalid header request!"],
            ];

            debug_log("Invalid header request!");
            echo json_encode( $response );
            exit;
        }

        $keyHash  = trim($headerRequest['keyHash']);
        $authInfo = $this->getApiUser($request->username);

        #authentication validation
        if(empty($authInfo) and  md5($authInfo['username'].":".$authInfo['password'].":".$request->requestTimestamp) != $keyHash and (abs($currentTimestamp - $request->requestTimestamp) >= 120 )) {

            $response = [
                'result'            => false,
                'responseTimestamp' => $currentTimestamp,
                'resultCode'        => 401,
                'message'           => ["Authentication failed!"],
            ];

            debug_log("Authentication failed!");
            echo json_encode( $response );
            exit;
        }

        $leads = $request->leads;

        #leads have validation
        if(empty($leads) and $leads == null) {

            $response = [
                'result'            => false,
                'responseTimestamp' => $currentTimestamp,
                'resultCode'        => 400,
                'message'           => ["Invalid request"],
            ];

            debug_log("Invalid request");
            echo json_encode( $response );
            exit;
        }

        #leads can't be greater than max lead
        if (count($leads) > $this->maxLeads) {

            $response = [
                'result'            => false,
                'responseTimestamp' => $currentTimestamp,
                'resultCode'        => 413,
                'message'           => ["Leads upload limit exceed"],
            ];

            debug_log("Leads upload limit exceed");
            echo json_encode( $response );
            exit;
        }

        $errorMsg = [];

        foreach ( $leads as $lead ) {

            #individual lead validation check
            $validation = $this->leadValidation($lead->customerContactNo,$lead->skillId,$lead->customerName,$lead->customerEmail);

            $errorCheck = $validation['error'];
            #have error then push error text on errorMsg array
            if ($errorCheck) {

                $errorMsg[] = $validation['errorMsg'][0];
            }

            #individual lead have error free then insert a lead in lead table
            if (!$errorCheck) {

                $sql            = "INSERT INTO `leads` SET `id` = ?, `skill_id` = ?, `first_name` = ?, `number_1` = ?, `custom_value_1` = ?";
                $id             = $this->generateId();
                $customerNum    = substr($lead->customerContactNo, -12);
                $skillId        = $lead->skillId;
                $stmt           = $mysqli->prepare($sql);

                $stmt->bind_param("issss", $id, $skillId,  $lead->customerName, $customerNum, $lead->customerEmail);
                $stmt->execute();
                $stmt->close();
            }

        }

        #if leads count equal to errorMsg count then execute these
        if( !empty($errorMsg) and count($errorMsg) == count($leads) ) {

            $response = [
                'result'            => false,
                'responseTimestamp' => $currentTimestamp,
                'resultCode'        => 400,
                'message'           => $errorMsg
            ];
        }

        echo json_encode( $response );
    }

    private function leadValidation($customerContactNo = '',$skillId = '',$customerName = '',$customerEmail = '') {

        $error      = false;

        #customer contact number validation rules
        if(!isset($customerContactNo) or empty($customerContactNo) or !is_numeric($customerContactNo)
            or strlen($customerContactNo) < 11 or strlen($customerContactNo) > 20 or $this->hasSpecialChar($customerContactNo) == true){

            $error      = true;
            $errorMsg[] = "Customer Contact no {$customerContactNo} is invalid";
            debug_log("Customer Contact no {$customerContactNo} is invalid");
        }

        #skill validation rules
        if(!isset($skillId) or empty($skillId) or strlen($skillId) != 2 or $this->hasSpecialChar($skillId) == true) {

            $error      = true;
            $errorMsg[] = "Skill id {$skillId} is invalid";
            debug_log("Skill id {$skillId} is invalid");
        }

        #if customer name field have value then execute customer name validation rules
        if( (!empty($customerName) and strlen($customerName) > 30) or (!empty($customerName) and $this->hasSpecialChar($customerName) == true) ) {

            $error      = true;
            $errorMsg[] = "Customer name {$customerName} is invalid";
            debug_log("Customer name {$customerName} is invalid");
        }

        #if customer email field have value then execute customer email validation rules
        if( (!empty($customerEmail) and strlen($customerEmail) > 100) or (!empty($customerEmail) and !filter_var($customerEmail, FILTER_VALIDATE_EMAIL)) ) {

            $error      = true;
            $errorMsg[] = "Customer email {$customerEmail} is invalid";
            debug_log("Customer email {$customerEmail} is invalid");
        }

        if($error) {

            $validation = [

                'error'    => true,
                'errorMsg' => $errorMsg
            ];
        } else {

            $validation = [

                'error'    => false,
                'errorMsg' => ["Valid Lead"]
            ];
        }

        return $validation;
    }
    private function hasSpecialChar($value) {

        $regex = "/[`'\"~!#$^&%*(){}<>,?;:\|+=]/";
        return preg_match($regex, $value); 
    }
    private function generateId() {

        $digits     = 4;
        $rand       = rand(pow(10, $digits-1), pow(10, $digits)-1);
        $tstmp      = substr(time(), -6);
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
$request   = json_decode($inputData);

if(isset($request->requestType) && !empty($request->requestType) && $_REQUEST['path'] == "request" && method_exists('api',$request->requestType)) {

    $obj->{$request->requestType}();
} else {

    debug_log("Invalid request");
    echo json_encode(
        [
            'result'            => false,
            'responseTimestamp' => time(),
            'resultCode'        => 400,
            'message'           => ["Invalid request"],
        ]
    );
}

#debug log write on text file make sure folder have permission
function debug_log($msg) {

    $path = getcwd () . DIRECTORY_SEPARATOR . 'log' . DIRECTORY_SEPARATOR ;

    if (!is_dir($path)) mkdir($path, 0777, true);

    $log = 'Error: ' . date ( 'F j, Y, g:i a' ) ."Time". time() .  'Message: ' . (json_encode ($msg)) . PHP_EOL;
    file_put_contents ( $path.'log_'. date ( 'j.n.Y' ) . '.txt' , $log, FILE_APPEND );
}

?>