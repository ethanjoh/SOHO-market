<?php

include_once "../include/admin_auth.php";
include_once "../../util/config.php";
include_once "../../util/util.php";

$connect = my_connect($host, $dbid, $dbpass, $dbname);

if ($mode == 'del') {
    // 해당데이타 검색
    if ($ck == "main_new") {
        $add = " , option1_chk = 'N' ";
    } else if ($ck == "main_special") {
        $add = " , option2_chk = 'N' ";
    } else if ($ck == "main_best") {
        $add = " , option3_chk = 'N' ";
    }
    $update = "UPDATE products SET $ck = 'N' $add WHERE num=$p_num ";
    $result = mysqli_query($connect, $update);
}

if ($mode == 'insert') {
    if ($ck == "main_new") {
        $add = " , option1_chk = 'Y' ";
    } else if ($ck == "main_special") {
        $add = " , option2_chk = 'Y' ";
    } else if ($ck == "main_best") {
        $add = " , option3_chk = 'Y' ";
    }

    $update = "UPDATE products SET $ck = 'Y' $add WHERE num=$p_num ";
    $result = mysqli_query($connect, $update);
}

if ($mode == 'approve') {
    $update = "UPDATE products SET approved = 'Y' WHERE num=$p_num ";
    $result = mysqli_query($connect, $update);
}

if ($mode == 'nonapprove') {
    $update = "UPDATE products SET approved = 'N' WHERE num=$p_num ";
    $result = mysqli_query($connect, $update);
}

if ($result) {
    $url = "sp_products_list.php?lcode=$lcode&mcode=$mcode&scode=$scode&page=$page";
    show_msg('내용을 수정했습니다.', $url);
} else {
    err_msg('DB오류가 발생했습니다.');
}
