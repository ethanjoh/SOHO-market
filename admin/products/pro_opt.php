<?php

include_once "../include/admin_auth.php";
include_once "../../util/util.php";

$mode  = set_var($_GET['mode']);
$p_num = set_var($_GET['p_num']);
$lcode = set_var($_GET['lcode']);
$mcode = set_var($_GET['mcode']);
$page  = set_var($_GET['page']);
$ck    = set_var($_GET['ck']);

if ($mode == 'unset') {
    // 해당데이타 검색
    if ($ck == "new") {
        $add = "option1_chk = 'N', main_new = 'N' ";
    } else if ($ck == "sp") {
        $add = "option2_chk = 'N', main_special = 'N' ";
    } else if ($ck == "best") {
        $add = "option3_chk = 'N', main_best = 'N' ";
    }
    $update = "UPDATE products SET $add WHERE num = '$p_num' ";
    $result = mysqli_query($connect, $update);

    if ($result) {
        $url = 'top_pro_list.php?lcode=' . $lcode . '&mcode=' . $mcode . '&page=' . $page;
        show_msg('메인표시 해제했습니다.', $url);
    } else {
        err_msg('DB오류가 발생했습니다.');
    }
} elseif ($mode == 'set') {
    if ($ck == "new") {
        $add = "option1_chk = 'Y', main_new = 'Y' ";
    } else if ($ck == "sp") {
        $add = "option2_chk = 'Y', main_special = 'Y' ";
    } else if ($ck == "best") {
        $add = "option3_chk = 'Y', main_best = 'Y' ";
    }

    $update = "UPDATE products SET $add WHERE num = '$p_num' ";
    $result = mysqli_query($connect, $update);

    if ($result) {
        $url = 'top_pro_list.php?lcode=' . $lcode . '&mcode=' . $mcode . '&page=' . $page;
        show_msg('메인표시 설정했습니다.', $url);
    } else {
        err_msg('DB오류가 발생했습니다.');
    }

}
