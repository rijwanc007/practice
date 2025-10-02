
<?php

class Sdf {

    private $baseUrl = "http://wsapi.dhakabank.com.bd/SetDblGoLimitProfile/SetProfile.asmx";
    private $bankCode, $groupCode;

    public function __construct($bankCode = null, $groupCode = null) {

        $this->bankCode    = $bankCode;
        $this->groupCode   = $groupCode;
    }

    public function customerCardList($client) {

        $result = null;
        $cardListRequest = '<?xml version="1.0" encoding="UTF-8"?>
                            <soapenv:Envelope
                                xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                                xmlns:xsd="http://www.w3.org/2001/XMLSchema"
                                xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
                                <soapenv:Body>
                                    <listCustomerCards>
                                        <ConnectionInfo>
                                            <BANK_C>'.$this->bankCode.'</BANK_C>
                                            <GROUPC>'.$this->groupCode.'</GROUPC>
                                        </ConnectionInfo>
                                        <Parameters>
                                            <BANK_C>'.$this->bankCode.'</BANK_C>
                                            <CLIENT>'.$client.'</CLIENT>
                                        </Parameters>
                                    </listCustomerCards>
                                </soapenv:Body>
                            </soapenv:Envelope>';

        $curl_response = $this->getCurlData($cardListRequest, null, $this->baseUrl);
        $result        = $this->convertXMLToObject($curl_response);

        // $result  = $result->AccountNo;


        return $result;
        
        // return $curl_response;

    }

    public function accountBalanceQuery($card) {

        $result = null;
        $accountBalanceQueryRequest = '<?xml version="1.0" encoding="UTF-8"?>
                                       <soapenv:Envelope
                                            xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                                            xmlns:xsd="http://www.w3.org/2001/XMLSchema"
                                            xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
                                            <soapenv:Body>
                                                <queryAccountBalanceByCard>
                                                    <ConnectionInfo>
                                                        <BANK_C>'.$this->bankCode.'</BANK_C>
                                                        <GROUPC>'.$this->groupCode.'</GROUPC>
                                                    </ConnectionInfo>
                                                    <Parameters>
                                                        <CARD>'.$card.'</CARD>
                                                        <BANK_C>'.$this->bankCode.'</BANK_C>
                                                        <GROUPC>'.$this->groupCode.'</GROUPC>
                                                    </Parameters>
                                                </queryAccountBalanceByCard>
                                            </soapenv:Body>
                                       </soapenv:Envelope>';

        $curl_response = $this->getCurlData($accountBalanceQueryRequest, null, $this->baseUrl);
        $result        = $this->convertXMLToObject($curl_response);

        return $result;
    }

    public function billInfoQuery($client,$billDate) {

        $result = null;
        $billInfoQueryRequest = '<?xml version="1.0" encoding="UTF-8"?>
                                 <SOAP-ENV:Envelope
                                    SOAP-ENV:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"
                                    xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/"
                                    xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/"
                                    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                                    xmlns:xsd="http://www.w3.org/2001/XMLSchema">
                                    <SOAP-ENV:Body>
                                        <queryBillInfo>
                                            <ConnectionInfo>
                                                <BANK_C>'.$this->bankCode.'</BANK_C>
                                                <GROUPC>'.$this->groupCode.'</GROUPC>
                                            </ConnectionInfo>
                                            <Parameters>
                                                <CLIENT>'.$client.'</CLIENT>
                                                <BANK_C>'.$this->bankCode.'</BANK_C>
                                                <BILL_DATE>'.$billDate.'</BILL_DATE>
                                            </Parameters>
                                        </queryBillInfo>
                                    </SOAP-ENV:Body>
                                 </SOAP-ENV:Envelope>';

        $curl_response = $this->getCurlData($billInfoQueryRequest, null, $this->baseUrl);
        $result        = $this->convertXMLToObject($curl_response);

        return $result;
    }

