<?php include_once "../util/util.php";?>

<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta charset="utf-8">
</head>
<body>

<?php

/**
 * 주문취소 처리
 */
//주문 취소에 따른 재고 복구
$qry = "SELECT * FROM mall_order WHERE num = '2914' ";
$res = mysqli_query($connect, $qry);
$row = mysqli_fetch_array($res);

$order_pro_num   = explode(",", $row['goods_fk']);    //상품 코드
$order_opt       = explode(",", $row['goods_kind']);  //주문상품 옵션
$order_opt_count = explode(",", $row['goods_count']); // 주문 수량

/*
옵션 배열 초기화
 */

for ($k = 0; $k < sizeof($order_pro_num); $k++) {
    $qry1 = "SELECT * FROM products WHERE num = '$order_pro_num[$k]' ";
    $res1 = mysqli_query($connect, $qry1);
    $row1 = mysqli_fetch_array($res1);

    $final_opt_count[$k] = explode(",", $row1['opt_count']); //초기화
    $final_opt_stock[$k] = explode(",", $row1['opt_stock']); //초기화
}

for ($i = 0; $i < sizeof($order_pro_num); $i++) {
    $pro_sql    = "SELECT * FROM products WHERE num = '$order_pro_num[$i]' ";
    $pro_result = mysqli_query($connect, $pro_sql);
    $pro_row    = mysqli_fetch_array($pro_result);

    $products_opt       = explode(",", $pro_row['opt']);       // 주문제품의 옵션을 가져옴
    $products_opt_count = explode(",", $pro_row['opt_count']); // 주문제품의 옵션재고를 가져옴
    $products_opt_stock = explode(",", $pro_row['opt_stock']); // 옵션재고 상태

    // 옵션별 재고 업데이트
    for ($j = 0; $j < sizeof($products_opt); $j++) {

        if ($products_opt[$j] == $order_opt[$i]) {
            $products_opt_count[$j]  = $products_opt_count[$j] + $order_opt_count[$i]; // 취소 주문수량 가감 후 전체재고 업데이트
            $final_opt_count[$i][$j] = $products_opt_count[$j];

            if ($products_opt_stock[$j] == "0" || "-1") {
                $final_opt_stock[$i][$j] = "1";
                $final_stock             = implode(",", $final_opt_stock[$i]);
            }

            $final_count = implode(",", $final_opt_count[$i]);

            echo "<pre>";
            print_r($final_count);
            echo "</pre>";

              // $qry2 = "UPDATE products SET opt_count='$final_count', opt_stock='$final_stock' WHERE num = '$order_pro_num[$i]' ";
              // mysqli_query($connect, $qry2);
        } // end if
    } // end for $j
}
; // end for $i

?>
</body>
</html>
