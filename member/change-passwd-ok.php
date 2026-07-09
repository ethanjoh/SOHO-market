<?php

include_once "../util/util.php";

$sid         = set_var($_POST['session_id']);
$sname       = set_var($_POST['session_name']);
$new_passwd  = set_var($_POST['new_passwd']);
$new_passwd2 = set_var($_POST['new_passwd2']);

// 이름과 아이디에 해당되는 세션이 존재하는지 확인
if (!isset($sid)) {
    err_msg('로그인 정보가 없습니다. 다시 로그인해 주세요.');
} else {

    $qry  = "SELECT * FROM member WHERE id='$sid' ";
    $res  = mysqli_query($connect, $qry);
    $mrow = mysqli_fetch_array($res);

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

    $company_name = $mrow['company_name'];
    $id           = $mrow['id'];

    // 세션을 다시 부여합니다.
    // 어떤 세션명이 사용되는지 확인할 것
    $_SESSION['p_id']   = $id;
    $_SESSION['p_name'] = $company_name;

    $sender       = "=?EUC-KR?B?" . base64_encode(iconv("UTF-8", "EUC-KR", "마켓")) . "?=\r\n";
    $sender_email = "griptech@hanmail.net";

    $subject   = $company_name . "님, 마켓 사이트 비밀번호 변경안내";
    $subject_c = "=?EUC-KR?B?" . base64_encode(iconv("UTF-8", "EUC-KR", $subject)) . "?=\r\n";
    $subject_c = addslashes($subject_c);

    $contents = "<p>골프그립 전문기업 마켓를 이용해 주셔서 고맙습니다.<br />";
    $contents .= "당사 사이트에서 비밀번호 변경이 되어 안내드립니다.</p>";
    $contents .= "<p>비밀번호 변경을 하지 않으셨다면 보안을 위해 당사로 연락부탁드립니다.<br/>";
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
    $url = "http://" . $_SERVER['SERVER_NAME'] . '/member/logout.php';

    show_msg($msg, $url);
}
