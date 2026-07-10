<?php
// 상위 클래스 로드 보장
include_once "class.http.php";

class EmmaSMS extends http {
    
    var $Args;

    // 표준 생성자로 초기화 단일화
    function __construct() {
        parent::__construct();
        $this->Args = array();
        $this->Args['Lang'] = "PHP";
        $this->Args['Char'] = "UTF-8";

        $this->host = "smsapi.whoisweb.net";
        $this->path = "/emma/EmmaSend.php";
    }

    function login($id, $pass) {
        $this->Args['Id'] = $id;
        $this->Args['Pass'] = $pass;
    }

    function send($To, $From, $Message, $Date='', $SmsType='') {
        if(is_array($To)) $this->Args['To'] = implode(",",$To);
        else $this->Args['To'] = $To;
        $this->Args['From'] = $From;
        $this->Args['Message'] = $Message;
        $this->Args['Date'] = $Date;
        $this->Args['SmsType'] = $SmsType;

        foreach($this->Args as $key => $value) $args[$key] = base64_encode($value);

        $this->variable["methodName"] = "EmmaSend";
        $this->variable["params"] = json_encode($args);

        $res = trim($this->getBody("post"));

        if(!$res) {
            return $this->errMsg;
        } else {
            return json_decode($res,true);
        }
    }

    function point() {
        foreach($this->Args as $key => $value) $args[$key] = base64_encode($value);

        $this->variable["methodName"] = "EmmaPoint";
        $this->variable["params"] = json_encode($args);

        $res = trim($this->getBody("post"));

        if(!$res) {
            return $this->errMsg;
        } else {
            $res = json_decode($res,true);

            if($res['Code'] != '00') {
                return $res['CodeMsg'];
            } else {
                return $res['Point'];
            }
        }
    }

    function statistics ($year, $month) {
        if (!checkdate ($month, 1, $year)) return $this->setError(" 날짜가 잘못되었습니다. ");

        $this->Args['date'] = $year."-".$month;

        foreach($this->Args as $key => $value) $args[$key] = base64_encode($value);

        $this->variable["methodName"] = "EmmaStatistic";
        $this->variable["params"] = json_encode($args);

        $res = trim($this->getBody("post"));

        $res = json_decode($res,true);

        if(!$res) {
            return $this->errMsg;
        } else {
            if($res['Code'] != '00') {
                return $this->setError($res['CodeMsg']);
            } else {
                $this->Point = $res['Point'];
                return $res['Statistics'];
            }
        }
    }

    function setError($msg) {
        $this->errMsg = $msg;
        return false;
    }
}
?>