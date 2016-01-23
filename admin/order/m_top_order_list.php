<?php
//관리자 인증 파일
include "../../util/admin_auth.php";
// 데이타베이스 연결정보 및 기타설정
include "../../util/config.php";
// 각종 유틸함수
include "../../util/util.php";
// MySQL 연결
$connect=my_connect($host,$dbid,$dbpass,$dbname);
?>
<!DOCTYPE HTML>
<html>
<head>
<title>B2B SCM mobile (주문목록)</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.css" />
<link href="http://www.<?=$_SERVER['SERVER_NAME']?>/admin/css/m_layout.css" rel="stylesheet" type="text/css" />
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.js"></script>
<script language="JavaScript" src="../js/admin.js" ></script>
<!-- m_top_list -->
</head>
<body>
<div data-role="page" data-theme="c">
  <?php
	switch ($mode) {
		case 'search' : $sql_2 = "SELECT * FROM mall_order WHERE user_id <> 'guest' AND $key LIKE '%$key_value%' "; break;		
		case 'unchk'  : $sql_2 = "SELECT * FROM mall_order WHERE cancel = 'N' AND user_id <> 'guest' AND status = '3' "; break;
		case 'chk'    : $sql_2 = "SELECT * FROM mall_order WHERE cancel = 'N' AND user_id <> 'guest' AND status = '5' "; break;		
		case 'paid'   : $sql_2 = "SELECT * FROM mall_order WHERE cancel = 'N' AND user_id <> 'guest' AND status = '7' "; break;			
		case 'delay'  : $sql_2 = "SELECT * FROM mall_order WHERE cancel = 'N' AND user_id <> 'guest' AND status = '0' "; break;									
		default       : $sql_2 = "SELECT * FROM mall_order WHERE user_id <> 'guest' "; 
	}	  


	$res_2 = mysqli_query($connect, $sql_2);
	$total_p = mysqli_num_rows($res_2);
	
	$scale=10;

   	if ($page == ''){
      $page=1;
  	}	    
   
	$cpage = intval($page);
	$totalpage = intval($total_p/$scale);
	
    if ($totalpage*$scale != $total_p)
  		$totalpage = $totalpage + 1;
        
    if ($cpage ==1) {
	  $cline = 0 ;
    } else {
 	  $cline = ($cpage*$scale) - $scale ;
    } 
        
     $limit=$cline+$scale;
       
     if ($limit >= $total_p) 
       	$limit=$total_p;

     $scale1 = $limit - $cline;	

