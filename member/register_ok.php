<?php

include "../util/config.php";
// 각종 유틸함수
include "../util/util.php";
// MySQL 연결
$connect = my_connect($host, $dbid, $dbpass, $dbname);

$sid   = set_var($_POST['session_id']);
$sname = set_var($_POST['session_name']);

$mode         = set_var($_POST['mode']);
$id           = set_var($_POST['userid']);
$id           = trim($id); //remove blank front and back
$passwd       = set_var($_POST['passwd']);
$md_email     = set_var($_POST['md_email']);
$optin        = set_var($_POST['optin']);
$md_name      = set_var($_POST['md_name']);
$md_hphone    = set_var($_POST['md_hphone']);
$sms          = set_var($_POST['sms']);
$company_name = set_var($_POST['company_name']);
$license_no   = set_var($_POST['license_no']);
$ceo          = set_var($_POST['ceo']);
$o_zipcode1   = set_var($_POST['o_zipcode1']);
$o_zipcode2   = set_var($_POST['o_zipcode2']);
$o_addr1      = set_var($_POST['o_addr1']);
$o_addr2      = set_var($_POST['o_addr2']);
$o_phone      = set_var($_POST['o_phone']);
$o_fax        = set_var($_POST['o_fax']);
$category1    = set_var($_POST['category1']);
$category2    = set_var($_POST['category2']);
$taxtype      = set_var($_POST['tax_type']);
$homepage     = set_var($_POST['homepage']);
$d_zipcode1   = set_var($_POST['d_zipcode1']);
$d_zipcode2   = set_var($_POST['d_zipcode2']);
$d_addr1      = set_var($_POST['d_addr1']);
$d_addr2      = set_var($_POST['d_addr2']);
$d_phone      = set_var($_POST['d_phone']);
$d_fax        = set_var($_POST['d_fax']);
// $seller         = set_var($_POST['seller']);

