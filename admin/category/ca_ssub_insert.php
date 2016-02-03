<?php

include_once "../include/admin_auth.php";
include_once "../../util/config.php";
include_once "../../util/util.php";

$connect = my_connect($host, $dbid, $dbpass, $dbname);

$code     = set_var($_POST['code']);
$mode     = set_var($_POST['mode']);
$id       = set_var($_POST['id']);
$lcode    = set_var($_POST['lcode']);
$mcode    = set_var($_POST['mcode']);
$ca_sname = set_var($_POST['ca_sname']);

$ca_sname = addslashes($ca_sname);

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

    $query = "insert into products_category3 values ('','$mcode','$code','$ca_sname')";
    mysqli_query($connect, $query);

} else if ($mode == "update") {

    // 자신의 값 변경
    $query = "update products_category3 set name='$ca_sname' where id=$id";
    mysqli_query($connect, $query);
}
echo ("<meta http-equiv='refresh' content='0; URL=ca_ssub_list.php?lcode=$lcode&mcode=$mcode'>");
