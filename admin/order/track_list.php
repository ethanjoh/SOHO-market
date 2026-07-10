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
<!DOCTYPE html>
<html lang="ko">
<head>
<title>B2B SCM</title>
<meta charset="UTF-8" />
<link rel="stylesheet" href="../css/admin_layout.css" />
<script src="../../js/global.js" ></script>
<script src="../js/admin.js" ></script>
<!-- popup calendar -->
<script type="text/javascript" src="../js/datepicker.js"></script>
<link href="../css/datepicker.css" rel="stylesheet" type="text/css" />
<!-- popup calendar end -->
</head>
<body>
<!-- wrapper -->
<div id="wrapper"> 
  <!-- header -->
  <?php
  include "../include/admin_top.php";
  ?>
  <!-- header end -->
  <div id="bodyblock"> 
    <!-- contents -->
    <div id="content">
      <form action="track_list.php" name="f" method="post" >
      <?php
   $today = date("Y-m-d");
   	
	switch ($mode) {
	case 'search' :
		$sql_2="SELECT orderid FROM mall_order 
			   WHERE delivery_type = 'L'
			   AND cancel = 'N'
			   AND status = '7'
			   AND recipient_name = ''
			   AND $key LIKE '%$key_value%' ";
		break;
	case 'date' : 
		$sql_2 = "SELECT orderid FROM mall_order
		          WHERE cancel = 'N'
				  AND delivery_type = 'L'
				  AND status = '7'
				  AND recipient_name = ''
				  AND createdate BETWEEN '$date1' AND '$date2' ";
		break;
	default :
	   $sql_2 = "SELECT orderid FROM mall_order 
	   				  WHERE delivery_type = 'L'
					  AND cancel = 'N'
					  AND status = '7' 
					  AND recipient_name = '' ";	
	}
	
	$res_2 = mysqli_query($connect, $sql_2);
	$total = mysqli_num_rows($res_2);

   $scale=50;
   if ($page == ''){
      $page=1;
   }	    
   
   $cpage = intval($page);
   $totalpage = intval($total/$scale);
	
    if ($totalpage*$scale != $total)
  		$totalpage = $totalpage + 1;
        
    if ($cpage ==1) {
	  $cline = 0 ;
    } else {
 	  $cline = ($cpage*$scale) - $scale ;
    } 
        
     $limit=$cline+$scale;
       
     if ($limit >= $total) 
       	$limit=$total;

     $scale1 = $limit - $cline;
?>
      <form method="get" action="track_list.php">
        <input type="hidden" name="mode" value="date" />
        <fieldset>
          <legend>날짜 검색</legend>
          <p>
            <label for="sd">시작일 :</label>
            <input type="text" class="w8em format-y-m-d divider-dash highlight-days-67 range-low-2006-01-01 no-transparency" name="date1" id="sd" value="" size="10" />
          </p>
          <p>
            <label for="ed">종료일 :</label>
            <input type="text" class="w8em format-y-m-d divider-dash highlight-days-67 range-low-2006-01-01 no-transparency" name="date2" id="ed" value="" size="10" />
          </p>
          <input type="image" src="../images/search_btn.gif" style="background-color:#FFFFFF; border:none;vertical-align: middle; " />
        </fieldset>
      </form>
      <table summary="view the total order list">
        <caption>
        주문 목록 (총
        <?=number_format($total)?>
        건)
        </caption>
        <thead>
          <tr class="odd">
            <th class="member" scope="col">주문번호</th>
            <th class="member" scope="col">주문일</th>
            <th class="member" scope="col">업체명</th>
            <th class="member" scope="col">운송장번호</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <td colspan="4" align="center"><?php
	  						$url = "$PHP_SELF?mode=$mode&key=$key&key_value=$key_value"; 
      						page_avg($totalpage,$cpage,$url); 
						 ?></td>
          </tr>
          <tr>
            <td  colspan="4" align='center' ><form method="get" name="search" action="track_list.php">
                <select name='key'>
                  <option value='buyer_name'>업체명</option>
                  <option value='user_id'>아이디</option>
                </select>
                <input type='hidden' name='mode' value='search'>
                <input type='text' name='key_value' size='16'>
                <input type="image" src="../images/search_btn.gif" style="background-color:#FFFFFF; border:none;vertical-align: middle; " />
              </form></td>
          </tr>
        </tfoot>
        <tbody>
          <?php
switch ($mode) {
	case 'search' :
   		$sql_4 = "SELECT * FROM mall_order 
             WHERE $key LIKE '%$key_value%' 
			 AND recipient_name = ''
			 ORDER BY num DESC LIMIT $cline,$scale1 "; 
		break;
	case 'date' : 
		$sql_4 = "SELECT * FROM mall_order
		          WHERE cancel = 'N'
				  AND recipient_name = ''
				  AND createdate BETWEEN '$date1' AND '$date2' 
				  ORDER BY num DESC LIMIT $cline,$scale1 ";
		break;				
	default :
   		$sql_4 = "SELECT * FROM mall_order 
   		     		WHERE status = '7' 
					AND cancel = 'N'
					AND delivery_type = 'L'
					AND recipient_name = ''
             		ORDER BY num DESC LIMIT $cline,$scale1 "; 
}

$res_4 = mysqli_query($connect, $sql_4);
$t_no = mysqli_num_rows($res_4);

if($t_no > 0) {

	for($i=0; $row = mysqli_fetch_array($res_4); $i++){
	
	?>
          <tr bgcolor="<?=$c_color?>">
            <td><a href="or_view.php?mode=<?=$mode?>&amp;oid=<?=$row['num']?>&amp;key=<?=$key?>&amp;key_value=<?=$key_value?>&amp;page=<?=$page?>">
              <?=$row['orderid']?>
              </a></td>
            <td><?=$row['createdate']?></td>
            <td><?=$row['recipient_name'] ? $row['recipient_name'] : $row['buyer_name']?></td>
            <td><form name="form1" method="get" action="or_changed.php">
                <input type="hidden" name="mode" value="4" />
                <input type="hidden" name="oid" value="<?=$row['num']?>" />
                <input type="hidden" name="status" value="<?=$row['status']?>" />
                <input type="hidden" name="last_amount" value="<?=$row['last_amount']?>" />     
                <input type="hidden" name="senddate" value="<?=$today?>" />           
                <input type="text" name="track_no" value="<?=$row['track_no']?>" size="16" />
                &nbsp;
                <input type="submit" name="enter" value="발송" />
              </form>
              </td>
          </tr>
          <?php 
  } // for loop end
 ?>
          <?php
}else {
?>
          <tr>
            <td colspan="4"><p>송장입력이 완료되었거나 해당 주문내역이 없습니다.</p></td>
          </tr>
          <?php 
 } ?>
        </tbody>
      </table>
      </form>
    </div>
    <!-- contens end --> 
  </div>
  <!-- bodyblock end --> 
  <!-- copyright -->
  <?php
include "../include/admin_bottom.php";
?>
  <!-- copyright  end --> 
</div>
<!-- wrapper end -->
</body>
</html>
