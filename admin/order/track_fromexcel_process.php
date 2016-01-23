<?php
//택배 운송장 업로드 처리 파일
//관리자 인증 파일
include "../../util/admin_auth.php";
// 데이타베이스 연결정보 및 기타설정
include "../../util/config.php";
// 각종 유틸함수
include "../../util/util.php";
// MySQL 연결
$connect=my_connect($host,$dbid,$dbpass,$dbname);

// $sql = "SELECT orderid, status, track_no, last_amount, senddate FROM mall_order 
// 	   				  WHERE delivery_type = 'L'
// 					  AND cancel = 'N'
// 					  AND status = '7' 
// 					  AND trans_cost <> '-1' ";	

// $res = mysqli_query($connect, $sql);


$uploaddir = './uploads/';
$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);


// echo "<pre>";

if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
    $msg = "<p>파일이 유효하고, 성공적으로 업로드 되었습니다.</p>";

    setlocale(LC_CTYPE, "ko_KR.eucKR"); 

	$file = fopen($uploadfile,"r");

	while(! feof($file)) {

	  $final = fgetcsv($file);

	  // print_r($final);

	  $update = "UPDATE mall_order SET status='8', track_no='$final[2]', senddate='$final[16]' WHERE orderid='$final[4]' ";   
	  $result = mysqli_query($connect, $update); 

	  $buyer = iconv("EUC-KR", "UTF-8", $final[5]);

	  if($result)
	  	$msg .= "주문번호 : ".$final[4]." - 수령인 : ".$buyer." 발송처리 완료<br/>";
	}

	fclose($file);

} else {
    print "파일 업로드 공격의 가능성이 있습니다!\n";
}

// echo "</pre>";
echo $msg;


?>