<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Content-Type: application/json; charset=UTF-8");

//ini_set('display_errors', '1');
//error_reporting(E_ALL);
//error_reporting(0);

//http://192.168.11.220/ccpro/api/datashare/request?start_date=2025-07-03%2011:04:40&&end_date=2025-07-03%2013:10:10&&type=inbound

require 'db_conf.php';
require 'constant.php';

class Api {

    private const ERROR_STATUS      = 'Failed';
    private const SUCCESS_STATUS    = 'Success';
    private const ERROR_CODE        = 400;
    private const SUCCESS_CODE      = 200;
    private const ERROR_MSG         = "Date range exceed the limit";
    private const SUCCESS_MSG       = "Data fetched successfully";
    public function __construct() {

        date_default_timezone_set('Asia/Dhaka');
        db_conn();
    }

    public function dataShare() : ? array {

        $currentTimestamp   = time();
        $headerRequest      = apache_request_headers();
        $inputData          = file_get_contents("php://input");
        $request            = json_decode($inputData);

        if(empty($request) || !isset($headerRequest['keyHash']) || !isset($headerRequest['Content-Type']) || $headerRequest['Content-Type'] !== "application/json") {

            return [
                'responseTimestamp' => $currentTimestamp,
                'resultStatus'      => self::ERROR_STATUS,
                'resultCode'        => 402,
                'message'           => "Invalid header request!",
                'data'              => []

            ];
        }

        if($request->username !== API_USER) {

            return [
                'responseTimestamp' => $currentTimestamp,
                'resultStatus'      => self::ERROR_STATUS,
                'resultCode'        => 401,
                'message'           => "API authentication Failed. Check Username or Password",
                'data'              => []

            ];
        }

        if(md5($request->username.":".API_PASSWORD.":".$request->requestTimestamp) !== trim($headerRequest['keyHash']) || (abs($currentTimestamp - $request->requestTimestamp) >= 1200 )) {

            return [
                'responseTimestamp' => $currentTimestamp,
                'resultStatus'      => self::ERROR_STATUS,
                'resultCode'        => 403,
                'message'           => "API authentication miss match!",
                'data'              => []

            ];
        }

        if($request->dataType == 'inbound') {

            $queryRequest = [
                'startDate' => $request->startDate,
                'endDate'   => $request->endDate,
            ];
            $sql    = "select callid from log_skill_inbound ";
            $sql   .= "where call_start_time between '{$request->startDate}' and '{$request->endDate}' ";
            $sql   .= "and skill_id in ('AH', 'AA', 'AB', 'AG', 'AI', 'AJ', 'Ak', 'AL', 'AF') ";
            $sql   .= "and call_type = 'V'";
            $result = db_select_array($sql);

            if (count($result) > DATA_FETCH_LIMIT) {

                return [
                    'responseTimestamp' => $currentTimestamp,
                    'resultStatus'      => self::ERROR_STATUS,
                    'resultCode'        => self::ERROR_CODE,
                    'message'           => self::ERROR_MSG,
                    'data'              => []

                ];
            }

            return self::inbound($queryRequest);

        } else if($request->dataType == 'outbound') {

            $queryRequest = [
                'startDate' => $request->startDate,
                'endDate'   => $request->endDate,
            ];
            $sql    = "select callid from log_agent_outbound_manual ";
            $sql   .= "where start_time between '{$request->startDate}' and '{$request->endDate}' ";
            $result = db_select_array($sql);

            if (count($result) > DATA_FETCH_LIMIT) {

                return [
                    'responseTimestamp' => $currentTimestamp,
                    'resultStatus'      => self::ERROR_STATUS,
                    'resultCode'        => self::ERROR_CODE,
                    'message'           => self::ERROR_MSG,
                    'data'              => []

                ];
            }

            return self::outbound($queryRequest);
        } else {

            return [
                'responseTimestamp' => $currentTimestamp,
                'resultStatus'      => self::ERROR_STATUS,
                'resultCode'        => 407,
                'message'           => "Invalid data type",
                'data'              => []

            ];
        }
    }

