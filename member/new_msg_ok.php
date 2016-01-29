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

/* 다른 회원에게 쪽지쓰기
$id = set_var($_POST['receive_id']);

// 존재하는 아이디인지 확인
$query  = "SELECT id FROM member WHERE id='$id' ";
$result = mysqli_query($connect, $query);
$total_num = mysqli_num_rows($result);

if(!$total_num){
	err_msg('존재하지 않는 아이디입니다. 아이디를 확인하세요.');
}
else{
*/  
  $msg = addslashes($msg);

  $qry1 = "insert into message_info(sendid_fk,receiveid_fk,message,send_reg)
           values('$_SESSION[p_id]','admin','$msg',now()) ";
  
  $res1 = mysqli_query($connect, $qry1);
  if (!$res1) {      
     err_msg('데이터베이스 오류가 발생하였습니다.');
  }
  else {
     echo("<meta http-equiv='content-type' content='text/html; charset=UTF-8' />
	       <script>
	      window.alert('쪽지를 보냈습니다.');
	      </script>");
    echo "<meta http-equiv='Refresh' content='0; URL=/member/sent_msg.php'>"; 
  }
//}
?>
