<?php

include_once "../include/admin_auth.php";
include_once "../../util/config.php";
include_once "../../util/util.php";

$connect = my_connect($host, $dbid, $dbpass, $dbname);

$passwd      = set_var($_POST['passwd']);
$passwd2     = set_var($_POST['passwd2']);
$email       = set_var($_POST['email']);
$name        = set_var($_POST['name']);
$hphone1     = set_var($_POST['hphone1']);
$hphone2     = set_var($_POST['hphone2']);
$hphone3     = set_var($_POST['hphone3']);
$zipcode1    = set_var($_POST['zipcode1']);
$zipcode2    = set_var($_POST['zipcode2']);
$addr1       = set_var($_POST['addr1']);
$addr2       = set_var($_POST['addr2']);
$phone1      = set_var($_POST['phone1']);
$phone2      = set_var($_POST['phone2']);
$phone3      = set_var($_POST['phone3']);
$dc_rate     = set_var($_POST['dc_rate']);
$tax         = set_var($_POST['tax']);
$payment_day = set_var($_POST['payment_day']);
$approved    = set_var($_POST['approved']);
$sms         = set_var($_POST['sms']);
$sms_chk     = set_var($_POST['sms_chk']);

$email = addslashes($email);
$addr1 = addslashes($addr1);
$addr2 = addslashes($addr2);

$payment_type  = $payment_day[0];
$approved_type = $approved[0];
$tax           = $tax[0];

$phone   = $phone1 . "-" . $phone2 . "-" . $phone3;
$hphone  = $hphone1 . "-" . $hphone2 . "-" . $hphone3;
$zipcode = $zipcode1 . "-" . $zipcode2;

if ($passwd2 != '') {
    $passwd = sha1($passwd2);
}

$query1 = "UPDATE pmember SET passwd = '$passwd',
							email = '$email',
							name = '$name',
							hphone = '$hphone',
						    zipcode = '$zipcode',
							addr1 = '$addr1',
							addr2 = '$addr2',
							phone = '$phone',
							dc_rate = '$dc_rate',
							tax = '$tax',
							payment_day = '$payment_type',
							approved = '$approved_type'
		  WHERE seq_num='$num' ";

$result1 = mysqli_query($connect, $query1);

######### SMS 발송처리 (회원 SMS 수신 Y, 승인처리 Y, 관리자 SMS 사용여부 Y, 승인 시 SMS Y 에만)
######### $sms: 회원 SMS 수신여부
$res     = mysqli_query($connect, "SELECT * FROM sms");
$sms_row = mysqli_fetch_array($res);

if ($sms_row['sms'] == "Y") {
    if ($sms == "Y" && $approved_type == "Y" && $sms_row['reg_chk'] == "Y" && $sms_chk == "Y") {
        //send_sms(받는 사람 핸드폰번호, 메시지 타입, 회원명, 날짜, DB 연결)
        //메시지 타입 1: 회원승인 처리
        //날짜 : 빈칸이면 즉시 발송
        send_sms($hphone, 1, $name, "", $connect);
    }
}
####### SMS 발송 끝

if (!$result1) {
    err_msg('DB 오류가 발생했습니다.');
} else {
    echo "<meta http-equiv='content-type' content='text/html; charset=UTF-8' />
     	   <script>
        	window.alert('정상적으로 수정했습니다.')
	       </script> ";
    echo "<meta http-equiv='Refresh' content='0;  URL=mem_view_pmember.php?num=$num&amp;page=$page'>";
}
