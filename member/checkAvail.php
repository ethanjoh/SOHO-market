<?php

include "../util/util.php";

$userid = $_POST['userid']; // get the username

if ($userid == "") {

    // if the post value is empty it will not do anything
    echo '아이디를 입력하세요';

} else {
    // if it's not empty, it will  query the database and outputs the message

    $query    = "SELECT id FROM member WHERE id ='$userid'";
    $result   = mysqli_query($connect, $query);
    $num_rows = mysqli_num_rows($result);

    if ($num_rows > 0) {
        echo '사용불가. 다시 입력해 주세요.';
    } else {
        echo '사용가능한 아이디입니다.';
    }
}
