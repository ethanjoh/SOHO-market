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

    $sid         = mysqli_real_escape_string($connect, $sid);
    $new_passwd2 = mysqli_real_escape_string($connect, $new_passwd2);

    $qry  = "SELECT * FROM p_member WHERE id='$sid' ";
    $res  = mysqli_query($connect, $qry);
    $mrow = mysqli_fetch_array($res);

    $passwd = sha1($new_passwd2);
    $query  = "UPDATE p_member SET passwd = '$passwd' WHERE id='$sid' ";
    $result = mysqli_query($connect, $query);

    // 게시판의 글들에 대한 비밀번호도 모두 수정한다.
    $query2  = "UPDATE board SET passwd='$passwd' WHERE id='$sid' ";
    $result2 = mysqli_query($connect, $query2);

    // 저장과정에서 오류가 발생하면
    if (!$result2) {
        err_msg('게시판 비밀번호 수정 중 DB 오류가 발생했습니다.');
        exit;
    } else if (!$result) {
        err_msg('비밀번호 변경 중 DB 오류가 발생했습니다.');
        exit;
    }

    $user_name  = $mrow['name'];
    $user_email = $mrow['email'];
    $id         = $sid;

    $com_info = get_company_info();

    // 세션을 다시 부여합니다.
    // 어떤 세션명이 사용되는지 확인할 것
    $_SESSION['p_id']   = $sid;
    $_SESSION['p_name'] = $user_name;

    if (!defined("PHP_EOL")) {
        define("PHP_EOL", "\r\n");
    }

    $to      = $user_email;
    $subject = "[" . $com_info['company_name'] . "] 비밀번호 변경 안내";
    $subject = "=?UTF-8?B?" . base64_encode($subject) . "?=";

// Assign the input values to variables for easy reference
    $name  = $com_info['company_name'];
    $email = $com_info['email'];
    $phone = $com_info['tel'];

    $message = $com_info['homepage'] . ' 에서 비밀번호를 변경하셨습니다.' . PHP_EOL;
    $message .= '(본인이 하신게 아니라면 해킹이 의심될 수 있으니 당사로 연락주시기 바랍니다.)' . PHP_EOL . PHP_EOL;

// Send the email
    $headers = "From: $name" . PHP_EOL;
    $headers .= "Reply-To: $email" . PHP_EOL;
    $headers .= "MIME-Version: 1.0" . PHP_EOL;
    $headers .= "Content-type: text/plain; charset=utf-8" . PHP_EOL;
    $headers .= "Content-Transfer-Encoding: quoted-printable" . PHP_EOL;

    $mailBody = $name . "에서 알려드립니다." . PHP_EOL . PHP_EOL;
    $mailBody .= "안내:" . PHP_EOL;
    $mailBody .= $message . PHP_EOL . PHP_EOL;
    $mailBody .= "문의사항은 " . $name . " 님에게 이메일 " . $email;
    $mailBody .= (isset($phone) && !empty($phone)) ? " 또는 전화번호 $phone 로 연락주시기 바랍니다." . PHP_EOL . PHP_EOL : '';
    $mailBody .= "-------------------------------------------------------------------------------------------" . PHP_EOL;

    $r = mail($to, $subject, $mailBody, $headers);

    if (!$r) {
        echo '이메일 보내기 실패';
    } else {
        $msg = "비밀번호를 정상적으로 수정했습니다. 다시 로그인해주세요.";
        $url = "http://" . $_SERVER['SERVER_NAME'] . '/member/logout.php';

        show_msg($msg, $url);
    }

}
