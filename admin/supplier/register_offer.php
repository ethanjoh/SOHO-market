<?php
// 데이타베이스 연결정보 및 기타설정
include "../../util/config.php";
// 각종 유틸함수
include "../../util/util.php";
// MySQL 연결
$connect=my_connect($host,$dbid,$dbpass,$dbname);

$id = set_var($_POST['id']);
$amount = set_var($_POST['amount']);
$products_fk = set_var($_POST['products_fk']);
$products_name = set_var($_POST['products_name']);
$products_kind = set_var($_POST['products_kind']);
$products_count = set_var($_POST['products_count']);
$products_price = set_var($_POST['products_price']);
$products_point = set_var($_POST['products_point']);
$products_barcode = set_var($_POST['products_barcode']);

if($mode == 'del'){
     $query = "DELETE FROM offer_cart WHERE cart_id='$cart_id'";
     mysqli_query($connect, $query);
	 
	 echo "<meta http-equiv='Refresh' content='0; URL=view_cart.php?id=$id'>"; 
}else {
	$query = "INSERT INTO p_code VALUES ('')";
	$result = mysqli_query($connect, $query);
	if(!$result) {
		err_msg('코드생성 중에 데이터베이스 에러가 났습니다.');
	}

	$query1 = "SELECT max(id) AS maxid FROM p_code";
	$result1 = mysqli_query($connect, $query1);
	if(!$result1) {
		err_msg('코드 최대값 확인 중에 데이터베이스 에러가 났습니다.');
	}

	$row = mysqli_fetch_array($result1);

	$p_code = $row['maxid'];

	//발주번호 작성
	$wdate = date('Ymd');
	$trade_code ="0".$wdate."-".$p_code;

	$offer_memo = addslashes($offer_memo);

	for($i=0; $i<sizeof($products_kind); $i++){
    	if($i != 0){
        	$temp_kind .= ",";
    	}
    	$temp_kind .= $products_kind[$i];
	}

	for($i=0; $i<sizeof($products_fk); $i++){
    	if($i != 0){
        	$temp_code .= ",";
    	}
    	$temp_code .= $products_fk[$i];
	}

	for($i=0; $i<sizeof($products_price); $i++){
    	if($i != 0){
        	$temp_price .= ",";
    	}
    	$temp_price .= $products_price[$i];
	}

	for($i=0; $i<sizeof($products_name); $i++){
    	if($i != 0){
        	$temp_name .= ",";
    	}
    	$temp_name .= $products_name[$i];
	}

	for($i=0; $i<sizeof($products_count); $i++){
    	if($i != 0){
        	$temp_count .= ",";
    	}
    	$temp_count .= $products_count[$i];
	}

	for($i=0; $i<sizeof($products_barcode); $i++){
    	if($i != 0){
        	$temp_barcode .= ",";
    	}
    	$temp_barcode .= $products_barcode[$i];
	}

	// $offer_memo = nl2br($offer_memo);

	$query2 = "INSERT INTO offer(orderid,goods_fk,goods_price, mod_price,
								goods_name,goods_kind, goods_barcode, goods_count,mod_count, 
					            id,amount,volume, createdate, offer_memo )
		 VALUES ('$trade_code','$temp_code','$temp_price', '$temp_price',
  				'$temp_name','$temp_kind', '$temp_barcode', '$temp_count', '$temp_count', 
			  	'$id', '$amount','$temp_count', now(), '$offer_memo' )";

	$result2 = mysqli_query($connect, $query2);
	if(!$result2) {
		err_msg('발주서 등록 중에 데이터베이스 에러가 났습니다.');
	}

	$query3 = "DELETE FROM offer_cart WHERE user_id='$id' ";
	$result3 = mysqli_query($connect, $query3);
	if(!$result3) {
		err_msg('장바구니 삭제 중에 데이터베이스 에러가 났습니다.');
	}


	$url = "offer_list.php";
	show_msg_close2('발주서를 등록했습니다.', $url);


}
?>
