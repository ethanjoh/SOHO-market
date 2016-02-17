<?php

include_once "../include/admin_auth.php";
include_once "../../util/config.php";
include_once "../../util/util.php";

$connect = my_connect($host, $dbid, $dbpass, $dbname);

$id         = set_var($_POST['id']);
$goods_name = set_var($_POST['goods_name']);
$sum        = set_var($_POST['sum']);
$reg_date   = set_var($_POST['reg_date']);
$paid       = set_var($_POST['paid']);

$paid = $paid[0];

$title = explode("-", $reg_date);
$title = $title[0] . "년 " . $title[1] . "월 정산";

$sql = "INSERT INTO sp_tax_list (id, title, goods_name, sum, reg_date, paid)
	           VALUES('$id', '$title', '$goods_name','$sum', '$reg_date', '$paid' )";
$result = mysqli_query($connect, $sql);

if ($result) {
    echo "<meta http-equiv='content-type' content='text/html; charset=UTF-8' />
	<script>
		alert('정산을 등록했습니다.')
	</script>
	<meta http-equiv='refresh' content='0; URL=reg_stat_list.php'>";
} else {
    echo "<<meta http-equiv='content-type' content='text/html; charset=UTF-8' />
	<script>
		alert('DB 에러가 발생했습니다.')
	</script>
	<meta http-equiv='refresh' content='0; URL=stat_list.php?id=$id'>";
}