    private static function inbound(array $queryRequest) : ? array {

        try {

            $sql    = "select lsi.callid as callId , lsi.tstamp as tstamp , lsi.call_start_time as callStartTime , lsi.cli as cli , lsi.did as did , lsi.status as status , ";
            $sql   .= "lsi.ring_time as ringTime , lsi.service_time as serviceTime , lsi.agent_hold_time as agentHoldTime , lsi.repeated_call as repeatedCall , lsi.ice_feedback as iceFeedback , ";
            $sql   .= "lsi.disc_party as discParty , lsi.hold_in_q as holdInQueue , lsi.wrap_up_time as wrapUpTime , lsi.agent_id as agentId , a.name as agentName , lsi.transfer_tag as transferTag , ";
            $sql   .= "s.skill_name as skillName , scdc.title as disposition ";
            $sql   .= "from log_skill_inbound as lsi ";
            $sql   .= "left join agents as a on a.agent_id = lsi.agent_id ";
            $sql   .= "left join skill_crm_disposition_code as scdc on scdc.disposition_id = lsi.disposition_id ";
            $sql   .= "left join skill as s on s.skill_id = lsi.skill_id ";
            $sql   .= "where lsi.call_start_time between '{$queryRequest['startDate']}' and '{$queryRequest['endDate']}' ";
            $sql   .= "and lsi.skill_id in ('AH', 'AA', 'AB', 'AG', 'AI', 'AJ', 'Ak', 'AL', 'AF') ";
            $sql   .= "and lsi.call_type = 'V' ";

            $result = db_select_array($sql);

            if( count($result) > 0 ) {

                foreach($result as $data) {

                    $data->agentName        = $data->agentName ?? '';
                    $data->ringTime			= gmdate('H:i:s',$data->ringTime);
                    $data->serviceTime		= gmdate('H:i:s',$data->serviceTime);
                    $data->agentHoldTime	= gmdate('H:i:s',$data->agentHoldTime);
                    $data->holdInQueue		= gmdate('H:i:s',$data->holdInQueue);
                    $data->wrapUpTime		= gmdate('H:i:s',$data->wrapUpTime);
                    $data->repeatedCall    	= $data->repeatedCall == 'Y' ? 'Yes' : 'No';
                    $data->discParty 		= DISC_PARTY[$data->discParty] ?? $data->transferTag;
                    $data->transferTag      = TRANSFER_TYPE[$data->transferTag] ?? $data->transferTag;
                    $data->disposition      = $data->disposition ?? '';
                    $data->iceFeedback	   	= $data->iceFeedback == 'Y' ? 'Positive' : 'Negative';
                    $data->status 		   	= $data->status == 'S' ? 'Served' : 'Abandoned';
                }
            }

            $resultStatus 	= self::SUCCESS_STATUS;
            $data  			= $result;
            $resultCode 	= self::SUCCESS_CODE;
            $msg   			= self::SUCCESS_MSG;
        } catch(Exception $e) {

            $resultStatus 	= self::ERROR_STATUS;
            $data  			= [];
            $resultCode 	= self::ERROR_CODE;
            $msg            = self::ERROR_MSG; #$e->getMessage();
        }

        return [
            'responseTimestamp' => time(),
            'resultStatus'      => $resultStatus,
            'resultCode'        => $resultCode,
            'message'           => $msg,
            'data' 				=> $data

        ];
    }

    private static function outbound(array $queryRequest) : ? array {

        try {

            $sql    = "select laom.start_time as dateTime , laom.callerid as did , a.agent_id as agentId , a.name as agentName , ";
            $sql   .= "laom.callid as callId , s.skill_name as skillName , laom.talk_time as talkTime , laom.ring_time as ringTime , laom.hold_time as holdTime , ";
            $sql   .= "laom.wrap_up_time as wrapUpTime , (laom.talk_time + laom.hold_time + laom.wrap_up_time) as aht , laom.callto as callTo , ";
            $sql   .= "laom.is_reached as status , laom.disc_party as discParty , laom.disc_cause as discCause , scdc.title as disposition ";
            $sql   .= "from log_agent_outbound_manual as laom ";
            $sql   .= "left join agents as a on a.agent_id = laom.agent_id ";
            $sql   .= "left join skill_crm_disposition_code as scdc on scdc.disposition_id = laom.disposition_id ";
            $sql   .= "left join skill as s on s.skill_id = laom.skill_id ";
            $sql   .= "where laom.start_time between '{$queryRequest['startDate']}' and '{$queryRequest['endDate']}' ";

            $result = db_select_array($sql);

            if(count($result) > 0) {

                foreach ($result as $data) {

                    $data->callEndTime      = date('Y-m-d H:i:s',(strtotime($data->dateTime) + $data->talkTime + $data->ringTime));
                    $data->skillName        = $data->skillName ?? '';
                    $data->status           = $data->status == 'Y' ? 'Answered' : 'No Answer';
                    $data->talkTime         = gmdate('H:i:s',$data->talkTime);
                    $data->ringTime         = gmdate('H:i:s',$data->ringTime);
                    $data->holdTime         = gmdate('H:i:s',$data->holdTime);
                    $data->wrapUpTime       = gmdate('H:i:s',$data->wrapUpTime);
                    $data->aht              = gmdate('H:i:s',$data->aht);
                    $data->disposition      = $data->disposition ?? '';
                    $data->discParty 		= DISC_PARTY[$data->discParty] ?? $data->transferTag;
                    $data->discMsg          = DISC_MSG[$data->discCause] ?? '';
                }
            }

            $resultStatus 	= self::SUCCESS_STATUS;
            $data  			= $result;
            $resultCode 	= self::SUCCESS_CODE;
            $msg   			= self::SUCCESS_MSG;
        } catch (Exception $e) {

            $resultStatus 	= self::ERROR_STATUS;
            $data  			= [];
            $resultCode 	= self::ERROR_CODE;
            $msg            = self::ERROR_MSG; #$e->getMessage();
        }

        return [
            'responseTimestamp' => time(),
            'resultStatus'      => $resultStatus,
            'resultCode'        => $resultCode,
            'message'           => $msg,
            'data' 				=> $data

        ];
    }
}


$obj        = new Api();
$inputData  = file_get_contents("php://input");
$request    = json_decode($inputData);

if(!empty($request->requestType) && $_REQUEST['path'] == "request" && method_exists('Api',$request->requestType)) {

    echo json_encode($obj->{$request->requestType}());
} else {

    echo json_encode([
        'responseTimestamp'     => time(),
        'resultStatus'          => 'Failed',
        'resultCode'            => 406,
        'message'               => "Invalid request",
        'data'                  => []

    ]);
}




