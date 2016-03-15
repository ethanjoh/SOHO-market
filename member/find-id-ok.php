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
    $id           = $row['id'];

    $msg = "이메일을 발송했습니다.";
    $url = "/";

    show_msg($msg, $url);
} else {
    err_msg('이메일 주소나 사업자등록번호가 일치하지 않습니다.');
    exit;
}