    public function transactionHistoryQuery($card,$beginDate,$endDate,$lockingFlag) {

        $result = null;
        $transactionHistoryQueryRequest = '<?xml version="1.0" encoding="UTF-8"?>
                                           <soapenv:Envelope 
                                                xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                                                xmlns:xsd="http://www.w3.org/2001/XMLSchema"
                                                xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
                                                <soapenv:Body>
                                                    <queryTransactionHistory>
                                                        <ConnectionInfo>
                                                            <BANK_C>'.$this->bankCode.'</BANK_C>
                                                            <GROUPC>'.$this->groupCode.'</GROUPC>
                                                        </ConnectionInfo>
                                                        <Parameters>
                                                            <CARD>'.$card.'</CARD>
                                                            <BEGIN_DATE>'.$beginDate.'</BEGIN_DATE>
                                                            <END_DATE>'.$endDate.'</END_DATE>
                                                            <BANK_C>'.$this->bankCode.'</BANK_C>
                                                            <GROUPC>'.$this->groupCode.'</GROUPC>
                                                            <LOCKING_FLAG>'.$lockingFlag.'</LOCKING_FLAG>
                                                        </Parameters>
                                                    </queryTransactionHistory>
                                                </soapenv:Body>
                                           </soapenv:Envelope>';

        $curl_response = $this->getCurlData($transactionHistoryQueryRequest, null, $this->baseUrl);
        $result        = $this->convertXMLToObject($curl_response);

        return $result;
    }

    public function activeCard($card) {

        $result = null;
        $activeCardRequest = '<?xml version="1.0" encoding="UTF-8"?>
                              <soapenv:Envelope
                                xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                                xmlns:xsd="http://www.w3.org/2001/XMLSchema"
                                xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
                                    <soapenv:Body>
                                        <activateCard>
                                            <ConnectionInfo>
                                                <BANK_C>'.$this->bankCode.'</BANK_C>
                                                <GROUPC>'.$this->groupCode.'</GROUPC>
                                            </ConnectionInfo>
                                            <Parameters>
                                                <CARD>'.$card.'</CARD>
                                                <BANK_C>'.$this->bankCode.'</BANK_C>
                                                <GROUPC>'.$this->groupCode.'</GROUPC>
                                            </Parameters>
                                        </activateCard>
                                    </soapenv:Body>
                              </soapenv:Envelope>';

        $curl_response = $this->getCurlData($activeCardRequest, null, $this->baseUrl);
        $result        = $this->convertXMLToObject($curl_response);

        return $result;

    }

    public function deActiveCard($externalSessionID,$card) {

        $result = null;
        $deActiveCardRequest = '<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                                    xmlns:xsd="http://www.w3.org/2001/XMLSchema"
                                    xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                                    xmlns:bin="urn:IssuingWS/binding">
                                <soapenv:Header/>
                                        <soapenv:Body>
                                            <deactivateCard>
                                                <ConnectionInfo>
                                                    <BANK_C>'.$this->bankCode.'</BANK_C>
                                                    <GROUPC>'.$this->groupCode.'</GROUPC>
                                                    <EXTERNAL_SESSION_ID>'.$externalSessionID.'</EXTERNAL_SESSION_ID>
                                                </ConnectionInfo>
                                                <Parameters>
                                                    <CARD>'.$card.'</CARD>
                                                </Parameters>
                                            </deactivateCard>
                                        </soapenv:Body>
                                </soapenv:Envelope>';

        $curl_response = $this->getCurlData($deActiveCardRequest, null, $this->baseUrl);
        $result        = $this->convertXMLToObject($curl_response);

        return $result;
    }

