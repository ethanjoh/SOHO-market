<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta charset="utf-8">
</head>
<body>

<?php

$rows = array('opt' => 'M004-09 : 3번 (38.5),M004-10 : 4번 (38.0),M004-11 : 5번 (37.5),M004-12 : 6번 (37.0),M004-13 : 7번 (36.5),M004-14 : 8번 (36.0),M004-15 : 9번 (35.5),M004-16 : P번 (35.0)',
    'opt_count'         => '0,10,10,10,10,10,10,10',
    'volume'            => '5,5',
    'p_opt'             => 'M004-11 : 5번 (37.5), M004-12 : 6번 (37.0)');
// $new_opt_count = array();

// 주문제품의 옵션을 가져옴
$products_opt       = explode(",", $rows['opt']); // 제품의 옵션을 배열로 저장
$order_count        = explode(",", $rows['volume']);
$order_opt          = explode(",", $rows['p_opt']); // 카트에 담긴 옵션명
$products_opt_count = explode(",", $rows['opt_count']); // 제품의 옵션수량을 배열로 저장
// $new_opt_count      = $products_opt_count; //  배열 초기화

for ($i = 0; $i < 8; $i++) {
    // 옵션별 재고 업데이트
    for ($j = 0; $j < sizeof($products_opt); $j++) {

        if ($products_opt[$j] == trim($order_opt[$i])) {
            $products_opt_count[$j] -= $order_count[$i]; // 전체재고에서 주문수량 차감
        }
    }

}

$final_opt_count = implode(",", $products_opt_count);

echo "<pre>";
print_r($final_opt_count);
echo "</pre>";

?>
</body>
</html>
