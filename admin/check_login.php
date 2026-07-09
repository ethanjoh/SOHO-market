<?php

include_once "../util/util.php";

$save_id  = set_var($_POST['save_id']);
$save_all = set_var($_POST['save_all']);

$admin_id   = set_var($_POST['admin_id']);
$admin_pass = set_var($_POST['admin_pass']);

$date_expiry = time() + 60 * 60 * 24 * 30; //30일동안 아이디저장

$query  = "SELECT * FROM admin_setup WHERE 1 ";
$result = mysqli_query($connect, $query);
$rows   = mysqli_fetch_array($result) or die("Error");

if ($rows['id'] == $admin_id && $rows['passwd'] == sha1($admin_pass)) {

    session_start();

    //아이디 저장하기
    if ($save_id) {
        setcookie("save_id", "Y", $date_expiry); //key, value, expiry time
    } else {
        setcookie("save_id", "", 0); //
    }

    if ($save_all) {
        setcookie("save_all", "Y", $date_expiry);
        setcookie("ROOT_PASS", "$admin_pass", $date_expiry);
    } else {
        setcookie("save_all", "", 0);
    }

    setcookie("ROOT_ID", "$admin_id", $date_expiry); // admin_auth.php 에서 인증확인

    //관리자페이지에서 게시판 접근을 위해 세션 지정
    $_SESSION["p_id"]   = 'admin';
    $_SESSION['p_name'] = '관리자';

    echo "<meta http-equiv='Refresh' content='0; URL=//$_SERVER[SERVER_NAME]/admin/main/main.php'>";
} elseif ($rows['id'] != $admin_id || $rows['passwd'] != sha1($admin_pass)) {
    $msg = "아이디 또는 비밀번호가 틀립니다. \\n 다시 시도해 주세요.";
    err_msg($msg);

}
