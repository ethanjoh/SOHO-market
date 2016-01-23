<?php

//관리자 인증 파일
include "../../util/admin_auth.php";
// 데이타베이스 연결정보 및 기타설정
include "../../util/config.php";
// 각종 유틸함수
include "../../util/util.php";
// MySQL 연결
$connect=my_connect($host,$dbid,$dbpass,$dbname);

// 주문확인
  $update = "UPDATE mall_order SET supplement='$add_memo' WHERE num='$oid' ";
  $result = mysqli_query($connect, $update);
  
  echo "<meta http-equiv='refresh' content='0; URL=or_view.php?oid=".$oid."&amp;mode=".$mode."&amp;key=".$key."&amp;key_value=".$key_value."&amp;page=".$page."'>";	

?> 
