<?
include "../util/config.php";
// 각종 유틸함수
include "../util/util.php";
// MySQL 연결
$connect=my_connect($host,$dbid,$dbpass,$dbname);

// 이름과 아이디에 해당되는 세션이 존재하는지 확인
if(!isset($_SESSION["p_id"]) || !isset($_SESSION["p_name"])){
  err_msg('로그인 정보가 없습니다. 다시 로그인해 주세요.');
}

//보기화면에서 삭제
if($mode=='view'){
    //받은 편지함내용의 삭제
	if($gb=='1'){
	  //$qry = "update message_info set receive_del='Y' where mnum='$mnum' ";
	  $qry = "DELETE FROM message_info where mnum='$mnum' ";
	  $res = mysqli_query($connect, $qry);

	  echo("<meta http-equiv='Refresh' content='0; URL=check_msg.php'>");
	}
	else if($gb=='2'){  //보낸 편지함 내용삭제
	  //$qry = "update message_info set send_del='Y' where mnum='$mnum' ";
	  $qry = "DELETE FROM message_info where mnum='$mnum' ";
	  $res = mysqli_query($connect, $qry);
      
	  echo("<meta http-equiv='Refresh' content='0; URL=sent_msg.php'>");
	}
}
else{
	//받은 편지함에서 삭제
	if($gb=='1'){
	  for($i=0;$i < sizeof($mnum);$i++){

		 if($mnum[$i]){
			//$qry = "update message_info set receive_del='Y' where mnum='$mnum[$i]' ";
			$qry = "DELETE FROM message_info where mnum='$mnum[$i]' ";
			$res = mysqli_query($connect, $qry);
		 }
	  }
	  echo("<meta http-equiv='Refresh' content='0; URL=check_msg.php'>");
	}
	else if($gb=='2'){ //보낸 편지함에서 삭제
	  for($i=0;$i < sizeof($mnum);$i++){

		 if($mnum[$i]){
			//$qry = "update message_info set send_del='Y' where mnum='$mnum[$i]' ";
			$qry = "DELETE FROM message_info where mnum='$mnum[$i]' ";
			$res = mysqli_query($connect, $qry);
		 }
	  }
	  echo("<meta http-equiv='Refresh' content='0; URL=sent_msg.php'>");
	}
}
?>
