<?php

include "../util/util.php";

$sid   = set_var($_POST['session_id']);
$sname = set_var($_POST['session_name']);

$mode         = set_var($_POST['mode']);
$id           = set_var($_POST['userid']);
$id           = trim($id); //remove blank front and back
$passwd       = set_var($_POST['passwd']);
$md_email     = set_var($_POST['md_email']);
$optin        = set_var($_POST['optin']);
$md_name      = set_var($_POST['md_name']);
$job_title    = set_var($_POST['job_title']);
$md_hphone    = set_var($_POST['md_hphone']);
$sms          = set_var($_POST['sms']);
$company_name = set_var($_POST['company_name']);
$license_no   = set_var($_POST['license_no']);
$ceo          = set_var($_POST['ceo']);
$o_zipcode1   = set_var($_POST['o_zipcode1']);
// $o_zipcode2   = set_var($_POST['o_zipcode2']);
$o_addr1    = set_var($_POST['o_addr1']);
$o_addr2    = set_var($_POST['o_addr2']);
$o_phone    = set_var($_POST['o_phone']);
$o_fax      = set_var($_POST['o_fax']);
$category1  = set_var($_POST['category1']);
$category2  = set_var($_POST['category2']);
$taxtype    = set_var($_POST['tax_type']);
$homepage   = set_var($_POST['homepage']);
$d_zipcode1 = set_var($_POST['d_zipcode1']);
$d_zipcode2 = set_var($_POST['d_zipcode2']);
$d_addr1    = set_var($_POST['d_addr1']);
$d_addr2    = set_var($_POST['d_addr2']);
$d_phone    = set_var($_POST['d_phone']);
$d_fax      = set_var($_POST['d_fax']);
// $seller         = set_var($_POST['seller']);

// 관리자 정보 가져오기
$qry = "SELECT * FROM admin_setup";
$res = mysqli_query($connect, $qry);
$row = mysqli_fetch_array($res);

$op_company  = $row['company_name'];
$op_homepage = $row['homepage'];
$op_email    = $row['email'];
$op_tel      = $row['tel'];
$op_fax      = $row['fax'];

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
        $url = "http://" . $_SERVER['SERVER_NAME'] . "/member/register-form.php?mode=edit";
        show_msg($msg, $url);

    } else {

        $o_zipcode = $o_zipcode1;
        $d_zipcode = $d_zipcode1;

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

        if (!$result) {
            err_msg('DB 오류가 발생했습니다.');
        } else {

            $msg = "정보를 정상적으로 수정했습니다.";
            $url = "http://" . $_SERVER['SERVER_NAME'];

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

    $o_zipcode = $o_zipcode1;
    $d_zipcode = $d_zipcode1;

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
						'$approved' )";

    $result = mysqli_query($connect, $query);

    // 저장과정에서 오류가 발생하면
    if (!$result) {
        err_msg('데이터베이스 오류가 발생하였습니다.\n 관리자에게 문의하시기 바랍니다.');
    } else {
        //가입메일 보내기
        $sender       = "=?EUC-KR?B?" . base64_encode(iconv("UTF-8", "EUC-KR", "" . $op_company . "")) . "?=\r\n";
        $sender_email = $op_email;

        $subject   = $company_name . "님, 가입을 환영합니다. (이용안내 필독)";
        $subject_c = "=?EUC-KR?B?" . base64_encode(iconv("UTF-8", "EUC-KR", $subject)) . "?=\r\n";
        $subject_c = addslashes($subject_c);

        $info = array(
            'company_name' => $company_name,
            'id'           => $id,
            'email'        => $sender_email,
            'fax'          => $op_fax,
            'homepage'     => $op_homepage,
        );

        // $contents = "<p><a href=\"http://" . $_SERVER['SERVER_NAME'] . "\">" . $op_company . "</a>에 가입하신 것을 환영합니다.<br />";
        // $contents .= "아래 이용안내를 필히 확인하시고 이용부탁드립니다.</p>";
        // $contents .= "기존 거래업체가 아닌 신규 회원 가입업체께서는 사업자등록증 사본을 팩스(" . $op_fax . ")로 보내주셔야 승인처리가 되어 이용이 가능합니다.<br />";
        // $contents .= " <p><br />";
        // $contents .= " <p>기타 문의사항은 <a href=\"http://" . $_SERVER['SERVER_NAME'] . "/member/help.php\">[이용안내]</a> 또는 1:1 문의게시판 , " . $op_tel . " 을 이용해주시기 바랍니다.<br>";
        // $contents .= " 이용해 주셔서 고맙습니다.</p>";
        // $contents = addslashes($contents);

        $contents = format_email($info);

        $headers = "Return-Path: $sender_email\r\n";
        $headers .= "From: $sender <$sender_email>\r\n";

        $boundary = "----" . uniqid("part");

        $headers .= "Content-Type: text/html; charset=utf-8\r\n";
        // $message = stripslashes($contents);
        $message = $contents;

        $to = $md_email;

        mail($to, $subject_c, $message, $headers);

        $msg = "회원가입이 완료되었습니다. 등록하신 이메일로 메일이 발송되었습니다.";
        msg($msg);

        $re_url = "http://" . $_SERVER['SERVER_NAME'];
        redirect($re_url);
    }

}
; // new member register end
