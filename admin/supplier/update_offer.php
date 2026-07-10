<?php
// 데이타베이스 연결정보 및 기타설정
include "../../util/config.php";
// 각종 유틸함수
include "../../util/util.php";
// MySQL 연결
$connect=my_connect($host,$dbid,$dbpass,$dbname);

$mod_volume = set_var($_POST['mod_volume']);
$oid = set_var($_POST['oid']);
$last_amount = set_var($_POST['last_amount']);

for($i=0; $i<sizeof($mod_volume); $i++){
    if($i != 0){
        $temp_count .= ",";
    }
    $temp_count .= $mod_volume[$i];
}

$query = "UPDATE offer SET mod_count='$temp_count', last_amount='$last_amount'
     		    WHERE num = '$oid' ";
				
$result = mysqli_query($connect, $query);

if(!$result){
   err_msg('수정 중 DB 오류가 발생했습니다.');
}

echo "<meta charset="UTF-8" />
   			<script type='text/javascript'>
   				alert('변경완료')
			</script>
   			<meta http-equiv='Refresh' content='0; URL=view_offer.php?oid=$oid'>"; 

?>
