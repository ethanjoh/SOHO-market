<?php

//택배 운송장 업로드 처리 파일
include_once "../include/admin_auth.php";
include_once "../../util/util.php";

$uploaddir  = './uploads/';
$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);

$today = date("Y-m-d");

if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
    $msg = "<p>파일이 유효하고, 성공적으로 업로드 되었습니다.</p>";

    setlocale(LC_CTYPE, "ko_KR.eucKR");

    $file = fopen($uploadfile, "r");

    while (!feof($file)) {

        $final = fgetcsv($file);

        $update = "UPDATE mall_order SET status='8', track_no='$final[3]', senddate='$today' WHERE orderid='$final[18]' ";
        $result = mysqli_query($connect, $update);

        $buyer = iconv("EUC-KR", "UTF-8", $final[5]);

        if ($result) {
            $msg .= "주문번호 : " . $final[4] . " - 수령인 : " . $buyer . " 발송처리 완료<br/>";
        }

    }

    fclose($file);

} else {
    print "파일 업로드 공격의 가능성이 있습니다!\n";
}

echo $msg;
