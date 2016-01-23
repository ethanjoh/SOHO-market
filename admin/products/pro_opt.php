<?php

//관리자 인증 파일
include "../../util/admin_auth.php";
// 데이타베이스 연결정보 및 기타설정
include "../../util/config.php";
// 각종 유틸함수
include "../../util/util.php";
// MySQL 연결
$connect=my_connect($host,$dbid,$dbpass,$dbname);

if($mode=='del'){
  // 해당데이타 검색
	if($ck == "main_new") {
		$add = " , option1_chk = 'N' ";
	}else if($ck == "main_special") {
		$add = " , option2_chk = 'N' ";
	}else if($ck == "main_best") {
		$add = " , option3_chk = 'N' ";
	}  
  $update = "UPDATE products SET $ck = 'N' $add WHERE num=$p_num ";
  $result = mysqli_query($connect, $update);
} 

if($mode=='insert'){
	if($ck == "main_new") {
		$add = " , option1_chk = 'Y' ";
	}else if($ck == "main_special") {
		$add = " , option2_chk = 'Y' ";
	}else if($ck == "main_best") {
		$add = " , option3_chk = 'Y' ";
	}
	
   $update = "UPDATE products SET $ck = 'Y' $add WHERE num=$p_num ";
   $result = mysqli_query($connect, $update);
}
if($result){    
	$url = "top_pro_list.php?lcode=$lcode&mcode=$mcode&scode=$scode&page=$page";
	show_msg('내용을 수정했습니다.', $url);
}
else{
     err_msg('DB오류가 발생했습니다.');
}
?>