    public function assignPin($card,$expiry,$stan,$pinBlock,$cardSecureCode) {

        $result = null;
        $assignPinRequest = '<SOAP-ENV:Envelope
                                SOAP-ENV:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"
                                xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/"
                                xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/"
                                xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                                xmlns:xsd="http://www.w3.org/2001/XMLSchema">
                                    <SOAP-ENV:Body>
                                        <assignPIN>
                                            <ConnectionInfo>
                                                <BANK_C>'.$this->bankCode.'</BANK_C>
                                                <GROUPC>'.$this->groupCode.'</GROUPC>
                                            </ConnectionInfo>
                                            <Parameters>
                                                <CARD>'.$card.'</CARD>
                                                <EXPIRY>'.$expiry.'</EXPIRY>
                                                <STAN>'.$stan.'</STAN>
                                                <PINBLOCK>'.$pinBlock.'</PINBLOCK>
                                                <CARD_SECURE_CODE>'.$cardSecureCode.'</CARD_SECURE_CODE>
                                            </Parameters>
                                        </assignPIN>
                                    </SOAP-ENV:Body>
                             </SOAP-ENV:Envelope>';

        $curl_response = $this->getCurlData($assignPinRequest, null, $this->baseUrl);
        $result        = $this->convertXMLToObject($curl_response);

        return $result;
    }

    public function realTimeStatementQuery($card,$beginDate,$endDate,$inclUnprocTr,$inclLocks) {

        $result = null;
        $realTimeStatementQueryRequest = '<?xml version="1.0" encoding="UTF-8"?>
                                          <soapenv:Envelope
                                                xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                                                xmlns:xsd="http://www.w3.org/2001/XMLSchema"
                                                xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
                                                    <soapenv:Body>
                                                        <queryRealTimeStatement>
                                                            <ConnectionInfo>
                                                                <BANK_C>'.$this->bankCode.'</BANK_C>
                                                                <GROUPC>'.$this->groupCode.'</GROUPC>
                                                            </ConnectionInfo>
                                                            <Parameters>
                                                                <CARD>'.$card.'</CARD>
                                                                <BEGIN_DATE>'.$beginDate.'</BEGIN_DATE>
                                                                <END_DATE>'.$endDate.'</END_DATE>
                                                                <INCL_UNPROC_TR>'.$inclUnprocTr.'</INCL_UNPROC_TR>
                                                                <INCL_LOCKS>'.$inclLocks.'</INCL_LOCKS>
                                                            </Parameters>
                                                        </queryRealTimeStatement>
                                                    </soapenv:Body>
                                         </soapenv:Envelope>';

        $curl_response = $this->getCurlData($realTimeStatementQueryRequest, null, $this->baseUrl);
        $result        = $this->convertXMLToObject($curl_response);

        return $result;
    }

    private function getCurlData($ciphertext, $header=null, $url=null) {
        
        $header = !empty($header) ? $header : array("Content-type: text/xml", "Accept: text/xml", "Cache-Control: no-cache");

        $soap_do = curl_init();

        curl_setopt($soap_do, CURLOPT_URL, $url );

        curl_setopt($soap_do, CURLOPT_CONNECTTIMEOUT, 30);

        curl_setopt($soap_do, CURLOPT_TIMEOUT,        30);

        curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true );

        curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($soap_do, CURLOPT_SSL_VERIFYHOST, false);

        curl_setopt($soap_do, CURLOPT_POST,           true );

        curl_setopt($soap_do, CURLOPT_POSTFIELDS,     $ciphertext);

        curl_setopt($soap_do, CURLOPT_HTTPHEADER,     $header);

        $result = curl_exec($soap_do);
        
        if($result == false) {
        
            $err = 'Curl error: ' . curl_error($soap_do);
            curl_close($soap_do);
            print $err;
            echo $soap_request;
            echo $result;
        }


        curl_close($soap_do);

        return $result;
    }

    private function convertXMLToObject($result)
    {

        $p = xml_parser_create();

        xml_parser_set_option($p, XML_OPTION_CASE_FOLDING, 0);

        xml_parse_into_struct($p, $result, $vals, $index);

        xml_parser_free($p);

        $obj = new stdClass();

        foreach ($vals as $key => $value){

            $tag_name = $value['tag'];

            $tag_value = $value['value'];

            $obj->$tag_name = !is_array($tag_value) ? $tag_value : "";

        }

        return $obj;

    }


}


