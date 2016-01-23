<?php
// 데이타베이스 연결정보 및 기타설정
include "../../util/config.php";
// 각종 유틸함수
include "../../util/util.php";
// MySQL 연결
$connect=my_connect($host,$dbid,$dbpass,$dbname);

$mode = set_var($_POST['mode']);
$num = set_var($_POST['num']);
$opt_stock = set_var($_POST['opt_stock']);
$stock = set_var($_POST['stock']);

for($i=0; $i<sizeof($opt_stock); $i++){
   	if($i != 0){
       	$temp_stock .= ",";
   	}
   	$temp_stock .= $opt_stock[$i];
}

$query = "UPDATE products SET opt_stock='$temp_stock', stock='$stock'
     		    WHERE num = '$num' ";
				   				
$result = mysqli_query($connect, $query);

if(!$result){
   err_msg('수정 중 DB 오류가 발생했습니다.');
}
else {
   echo "<meta http-equiv='content-type' content='text/html; charset=UTF-8' />
   			<script language='javascript' type='text/javascript'>
   				alert('재고를 수정했습니다.')
			</script>
   			<meta http-equiv='Refresh' content='0; URL=sp_stock_list.php'>"; 
} 
?>
