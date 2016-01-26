<?php
// 데이타베이스 연결정보 및 기타설정
include "../util/config.php";
// 각종 유틸함수
include "../util/util.php";
// MySQL 연결
$connect = my_connect($host,$dbid,$dbpass,$dbname);

//purchase.php에서 넘어온 값들
$products_fk 	= set_var($_POST['products_fk']);
$products_name 	= set_var($_POST['products_name']);
$products_kind 	= set_var($_POST['products_kind']);
$products_count = set_var($_POST['products_count']);
$products_price = set_var($_POST['products_price']);
$products_point = set_var($_POST['products_point']);
$products_stock = set_var($_POST['products_stock']);
//$products_opt_stock = set_var($_POST['products_opt_stock']);

//구매자 정보
$buyer_zipcode 		= set_var($_POST['buyer_zipcode']);
$buyer_address01 	= set_var($_POST['buyer_address01']);
$buyer_address02 	= set_var($_POST['buyer_address02']);
$buyer_phone 		= set_var($_POST['buyer_phone']);
$buyer_hphone 		= set_var($_POST['buyer_hphone']);
$sms 				= set_var($_POST['sms']);

//$deposit_year = set_var($_POST['deposit_year']);
//$deposit_month = set_var($_POST['deposit_month']);
//$deposit_day = set_var($_POST['deposit_day']);
$company_name 	= set_var($_POST['company_name']); //입금자명, 별도로 입력하지 않으면 업체명
$buyer_name 	= set_var($_POST['buyer_name']);
// $deposit_date = set_var($_POST['deposit_date']);

// $bank_name 	= set_var($_POST['bank_name']);
$delivery 	= set_var($_POST['delivery_type']);
$memo 		= set_var($_POST['memo']);

//수령자가 다를 경우
$recipient_name 		= set_var($_POST['recipient_name']);
$recipient_zipcode01 	= set_var($_POST['recipient_zipcode01']);
$recipient_zipcode02 	= set_var($_POST['recipient_zipcode02']);
$recipient_address01 	= set_var($_POST['recipient_address01']);
$recipient_address02 	= set_var($_POST['recipient_address02']);
$recipient_phone01 		= set_var($_POST['recipient_phone01']);
$recipient_phone02 		= set_var($_POST['recipient_phone02']);
$recipient_phone03 		= set_var($_POST['recipient_phone03']);
$recipient_hphone01 	= set_var($_POST['recipient_hphone01']);
$recipient_hphone02 	= set_var($_POST['recipient_hphone02']);
$recipient_hphone03 	= set_var($_POST['recipient_hphone03']);

$seller = set_var($_POST['seller']);

if($_SESSION['p_id']){
  $member_id_fk = $_SESSION['p_id'];
}
else{
  $member_id_fk = 'guest';
  $mileage_add ='';
}

$query = "INSERT INTO p_code VALUES ('')";
mysqli_query($connect, $query);

$query = "SELECT max(id) AS maxid FROM p_code";
$result = mysqli_query($connect, $query);
$row = mysqli_fetch_array($result);
mysqli_free_result($result);
$p_code = $row['maxid'];

$wdate = date('Ymd');
if($from == "m_purchase")
	$trade_code ="m".$wdate."-".$p_code;
else
	$trade_code ="r".$wdate."-".$p_code;

//$buyer_zipcode = $buyer_zipcode01."-".$buyer_zipcode02;
$buyer_address = $buyer_address01." ".$buyer_address02;
$delivery_type = $delivery['0'];

if($recipient_name) {

	$recipient_zipcode 	= $recipient_zipcode01."-".$recipient_zipcode02;
	$recipient_address 	= $recipient_address01." ".$recipient_address02;
	$recipient_phone 	= $recipient_phone01."-".$recipient_phone02."-".$recipient_phone03;
	$recipient_hphone 	= $recipient_hphone01."-".$recipient_hphone02."-".$recipient_hphone03;

} else {
	$recipient_name 		= '';
	$recipient_zipcode01 	= '';
	$recipient_zipcode02 	= '';
	$recipient_address01 	= '';
	$recipient_address02 	= '';
	$recipient_phone01 		= '';
	$recipient_phone02 		= '';
	$recipient_phone03 		= '';
	$recipient_hphone01 	= '';
	$recipient_hphone02 	= '';
	$recipient_hphone03 	= '';
}

$memo = addslashes($memo);

//$buyer_license_no = $buyer_license_no01."-".$buyer_license_no02."-".$buyer_license_no03;
//$buyer_phone = $buyer_phone01."-".$buyer_phone02."-".$buyer_phone03;
//$buyer_hphone = $buyer_hphone01."-".$buyer_hphone02."-".$buyer_hphone03;

if($seller == "3") {
	$deposit_date = "";
}else {
	//$deposit_date = $deposit_year."-".$deposit_month."-".$deposit_day;
	$deposit_date = $deposit_date;
}

//무통장일 경우 초기값를 입금확인전으로
$pay_code = '3';

