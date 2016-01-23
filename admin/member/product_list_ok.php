<?php
//관리자 인증 파일
include "../../util/admin_auth.php";
// 데이타베이스 연결정보 및 기타설정
include "../../util/config.php";
// 각종 유틸함수
include "../../util/util.php";
// MySQL 연결
$connect=my_connect($host,$dbid,$dbpass,$dbname);

$flag 		= set_var($_POST['flag']);
$com_id 	= set_var($_POST['com_id']);
$pro_id 	= set_var($_POST['pro_id']);
$price 		= set_var($_POST['price']);
$num 		= array_flip($_POST['num']);
$count		= set_var($_POST['count']);


for($i=0; $i < $count; $i++) {
	if(isset($num[$i]))
		$temp_num[$i] = "Y";
	else
		$temp_num[$i] = "N";
}

$pro_id 	= implode(',', $pro_id);
$available 	= implode(',', $temp_num);
$price 		= implode(',', $price);
	
if($flag == "edit") {
	// print_r($num);


	// for ($i=0; $i < count($pro_id); $i++) {

	// 	if($pro_id[$i] == $num[$i]) {
	// 		if($i == 0)
	// 			$available = "Y,";
	// 		else
	// 			$available .= ",Y";
	// 	}else{
	// 		if($i == 0)
	// 			$available = "N,";
	// 		else
	// 			$available .= ",N";
	// 	}
	// }

	// $pro_id 	= implode(',', $pro_id);
	// $available 	= implode(',', $temp_num);
	// $price 		= implode(',', $price);

	// print_r($available);

	$sql = "UPDATE buy_product SET pro_id = '$pro_id', available = '$available', price = '$price' WHERE com_id = '$com_id' ";
	$result = mysqli_query($connect, $sql);

	if($result) {
		$url = "product_list.php?id=".$com_id;
		$msg = "구매가능 상품을 수정했습니다.";
		show_msg($msg, $url);
	}else{
		$url = "product_list.php?id=".$com_id;
		$msg = "DB 수정 시 에러가 발생했습니다.";
		show_msg($msg, $url);
	}


}else{
	// $pro_id 	= implode(',', $pro_id);
	// $available 	= implode(',', $num);
	// $price 		= implode(',', $price);

	$sql = "INSERT INTO buy_product (com_id, pro_id, available, price) VALUES ('$com_id', '$pro_id', '$available', '$price')";
	$result = mysqli_query($connect, $sql);

	if($result) {
		$url = "product_list.php?id=".$com_id;
		$msg = "구매가능 상품을 추가했습니다.";
		show_msg($msg, $url);
	}else{
		$url = "product_list.php?id=".$com_id;
		$msg = "DB 추가 시 에러가 발생했습니다.";
		show_msg($msg, $url);
	}

}