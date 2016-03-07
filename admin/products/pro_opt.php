<?php

include_once "../include/admin_auth.php";
include_once "../../util/util.php";

$mode  = set_var($_GET['mode']);
$p_num = set_var($_GET['p_num']);
$page  = set_var($_GET['page']);
$ck    = set_var($_GET['ck']);

$lcode = set_var($_GET['lcode']);
$mcode = set_var($_GET['mcode']);
$scode = set_var($_GET['scode']);

if ($mode == 'del') {
    // 해당데이타 검색
    if ($ck == "main_new") {
        $add = "option1_chk = 'N', main_new = 'N' ";
    } else if ($ck == "main_special") {
        $add = "option2_chk = 'N', , main_special = 'N' ";
    } else if ($ck == "main_best") {
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

if ($mode == 'insert') {
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
