<?php

include_once "../include/admin_auth.php";
include_once "../../util/util.php";

$csvFilePath = "uploads/products_list.csv"; // 파일명 변경가능

$tempCSV = file_get_contents($csvFilePath);
$tempCSV = mb_convert_encoding($tempCSV, 'UTF-8', 'EUC-KR');

$fp = tmpfile();
fwrite($fp, $tempCSV);
rewind($fp);
setlocale(LC_ALL, 'ko_KR.UTF-8');

$final = array();

while ($final = fgetcsv($fp)) {
    // csv 파일 첫 번째 줄은 비워놓을 것 (첫줄 데이터는 에러남)

    $update = "UPDATE products SET opt_count='$final[3]' WHERE num='$final[0]' ";
    $result = mysqli_query($connect, $update);

    if ($result) {
        $msg .= "Update completed!<br/>";
    }

}

fclose($file);

echo $msg;
