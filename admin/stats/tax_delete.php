<?php

//관리자 인증 파일
include "../../util/admin_auth.php";
// 데이타베이스 연결정보 및 기타설정
include "../../util/config.php";
// 각종 유틸함수
include "../../util/util.php";
// MySQL 연결
$connect=my_connect($host,$dbid,$dbpass,$dbname);

//주문 취소에 따른 재고 복구
$sql = "SELECT * FROM tax_list WHERE num = '$oid' ";
$res = mysqli_query($connect, $sql);
$row = mysqli_fetch_array($res);

$a_goods_fk = explode(",", $row['goods_fk']); //상품 코드
$mod_volume = explode(",", $row['mod_count']); //변경된 수량

for($i=0; $i<sizeof($a_goods_fk); $i++){
   $pro_sql="SELECT * FROM products WHERE num='$a_goods_fk[$i]'";
   $pro_result = mysqli_query($connect, $pro_sql);
   $pro_row = mysqli_fetch_array($pro_result);
   
   $stock = $pro_row['stock']+$mod_volume[$i];
   
   $update1 = "UPDATE products SET stock='$stock' WHERE num='$a_goods_fk[$i]'";
   mysqli_query($connect, $update1);
}   

if($mode == "d") 
	$update = "DELETE FROM mall_order WHERE num='$oid' ";
else 
// 해당 주문정보를 취소처리 합니다.
	$update = "UPDATE mall_order SET cancel='Y', last_amount=0 WHERE num='$oid' ";

$result = mysqli_query($connect, $update);



if($from != "quot") {
	echo "<meta http-equiv='refresh' content='0; URL=top_order_list.php?page=$page'>";	
}else {
	echo "<meta http-equiv='refresh' content='0; URL=or_quot_list.php?page=$page'>";	
}
?>
 
