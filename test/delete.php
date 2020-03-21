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
$qry = "SELECT * FROM mall_order WHERE num = '2887' ";
$res = mysqli_query($connect, $qry);
$row = mysqli_fetch_array($res);

$a_goods_fk     = explode(",", $row['goods_fk']);    //상품 코드
$a_goods_kind   = explode(",", $row['goods_kind']);  //주문상품 옵션
$a_goods_volume = explode(",", $row['goods_count']); // 주문 수량

for ($i = 0; $i < sizeof($a_goods_fk); $i++) {
    $pro_sql    = "SELECT * FROM products WHERE num = '$a_goods_fk[$i]' ";
    $pro_result = mysqli_query($connect, $pro_sql);
    $pro_row    = mysqli_fetch_array($pro_result);

    /**
    취소 옵션 재고 업데이트
     **/
                                                               // 주문제품의 옵션을 가져옴
    $products_opt       = explode(",", $pro_row['opt']);       // 제품의 옵션을 배열로 저장
    $products_opt_count = explode(",", $pro_row['opt_count']); // 제품의 옵션을 배열로 저장
    $opt_del_chk        = explode(",", $pro_row['opt_stock']);

    // 옵션별 재고 업데이트
    for ($j = 0; $j < sizeof($products_opt); $j++) {
        if ($products_opt[$j] == $a_goods_kind[$i]) {
            $products_opt_count[$j] += $a_goods_volume[$i]; // 취소 주문수량 가감 후 전체재고 업데이트
            $final_opt_count = implode(",", $products_opt_count);

            if ($opt_del_chk[$j] == "0" || "-1") {
                $opt_del_chk[$j] = "1";
                $final_del_chk   = implode(",", $opt_del_chk);
            }

            echo "<pre>";
            print_r($final_del_chk);
            echo "</pre>";

            $qry2 = "UPDATE products SET opt_count='$final_opt_count', opt_stock='$final_del_chk' WHERE num = '$a_goods_fk[$i]' ";
            mysqli_query($connect, $qry2);
        }
    }
}

?>
</body>
</html>
