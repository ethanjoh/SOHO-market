<?php
// 데이타베이스 연결정보 및 기타설정
include '../util/util.php';
include '../util/config.php';
// MySQL 연결
$connect=my_connect($host,$dbid,$dbpass,$dbname);

$mode = set_var($_POST['mode']);
$num = set_var($_POST['num']);
$passwd = set_var($_POST['pwd2']);
$code = set_var($_POST['code']);

$query = "SELECT * FROM code WHERE code='$code' ";
$result = mysqli_query($connect, $query);
$row = mysqli_fetch_array($result);

//관리자 이메일 정보
$result2 = mysqli_query($connect, "SELECT * FROM admin_setup");
$mrow = mysqli_fetch_array($result2);

if($row['passwd'] == sha1($passwd)) {
	$_SESSION['p_id']    = 'admin';
	$_SESSION['p_name']  = '관리자';
	$_SESSION['p_email']  = $mrow['email'];
   echo "<meta http-equiv='Refresh' content='0; URL=list.php?code=$code'>"; 
} else {
	$url = 'list.php?code='.$code;
	show_msg('게시판 관리용 비밀번호가 틀립니다.', $url);
}

?>
