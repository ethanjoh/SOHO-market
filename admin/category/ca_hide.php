<?php

include_once "../include/admin_auth.php";
include_once "../../util/util.php";

$chk  = set_var($_GET['chk']);
$code = set_var($_GET['code']);

if ($chk == "Y") {
    $flag = "N";
} else {
    $flag = "Y";
}

$query  = "UPDATE products_category1 SET hide='$flag' WHERE code='$code' ";
$result = mysqli_query($connect, $query);

$url = "top_ca_list.php";
$msg = "변경되었습니다.";
show_msg($msg, $url);
//echo ("<meta http-equiv='refresh' content='0; URL=top_ca_list.php'>");