?>
  <div data-role="header" style="overflow:hidden;"> <a href="#" onClick="javascript:history.back(-1);" data-icon="arrow-l">뒤로</a>
    <h1>B2B 주문목록</h1>
    <a href="../m.php" data-icon="home" data-ajax="false">홈</a>
    <div data-role="navbar">
      <ul>
        <li><a href="m_top_order_list.php?mode=unchk">미처리</a></li>
        <li><a href="m_top_order_list.php?mode=chk">주문확인</a></li>
        <li><a href="m_top_order_list.php?mode=delay">발송지연</a></li>
        <li><a href="m_top_order_list.php">전체주문</a></li>        
      </ul>
    </div>
  </div>
  <div data-role="content">
    <ul data-role="listview">
      <?php
		switch ($mode) {
			case 'search' : $sql_4 = "SELECT * FROM mall_order WHERE $key LIKE '%$key_value%' AND user_id <> 'guest' ORDER BY num DESC LIMIT $cline,$scale1 "; break;	
			case 'unchk'  : $sql_4 = "SELECT * FROM mall_order WHERE cancel = 'N' AND user_id <> 'guest' AND status = '3' ORDER BY num DESC LIMIT $cline,$scale1 ";	break;
			case 'chk'    : $sql_4 = "SELECT * FROM mall_order WHERE cancel = 'N' AND user_id <> 'guest' AND status = '5' ORDER BY num DESC LIMIT $cline,$scale1 ";	break;		
			case 'paid'   : $sql_4 = "SELECT * FROM mall_order WHERE cancel = 'N' AND user_id <> 'guest' AND status = '7' ORDER BY num DESC LIMIT $cline,$scale1 ";	break;			
			case 'delay'  : $sql_4 = "SELECT * FROM mall_order WHERE cancel = 'N' AND user_id <> 'guest' AND status = '0' ORDER BY num DESC LIMIT $cline,$scale1 ";	break;									
			default       : $sql_4 = "SELECT * FROM mall_order WHERE user_id <> 'guest' ORDER BY num DESC LIMIT $cline,$scale1 "; 
		}


		$a_pay_type['1'] = "무통장 입금";
		$a_pay_type['2'] = "신용카드";
		$a_pay_type['3'] = "휴대폰 결제";

		$res_4 = mysqli_query($connect, $sql_4);
		$t_no = mysqli_num_rows($res_4);

		if($t_no > 0) {

			$total = 0; //금일주문총액

			for($i=0; $row = mysqli_fetch_array($res_4); $i++){
				//주문소스 추출
				$os = substr($row['orderid'], 0, 1);

				if($os == "m")
					$os_icon = "<img src=\"../images/smartphone.png\">"; 
				else
					$os_icon ="";
			
				//회원정보
				$sql = "SELECT * FROM member WHERE id='$row[user_id]' ";
				$res = mysqli_query($connect, $sql);
				$trow = mysqli_fetch_array($res);

				if($row['cancel'] == 'Y') {
					$c_color="data-icon=\"delete\""; 
					$status_now="주문취소";
					//$o_total -= $row['amount'];
					$total -= $row['last_amount']; //취소에 따른 합계금액차감
		?>
      <li>
	        <?php

				 if($row['recipient_name']) {
				 	echo "<h1>".$os_icon.$row['createdate']."</h1>\n";
					echo "<p>".$row['buyer_name']." -> (".$row['recipient_name'].")</p>\n";
				 }else {
					echo "<h1>".$row['createdate']."</h1>\n";
					echo "<p>".$row['buyer_name']."</p>\n";
				 }
					
				 if($row['supplement'])
				 	echo "<span class=\"ui-li-count\">1</span>";	
				?>
      </li>
      <?php
				}else { 
					if($row['status']=='1'){
						$c_color="arrow-r"; 
						$theme = "a";
						$status_now="미처리";
					} else if ($row['status']=='3'){ 
						$c_color="arrow-r";
						$theme = "a";
						$status_now="미처리";
					} else if($row['status']=='5'){
						$c_color="edit";
						$theme = "b";
						$status_now="주문확인";
					} else if ($row['status']=='7'){ 
						$c_color="check";
						$theme = "e";
						$status_now="포장완료";
					} else if ($row['status']=='8'){ 
						$c_color="star";
						$theme = "c";
						$status_now="발송완료";
					} else if ($row['status']=='0'){ 
						$c_color="info";
						$theme = "d";
						$status_now="발송지연";
					} 
			
	
?>
      <li data-theme="<?=$theme?>" data-icon="<?=$c_color?>">
        <?php

			 if($row['recipient_name']) {
			 	echo "<a href=\"m_or_view.php?mode=".$mode."&amp;oid=".$row['num']."&amp;key=".$key."&amp;key_value=".$key_value."&amp;page=".$page."\"><h1>".$os_icon." ".$row['createdate']."</h1>\n";
				echo "<p>".$row['buyer_name']." -> (".$row['recipient_name'].")</p></a>\n";
			 }else{
				echo "<a href=\"m_or_view.php?mode=".$mode."&amp;oid=".$row['num']."&amp;key=".$key."&amp;key_value=".$key_value."&amp;page=".$page."\"><h1>".$os_icon." ".$row['createdate']."</h1>\n";
				echo "<p>".$row['buyer_name']."</p></a>\n";
			 }
			 
			if($row['supplement'])
				echo "<span class=\"ui-li-count\">1</span>\n";
			?>
      </li>
      <?php } // for loop end   
		}
		 ?>
    </ul>
    <?php }else { ?>
    <div>해당 주문내역이 없습니다.</div>
	    <?php 
	 } ?>

      <?php
		$url = "$PHP_SELF?mode=$mode&date1=$date1&date2=$date2&key=$key&key_value=$key_value"; 
    	page_mobile2($totalpage,$cpage,$url); 
	 ?>

  </div>
</div>
</body>
</html>