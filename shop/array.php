<?php
include "../util/config.php";
include "../util/util.php";
$connect = my_connect($host, $dbid, $dbpass, $dbname);

$query  = "SELECT * FROM products p, products_cart c WHERE c.user_id='test' AND p.num=c.product_code";
$result = mysqli_query($connect, $query);

if ($result) {

    for ($i = 0; $rows = mysqli_fetch_array($result); $i++) {
        $s_tot     = (int) $rows['volume'] * (int) $rows['amount']; // 소계 = volume(주문수량) X amount(단가)
        $tot_money = $tot_money + $s_tot; //총합
        //$products_stock = $rows['stock'] - $rows['volume']; // 제품 전체재고에서 카트 재고 뺌

        $products_num[$i]   = $rows['num'];
        $products_name[$i]  = stripslashes($rows['name']);
        $products_price[$i] = calc_offer_price($rows['retail_price'], $p_id); // 업체별 공급가 확인
        $products_count[$i] = $rows['volume'];
        $products_kind[$i]  = $rows['p_opt']; // 카트에 담긴 옵션명

        // 주문제품의 옵션을 가져옴
        $products_opt       = explode(",", $rows['opt']); // 제품의 옵션을 배열로 저장
        $products_opt_count = explode(",", $rows['opt_count']); // 제품의 옵션을 배열로 저장

        // 옵션별 재고 업데이트
        for ($j = 0; $j < sizeof($products_opt); $j++) {
            if ($products_opt[$j] == $rows['p_opt']) {
                $new_opt_count[$j] = $products_opt_count[$j] - $rows['volume']; // 전체재고에서 주문수량 차감
            }
        }

        //DB에 재고 업데이트
        $final_opt_count = implode(",", $new_opt_count);

        echo "<pre>";
        print_r($final_opt_count);
        echo "</pre>";

        $qry2 = "UPDATE products SET opt_count='$final_opt_count' WHERE num='$products_num[$i]' ";
        mysqli_query($connect, $qry2);

    }

}
