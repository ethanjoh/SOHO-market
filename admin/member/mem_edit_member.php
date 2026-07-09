<?php

include_once "../include/admin_auth.php";
include_once "../../util/util.php";

$num  = set_var($_POST['num']);
$page = set_var($_POST['page']);

$passwd     = set_var($_POST['passwd']);
$passwd2    = set_var($_POST['passwd2']);
$changePw   = set_var($_POST['changePw']);
$md_email   = set_var($_POST['md_email']);
$md_hphone1 = set_var($_POST['md_hphone1']);
$md_hphone2 = set_var($_POST['md_hphone2']);
$md_hphone3 = set_var($_POST['md_hphone3']);

$md_name      = set_var($_POST['md_name']);
$job_title    = set_var($_POST['job_title']);
$md_hphone    = set_var($_POST['md_hphone']);
$company_name = set_var($_POST['company_name']);
$ceo          = set_var($_POST['ceo']);
$license_no1  = set_var($_POST['license_no1']);
$license_no2  = set_var($_POST['license_no2']);
$license_no3  = set_var($_POST['license_no3']);
// $open_year         = set_var($_POST['open_year']);
// $open_month     = set_var($_POST['open_month']);
// $open_day         = set_var($_POST['open_day']);
$o_zipcode1 = set_var($_POST['o_zipcode1']);
// $o_zipcode2  = set_var($_POST['o_zipcode2']);
$o_addr1    = set_var($_POST['o_addr1']);
$o_addr2    = set_var($_POST['o_addr2']);
$o_phone1   = set_var($_POST['o_phone1']);
$o_phone2   = set_var($_POST['o_phone2']);
$o_phone3   = set_var($_POST['o_phone3']);
$o_fax1     = set_var($_POST['o_fax1']);
$o_fax2     = set_var($_POST['o_fax2']);
$o_fax3     = set_var($_POST['o_fax3']);
$category1  = set_var($_POST['category1']);
$category2  = set_var($_POST['category2']);
$taxtype    = set_var($_POST['tax_type']);
$homepage   = set_var($_POST['homepage']);
$d_zipcode1 = set_var($_POST['d_zipcode1']);
// $d_zipcode2  = set_var($_POST['d_zipcode2']);
$d_addr1     = set_var($_POST['d_addr1']);
$d_addr2     = set_var($_POST['d_addr2']);
$d_phone1    = set_var($_POST['d_phone1']);
$d_phone2    = set_var($_POST['d_phone2']);
$d_phone3    = set_var($_POST['d_phone3']);
$d_fax1      = set_var($_POST['d_fax1']);
$d_fax2      = set_var($_POST['d_fax2']);
$d_fax3      = set_var($_POST['d_fax3']);
$seller      = set_var($_POST['seller']);
$dc_rate     = set_var($_POST['dc_rate']);
$tax         = set_var($_POST['tax']);
$payment_day = set_var($_POST['payment_day']);
$approved    = set_var($_POST['approved']);
$sms         = set_var($_POST['sms']);
$sms_chk     = set_var($_POST['sms_chk']);

$company_name = addslashes($company_name);
$license_no   = $license_no1 . "-" . $license_no2 . "-" . $license_no3;
// $open_date    = $open_year . "-" . $open_month . "-" . $open_day;
$md_email = addslashes($md_email);
$o_addr1  = addslashes($o_addr1);
$o_addr2  = addslashes($o_addr2);
$d_addr1  = addslashes($d_addr1);
$d_addr2  = addslashes($d_addr2);

$seller_type   = $seller[0];
$payment_type  = $payment_day[0];
$approved_type = $approved[0];
$tax           = $tax[0];

$o_phone   = $o_phone1 . "-" . $o_phone2 . "-" . $o_phone3;
$o_fax     = $o_fax1 . "-" . $o_fax2 . "-" . $o_fax3;
$d_phone   = $d_phone1 . "-" . $d_phone2 . "-" . $d_phone3;
$d_fax     = $d_fax1 . "-" . $d_fax2 . "-" . $d_fax3;
$md_hphone = $md_hphone1 . "-" . $md_hphone2 . "-" . $md_hphone3;
$o_zipcode = $o_zipcode1;
$d_zipcode = $d_zipcode1;

if ($taxtype == "1") //일반과세자
{
    $tax_type = "I";
} else if ($taxtype == "2") //간이과세자
{
    $tax_type = "G";
}

if ($changePw) {
    $new_passwd = sha1($passwd2);

    $query1 = "UPDATE member SET passwd = '$new_passwd' WHERE seq_num='$num' ";
} else {
    $query1 = "UPDATE member SET
							md_email 		= '$md_email',
							md_name 		= '$md_name',
							job_title 		= '$job_title',
							md_hphone 		= '$md_hphone',
							company_name 	= '$company_name',
							license_no 		= '$license_no',
							ceo 			= '$ceo',
							o_zipcode 		= '$o_zipcode',
							o_addr1 		= '$o_addr1',
							o_addr2 		= '$o_addr2',
							o_phone 		= '$o_phone',
							o_fax 			= '$o_fax',
							category1 		= '$category1',
							category2 		= '$category2',
							tax_type 		= '$tax_type',
							homepage 		= '$homepage',
							d_zipcode 		= '$d_zipcode',
							d_addr1 		= '$d_addr1',
							d_addr2 		= '$d_addr2',
							d_phone 		= '$d_phone',
							d_fax 			= '$d_fax',
							seller 			= '$seller_type',
							dc_rate 		= '$dc_rate',
							tax 			= '$tax',
							payment_day 	= '$payment_type',
							approved 		= '$approved_type'
		  WHERE seq_num='$num' ";

}

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
        send_sms($md_hphone, 1, $company_name, "", $connect);
    }
}
####### SMS 발송 끝

if (!$result1) {
    err_msg('DB 오류가 발생했습니다.');
} else {
    $url = "https://" . $_SERVER['SERVER_NAME'] . "/admin/member/mem_view_member.php?num=" . $num . "&amp;page=" . $page;
    $msg = "정상적으로 수정했습니다.";

    show_msg($msg, $url);

    // echo "<meta http-equiv='content-type' content='text/html; charset=UTF-8' />
    //         <script>
    //         window.alert('정상적으로 수정했습니다.')
    //     </script> ";
    // echo "<meta http-equiv='Refresh' content='0;  URL=http://" . $_SERVER['SERVER_NAME'] . "/admin/member/mem_view_member.php?num=" . $num . "&amp;page=" . $page . "'>";
}
