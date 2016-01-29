<?php
########## 데이터베이스에 연결한다. ##########
// 데이타베이스 연결정보 및 기타설정
include "../util/config.php";
// 각종 유틸함수
include "../util/util.php";
// MySQL 연결
$connect=my_connect($host,$dbid,$dbpass,$dbname);

// $sid = set_var($_POST['session_id']);
// $sname = set_var($_POST['session_name']);

$sid = set_var($_POST['id']);
$cpasswd = set_var($_POST['cpasswd']);
$passwd2 = set_var($_POST['passwd2']);
$passwd3 = set_var($_POST['passwd3']);

// 이름과 아이디에 해당되는 세션이 존재하는지 확인
if(!isset($sid)) {
   err_msg('로그인 정보가 없습니다. 다시 로그인해 주세요.');
}


//비밀번호 수정만
if($ch) {
	//비밀번호 확인
	$qry = "SELECT * FROM member WHERE id='$sid' ";
	$res = mysqli_query($connect, $qry);
	$mrow = mysqli_fetch_array($res);

	if($mrow['passwd'] != sha1($cpasswd)) {
		$msg = "비밀번호가 일치하지 않습니다.";
		$url = "http://www.".$_SERVER['SERVER_NAME']."/member/edit_member.php";
		show_msg($msg, $url);
	}else {	
		$ch_passwd = sha1($passwd2);
		$query3 = "UPDATE member SET passwd = '$ch_passwd' WHERE id='$sid' ";
		$result3 = mysqli_query($connect, $query3);	

		if(!$result3) {
			err_msg('비밀번호 변경 중 DB 오류가 발생했습니다.');	
		}

		######### 게시판의 글들에 대한 비밀번호도 모두 수정한다. #########
		$query2 = "UPDATE board SET passwd='$ch_passwd' WHERE id='$sid' ";
		$result2 = mysqli_query($connect, $query2);

		if(!$result2) {
			err_msg('게시판 비밀번호 수정 중 DB 오류가 발생했습니다.');
		}


	   	session_start();
			session_destroy();

		$msg = "비밀번호를 변경했습니다. 다시 로그인해주세요.";
		$url = "http://www.".$_SERVER['SERVER_NAME']."/shop/index.php";
		show_msg($msg, $url);
		
	}	
		
}

// $passwd = set_var($_POST['passwd2']); 

// //암호화
// $passwd = sha1($passwd);

// ########## 회원정보 테이블에 입력값을 수정한다. ########## 
// $query = "UPDATE member SET passwd = '$passwd' 							
// 		        WHERE id='$sid' ";
// $result = mysqli_query($connect, $query);

// ######### 게시판의 글들에 대한 비밀번호도 모두 수정한다. #########
// $query2 = "UPDATE board SET passwd='$passwd'
// 					  WHERE id='$sid' ";
// $result2 = mysqli_query($connect, $query2);

// // 저장과정에서 오류가 발생하면
// if (!$result) {      
// 	err_msg('DB 오류가 발생했습니다.');
// } else if(!result2) {
// 	err_msg('게시판 비밀번호 수정 중 DB 오류가 발생했습니다.');
// } else {
    

// $msg = "정상적으로 수정했습니다. 다시 로그인하세요.";
// $url = "http://$_SERVER[SERVER_NAME]/member/logout.php";

// show_msg($msg, $url);
// }
?>
