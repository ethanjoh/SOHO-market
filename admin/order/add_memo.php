<?php

include_once "../include/admin_auth.php";
include_once "../../util/config.php";
include_once "../../util/util.php";

$connect = my_connect($host, $dbid, $dbpass, $dbname);

$oid       = set_var($_POST['oid']);
$mode      = set_var($_POST['mode']);
$key       = set_var($_POST['key']);
$key_value = set_var($_POST['key_value']);
$page      = set_var($_POST['page']);
$add_memo  = set_var($_POST['add_memo']);

// 주문확인
$update = "UPDATE mall_order SET supplement='$add_memo' WHERE num='$oid' ";
$result = mysqli_query($connect, $update);

echo "<meta http-equiv='refresh' content='0; URL=or_view.php?oid=" . $oid . "&amp;mode=" . $mode . "&amp;key=" . $key . "&amp;key_value=" . $key_value . "&amp;page=" . $page . "'>";
