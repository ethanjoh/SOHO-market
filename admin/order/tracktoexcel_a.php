<?php
$file_name = "tracklist_a_".date("Y-m-d");

header( "Content-type: application/vnd.ms-excel; charset=UTF-8" );
header( "Content-Disposition: attachment; filename=$file_name.xls" );
header( "Content-Description: PHP4 Generated Data" );

//관리자 인증 파일
include "../../util/admin_auth.php";
// 데이타베이스 연결정보 및 기타설정
include "../../util/config.php";
// 각종 유틸함수
include "../../util/util.php";
// MySQL 연결
$connect=my_connect($host,$dbid,$dbpass,$dbname);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko">
<head>
<title>운송장 출력</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
</head>
<body>
<table summary="view the total order list" border="1">
  <tbody>
    <?php
$date1 = set_var($_GET['date1']);
$date2 = set_var($_GET['date2']);

//$today = date("Y-m-d");

if (empty($date1)) $date1 = $date1;
if (empty($date2)) $date2 = $date2;

$sql = "SELECT * FROM mall_order
	   				  WHERE delivery_type = 'L'
					  AND cancel = 'N'
					  AND status = '7'
					  AND trans_cost <> '-1'
					  ORDER BY num DESC ";
/*
$sql = "SELECT * FROM mall_order
		  WHERE delivery_type='L'
		  AND cancel = 'N'
		  AND status = '7'
		  AND createdate BETWEEN '$date1' AND '$date2'
		  ORDER BY num DESC ";
		  */
$res = mysqli_query($connect, $sql);
$t_no = mysqli_num_rows($res);

if($t_no > 0) {
	for($i=0; $row = mysqli_fetch_array($res); $i++){
?>
    <tr>
      <td><?=$row['orderid']?></td>
      <td><?=$row['recipient_name'] ? $row['recipient_name'] : $row['buyer_name']?></td>
      <?php
//상품명 가져옴
$a_goods_fk = explode(",", $row['goods_fk']);

$pro_sql="SELECT * FROM products WHERE num='$a_goods_fk[0]'";
$pro_result = mysqli_query($connect, $pro_sql);
$pro_row = mysqli_fetch_array($pro_result);

if(count($a_goods_fk) > 1) {
	$goods_name = cut_string_utf8($pro_row['name'],30,'...');
	$goods_name .= " (외)";
}else {
	$goods_name = cut_string_utf8($pro_row['name'],30,'...');
}

   //배송정책 가져옴
$query4 = "SELECT * FROM misc_setup WHERE id='admin' ";
$result4 = mysqli_query($connect, $query4);
$misc = mysqli_fetch_array($result4);

//if($row['last_amount'] >=$misc['min_sum'] || $row['trans_cost'] == '0')
if($row['trans_cost'] == '0') {
	$str = "3"; //신용
	$t_cost = "2200";
}else {
	$str = "2"; //착불
	$t_cost = "2500";
}
?>
      <td><?=$goods_name?></td>
      <td>1</td>
      <td><?=$row['recipient_name'] ? $row['recipient_zipno'] : $row['buyer_zipno']?></td>
      <td><?=$row['recipient_name'] ? $row['recipient_address'] : $row['buyer_address']?></td>
      <td><?=$row['recipient_name'] ? $row['recipient_phone'] : $row['buyer_phone']?></td>
      <td><?=$row['recipient_name'] ? $row['recipient_hphone'] : $row['buyer_hphone']?></td>
      <td><?=$str?></td>
      <td><?=$t_cost?></td>
      <td><?php
			if($row['memo'])
			echo $row['memo'];
			?></td>
            <!--
      <td><?= $row['recipient_name'] ? $row['buyer_name'] : "" ?></td>
      <td><?= $row['recipient_name'] ? $row['buyer_phone'] : "" ?></td>
      -->
    </tr>
    <?php
  } // for loop end
 ?>
    <?php
}else {
?>
    <tr>
      <td colspan="12"><p>해당 주문내역이 없습니다.</p></td>
    </tr>
    <?php
 } ?>
  </tbody>
</table>
</body>
</html>
