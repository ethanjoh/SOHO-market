<?php
// 데이타베이스 연결정보 및 기타설정
include "../util/config.php";
// 각종 유틸함수
include "../util/util.php";
// MySQL 연결
$connect = my_connect($host, $dbid, $dbpass, $dbname);

$id        = set_var($_POST['id']);
$id        = trim($id); //앞뒤 공백제거
$pwd       = set_var($_POST['pwd']);
$msave_all = set_var($_POST['msave_all']);

$date_expiry = time() + 60 * 60 * 24 * 30; //30일동안 아이디저장

//회원 테이블에서 정보확인
$query  = "SELECT * FROM member WHERE id=binary('$id') ";
$result = mysqli_query($connect, $query);
$rows   = mysqli_fetch_array($result);

if ($rows['passwd'] != sha1($pwd)) {
    msg('비밀번호가 틀립니다.\n (Wrong password.)');
} else {
    // ini_set("session.cookie_domain", $_SERVER['SERVER_NAME']); //서브도메인간 세션 공유
    //    session_start();

    $_SESSION["p_id"]    = $id;
    $_SESSION["p_pw"]    = $pwd;
    $_SESSION["p_name"]  = $rows['company_name'];
    $_SESSION["p_email"] = $rows['md_email'];

    //save id and passwd
    if ($msave_all) {
        setcookie("msave_all", "Y", $date_expiry);
        setcookie("id", "$id", $date_expiry);
        setcookie("pwd", "$pwd", $date_expiry);

    } else {
        setcookie("msave_all", "", 0);
    }

    //장바구니용 쿠키 선언
    if (!$_COOKIE['member_sid']) {
        $SID = md5(uniqid(rand()));
        SetCookie("p_sid", $SID, 0, "/");
    }

    //로그인 풀림 방지
    if (!$_COOKIE['PHPSESSID']) {
        setcookie("PHPSESSID", session_id(), 0, "/");
    }

}

if ($uri) {
    $uri   = urldecode($uri);
    $uri_d = explode('/', $uri);

    if ($uri_d[1] == "bbs") {
        echo ("<meta http-equiv='Refresh' content='0; URL=http://$_SERVER[SERVER_NAME]" . $uri . "'>");
    } else {
        echo ("<meta http-equiv='Refresh' content='0; URL=http://$_SERVER[SERVER_NAME]/shop/catalog-list.php'>");
    }

}
; // }else{; //         // echo("<meta http-equiv='Refresh' content='0; URL=http://$_SERVER[SERVER_NAME]'>");; //    echo("<meta http-equiv='Refresh' content='0; URL=http://$_SERVER[SERVER_NAME]/shop/catalog-list.php'>");; // }; // echo("<meta http-equiv='Refresh' content='0; URL=http://$_SERVER[SERVER_NAME]/shop/catalog-list.php'>");