if ("edit" == $mode) {
    // 이름과 아이디에 해당되는 세션이 존재하는지 확인
    if (!isset($sid) || !isset($sname)) {
        err_msg('로그인 정보가 없습니다. 다시 로그인해 주세요.');
    }

    //비밀번호 확인
    $qry  = "SELECT * FROM member WHERE id='$sid' ";
    $res  = mysqli_query($connect, $qry);
    $mrow = mysqli_fetch_array($res);

    if ($mrow['passwd'] != sha1($passwd)) {
        $msg = "비밀번호가 일치하지 않습니다.";
        $url = "http://" . $_SERVER['SERVER_NAME'] . "/member/register_form.php?mode=edit";
        show_msg($msg, $url);

    } else {
        //비밀번호 수정만
        if ($changePW == "Y") {
            $passwd  = sha1($new_passwd2);
            $query3  = "UPDATE member SET passwd = '$passwd' WHERE id='$sid' ";
            $result3 = mysqli_query($connect, $query3);

            // 게시판의 글들에 대한 비밀번호도 모두 수정한다.
            $query2  = "UPDATE board SET passwd='$passwd' WHERE id='$sid' ";
            $result2 = mysqli_query($connect, $query2);

            // 저장과정에서 오류가 발생하면
            if (!$result2) {
                err_msg('게시판 비밀번호 수정 중 DB 오류가 발생했습니다.');
            } else if (!$result3) {
                err_msg('비밀번호 변경 중 DB 오류가 발생했습니다.');
            }

            // 세션을 다시 부여합니다.
            session_register("p_name");
            session_register("p_email");

            $p_name  = $company_name;
            $p_email = $md_email;

            $sender       = "=?EUC-KR?B?" . base64_encode(iconv("UTF-8", "EUC-KR", "신수상사")) . "?=\r\n";
            $sender_email = "griptech@hanmail.net";

            $subject   = $company_name . "님, 신수상사 사이트 비밀번호 변경안내";
            $subject_c = "=?EUC-KR?B?" . base64_encode(iconv("UTF-8", "EUC-KR", $subject)) . "?=\r\n";
            $subject_c = addslashes($subject_c);

            $contents = "<p>골프그립 전문기업 신수상사를 이용해 주셔서 고맙습니다.<br />";
            $contents .= "당사 사이트에서 비밀번호 변경이 되어 안내드립니다.</p>";
            $contents .= "<p>비밀번호 변경을 하지 않았다면 보안을 위해 당사로 연락부탁드립니다.<br/>";
            $contents .= "이용해 주셔서 고맙습니다.</p>";
            $contents = addslashes($contents);

            $headers = "Return-Path: $sender_email\r\n";
            $headers .= "From: $sender <$sender_email>\r\n";

            $boundary = "----" . uniqid("part");

            $headers .= "Content-Type: text/html; charset=utf-8\r\n";
            $message = stripslashes($contents);

            $to = $md_email;

            mail($to, $subject_c, $message, $headers);

            $msg = "비밀번호를 정상적으로 수정했습니다. 다시 로그인해주세요.";
            $url = "http://" . $_SERVER['SERVER_NAME'] . "/index.php";

            show_msg($msg, $url);

        } else {

            $o_zipcode = $o_zipcode1 . "-" . $o_zipcode2;
            $d_zipcode = $d_zipcode1 . "-" . $d_zipcode2;

            $md_email = addslashes($md_email);
            $o_addr1  = addslashes($o_addr1);
            $o_addr2  = addslashes($o_addr2);
            $d_addr1  = addslashes($d_addr1);
            $d_addr2  = addslashes($d_addr2);

            if (!empty($sms)) {
                $sms = "Y";
            } else {
                $sms = "N";
            }

            if (!empty($optin)) {
                $optin = "Y";
            } else {
                $optin = "N";
            }

            ########## 회원정보 테이블에 입력값을 수정한다. ##########
            $query = "UPDATE member SET md_email 		= '$md_email',
										optin 			= '$optin',
										md_name 		= '$md_name',
										job_title 		= '$job_title',
										md_hphone 		= '$md_hphone',
										sms 			= '$sms',
										company_name	= '$company_name',
										ceo 			= '$ceo',
										o_zipcode 		= '$o_zipcode',
										o_addr1 		= '$o_addr1',
										o_addr2 		= '$o_addr2',
										o_phone 		= '$o_phone',
										o_fax 			= '$o_fax',
										category1 		= '$category1',
										category2 		= '$category2',
										homepage 		= '$homepage',
										d_zipcode 		= '$d_zipcode',
										d_addr1 		= '$d_addr1',
										d_addr2 		= '$d_addr2',
										d_phone 		= '$d_phone',
										d_fax 			= '$d_fax'
					  WHERE id='$sid' ";
            $result = mysqli_query($connect, $query);

        } // changePw end

        if (!$result) {
            err_msg('DB 오류가 발생했습니다.');
        } else {

            $msg = "정보를 정상적으로 수정했습니다.";
            $url = "http://" . $_SERVER['SERVER_NAME'] . "/main/index.php";

            show_msg($msg, $url);

        }

    } //비교 end

} else {
    // new member register

    // $md_email = addslashes($md_email);
    // $o_addr1  = addslashes($o_addr1);
    // $o_addr2  = addslashes($o_addr2);
    // $d_addr1  = addslashes($d_addr1);
    // $d_addr2  = addslashes($d_addr2);

    $o_zipcode = $o_zipcode1 . "-" . $o_zipcode2;
    $d_zipcode = $d_zipcode1 . "-" . $d_zipcode2;

    $passwd = sha1($passwd);

    if ($taxtype == "1") //일반과세자
    {
        $tax_type = "I";
    } else if ($taxtype == "2") //간이과세자
    {
        $tax_type = "G";
    }

    // if($seller == "1") //사입판매
    //     $dc_rate = "40";
    // else if($seller == "2") //위탁판매
    //     $dc_rate = "35";

    $approved = "N"; //자동승인 여부

    ########## 회원정보 테이블에 입력값을 등록한다. ##########
    $query = "INSERT INTO member(id,
								passwd,
								md_email,
								optin,
								md_name,
								job_title,
								md_hphone,
								sms,
								company_name,
								license_no,
								ceo,
								o_zipcode,
								o_addr1,
								o_addr2,
								o_phone,
								o_fax,
								category1,
								category2,
								tax_type,
								homepage,
								d_zipcode,
								d_addr1,
								d_addr2,
								d_phone,
								d_fax,
								reg_date,
								dc_rate,
								approved
								)
			   VALUES ('$id',
						'$passwd',
						'$md_email',
						'$optin',
						'$md_name',
						'$job_title',
						'$md_hphone',
						'$sms',
						'$company_name',
						'$license_no',
						'$ceo',
						'$o_zipcode',
						'$o_addr1',
						'$o_addr2',
						'$o_phone',
						'$o_fax',
						'$category1',
						'$category2',
						'$tax_type',
						'$homepage',
						'$d_zipcode',
						'$d_addr1',
						'$d_addr2',
						'$d_phone',
						'$d_fax',
						now(),
						'$dc_rate',
						'$approved' )";

    $result = mysqli_query($connect, $query);

    // $query2 = "INSERT INTO message_info (sendid_fk, receiveid_fk, message, send_reg) VALUES ('admin', '$id', '가입을 환영합니다. 등록하신 이메일로 메일을 보냈으니 확인부탁드립니다.', now() )";
    // $result2 = mysqli_query($connect, $query2);

    // 저장과정에서 오류가 발생하면
    if (!$result) {
        err_msg('데이터베이스 오류가 발생하였습니다.\n 관리자에게 문의하시기 바랍니다.');
    } else {
        //가입메일 보내기
        $sender       = "=?EUC-KR?B?" . base64_encode(iconv("UTF-8", "EUC-KR", "(주)에스메딕스 솔루션")) . "?=\r\n";
        $sender_email = "webmaster@smedics.co.kr";

        $subject   = $company_name . "님, 가입을 환영합니다. (이용안내 필독)";
        $subject_c = "=?EUC-KR?B?" . base64_encode(iconv("UTF-8", "EUC-KR", $subject)) . "?=\r\n";
        $subject_c = addslashes($subject_c);

        $contents = "<p><a href=\"http://www." . $_SERVER['SERVER_NAME'] . "\">의료기기 전문기업 (주)에스메딕스 솔루션</a>에 가입하신 것을 환영합니다.<br />";
        $contents .= "아래 이용안내를 필히 확인하시고 이용부탁드립니다.</p>";
        $contents .= "<p>사용하시는 이메일 계정에서 수신거부 등으로 공지메일 등이 반송될 경우 별도통지없이 회원탈퇴처리될 수 있습니다.<br />";
        $contents .= "담당자와 연락이 닿지 않는 경우 사용정지될 수 있으니 연락가능한 전화번호를 필히 기재하시기 바랍니다.<br />";
        $contents .= "회원가입 후 사업자등록증 사본을 팩스(02-3437-8890)로 보내주시기 바랍니다.<br />";
        $contents .= " <p><br />";
        $contents .= " <p>기타 문의사항은 [이용안내] 게시판에서 먼저 확인해 주시고, 02-3437-8891 또는 1:1 문의게시판을 이용해주시기 바랍니다.<br>";
        $contents .= " 이용해 주셔서 고맙습니다.</p>";
        $contents = addslashes($contents);

        $headers = "Return-Path: $sender_email\r\n";
        $headers .= "From: $sender <$sender_email>\r\n";

        $boundary = "----" . uniqid("part");

        $headers .= "Content-Type: text/html; charset=utf-8\r\n";
        $message = stripslashes($contents);

        $to = $md_email;

        mail($to, $subject_c, $message, $headers);

        $msg = "회원가입이 완료되었습니다. 등록하신 이메일로 메일이 발송되었습니다.";
        msg($msg);

        $re_url = "http://" . $_SERVER['SERVER_NAME'];
        redirect($re_url);
    }

}
; // new member register end
