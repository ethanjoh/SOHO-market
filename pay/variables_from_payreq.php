<?php

$lgd_oid = $LGD_OID;

/**
 * payreq_crossplatform.php에서 넘어온 값
 */
//수령자가 다를 경우
$check_diff_addr     = set_var($_POST['check_diff_addr']);
$recipient_name      = set_var($_POST['recipient_name']);
$recipient_zipcode   = set_var($_POST['recipient_zipcode01']);
$recipient_address01 = set_var($_POST['recipient_address01']);
$recipient_address02 = set_var($_POST['recipient_address02']);
$recipient_phone     = set_var($_POST['recipient_phone']);
$recipient_hphone    = set_var($_POST['recipient_hphone']);
$recipient_address   = $recipient_address01 . ' ' . $recipient_address02;

$memo_to_delivery = set_var($_POST['memo_to_delivery']);
$memo_to_admin    = set_var($_POST['memo_to_admin']);

$p_id    = set_var($_SESSION['p_id']);
$user_id = $p_id;

// 주문자 정보 가져옴
$qry = "SELECT * FROM member WHERE id='$p_id' ";
$res = mysqli_query($connect, $qry);

if ($res) {
    $rows = mysqli_fetch_array($res);

    $buyer_name    = $rows['company_name'];
    $buyer_email   = $rows['md_email'];
    $buyer_zipcode = $rows['d_zipcode'];
    $buyer_address = $rows['d_addr1'] . ' ' . $rows['d_addr2'];
    $buyer_phone   = $rows['d_phone'];
    $buyer_hphone  = $rows['md_hphone'];
}

// 중복되지 않는 주문번호 만듬
$trade_code = $lgd_oid;

$delivery_type = 'L';
$payment_type  = '';

// 결제방식
if ("SC0010" == $LGD_PAYTYPE) {
    //카드결제
    $payment_type = "2";
} elseif ("SC0030" == $LGD_PAYTYPE) {
    //실시간 계좌이체
    $payment_type = "3";
} elseif ("SC0040" == $LGD_PAYTYPE) {
    //무통장, 가상계좌
    $payment_type = "1";
}

if ("option1" != $check_diff_addr) {
    $recipient_name      = '';
    $recipient_zipcode01 = '';
    $recipient_address01 = '';
    $recipient_address02 = '';
    $recipient_phone     = '';
    $recipient_hphone    = '';
}

$memo_to_delivery = addslashes($memo_to_delivery);
$memo_to_admin    = addslashes($memo_to_admin);
$status           = '3'; //입금 확인 전

$products_num   = array();
$products_name  = array();
$products_price = array();
$products_count = array();
$products_kind  = array();
$products_stock = array();
$trans_cost     = null;

//JOIN문을 사용해 장바구니와 제품정보에서 데이터를 가져옴
// 카테고리와 등록 순서로 정렬
$query  = "SELECT * FROM products p, products_cart c WHERE c.user_id='$p_id' AND p.num=c.product_code";
$result = mysqli_query($connect, $query);

if ($result) {

    $tot_money = 0;

    for ($i = 0; $rows = mysqli_fetch_array($result); $i++) {
        $s_tot          = (int) $rows['volume'] * (int) $rows['amount']; // 소계
        $tot_money      = $tot_money + $s_tot;                           //총합
        $products_stock = $rows['stock'] - $rows['volume'];              // 제품재고에서 카트 재고 뺌

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
