<?php

include "../util/util.php";

$sid   = set_var($_POST['session_id']);
$sname = set_var($_POST['session_name']);

$mode    = set_var($_POST['mode']);
$id      = set_var($_POST['userid']);
$id      = trim($id); //remove blank front and back
$passwd  = set_var($_POST['passwd']);
$email   = set_var($_POST['email']);
$optin   = set_var($_POST['optin']);
$name    = set_var($_POST['name']);
$hphone1 = set_var($_POST['hphone1']);
$hphone2 = set_var($_POST['hphone2']);
$hphone3 = set_var($_POST['hphone3']);
$sms     = set_var($_POST['sms']);

$o_zipcode1 = set_var($_POST['o_zipcode1']);
$o_addr1    = set_var($_POST['o_addr1']);
$o_addr2    = set_var($_POST['o_addr2']);
$o_phone1   = set_var($_POST['o_phone1']);
$o_phone2   = set_var($_POST['o_phone2']);
$o_phone3   = set_var($_POST['o_phone3']);

$d_zipcode1 = set_var($_POST['d_zipcode1']);
$d_addr1    = set_var($_POST['d_addr1']);
$d_addr2    = set_var($_POST['d_addr2']);
$d_phone1   = set_var($_POST['d_phone1']);
$d_phone2   = set_var($_POST['d_phone2']);
$d_phone3   = set_var($_POST['d_phone3']);
$d_hphone1  = set_var($_POST['d_hphone1']);
$d_hphone2  = set_var($_POST['d_hphone2']);
$d_hphone3  = set_var($_POST['d_hphone3']);
$dc_rate    = set_var($_POST['dc_rate']);

$hphone   = $hphone1 . '-' . $hphone2 . '-' . $hphone3;
$o_phone  = $o_phone1 . '-' . $o_phone2 . '-' . $o_phone3;
$d_phone  = $d_phone1 . '-' . $d_phone2 . '-' . $d_phone3;
$d_hphone = $d_hphone1 . '-' . $d_hphone2 . '-' . $d_hphone3;

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
    $qry  = "SELECT * FROM p_member WHERE id='$sid' ";
    $res  = mysqli_query($connect, $qry);
    $mrow = mysqli_fetch_array($res);

    if ($mrow['passwd'] != sha1($passwd)) {
        $msg = "비밀번호가 일치하지 않습니다.";
        $url = "http://" . $_SERVER['SERVER_NAME'] . "/member/p-register-form.php?mode=edit";
        show_msg($msg, $url);

    } else {

        $o_zipcode = $o_zipcode1;
        $d_zipcode = $d_zipcode1;

        $email   = addslashes($email);
        $o_addr1 = addslashes($o_addr1);
        $o_addr2 = addslashes($o_addr2);
        $d_addr1 = addslashes($d_addr1);
        $d_addr2 = addslashes($d_addr2);

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
        $query = "UPDATE p_member SET email 	= '$email',
									optin 		= '$optin',
									name 		= '$name',
									hphone 		= '$hphone',
									sms 		= '$sms',
									o_zipcode 	= '$o_zipcode',
									o_addr1 	= '$o_addr1',
									o_addr2 	= '$o_addr2',
									o_phone 	= '$o_phone',
									d_zipcode 	= '$d_zipcode',
									d_addr1 	= '$d_addr1',
									d_addr2 	= '$d_addr2',
									d_phone 	= '$d_phone',
                                    d_hphone     = '$d_hphone'
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

    $o_zipcode = $o_zipcode1;
    $d_zipcode = $d_zipcode1;

    $passwd = sha1($passwd);

    $approved = "Y"; //자동승인 여부

    ########## 회원정보 테이블에 입력값을 등록한다. ##########
    $query = "INSERT INTO p_member(id,
								passwd,
								email,
								optin,
								name,
								hphone,
								sms,
								o_zipcode,
								o_addr1,
								o_addr2,
								o_phone,
								d_zipcode,
								d_addr1,
								d_addr2,
								d_phone,
                                d_hphone,
								reg_date,
                                login_date,
								dc_rate,
								approved
								)
			   VALUES ('$id',
						'$passwd',
						'$email',
						'$optin',
						'$name',
						'$hphone',
						'$sms',
						'$o_zipcode',
						'$o_addr1',
						'$o_addr2',
						'$o_phone',
						'$d_zipcode',
						'$d_addr1',
						'$d_addr2',
						'$d_phone',
						'$d_hphone',
						now(),
                        now(),
						'$dc_rate',
						'$approved' )";

    $result = mysqli_query($connect, $query);

    // 저장과정에서 오류가 발생하면
    if (!$result) {
        err_msg('데이터베이스 오류가 발생하였습니다.\n 관리자에게 문의하시기 바랍니다.');
    } else {
        //가입메일 보내기
        $sender       = "=?EUC-KR?B?" . base64_encode(iconv("UTF-8", "EUC-KR", "" . $op_company . "")) . "?=\r\n";
        $sender_email = 'noreply@' . $_SERVER['SERVER_NAME'];

        $subject   = $name . "님, 가입을 환영합니다.";
        $subject_c = "=?EUC-KR?B?" . base64_encode(iconv("UTF-8", "EUC-KR", $subject)) . "?=\r\n";
        $subject_c = addslashes($subject_c);

        $info = array(
            'name'     => $name,
            'id'       => $id,
            'email'    => $op_email,
            'fax'      => $op_fax,
            'homepage' => $op_homepage,
        );

        // $contents = "<p><a href=\"http://www." . $_SERVER['SERVER_NAME'] . "\">" . $op_company . "</a>에 가입하신 것을 환영합니다.<br />";
        // $contents .= "가입하신 회원 정보 확인을 부탁드립니다.</p>";
        // $contents .= "<p>ID:" . $id . "</p>";
        // $contents .= "<p>기타 문의사항은 <a href=\"http://" . $_SERVER['SERVER_NAME'] . "/member/help.php\">[이용안내]</a> 또는 1:1 문의게시판 , " . $op_tel . " 을 이용해주시기 바랍니다.<br>";
        // $contents .= "고맙습니다.</p>";
        // $contents = addslashes($contents);

        $file     = 'p-join-confirmation.html';
        $contents = format_email($info, $file);

        $headers = "Return-Path: $sender_email\r\n";
        $headers .= "From: $sender <$sender_email>\r\n";

        $boundary = "----" . uniqid("part");

        $headers .= "Content-Type: text/html; charset=utf-8\r\n";
        // $message = stripslashes($contents);
        $message = $contents;

        $to = $email;

        mail($to, $subject_c, $message, $headers);

        $msg = "회원가입이 완료되었습니다. 등록하신 이메일로 메일이 발송되었습니다.";
        msg($msg);

        $re_url = "http://" . $_SERVER['SERVER_NAME'];
        redirect($re_url);
    }

}
; // new member register end
