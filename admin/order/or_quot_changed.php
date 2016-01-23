<?php

//관리자 인증 파일
include "../../util/admin_auth.php";
// 데이타베이스 연결정보 및 기타설정
include "../../util/config.php";
// 각종 유틸함수
include "../../util/util.php";
// MySQL 연결
$connect=my_connect($host,$dbid,$dbpass,$dbname);

// 견적확인
if($mode == '1'){
  $update = "UPDATE mall_order SET status='5' WHERE num='$oid' ";
  $result = mysqli_query($connect, $update);
}


//처리완료
if($mode=='3'){
  
  $qry = "SELECT * FROM mall_order WHERE num='$oid' ";
  $res = mysqli_query($connect, $qry);
  $rows = mysqli_fetch_array($res);
  

  $update = "UPDATE mall_order SET status='8', track_no='$track_no', last_amount='$last_amount' WHERE num='$oid' ";
  $result = mysqli_query($connect, $update);
}


echo "<meta http-equiv='refresh' content='0; URL=or_quot_view.php?oid=$oid'>";	

?> 
