<?php
include "../util/config.php";
include "../util/util.php";
$connect = my_connect($host, $dbid, $dbpass, $dbname);

session_start();

// $lgd_oid = $LGD_OID;

//purchase.php에서 넘어온 값들
// $products_num    = set_var($_POST['products_fk']);
// $products_name  = set_var($_POST['products_name']);
// $products_kind  = set_var($_POST['products_kind']);
// $products_count = set_var($_POST['products_count']);
// $products_price = set_var($_POST['products_price']);
// $products_point = set_var($_POST['products_point']);
// $products_stock = set_var($_POST['products_stock']);
//$products_opt_stock = set_var($_POST['products_opt_stock']);

//구매자 정보
// $buyer_zipcode   = set_var($_POST['buyer_zipcode']);
// $buyer_address01 = set_var($_POST['buyer_address01']);
// $buyer_address02 = set_var($_POST['buyer_address02']);
// $buyer_phone     = set_var($_POST['buyer_phone']);
// $buyer_hphone    = set_var($_POST['buyer_hphone']);
// $sms             = set_var($_POST['sms']);

//$deposit_year = set_var($_POST['deposit_year']);
//$deposit_month = set_var($_POST['deposit_month']);
//$deposit_day = set_var($_POST['deposit_day']);
// $company_name = set_var($_POST['company_name']); //입금자명, 별도로 입력하지 않으면 업체명
// $buyer_name   = set_var($_POST['buyer_name']);
// $deposit_date = set_var($_POST['deposit_date']);

// $bank_name     = set_var($_POST['bank_name']);
// $delivery         = set_var($_POST['delivery_type']);
$memo_to_delivery = set_var($_POST['memo_to_delivery']);
$memo_to_admin    = set_var($_POST['memo_to_admin']);

//수령자가 다를 경우
$check_diff_addr     = set_var($_POST['check_diff_addr']);
$recipient_name      = set_var($_POST['recipient_name']);
$recipient_zipcode   = set_var($_POST['recipient_zipcode01']);
$recipient_address01 = set_var($_POST['recipient_address01']);
$recipient_address02 = set_var($_POST['recipient_address02']);
$recipient_phone     = set_var($_POST['recipient_phone']);
$recipient_hphone    = set_var($_POST['recipient_hphone']);
$recipient_address   = $recipient_address01 . ' ' . $recipient_address02;
$p_id                = set_var($_SESSION['p_id']);

// 주문자 정보 가져옴
$qry  = "SELECT * FROM member WHERE id='$p_id' ";
$res  = mysqli_query($connect, $qry);
$rows = mysqli_fetch_array($res);

$buyer_name    = $rows['company_name'];
$buyer_email   = $rows['md_email'];
$buyer_zipcode = $rows['d_zipcode'];
$buyer_address = $rows['d_addr1'] . ' ' . $rows['d_addr2'];
$buyer_phone   = $rows['d_phone'];
$buyer_hphone  = $rows['md_hphone'];

if ($p_id) {
    $user_id = $rows['id'];
} else {
    $user_id = 'guest';
}

// 중복되지 않는 주문번호 만듬
$query = "INSERT INTO p_code VALUES ('')";
mysqli_query($connect, $query);

$query      = "SELECT max(id) AS maxid FROM p_code";
$result     = mysqli_query($connect, $query);
$row        = mysqli_fetch_array($result);
$p_code     = $row['maxid'];
$wdate      = date('Ymd');
$trade_code = "r-" . $wdate . "-" . $p_code;

$delivery_type = 'L';

if ("option1" == $check_diff_addr) {

    // $recipient_zipcode = $recipient_zipcode01 . "-" . $recipient_zipcode02;
    $recipient_zipcode = $recipient_zipcode01;
    $recipient_address = $recipient_address01 . " " . $recipient_address02;

} else {
    $recipient_name      = '';
    $recipient_zipcode01 = '';
    $recipient_address01 = '';
    $recipient_address02 = '';
    $recipient_phone     = '';
    $recipient_hphone    = '';
}

$memo_to_delivery = addslashes($memo_to_delivery);
$memo_to_admin    = addslashes($memo_to_admin);
$pay_code         = '3'; //입금 확인 전

// if ($seller == "3") {
//     $deposit_date = "";
// } else {
//     //$deposit_date = $deposit_year."-".$deposit_month."-".$deposit_day;
//     $deposit_date = $deposit_date;
// }

//무통장일 경우 초기값를 입금확인전으로
// $pay_code = '3';

// $pay_name = "무통장 입금<br/>\n";
// $pay_name .= "- 입금은행명 : $bank_name<br/>\n";
// $pay_name .= "- 입금자명 : $company_name<br/>\n";
// $pay_name .= "- 입금예정일 : $deposit_date\n";

//JOIN문을 사용해 장바구니와 제품정보에서 데이터를 가져옴
// 카테고리와 등록 순서로 정렬
$query  = "SELECT * FROM products p, products_cart c WHERE c.user_id='$p_id' AND p.num=c.product_code";
$result = mysqli_query($connect, $query);
// $total_count = mysqli_num_rows($result);

$products_num   = array();
$products_name  = array();
$products_price = array();
$products_count = array();
$products_kind  = array();
$products_stock = array();
$trans_cost     = null;

