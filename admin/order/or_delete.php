<?php

include_once "../include/admin_auth.php";
include_once "../../util/util.php";

$mode = set_var($_GET['mode']);
$oid  = set_var($_GET['oid']);
$page = set_var($_GET['page']);
$uri  = set_var($_GET['reUrl']);
$uri  = urldecode($uri);

//주문 취소에 따른 재고 복구
$qry = "SELECT * FROM mall_order WHERE num = '$oid' ";
$res = mysqli_query($connect, $qry);
$row = mysqli_fetch_array($res);

$a_goods_fk     = explode(",", $row['goods_fk']); //상품 코드
$a_goods_kind   = explode(",", $row['goods_kind']); //주문상품 옵션
$a_goods_volume = explode(",", $row['goods_count']); //변경된 수량
$new_opt_count  = array();

for ($i = 0; $i < sizeof($a_goods_fk); $i++) {
    $pro_sql    = "SELECT * FROM products WHERE num = '$a_goods_fk[$i]' ";
    $pro_result = mysqli_query($connect, $pro_sql);
    $pro_row    = mysqli_fetch_array($pro_result);

    /**
    취소 옵션 재고 업데이트
     **/
    // 주문제품의 옵션을 가져옴
    $products_opt       = explode(",", $pro_row['opt']); // 제품의 옵션을 배열로 저장
    $products_opt_count = explode(",", $pro_row['opt_count']); // 제품의 옵션을 배열로 저장

    // 옵션별 재고 업데이트
    for ($j = 0; $j < sizeof($products_opt); $j++) {
        if ($products_opt[$j] == $a_goods_kind[$i]) {
            $products_opt_count[$j] = $products_opt_count[$j] + $a_goods_volume[$i]; // 취소 주문수량 가감 후 전체재고 업데이트
            $final_opt_count        = implode(",", $products_opt_count);

            $qry2 = "UPDATE products SET opt_count='$final_opt_count' WHERE num = '$a_goods_fk[$i]' ";
            mysqli_query($connect, $qry2);
        }
    }
}

if ($mode == "d") {
    $update = "DELETE FROM mall_order WHERE num='$oid' ";
} else {
    // 해당 주문정보를 취소처리 합니다.
    $update = "UPDATE mall_order SET cancel='Y', last_amount=0 WHERE num='$oid' ";
}

$result = mysqli_query($connect, $update);

echo "<meta http-equiv='refresh' content='0; URL=top_order_list.php?page=$page'>";
// header("Location: " . $uri . "");
