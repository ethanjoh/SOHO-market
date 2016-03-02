<?php

include_once "../include/admin_auth.php";
// include_once "../../util/config.php";
include_once "../../util/util.php";

// $connect = my_connect($host, $dbid, $dbpass, $dbname);

$chk      = set_var($_POST['chk']);
$contents = set_var($_POST['contents']);

if ($chk) {
    $flag = 'Y';
} else {
    $flag = 'N';
}

$query  = "SELECT * FROM popup ";
$result = mysqli_query($connect, $query);
// $row    = mysqli_fetch_array($result);

if ($result) {
    //update
    $dbinsert1 = "UPDATE popup SET contents='$contents', chk='$flag' LIMIT 1 ";
    $result1   = mysqli_query($connect, $dbinsert1);

    if ($result1) {
        $url = "popup_setup.php";
        show_msg('공지를 수정했습니다.', $url);
    } else {
        err_msg('공지 수정 중 DB오류가 발생했습니다.');
    }
} else {
    $dbinsert1 = "INSERT INTO popup(contents, chk) VALUES('$contents', '$flag')";
    $result1   = mysqli_query($connect, $dbinsert1);

    if ($result1) {
        $url = "popup_setup.php";
        show_msg('공지를 등록했습니다.', $url);
    } else {
        err_msg('공지 등록 중 DB오류가 발생했습니다.');
    }
}
