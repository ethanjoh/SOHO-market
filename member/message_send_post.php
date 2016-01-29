<?
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


// 존재하는 아이디인지 확인
$query  = "SELECT id FROM member WHERE id='$receive_id' ";
$result = mysqli_query($connect, $query);
$total_num = mysqli_num_rows($result);

if(!$total_num){
	err_msg('존재하지 않는 아이디입니다. 아이디를 확인하세요.');
}
else{
  
  $msg = addslashes($msg);

  $qry1 = "insert into message_info(sendid_fk,receiveid_fk,message,send_reg)
           values('$_SESSION[p_id]','$receive_id','$msg',now()) ";
  
  $res1 = mysqli_query($connect, $qry1);
  if (!$res1) {      
     err_msg('데이터베이스 오류가 발생하였습니다.');
  }
  else {
     echo("<script>
	      window.alert('정상적으로 메시지가 전달 되었습니다!');
	      </script>");
    echo "<meta http-equiv='Refresh' content='0; URL=/member/message_2.php'>"; 
  }
}
?>
