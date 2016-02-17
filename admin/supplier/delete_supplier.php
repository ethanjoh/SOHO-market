<?php

include "../../util/config.php";
// 각종 유틸함수
include "../../util/util.php";
// MySQL 연결
$connect=my_connect($host,$dbid,$dbpass,$dbname);

$query = "DELETE FROM supplier WHERE seq_num = $m_num";
$result = mysqli_query($connect, $query);

if (!$result) {      
   err_msg('데이터베이스 오류가 발생했습니다.');
}
else {
	$url = 'top_supplier_list.php?page='.$page;
	show_msg('공급업체를 삭제했습니다.', $url);
}
?>
