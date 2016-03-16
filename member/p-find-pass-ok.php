<?php

include_once "../util/util.php";

$id        = set_var($_POST['id']);
$phone_no1 = set_var($_POST['phone_no1']);
$phone_no2 = set_var($_POST['phone_no2']);
$phone_no3 = set_var($_POST['phone_no3']);

if (!$id || !$phone_no1 || !$phone_no2 || !$phone_no3) {
    err_msg('정식으로 접속하세요.');
    exit;
}

$phone_no = $phone_no1 . "-" . $phone_no2 . "-" . $phone_no3;
$id       = mysqli_real_escape_string($connect, $id);
$phone_no = mysqli_real_escape_string($connect, $phone_no);

$query  = "SELECT * FROM p_member WHERE hphone ='$phone_no' AND id='$id' ";
$result = mysqli_query($connect, $query);
$num    = mysqli_num_rows($result);

if ($num > 0) {
    $row        = mysqli_fetch_array($result);
    $user_id    = $id;
    $user_email = $row['email'];

    $ini_password  = GenerateString(6);
    $save_password = sha1($ini_password);

    $qry = "UPDATE p_member SET passwd = '$save_password' WHERE id='$id' ";
    mysqli_query($connect, $qry);

    $com_info = get_company_info();

    if (!defined("PHP_EOL")) {
        define("PHP_EOL", "\r\n");
    }

    $to      = $user_email;
    $subject = "[" . $com_info['company_name'] . "] 비밀번호 초기화 안내";
    $subject = "=?UTF-8?B?" . base64_encode($subject) . "?=";

// Assign the input values to variables for easy reference
    $name  = $com_info['company_name'];
    $email = $com_info['email'];
    $phone = $com_info['tel'];

    $message = $com_info['homepage'] . ' 에서 비밀번호 초기화를 요청하셨습니다.' . PHP_EOL;
    $message .= '(본인이 하신게 아니라면 해킹이 의심될 수 있으니 비밀번호를 변경하시기 바랍니다.)' . PHP_EOL . PHP_EOL;
    $message .= '초기화된 비밀번호는 아래와 같습니다. 사이트에 로그인 하신 후 변경하세요.' . PHP_EOL;
    $message .= 'PASSWORD: ' . $ini_password . ' (대소문자 구분)' . PHP_EOL;

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
        $msg = "등록하신 이메일로 정보를 발송했습니다.";
        $url = "/";

        show_msg($msg, $url);
    }

} else {
    err_msg('아이디나 휴대폰 번호와 일치하는 정보가 없습니다.');
    exit;
}
