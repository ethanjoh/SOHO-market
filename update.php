<!DOCTYPE html>
<html>
<head lang="ko">
	<title></title>
	<meta charset="utf-8">
</head>
<body>

<?php

$rows = [
    'p_opt'     => 'B010-06:Dark Gray 47g(립그립)',
    'volume'    => '1',
    'amount'    => '2420',
    'opt'       => 'B010-01:Black 47g(립),B010-02:Black 47g(라운드),B010-06:Dark Gray 47g(립그립),B010-09:Dark Gray 47g(라운드그립),B010-05:Dark Blue 47g(립그립),B010-08:Dark Blue 47g(라운드그립),B010-07:Dark Red 47g(립그립),B010-10:Dark Red 47g(라운드그립)',
    'opt_count' => '100,100,100,100,100,100,100,100',
];

for ($i = 0; $i < 1; $i++) {

    $products_count[$i] = $rows['volume'];
    $products_kind[$i]  = $rows['p_opt']; // 카트에 담긴 옵션명

    // 주문제품의 옵션을 가져옴
    $products_opt       = explode(",", $rows['opt']); // 제품의 옵션을 배열로 저장
    $products_opt_count = explode(",", $rows['opt_count']); // 제품의 옵션수량을 배열로 저장
    $new_opt_count      = $products_opt_count;

    //옵션별재고업데이트
    for ($j = 0; $j < sizeof($products_opt); $j++) {
        if ($products_opt[$j] == $rows['p_opt']) {
            $new_opt_count[$j] = $products_opt_count[$j] - $rows['volume']; // 전체재고에서 주문수량 차감
        }
    }

    // //DB에 재고 업데이트
    $final_opt_count = implode(",", $new_opt_count);

    echo "<pre>";
    print_r($final_opt_count);
    echo "</pre>";

}
?>

</body>
</html>

