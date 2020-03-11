<?php include_once "util/util.php";?>

<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta charset="utf-8">
</head>
<body>

<?php

$selected_opt = "OPT-D";
$order_count  = "100";

// 상품옵션 재고 확인
$qry1    = "SELECT * FROM products WHERE num='4796' ";
$res1    = mysqli_query($connect, $qry1);
$opt_row = mysqli_fetch_array($res1);

$products_opt       = explode(",", $opt_row['opt']); // 제품의 옵션을 배열로 저장
$products_opt_count = explode(",", $opt_row['opt_count']); // 제품의 옵션수량을 배열로 저장

// 옵션별 재고 업데이트
for ($i = 0; $i < sizeof($products_opt); $i++) {

    if ($products_opt[$i] == $selected_opt) {

        if ($products_opt_count[$i] < $order_count) {
            echo "<pre>";
            print_r('OVER!');
            echo "</pre>";
        }
    }
}

?>
</body>
</html>
