<?php

//header('Access-Control-Allow-Origin: *');
//header('Access-Control-Allow-Methods: POST');
//header("Access-Control-Allow-Headers: X-Requested-With");
//header("Content-Type: application/json; charset=UTF-8");
//
//ini_set('display_errors', '1');
//error_reporting(E_ALL);
//error_reporting(0);

//http://192.168.11.220/ccpro/api/datashare/request?start_date=2025-07-03%2011:04:40&&end_date=2025-07-03%2013:10:10&&type=inbound

require 'db_conf.php';
require 'constant.php';

class Api {

    private const ERROR_STATUS      = false;
    private const SUCCESS_STATUS    = true;
    private const ERROR_CODE        = 400;
    private const SUCCESS_CODE      = 200;
    private const ERROR_MSG         = "something went wrong please check the type or date time range cross data fetch limit";
    private const SUCCESS_MSG       = "data fetched successfully";
    public function __construct() {

        date_default_timezone_set('Asia/Dhaka');
        db_conn();
    }

    public static function dataShare(array $params) {

        switch ($params['type']) {

            case 'inbound'  :
                $queryParams = [
                    'startDate' => $params['startDate'],
                    'endDate'   => $params['endDate'],
                ];
                $sql    = "select callid from log_skill_inbound ";
                $sql   .= "where call_start_time between '{$params['startDate']}' and '{$params['endDate']}' ";
                $sql   .= "and skill_id in ('AH', 'AA', 'AB', 'AG', 'AI', 'AJ', 'Ak', 'AL', 'AF') ";
                $sql   .= "and call_type = 'V'";
                $result = db_select_array($sql);
                if (count($result) > DATA_FETCH_LIMIT) {

                    $errorParams = [
                      'resultStatus' => self::ERROR_STATUS,
                      'resultCode'   => self::ERROR_CODE,
                      'message'      => self::ERROR_MSG
                    ];
                    echo json_encode(self::other($errorParams));
                    self::other($errorParams);
                } else {

                    echo json_encode(self::inbound($queryParams));
                    #self::inbound($queryParams);
                }
                break;

            case 'outbound' :
                $queryParams = [
                    'startDate' => $params['startDate'],
                    'endDate'   => $params['endDate'],
                ];
                $sql    = "select callid from log_agent_outbound_manual ";
                $sql   .= "where start_time between '{$params['startDate']}' and '{$params['endDate']}' ";
                $result = db_select_array($sql);

                if (count($result) > DATA_FETCH_LIMIT) {

                    $errorParams = [
                        'resultStatus' => self::ERROR_STATUS,
                        'resultCode'   => self::ERROR_CODE,
                        'message'      => self::ERROR_MSG
                    ];
                    echo json_encode(self::other($errorParams));
                    #self::other($errorParams);
                } else {

                    echo json_encode(self::outbound($queryParams));
                    #self::outbound($queryParams);
                }
                break;

            default         :
                    echo json_encode(self::other());
                    #self::other();
        }
    }

    private static function inbound(array $queryParams) : ? array {

        try {

            $sql    = "select lsi.callid as callId , lsi.tstamp as tstamp , lsi.call_start_time as callStartTime , lsi.cli as cli , lsi.did as did , lsi.status as status , ";
            $sql   .= "lsi.ring_time as ringTime , lsi.service_time as serviceTime , lsi.agent_hold_time as agentHoldTime , lsi.repeated_call as repeatedCall , lsi.ice_feedback as iceFeedback , ";
            $sql   .= "lsi.disc_party as discParty , lsi.hold_in_q as holdInQueue , lsi.wrap_up_time as wrapUpTime , lsi.agent_id as agentId , a.name as agentName , lsi.transfer_tag as transferTag , ";
            $sql   .= "s.skill_name as skillName , scdc.title as disposition ";
            $sql   .= "from log_skill_inbound as lsi ";
            $sql   .= "left join agents as a on a.agent_id = lsi.agent_id ";
            $sql   .= "left join skill_crm_disposition_code as scdc on scdc.disposition_id = lsi.disposition_id ";
            $sql   .= "left join skill as s on s.skill_id = lsi.skill_id ";
            $sql   .= "where lsi.call_start_time between '{$queryParams['startDate']}' and '{$queryParams['endDate']}' ";
            $sql   .= "and lsi.skill_id in ('AH', 'AA', 'AB', 'AG', 'AI', 'AJ', 'Ak', 'AL', 'AF') ";
            $sql   .= "and lsi.call_type = 'V' ";

            $result = db_select_array($sql);

            if( count($result) > 0 ) {

                foreach($result as $data) {

                    $data->ringTime			= gmdate('H:i:s',$data->ringTime);
                    $data->serviceTime		= gmdate('H:i:s',$data->serviceTime);
                    $data->agentHoldTime	= gmdate('H:i:s',$data->agentHoldTime);
                    $data->holdInQueue		= gmdate('H:i:s',$data->holdInQueue);
                    $data->wrapUpTime		= gmdate('H:i:s',$data->wrapUpTime);
                    $data->repeatedCall    	= $data->repeatedCall == 'Y' ? 'Yes' : 'No';
                    $data->discParty 		= DISC_PARTY[$data->discParty] ?? $data->transferTag;
                    $data->transferTag      = TRANSFER_TYPE[$data->transferTag] ?? $data->transferTag;
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
            'resultStatus'      => $resultStatus,
            'data' 				=> $data,
            'resultCode'        => $resultCode,
            'message'           => $msg,
        ];
    }

    private static function outbound(array $queryParams) : ? array {

        try {

            $sql    = "select laom.start_time as dateTime , laom.callerid as did , a.agent_id as agentId , a.name as agentName , ";
            $sql   .= "laom.callid as callId , s.skill_name as skillName , laom.talk_time as talkTime , laom.ring_time as ringTime , laom.hold_time as holdTime , ";
            $sql   .= "laom.wrap_up_time as wrapUpTime , (laom.talk_time + laom.hold_time + laom.wrap_up_time) as aht , laom.callto as callTo , ";
            $sql   .= "laom.is_reached as status , laom.disc_party as discParty , laom.disc_cause as discCause , scdc.title as disposition ";
            $sql   .= "from log_agent_outbound_manual as laom ";
            $sql   .= "left join agents as a on a.agent_id = laom.agent_id ";
            $sql   .= "left join skill_crm_disposition_code as scdc on scdc.disposition_id = laom.disposition_id ";
            $sql   .= "left join skill as s on s.skill_id = laom.skill_id ";
            $sql   .= "where laom.start_time between '{$queryParams['startDate']}' and '{$queryParams['endDate']}' ";

            $result = db_select_array($sql);

            if(count($result) > 0) {

                foreach ($result as $data) {

                    $data->callEndTime      = date('Y-m-d H:i:s',(strtotime($data->dateTime) + $data->talkTime + $data->ringTime));
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
            'resultStatus'      => $resultStatus,
            'data' 				=> $data,
            'resultCode'        => $resultCode,
            'message'           => $msg,
        ];
    }

    private static function other(array $errorParams) : ? array {

        return [
            'resultStatus'      => $errorParams['resultStatus'],
            'data' 				=> [],
            'resultCode'        => $errorParams['resultCode'],
            'message'           => $errorParams['message'],
        ];
    }
}

$params     = [
    'startDate' => $_REQUEST['start_date'] ?? date('Y-m-d H:i:s'),
    'endDate'   => $_REQUEST['end_date'] ?? date('Y-m-d H:i:s'),
    'type'      => $_REQUEST['type'] ?? '',
];

$obj = new Api();
$obj::dataShare($params);



