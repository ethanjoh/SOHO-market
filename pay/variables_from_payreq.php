<?php

// NEW VERSION 2020.02.26

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

// 회원 구분해서 주문자 정보 가져옴
// 'c':기업회원, 'p': 개인회원
if ($sessionFlag == "c") {
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
} elseif ($sessionFlag == "p") {
    $qry = "SELECT * FROM p_member WHERE id='$p_id' ";
    $res = mysqli_query($connect, $qry);

    if ($res) {
        $rows = mysqli_fetch_array($res);

        $buyer_name    = $rows['name'];
        $buyer_email   = $rows['email'];
        $buyer_zipcode = $rows['d_zipcode'];
        $buyer_address = $rows['d_addr1'] . ' ' . $rows['d_addr2'];
        $buyer_phone   = $rows['d_phone'];
        $buyer_hphone  = $rows['hphone'];
    }
}

// 중복되지 않는 주문번호 만듬
$trade_code = $lgd_oid;

$delivery_type = 'L';
$payment_type  = '';

// 결제방식
if ("SC0010" == $LGD_PAYTYPE) {
    $payment_type = "2"; //카드결제
} elseif ("SC0030" == $LGD_PAYTYPE) {
    $payment_type = "3"; //실시간 계좌이체
} elseif ("SC0040" == $LGD_PAYTYPE) {
    $payment_type = "1"; //무통장, 가상계좌
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

$products_num       = array();
$products_name      = array();
$products_price     = array();
$order_count        = array();
$order_opt          = array();
$products_stock     = array();
$products_opt       = array(); // 추가
$products_opt_count = array(); // 추가
$trans_cost         = null;

// 옵션재고 업데이트를 위해 $final_opt_count 배열 초기화
$qry1 = "SELECT * FROM products p, products_cart c WHERE c.user_id='$p_id' AND p.num=c.product_code";
$res  = mysqli_query($connect, $qry1);

for ($k = 0; $row = mysqli_fetch_array($res); $k++) {
    $final_opt_count = explode(",", $row['opt_count']); //초기화
}

// JOIN문을 사용해 장바구니와 제품정보에서 데이터를 가져옴
// 카테고리와 등록 순서로 정렬
$query  = "SELECT * FROM products p, products_cart c WHERE c.user_id='$p_id' AND p.num=c.product_code";
$result = mysqli_query($connect, $query);

$sessionFlag = set_var($_SESSION['p_flag']);
$calcPrice   = 0;

if ($result) {

    $tot_money = 0;

    for ($i = 0; $rows = mysqli_fetch_array($result); $i++) {

        if ($sessionFlag == "c") {
            $calcPrice = $rows['retail_price'];
        } elseif ($sessionFlag == "p") {
            $calcPrice = $rows['shop_price'];
        }

        $s_tot     = (int) $rows['volume'] * (int) $rows['amount']; // 소계 = volume(주문수량) X amount(단가)
        $tot_money = $tot_money + $s_tot; //총합
        //$products_stock = $rows['stock'] - $rows['volume']; // 제품 전체재고에서 카트 재고 뺌

        $products_num[$i]   = $rows['num'];
        $products_name[$i]  = stripslashes($rows['name']);
        $products_price[$i] = calc_offer_price($rows['retail_price'], $p_id); // 업체별 공급가 확인
        $products_opt       = explode(",", $rows['opt']); // 제품의 옵션을 배열로 저장
        $products_opt_count = explode(",", $rows['opt_count']); // 제품의 옵션수량을 배열로 저장
        $order_opt[$i]      = $rows['p_opt']; // 카트에 담긴 옵션명
        $order_count[$i]    = $rows['volume']; // 카트에 담긴 옵션 수량

        // 옵션별 재고 업데이트
        for ($j = 0; $j < sizeof($products_opt); $j++) {
            if ($products_opt[$j] == $order_opt[$i]) {
                // $new_opt_count[$j] = $products_opt_count[$j] - $order_count[$i]; // 전체재고에서 주문수량 차감
                $products_opt_count[$j] -= $order_count[$i]; // 전체재고에서 주문수량 차감
                $final_opt_count[$j] = $products_opt_count[$j];

                // debug
                // $txt  = print_r($products_opt_count, true);
                // $file = fopen("final_opt_count.txt", "ab+");
                // fwrite($file, $txt);
                // fclose($file);
            }
        }

        //DB에 재고 업데이트
        $final_count = implode(",", $final_opt_count);
        $qry2        = "UPDATE products SET opt_count='$final_count' WHERE num='$products_num[$i]'";
        mysqli_query($connect, $qry2);

    }

    $trans_cost = calc_delivery_fee($tot_money); //택배비 계산
}

// 배열에 저장한 주문정보 ,로 구분해서 합치기
$temp_code  = '';
$temp_price = '';
$temp_name  = '';
$temp_count = '';
$temp_kind  = '';

for ($i = 0; $i < sizeof($order_opt); $i++) {
    if ($i != 0) {
        $temp_kind .= ",";
    }
    $temp_kind .= $order_opt[$i];
}

for ($i = 0; $i < sizeof($products_num); $i++) {
    //구매수량에 따른 재고 업데이트
    // $qry = "UPDATE products SET stock='$products_stock[$i]' WHERE num='$products_num[$i]' ";
    // mysqli_query($connect, $qry);

    if ($i != 0) {
        $temp_code .= ",";
    }
    $temp_code .= $products_num[$i];
}

// debug
$re   = '상품코드: ' . $temp_code . "\n";
$txt  = print_r($re, true);
$file = fopen("temp_code.txt", "w");
fwrite($file, $txt);
fclose($file);

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

for ($i = 0; $i < sizeof($order_count); $i++) {
    if ($i != 0) {
        $temp_count .= ",";
    }
    $temp_count .= $order_count[$i];
}
