<?php

//관리자 인증 파일
include "../../util/admin_auth.php";
// 데이타베이스 연결정보 및 기타설정
include "../../util/config.php";
// 각종 유틸함수
include "../../util/util.php";
// MySQL 연결
$connect = my_connect($host, $dbid, $dbpass, $dbname);

$mode  = $_GET['mode'];
$p_num = $_GET['p_num'];
$page  = $_GET['page'];
$ck    = $_GET['ck'];

$lcode = $_GET['lcode'];
$mcode = $_GET['mcode'];
$scode = $_GET['scode'];

if ('del' == $mode) {
    // 해당데이타 검색
    if ("main_new" == $ck) {
        $add = "option1_chk = 'N', main_new = 'N' ";
    } else if ("main_special" == $ck) {
        $add = "option2_chk = 'N', , main_special = 'N' ";
    } else if ("main_best" == $ck) {
        $add = "option3_chk = 'N', main_best = 'N' ";
    }
    $update = "UPDATE products SET $add WHERE num = '$p_num' ";
    $result = mysqli_query($connect, $update);

    if ($result) {
        $url = 'top_pro_list.php?lcode=' . $lcode . '&mcode=' . $mcode . '&scode=' . $scode . '&page=' . $page;
        show_msg('메인표시 해제했습니다.', $url);
    } else {
        err_msg('DB오류가 발생했습니다.');
    }
}

if ('insert' == $mode) {
    if ("main_new" == $ck) {
        $add = "option1_chk = 'Y', main_new = 'Y' ";
    } else if ("main_special" == $ck) {
        $add = "option2_chk = 'Y', main_special = 'Y' ";
    } else if ("main_best" == $ck) {
        $add = "option3_chk = 'Y', main_best = 'Y' ";
    }

    $update = "UPDATE products SET $add WHERE num = '$p_num' ";
    $result = mysqli_query($connect, $update);

    if ($result) {
        $url = 'top_pro_list.php?lcode=' . $lcode . '&mcode=' . $mcode . '&scode=' . $scode . '&page=' . $page;
        show_msg('메인표시 설정했습니다.', $url);
    } else {
        err_msg('DB오류가 발생했습니다.');
    }

}
