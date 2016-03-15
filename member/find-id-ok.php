<?php

include_once "../util/util.php";

$md_email    = set_var($_POST['md_email']);
$license_no1 = set_var($_POST['license_no1']);
$license_no2 = set_var($_POST['license_no2']);
$license_no3 = set_var($_POST['license_no3']);

if (!$md_email || !$license_no1 || !$license_no2 || !$license_no3) {
    err_msg('정식으로 접속하세요.');
    exit;
}

$license_no = $license_no1 . "-" . $license_no2 . "-" . $license_no3;
$md_email   = mysqli_real_escape_string($connect, $md_email);
$license_no = mysqli_real_escape_string($connect, $license_no);

$query  = "SELECT * FROM member WHERE md_email='$md_email' AND license_no = '$license_no' ";
$result = mysqli_query($connect, $query);
$num    = mysqli_num_rows($result);

if ($num > 0) {
    $row          = mysqli_fetch_array($result);
    $company_name = $row['company_name'];
    $user_id      = $row['id'];
    $user_email   = $row['md_email'];

    $com_info = get_company_info();

//이메일 보내기
    if (!defined("PHP_EOL")) {
        define("PHP_EOL", "\r\n");
    }

    $to      = $user_email;
    $subject = "[" . $com_info['company_name'] . "] 아이디 찾기 결과안내";
    $subject = "=?UTF-8?B?" . base64_encode($subject) . "?=";

// Assign the input values to variables for easy reference
    $name  = $com_info['company_name'];
    $email = $com_info['email'];
    $phone = $com_info['tel'];

    $message = $com_info['homepage'] . '에서 아이디 찾기를 하셨습니다.' . PHP_EOL;
    $message .= '(본인이 하신게 아니라면 해킹이 의심될 수 있으니 비밀번호를 변경하시기 바랍니다.)' . PHP_EOL . PHP_EOL;
    $message .= '문의하신 아이디는 아래와 같습니다.' . PHP_EOL;
    $message .= 'ID: ' . $user_id . PHP_EOL;

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
    err_msg('이메일 주소나 사업자등록번호가 일치하지 않습니다.');
    exit;
}
