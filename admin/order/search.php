<?php

//관리자 인증 파일
include "../../util/admin_auth.php";
// 데이타베이스 연결정보 및 기타설정
include "../../util/config.php";
// 각종 유틸함수
include "../../util/util.php";
// MySQL 연결
$connect=my_connect($host,$dbid,$dbpass,$dbname);

$term = $_GET["term"];
$sql = "SELECT * FROM member WHERE company_name LIKE '%$term%'";
$result = mysqli_query($connect, $sql);
while ($data = mysqli_fetch_array($result)) {
	$arr[] = array("label"=>$data['company_name'], "value"=>$data['company_name']); 
}

echo json_encode($arr); 
// mysqli_close($result);

?>