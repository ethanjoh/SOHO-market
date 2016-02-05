<?php
//include common functions to connect to DB
include '../util/util.php';
include '../util/config.php';
// MySQL 연결
$connect = my_connect($host,$dbid,$dbpass,$dbname);

$mode 		= set_var($_POST['mode']);
$main_no 	= set_var($_POST['main_no']);
$reply_no 	= set_var($_POST['reply_no']);
$id 		= set_var($_POST['id']);
$passwd 	= set_var($_POST['passwd']);

$query1 	= "SELECT * FROM member WHERE id='$id' ";
$result1 	= mysqli_query($connect, $query1);
$mrow 		= mysqli_fetch_array($result1);
//mysqli_free_result($result1);

//부모글 삭제 시
if($mode == 'parent') {
   $board = 'bbs_'.$code;
	$pw_sql = "SELECT * FROM $board WHERE main_no=$main_no ";
	$result = mysqli_query($connect, $pw_sql);
	$pw_row = mysqli_fetch_array($result);
//답글 삭제 시
}else if($mode == 'child'){
   //답글 테이블에서 비밀번호 가져오기
	$board = 'bbs_re_'.$code;
	$pw_sql = "SELECT * FROM $board WHERE reply_no=$reply_no ";
	$result = mysqli_query($connect, $pw_sql);
	$pw_row = mysqli_fetch_array($result);
}

//비밀번호 체크
if($pw_row['passwd'] != sha1($passwd) || $pw_row['id'] != $id ) {
	$url = "read.php?code=$code&main_no=$main_no";
	show_msg("본인이 작성한 글이 아니거나 비밀번호가 맞지 않습니다.", $url);
} else if($pw_row['passwd'] == sha1($passwd) && $pw_row['id'] == $id ) {
	//부모글 삭제
	if($mode == 'parent') {
	   $board = 'bbs_'.$code;
		$sql = "DELETE FROM $board WHERE main_no=$main_no ";
		mysqli_query($connect, $sql) or dbError(mysql_error());

		//답글이 있다면 함께 삭제
		if($pw_row['depth'] > 0) {
		   //답글 테이블 호출
		   $board = 'bbs_re_'.$code;
			$sql2 = "DELETE FROM $board WHERE main_no=$main_no ";
			mysqli_query($connect, $sql2) or dbError(mysql_error());
		}

		$url = "list.php?code=$code";
	   show_msg("글을 삭제했습니다.", $url);
	//답글 삭제 시
	} else if($mode == 'child') {
	   $board = 'bbs_re_'.$code;
		$sql = "DELETE FROM $board WHERE reply_no=$reply_no ";
		mysqli_query($connect, $sql) or dbError(mysql_error());

		//부모글의 depth를 하나 줄인다.
		$board = 'bbs_'.$code;
		$sql2 = "UPDATE $board SET depth=depth-1 WHERE main_no=$main_no ";
		mysqli_query($connect, $sql2) or dbError(mysql_error());

	   $url = "read.php?code=$code&main_no=$main_no";
	   show_msg("답글을 삭제했습니다.", $url);
	}
}
?>