$pay_name = "무통장 입금<br/>\n";
$pay_name .= "- 입금은행명 : $bank_name<br/>\n";
$pay_name .= "- 입금자명 : $company_name<br/>\n";
$pay_name .= "- 입금예정일 : $deposit_date\n";

for($i=0; $i<sizeof($products_kind); $i++){
    if($i != 0){
        $temp_kind .= ",";
    }
    $temp_kind .= $products_kind[$i];
}

/*
//$temp_opt_stock = explode(',', $products_opt_stock); //각 상품의 옵션 수량

for($i=0; $i<sizeof($products_opt_stock); $i++){
    if($i != 0){
        $temp_opt_stock .= ",";
    }
    $temp_opt_stock .= $products_opt_stock[$i];
}
*/

for($i=0; $i<sizeof($products_fk); $i++){
		/* 옵션 재고 변경 작업 요
		if($products_kind[$i]) {
		//구매수량에 따른 옵션재고 업데이트
		$qry = "UPDATE products SET opt_stock='$temp_opt_stock[$i]' WHERE num=$products_fk[$i]";
		mysqli_query($connect, $qry);
		}
		*/

	//구매수량에 따른 재고 업데이트
	$qry = "UPDATE products SET stock='$products_stock[$i]' WHERE num='$products_fk[$i]' ";
	mysqli_query($connect, $qry);

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

for($i=0; $i<sizeof($products_point); $i++){
    if($i != 0){
        $temp_point .= ",";
    }
    $temp_point .= $products_point[$i];
}

$query = "INSERT INTO mall_order(orderid,goods_fk,goods_price, mod_price,
								goods_name,goods_kind,goods_count,mod_count, goods_point,
								user_id,amount,volume,trans_cost,
								mileage_add,mileage_use,real_amount,createdate,
								buyer_name,buyer_zipno,buyer_address,buyer_phone,
								buyer_hphone,buyer_email,
								recipient_name,recipient_zipno,recipient_address,
								recipient_phone,recipient_hphone,
								payment_type,bank,account,deposit_date,status, delivery_type, memo )
		 VALUES ('$trade_code','$temp_code','$temp_price', '$temp_price',
				'$temp_name','$temp_kind', '$temp_count', '$temp_count', '$temp_point',
				'$member_id_fk', '$amount','$temp_count','$trans_cost',
				'$mileage_add','$mileage_use', '$real_mny',now(),
				'$buyer_name','$buyer_zipcode', '$buyer_address', '$buyer_phone',
				'$buyer_hphone', '$buyer_email',
				'$recipient_name', '$recipient_zipcode','$recipient_address',
				'$recipient_phone','$recipient_hphone',
				'1', '$bank_name','$company_name','$deposit_date','$pay_code', '$delivery_type', '$memo' )";

$result = mysqli_query($connect, $query);

//주문상품 장바구니에서 삭제
for($i=0; $i<sizeof($products_fk); $i++){
	$qry2 = "DELETE FROM products_cart WHERE user_id = '$member_id_fk' AND product_fk='$products_fk[$i]' ";
	mysqli_query($connect, $qry2);
}


if(!$result){
   err_msg('데이터베이스 에러가 났습니다.');
}
else{
	######### SMS 발송처리 (회원 SMS 수신 Y, 관리자 SMS 사용여부 Y 에만)
	######### $sms: 회원 SMS 수신여부
	$res = mysqli_query($connect, "SELECT * FROM sms");
	$sms_row = mysqli_fetch_array($res);

	//관리페이지에서 SMS 사용여부 확인
	if($sms_row['sms'] == "Y") {
		//구매자에게 SMS 발송, 승인된 회원만 구매가능하므로 승인여부 제외
		if($sms == "Y" && $sms_row['order_chk'] == "Y") {
			//send_sms(받는 사람 핸드폰번호, 메시지 타입, 날짜, db연결)
			//메시지 타입 3: 주문완료 처리, 날짜가 빈칸이면 즉시 발송
			send_sms($buyer_hphone, 3, $buyer_name, "", $connect);
		}

		//관리자에게 SMS 발송
		if($sms_row['orderin_chk'] == "Y") {
			//send_sms(self->관리자에게, 메시지 타입, 날짜, db연결)
			//메시지 타입 2: 주문접수 처리
			send_sms("self", 2, $buyer_name, "", $connect);
		}

	}
	####### SMS 발송 끝

   //echo "<meta http-equiv='Refresh' content='0; URL=http://www.$_SERVER[SERVER_NAME]/shop/purchase_after.php?trade_code=$trade_code'>";
   // if($from == "m_purchase")
   // 		echo "<meta http-equiv='Refresh' content='0; URL=http://www.$_SERVER[SERVER_NAME]/m/m_order_info.php'>";
   // else
   		echo "<meta http-equiv='Refresh' content='0; URL=http://$_SERVER[SERVER_NAME]/shop/order-list.php'>";
}
?>
