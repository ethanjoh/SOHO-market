<?php
########## 데이터베이스에 연결한다. ##########
// 데이타베이스 연결정보 및 기타설정
include "../util/config.php";
// 각종 유틸함수
include "../util/util.php";
// MySQL 연결
$connect=my_connect($host,$dbid,$dbpass,$dbname);

// 이름과 아이디에 해당되는 세션이 존재하는지 확인
if(!isset($_SESSION["p_id"]) || !isset($_SESSION["p_name"])){
  err_msg('로그인 정보가 없습니다. 다시 로그인해 주세요.');
}

$passwd = set_var($_POST['passwd2']); 

//암호화
$passwd = sha1($passwd);

########## 회원정보 테이블에 입력값을 수정한다. ########## 
$query = "UPDATE pmember SET passwd = '$passwd' 							
		        WHERE id='$_SESSION[p_id]' ";
$result = mysqli_query($connect, $query);

######### 게시판의 글들에 대한 비밀번호도 모두 수정한다. #########
$query2 = "UPDATE board SET passwd='$passwd'
					  WHERE id='$_SESSION[p_id]' ";
$result2 = mysqli_query($connect, $query2);

// 저장과정에서 오류가 발생하면
if (!$result) {      
	err_msg('DB 오류가 발생했습니다.');
} else if(!result2) {
	err_msg('게시판 비밀번호 수정 중 DB 오류가 발생했습니다.');
} else {
    

$msg = "정상적으로 수정했습니다. 다시 로그인하세요.";
$url = "logout.php";

show_msg($msg, $url);
}
?>
