<?php
########## 데이터베이스에 연결한다. ##########
// 데이타베이스 연결정보 및 기타설정
include "../../util/config.php";
// 각종 유틸함수
include "../../util/util.php";
// MySQL 연결
$connect=my_connect($host,$dbid,$dbpass,$dbname);

//다른 회원에게 쪽지쓰기
$id = set_var($_POST['receive_id']);
$reply_id = set_var($_POST['reply_id']);
$mode = set_var($_POST['mode']);

// 존재하는 아이디인지 확인
if($mode == "reply") {
	$query = "SELECT * FROM member WHERE id='$reply_id' ";
	$id = $reply_id;
}else {
	$query  = "SELECT * FROM member WHERE id='$id' ";
}

$result = mysqli_query($connect, $query);
$total_num = mysqli_num_rows($result);

if(!$total_num ){
	err_msg('존재하지 않는 아이디입니다. 아이디를 확인하세요.');
}
else{
 
  $msg = addslashes($msg);

  $qry1 = "INSERT INTO message_info(sendid_fk,receiveid_fk,message,send_reg)
           VALUES('admin','$id','$msg',now()) ";
  
  $res1 = mysqli_query($connect, $qry1);
  if (!$res1) {      
     err_msg('데이터베이스 오류가 발생하였습니다.');
  }
  else {
     echo("<meta http-equiv='content-type' content='text/html; charset=UTF-8' />
	       <script>
	      window.alert('쪽지를 보냈습니다.');
	      </script>");
    echo "<meta http-equiv='Refresh' content='0; URL=sent_msg.php'>"; 
  }
}
?>
