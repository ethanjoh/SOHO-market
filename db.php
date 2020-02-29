<?php include_once "util/util.php";?>

<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta charset="utf-8">
</head>
<body>

<?php

// global $final_opt_count;

$qry1 = "SELECT * FROM products p, products_cart c WHERE c.user_id='test' AND p.num=c.product_code";
$res  = mysqli_query($connect, $qry1);

for ($k = 0; $row = mysqli_fetch_array($res); $k++) {
    $final_opt_count = explode(",", $row['opt_count']); //초기화
}

$query  = "SELECT * FROM products p, products_cart c WHERE c.user_id='test' AND p.num=c.product_code";
$result = mysqli_query($connect, $query);

if ($result) {

    for ($i = 0; $rows = mysqli_fetch_array($result); $i++) {

        $products_num[$i]   = $rows['num'];
        $products_opt       = explode(",", $rows['opt']); // 제품의 옵션을 배열로 저장
        $products_opt_count = explode(",", $rows['opt_count']); // 제품의 옵션수량을 배열로 저장
        $order_opt[$i]      = $rows['p_opt']; // 카트에 담긴 옵션명
        $order_count[$i]    = $rows['volume']; // 카트에 담긴 옵션 수량

        // 옵션별 재고 업데이트
        for ($j = 0; $j < sizeof($products_opt); $j++) {

            if ($products_opt[$j] == $order_opt[$i]) {
                $products_opt_count[$j] = $products_opt_count[$j] - $order_count[$i]; // 전체재고에서 주문수량 차감
                $final_opt_count[$j]    = $products_opt_count[$j];

                echo "<pre>";
                print_r($final_opt_count);
                echo "</pre>";
            }
        }

        //DB에 재고 업데이트
        $final_count = implode(",", $final_opt_count);
        $qry2        = "UPDATE products SET opt_count='$final_count' WHERE num='$products_num[$i]'";
        mysqli_query($connect, $qry2);

        echo "<pre>";
        print_r($final_count);
        echo "</pre>";
    }

} else {
    echo "NO RESULT";
}

?>
</body>
</html>
