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
    $final_opt_count[$row['num']] = explode(",", $row['opt_count']); //초기화
    $final_opt_stock[$row['num']] = explode(",", $row['opt_stock']); //초기화
}

// echo "<pre>";
// print_r($final_opt_count);
// print_r($final_opt_stock);
// echo "</pre>";

$query  = "SELECT * FROM products p, products_cart c WHERE c.user_id='test' AND p.num=c.product_code";
$result = mysqli_query($connect, $query);

$sessionFlag = set_var($_SESSION['p_flag']);
$calcPrice   = 0;

if ($result) {

    $tot_money = 0;

    for ($i = 0; $rows = mysqli_fetch_array($result); $i++) {

        // if ($sessionFlag == "c") {
        $calcPrice = $rows['retail_price'];
        // } elseif ($sessionFlag == "p") {
        // $calcPrice = $rows['shop_price'];
        // }

        $s_tot     = (int) $rows['volume'] * (int) $rows['amount']; // 소계 = volume(주문수량) X amount(단가)
        $tot_money = $tot_money + $s_tot;                           //총합

        $products_num[$i]                 = $rows['num'];
        $products_name[$i]                = stripslashes($rows['name']);
        $products_price[$i]               = calc_offer_price($calcPrice, 'test'); // 업체별 공급가 확인 (개인구매 시 소비자가 적용)
        $products_opt[$rows['num']]       = explode(",", $rows['opt']);           // 제품의 옵션을 배열로 저장
        $products_opt_count[$rows['num']] = explode(",", $rows['opt_count']);     // 제품의 옵션수량을 배열로 저장
        $products_opt_stock[$rows['num']] = explode(",", $rows['opt_stock']);     // 제품의 품절표시 배열로 저장
        $order_opt[$rows['num']]          = $rows['p_opt'];                       // 카트에 담긴 옵션명
        $order_count[$rows['num']]        = $rows['volume'];                      // 카트에 담긴 옵션 수량

        // echo "<pre>";
        // print_r($order_opt);
        // echo "</pre>";

        // echo "<pre>";
        // print_r((count($products_opt, 1) / count($products_opt, 0)) - 1);
        // echo "</pre>";

        // 옵션별 재고 업데이트 (2차원 배열의 요소값 갯수 카운트)
        for ($j = 0; $j < (count($products_opt, 1) / count($products_opt, 0)) - 1; $j++) {

            if ($products_opt[$rows['num']][$j] == $order_opt[$rows['num']]) {

                $final_opt_count[$rows['num']][$j] = $products_opt_count[$rows['num']][$j] - $order_count[$rows['num']]; // 전체재고에서 주문수량 차감

                // 주문 옵션재고수량이 0이하일 경우 해당 옵션 품절표시
                if ($final_opt_count[$rows['num']][$j] <= 0) {
                    $final_opt_stock[$rows['num']][$j] = 0;
                    $isOptSoldout                      = "Y";

                    // 단일 옵션일 경우 상품 자체에 품절표시
                    if ((count($products_opt, 1) / count($products_opt, 0)) - 1 == 1) {
                        $isOutofStock = "Y";
                    } else {
                        $isOutofStock = "";
                    }

                } else {
                    $isOptSoldout = "";
                }

            }

        } // end for $j

        //주문옵션 임시저장
        if ($i != 0) {
            $temp_kind .= ",";
        }
        $temp_kind .= $order_opt[$rows['num']];

        //주문수량 임시저장
        if ($i != 0) {
            $temp_count .= ",";
        }
        $temp_count .= $order_count[$rows['num']];

        //DB에 재고, 품절상황 업데이트
        $final_count = implode(",", $final_opt_count[$rows['num']]);

        if ($isOptSoldout && $isOutofStock) {
            // 단일옵션인 경우 상품 자체에 품절표시
            $qry2 = "UPDATE products SET opt_count='$final_count', del_chk='O' WHERE num='$products_num[$i]'";
        } elseif ($isOptSoldout) {
            $final_stock = implode(",", $final_opt_stock[$rows['num']]);
            $qry2        = "UPDATE products SET opt_count='$final_count', opt_stock='$final_stock' WHERE num='$products_num[$i]'";
        } else {
            $qry2 = "UPDATE products SET opt_count='$final_count' WHERE num='$products_num[$i]'";

        }

        // mysqli_query($connect, $qry2);
    }

} else {
    echo "NO RESULT";
}

echo "<pre>";
print_r($temp_count);
echo "</pre>";

// for ($i = 0; $i < sizeof($order_opt); $i++) {
//     if ($i != 0) {
//         $temp_kind .= ",";
//     }
//     $temp_kind .= $order_opt;
// }

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
; // for ($i = 0; $i < sizeof($order_count); $i++) {; //     if ($i != 0) {; //         $temp_count .= ",";; //     }; //     $temp_count .= $order_count[$i];; // }

?>
</body>
</html>
