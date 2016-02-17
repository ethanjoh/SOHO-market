<?php

// 데이타베이스 연결정보 및 기타설정
include "../util/config.php";
// 각종 유틸함수
include "../util/util.php";
// MySQL 연결
$connect=my_connect($host,$dbid,$dbpass,$dbname);

$userid = $_POST['userid']; // get the username

if ($userid == "") {

 // if the post value is empty it will not do anything

}else{ // if it's not empty, it will  query the database and outputs the message

    $query = "SELECT id FROM member WHERE id ='$userid'";
    $result = mysqli_query($connect,$query);
    $num_rows = mysqli_num_rows($result);

    if($num_rows >0 ) {
        echo '사용불가. 다시 입력해 주세요.';
    }else{
        echo '사용가능한 아이디입니다.';
    }
}

?>
