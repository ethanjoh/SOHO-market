<?php
include '../util/util.php';
include '../util/config.php';
// MySQL 연결
$connect=my_connect($host,$dbid,$dbpass,$dbname);

$code = set_var($_POST['code']);
$main_no = set_var($_POST['main_no']);
$reply_no = set_var($_POST['reply_no']);
$title = set_var($_POST['title']);
$contents = set_var($_POST['contents']);

//답글을 수정한다.
$board = 'bbs_re_'.$code;
$sql = "UPDATE $board SET title='$title',
										contents='$contents',
										date=now()
			WHERE main_no=$main_no AND reply_no=$reply_no";

mysqli_query($connect, $sql) or dbError(mysqli_error($connect));

echo "<meta HTTP-EQUIV='CONTENT-TYPE' content='text/html;charset=UTF-8'>
			<script type=\"text/javascript\" language=\"JavaScript\">
	        alert(\"답글을 수정했습니다.\");
	        window.close();
	        opener.document.location.replace(\"read.php?code=$code&main_no=$main_no&reply_no=$reply_no\");
         </script>";

?>

