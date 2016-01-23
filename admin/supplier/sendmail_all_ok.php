<?php
//관리자 인증 파일
include "../../util/admin_auth.php";
// 데이타베이스 연결정보 및 기타설정
include "../../util/config.php";
// 각종 유틸함수
include "../../util/util.php";
// MySQL 연결
$connect=my_connect($host,$dbid,$dbpass,$dbname);


$sender = set_var($_POST['sender']);
$sender_email = set_var($_POST['sender_email']);
$subject = set_var($_POST['subject']);
$contents = set_var($_POST['contents']);

$subject  = addslashes($subject);
$contents = addslashes($contents);

  for($i=0;$i < sizeof($num);$i++){
	  $query  = "SELECT * FROM member WHERE seq_num='$num[$i]' ";
	  $result  = mysqli_query($connect, $query);
	  $rows = mysqli_fetch_array($result);

	  //$md_email= $rows[md_email];

	  $body = nl2br($contents);

	  $fromname = $sender;
	  $from = $sender_email;
	  
	  $toname = $rows[company_name];
	  $to = $rows[md_email];
		
	  $mailheaders = "Return-Path: $from\r\n";
	  $mailheaders .= "From: $fromname <$from>\r\n";
	  $mailheaders .= "Content-Type: text/html; charset=utf-8\r\n";
	  mail($to,$subject,$body,$mailheaders);    
  }
  
  echo("
           <script>
	         window.alert('메일이 발송되었습니다.')
			 self.close()
	        </script>
	  ");

?>
