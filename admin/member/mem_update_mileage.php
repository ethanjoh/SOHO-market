<?php
// 데이타베이스 연결정보 및 기타설정
include "../../util/config.php";
// 각종 유틸함수
include "../../util/util.php";
// MySQL 연결
$connect=my_connect($host,$dbid,$dbpass,$dbname);

$mod_mileage = set_var($_GET['mod_mileage']);
$id_fk = set_var($_GET['id_fk']);

$query = "UPDATE mileage SET mileage='$mod_mileage'
     		    WHERE id_fk = '$id_fk' ";
				
$result = mysqli_query($connect, $query);

if(!$result){
   err_msg('적립금 수정 중 DB 오류가 났습니다.');
}
else{
   echo("
      <script>
        window.alert('적립금을  수정했습니다.')
 	  </script>
    ");
   echo "<meta http-equiv='Refresh' content='0; URL=mem_mileage_list.php'>"; 
}
?>
