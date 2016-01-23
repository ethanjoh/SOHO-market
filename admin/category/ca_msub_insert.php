<?php

//관리자 인증 파일
include "../../util/admin_auth.php";
// 데이타베이스 연결정보 및 기타설정
include "../../util/config.php";
// 각종 유틸함수
include "../../util/util.php";
// MySQL 연결
$connect=my_connect($host,$dbid,$dbpass,$dbname);

$code = set_var($_POST['code']);
$mode = set_var($_POST['mode']);
$id = set_var($_POST['id']);
$lcode = set_var($_POST['lcode']);
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
    
    $query = "insert into products_category2 values ('','$lcode','$code','$ca_mname')";
    mysqli_query($connect, $query);

} 
else if ($mode == "update") {
	    
	  // 자신의 값 변경
    $query = "update products_category2 set name='$ca_mname' where id=$id";
    mysqli_query($connect, $query);
}
	 echo ("<meta http-equiv='refresh' content='0; URL=ca_msub_list.php?lcode=$lcode'>");
?>
