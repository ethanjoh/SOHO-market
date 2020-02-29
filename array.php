<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta charset="utf-8">
</head>
<body>

<?php

$rows = array('opt' => 'M004-09 : 3번 (38.5),M004-10 : 4번 (38.0),M004-11 : 5번 (37.5),M004-12 : 6번 (37.0),M004-13 : 7번 (36.5),M004-14 : 8번 (36.0),M004-15 : 9번 (35.5),M004-16 : P번 (35.0)',
    'opt_count'         => '0,10,10,10,10,10,10,10');

for ($i = 0; $i < 1; $i++) {
    $opt_count[$i] = explode(",", $rows['opt_count']); // 제품의 옵션을 배열로 저장
}

// $final_opt_count = implode(",", $opt_count);

echo "<pre>";
print_r($opt_count);
echo "</pre>";

?>
</body>
</html>
