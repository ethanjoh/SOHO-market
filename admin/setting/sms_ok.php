<?php
/* 아미지 디렉토리 문제로 basic.php보다 상위 디렉토리에 위치시킨다. */

include_once "../include/admin_auth.php";
include_once "../../util/config.php";
include_once "../../util/util.php";

$connect = my_connect($host, $dbid, $dbpass, $dbname);

$sms          = set_var($_POST['sms']);
$id           = set_var($_POST['sms_id']);
$passwd       = set_var($_POST['sms_passwd']);
$from_phone   = set_var($_POST['from_phone']);
$to_phone     = set_var($_POST['to_phone']);
$reg_chk      = set_var($_POST['reg_chk']);
$reg_msg      = set_var($_POST['reg_msg']);
$orderin_chk  = set_var($_POST['orderin_chk']);
$orderin_msg  = set_var($_POST['orderin_msg']);
$order_chk    = set_var($_POST['order_chk']);
$order_msg    = set_var($_POST['order_msg']);
$orderout_chk = set_var($_POST['orderout_chk']);
$orderout_msg = set_var($_POST['orderout_msg']);
$offer_chk    = set_var($_POST['offer_chk']);
$offer_msg    = set_var($_POST['offer_msg']);

$reg_msg   = addslashes($reg_msg);
$order_msg = addslashes($order_msg);
$pkg_msg   = addslashes($pkg_msg);

if (!$reg_chk) {
    $reg_chk = "N";
}

if (!$order_chk) {
    $order_chk = "N";
}

if (!$orderin_chk) {
    $orderin_chk = "N";
}

if (!$orderout_chk) {
    $orderout_chk = "N";
}

if (!$tax_chk) {
    $tax_chk = "N";
}

if (!$offer_chk) {
    $offer_chk = "N";
}

########## 어드민 테이블에 입력값을 등록한다. ##########
$query = "UPDATE sms SET
						sms = '$sms',
						id = '$id',
						passwd = '$passwd',
						from_phone = '$from_phone',
						to_phone = '$to_phone',
						reg_chk = '$reg_chk',
						reg_msg = '$reg_msg',
						orderin_chk = '$orderin_chk',
						orderin_msg = '$orderin_msg',
						order_chk = '$order_chk',
						order_msg = '$order_msg',
						orderout_chk = '$orderout_chk',
						orderout_msg = '$orderout_msg',
						tax_chk = '$tax_chk',
						tax_msg = '$tax_msg',
						offer_chk = '$offer_chk',
						offer_msg = '$offer_msg' ";

$result = mysqli_query($connect, $query);

// 저장과정에서 오류가 발생하면
if (!$result) {
    err_msg('DB 오류가 발생했습니다.');
} else {
    echo ("<meta http-equiv='content-type' content='text/html; charset=UTF-8' />
		 <script>
	  window.alert('설정을 저장했습니다.');
	  </script>");
    echo "<meta http-equiv='Refresh' content='0; URL=sms.php'>";
}
