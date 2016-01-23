<?php

//관리자 인증 파일
include "../../util/admin_auth.php";
// 데이타베이스 연결정보 및 기타설정
include "../../util/config.php";
// 각종 유틸함수
include "../../util/util.php";
// MySQL 연결
$connect=my_connect($host,$dbid,$dbpass,$dbname);

$ca_name = set_var($_POST['ca_name']);
$code = set_var($_POST['code']);
$mode = set_var($_POST['mode']);
$id = set_var($_POST['val']);
$ca_name = addslashes($ca_name);

if ($mode == "insert") {
	// 카테고리 코드값 존재여부
	/*
    $query = "select * from products_category1 where code='$code'";
    $result = mysqli_query($connect, $query);
    $count = mysqli_num_rows($result);
    mysqli_free_result($result);

    if($count){
        err_msg("입력하신 코드가 이미 있습니다.");
    }*/
    
    $query = "INSERT INTO products_category1(num, id, code, name, hide) VALUES('$num', '$id', '$code','$ca_name', 'N')";
    $result = mysqli_query($connect, $query);

	if($result) {
		$msg = "카테고리를 등록했습니다.";
		$url = "top_ca_list.php";
		
		show_msg($msg, $url);
	}else {
		$msg = "카테고리 등록에 실패했습니다.";
		$url = "top_ca_list.php";
		
		show_msg($msg, $url);
	}

} else if ($mode == "update") {
	    
	// 자신의 값 변경
    $query = "UPDATE products_category1 SET name='$ca_name', id='$id' WHERE num='$num' ";
    $result = mysqli_query($connect, $query);


    //기존 상품 변경
    $query1 = "UPDATE products SET id='$id' WHERE category_l='$num' ";
    $result1 = mysqli_query($connect, $query1);

    if($result) {
		$msg = "카테고리를 수정했습니다.";
		$url = "top_ca_list.php";
		
		show_msg($msg, $url);
	}else {
		$msg = "카테고리 수정에 실패했습니다.";
		$url = "top_ca_list.php";
		
		show_msg($msg, $url);
	}
}

?>
