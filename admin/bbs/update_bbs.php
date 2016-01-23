<?php
// 데이타베이스 연결정보 및 기타설정
include "../../util/config.php";
// 각종 유틸함수
include "../../util/util.php";
// MySQL 연결
$connect=my_connect($host,$dbid,$dbpass,$dbname);

$mode = set_var($_POST['mode']);
$num = set_var($_POST['num']);
$title = set_var($_POST['title']);
$passwd = set_var($_POST['passwd']);
$code = set_var($_POST['code']);
$read = set_var($_POST['readonly']);

if($mode == "modify") {
	$query = "UPDATE code SET bbs_name='$title' WHERE num = '$num' ";
	$result = mysqli_query($connect, $query);
} else if($mode == "del") {
	$query = "DELETE FROM code WHERE num = '$num' ";
	$result = mysqli_query($connect, $query);
	
	//메인 게시판 삭제
	$board = 'bbs_'.$code;
	$query1 = "DROP TABLE $board ";
	$result1 = mysqli_query($connect, $query1);
	
	//답변 게시판 삭제
	$board2 = 'bbs_re_'.$code;
	$query2 = "DROP TABLE $board2 ";
	$result2 = mysqli_query($connect, $query2);	
	
} else if($mode == "ins") {
	$passwd = sha1($passwd);
	$readonly = $read[0];
	$query = "INSERT INTO code (code, bbs_name, passwd, readonly)
				    VALUES ('$code', '$title', '$passwd', '$readonly' )";
	$result = mysqli_query($connect, $query);
	
	//메인 게시판 테이블 생성
	$board = 'bbs_'.$code;				
	$query2 = "CREATE TABLE IF NOT EXISTS $board ( 
				  main_no int(11) unsigned NOT NULL AUTO_INCREMENT,
				 id varchar(11) NOT NULL,
				 title varchar(30) NOT NULL,
				 name varchar(20) NOT NULL,
				 contents mediumtext NOT NULL,
				 passwd varchar(41) NOT NULL,
				 date datetime NOT NULL,
				 count int(10) unsigned NOT NULL default '0',  
				 email  varchar(40),
				 depth int(3) unsigned NOT NULL default '0',
				 filename varchar(255),
				 PRIMARY KEY (main_no),
				 KEY (title, name)
				)TYPE=MyISAM,CHARSET=utf8";
	$result2 = mysqli_query($connect, $query2);
	
	//답변 게시판 테이블 생성
	$board2 = 'bbs_re_'.$code;
	$query3 = "CREATE TABLE IF NOT EXISTS $board2 ( 
				 reply_no int(11) unsigned NOT NULL AUTO_INCREMENT,
				 main_no int(11) unsigned NOT NULL,
				 id varchar(11) NOT NULL,
				 title varchar(30) NOT NULL,
				 name varchar(20) NOT NULL,
				 contents mediumtext NOT NULL,
				 passwd varchar(41) NOT NULL,
				 date datetime NOT NULL,
				 email  varchar(40),
				 PRIMARY KEY (reply_no),
				 KEY (main_no)
				)TYPE=MyISAM,CHARSET=utf8";
	$result3 = mysqli_query($connect, $query3);
	
} else if($mode == "pw") {
   $passwd = sha1($passwd);
	$query = "UPDATE code SET passwd='$passwd' WHERE num = '$num' ";
	$result = mysqli_query($connect, $query);
}	

if(!$result){
   err_msg('DB 오류가 발생했습니다.');
} else {
	$url = 'bbs_list.php';
	show_msg('작업을 완료했습니다.', $url);
} 

?>