if ($result) {

    $tot_money = 0;

    for ($i = 0; $rows = mysqli_fetch_array($result); $i++) {
        $s_tot          = (int) $rows['volume'] * (int) $rows['amount']; // 소계
        $tot_money      = $tot_money + $s_tot; //총합
        $products_stock = $rows['stock'] - $rows['volume']; // 제품재고에서 카트 재고 뺌

        $products_num[$i]   = $rows['num'];
        $products_name[$i]  = stripslashes($rows['name']);
        $products_price[$i] = calc_offer_price($rows['retail_price'], $p_id); // 업체별 공급가 확인
        $products_count[$i] = $rows['volume'];
        $products_kind[$i]  = $rows['p_opt'];
    }

    $trans_cost = calc_delivery_fee($tot_money); //택배비 계산
}

// 배열에 저장한 주문정보 ,로 구분해서 합치기
$temp_code  = '';
$temp_price = '';
$temp_name  = '';
$temp_count = '';
$temp_kind  = '';

for ($i = 0; $i < sizeof($products_kind); $i++) {
    if ($i != 0) {
        $temp_kind .= ",";
    }
    $temp_kind .= $products_kind[$i];
}

for ($i = 0; $i < sizeof($products_num); $i++) {
    //구매수량에 따른 재고 업데이트
    $qry = "UPDATE products SET stock='$products_stock[$i]' WHERE num='$products_num[$i]' ";
    mysqli_query($connect, $qry);

    if ($i != 0) {
        $temp_code .= ",";
    }
    $temp_code .= $products_num[$i];
}

for ($i = 0; $i < sizeof($products_price); $i++) {
    if ($i != 0) {
        $temp_price .= ",";
    }
    $temp_price .= $products_price[$i];
}

for ($i = 0; $i < sizeof($products_name); $i++) {
    if ($i != 0) {
        $temp_name .= ",";
    }
    $temp_name .= $products_name[$i];
}

for ($i = 0; $i < sizeof($products_count); $i++) {
    if ($i != 0) {
        $temp_count .= ",";
    }
    $temp_count .= $products_count[$i];
}

$query = "INSERT INTO mall_order(orderid,goods_fk,goods_price, mod_price,
								goods_name,goods_kind,goods_count,mod_count,
								user_id, volume,trans_cost,	createdate,
								buyer_name,buyer_zipcode,buyer_address,buyer_phone,
								buyer_hphone,buyer_email,
								recipient_name,recipient_zipcode,recipient_address,
								recipient_phone,recipient_hphone,
								delivery_type, memo_to_delivery, memo_to_admin )
		 VALUES ('$trade_code','$temp_code','$temp_price', '$temp_price',
				'$temp_name','$temp_kind', '$temp_count', '$temp_count',
				'$user_id', '$temp_count','$trans_cost', now(),
				'$buyer_name','$buyer_zipcode', '$buyer_address', '$buyer_phone',
				'$buyer_hphone', '$buyer_email',
				'$recipient_name', '$recipient_zipcode','$recipient_address',
				'$recipient_phone','$recipient_hphone',
				'$delivery_type', '$memo_to_delivery', '$memo_to_admin')";

$result = mysqli_query($connect, $query);

//주문상품 장바구니에서 삭제
for ($i = 0; $i < sizeof($products_num); $i++) {
    $qry2 = "DELETE FROM products_cart WHERE user_id = '$user_id' AND product_code='$products_num[$i]' ";
    mysqli_query($connect, $qry2);
}

if (!$result) {
    err_msg('데이터베이스 에러가 났습니다.');
} else {
    ######### SMS 발송처리 (회원 SMS 수신 Y, 관리자 SMS 사용여부 Y 에만)
    ######### $sms: 회원 SMS 수신여부
    $res     = mysqli_query($connect, "SELECT * FROM sms");
    $sms_row = mysqli_fetch_array($res);

    //관리페이지에서 SMS 사용여부 확인
    if ($sms_row['sms'] == "Y") {
        //구매자에게 SMS 발송, 승인된 회원만 구매가능하므로 승인여부 제외
        if ($sms == "Y" && $sms_row['order_chk'] == "Y") {
            //send_sms(받는 사람 핸드폰번호, 메시지 타입, 날짜, db연결)
            //메시지 타입 3: 주문완료 처리, 날짜가 빈칸이면 즉시 발송
            send_sms($buyer_hphone, 3, $buyer_name, "", $connect);
        }

        //관리자에게 SMS 발송
        if ($sms_row['orderin_chk'] == "Y") {
            //send_sms(self->관리자에게, 메시지 타입, 날짜, db연결)
            //메시지 타입 2: 주문접수 처리
            send_sms("self", 2, $buyer_name, "", $connect);
        }

    }
    ####### SMS 발송 끝

    //echo "<meta http-equiv='Refresh' content='0; URL=http://www.$_SERVER[SERVER_NAME]/shop/purchase_after.php?trade_code=$trade_code'>";
    // if($from == "m_purchase")
    //         echo "<meta http-equiv='Refresh' content='0; URL=http://www.$_SERVER[SERVER_NAME]/m/m_order_info.php'>";
    // else
    echo "<meta http-equiv='Refresh' content='0; URL=http://$_SERVER[SERVER_NAME]/shop/order-list.php'>";
}
