<?php

include_once "../include/admin_auth.php";
include_once "../../util/util.php";

$code     = set_var($_POST['code']);
$mode     = set_var($_POST['mode']);
$id       = set_var($_POST['id']);
$lcode    = set_var($_POST['lcode']);
$ca_mname = set_var($_POST['ca_mname']);

$ca_mname = addslashes($ca_mname);

if ($mode == "insert") {
    // 카테고리 코드값 존재여부
    /*
    $query = "select * from products_category2 where code='$code'";
    $result = mysqli_query($connect, $query);
    $count = mysqli_num_rows($result);
    mysqli_free_result($result);

    if($count){
    err_msg("입력하신 코드가 이미 있습니다.");
    }
     */

    $query = "INSERT INTO products_category2 VALUES ('','$lcode','$code','$ca_mname', 'N')";
    mysqli_query($connect, $query);

} else if ($mode == "update") {

    // 자신의 값 변경
    $query = "UPDATE products_category2 SET name='$ca_mname' WHERE id='$id' ";
    mysqli_query($connect, $query);
}

header("Location: ca_msub_list.php?lcode=" . $lcode . "");
