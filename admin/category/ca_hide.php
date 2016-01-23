<?php

//관리자 인증 파일
include "../../util/admin_auth.php";
// 데이타베이스 연결정보 및 기타설정
include "../../util/config.php";
// 각종 유틸함수
include "../../util/util.php";
// MySQL 연결
$connect=my_connect($host,$dbid,$dbpass,$dbname);

if($chk == "Y") {
	$flag = "N";
}else {
	$flag = "Y";
}
	
	$query = "UPDATE products_category1 SET hide='$flag' WHERE code='$code' ";
	$result = mysqli_query($connect, $query);

$url = "top_ca_list.php";
$msg = "변경되었습니다.";
show_msg($msg, $url);
//echo ("<meta http-equiv='refresh' content='0; URL=top_ca_list.php'>");
?>
