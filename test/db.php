<?php include_once "../util/util.php";?>

<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta charset="utf-8">
</head>
<body>

<?php

$qry1 = "SELECT * FROM products p, products_cart c WHERE c.user_id='test' AND p.num=c.product_code";
$res1 = mysqli_query($connect, $qry1);

for ($k = 0; $row = mysqli_fetch_array($res1); $k++) {
    $final_opt_count[$k] = explode(",", $row['opt_count']); //초기화
    $final_opt_stock[$k] = explode(",", $row['opt_stock']); //초기화
}

// echo "<pre>";
// print_r($final_opt_count);
// print_r($final_opt_stock);
// echo "</pre>";

$query  = "SELECT * FROM products p, products_cart c WHERE c.user_id='test' AND p.num=c.product_code";
$result = mysqli_query($connect, $query);

if ($result) {

    for ($i = 0; $rows = mysqli_fetch_array($result); $i++) {

        $products_num[$i]   = $rows['num'];
        $products_opt       = explode(",", $rows['opt']);       // 제품의 옵션을 배열로 저장
        $products_opt_count = explode(",", $rows['opt_count']); // 제품의 옵션수량을 배열로 저장
        $products_opt_stock = explode(",", $rows['opt_stock']); // 제품의 품절표시 배열로 저장
        $order_opt[$i]      = $rows['p_opt'];                   // 카트에 담긴 옵션명
        $order_count[$i]    = $rows['volume'];                  // 카트에 담긴 옵션 수량

        // 옵션별 재고 업데이트
        for ($j = 0; $j < sizeof($products_opt); $j++) {

            if ($products_opt[$j] == $order_opt[$i]) {
                $products_opt_count[$j]  = $products_opt_count[$j] - $order_count[$i]; // 전체재고에서 주문수량 차감
                $final_opt_count[$i][$j] = $products_opt_count[$j];

                // 주문 옵션재고수량이 0이하일 경우 해당 옵션 품절표시
                if ($products_opt_count[$j] <= 0) {
                    $final_opt_stock[$i][$j] = 0;
                    $isOptSoldout            = $final_opt_stock;

                    // 단일 옵션일 경우 상품 자체에 품절표시
                    if (sizeof($products_opt) == 1) {
                        $isOutofStock = "Y";
                    } else {
                        $isOutofStock = "";
                    }

                } else {
                    $isOptSoldout = "";
                }

            }

        } // end for $j

        //DB에 재고, 품절상황 업데이트
        $final_count = implode(",", $final_opt_count[$i]);

        echo "<pre>";
        print_r($final_opt_count[$i]);
        echo "</pre>";

        if ($isOptSoldout && $isOutofStock) {
            // 단일옵션인 경우 상품 자체에 품절표시
            $qry2 = "UPDATE products SET opt_count='$final_count', del_chk='O' WHERE num='$products_num[$i]'";
        } elseif ($isOptSoldout) {
            $final_stock = implode(",", $final_opt_stock[$i]);
            $qry2        = "UPDATE products SET opt_count='$final_count', opt_stock='$final_stock' WHERE num='$products_num[$i]'";
        } else {
            $qry2 = "UPDATE products SET opt_count='$final_count' WHERE num='$products_num[$i]'";
        }

        mysqli_query($connect, $qry2);
    }

} else {
    echo "NO RESULT";
}

?>
</body>
</html>
