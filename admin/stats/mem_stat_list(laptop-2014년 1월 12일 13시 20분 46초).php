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
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko">
<head>
<title>B2B SCM</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="../css/admin_layout.css" />
<link rel="stylesheet" type="text/css" href="../chrometheme/chromestyle.css" />
<script language="JavaScript" src="../../js/global.js" type="text/javascript"></script>
<script language="JavaScript" src="../js/admin.js" type="text/javascript"></script>
<script language="JavaScript" src="../js/chrome.js" type="text/javascript">
/***********************************************
* Chrome CSS Drop Down Menu- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/
</script>
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
      <?php
switch ($mode) {
	case 	'date' :
	$query = "SELECT * FROM member, mall_order 
	          				  WHERE (mall_order.cancel = 'N') 
			  				  AND (member.id='$id') 
			  				  AND (mall_order.user_id='$id') 
			  				  AND (mall_order.status = '8' )
			  				  AND mall_order.createdate BETWEEN  '$date1' AND '$date2'
			   				  ORDER BY mall_order.num DESC ";
	break;
	default :
	$query = "SELECT * FROM member, mall_order 
	          				  WHERE (mall_order.cancel = 'N') 
			  				  AND (member.id='$id') 
			  				  AND (mall_order.user_id='$id') 
			  				  AND (mall_order.status = '8' )
			   				  ORDER BY mall_order.num DESC ";								  
}

$result = mysqli_query($connect, $query);
$total = mysqli_num_rows($result);

/*
$scale=30;

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
*/	
?>
      <fieldset class="info">
        <legend><img src="../images/info.png" alt="안내" /> 사용방법</legend>
        <ul>
          <li style="text-align:left">정산할 날짜 범위를 검색해 정산금액을 확인합니다.</li>
          <li style="text-align:left">실정산액합계가 맞다면, 발행일을 입력합니다. </li>
          <li style="text-align:left">결제여부를 선택한 후 등록합니다.</li>
          <li style="text-align:left">발행한 세금계산서는 상단의 [정산관리]->[계산서 발행목록]에서 확인가능합니다.</li>
          <li style="text-align:left"><font style="background-color:#FBAFFF; color:black;">배경색</font>이 다른 경우 반품회수 정산입니다.</li>          
        </ul>
      </fieldset>
      <form name="stat" method="get" action="mem_stat_list.php">
        <input type="hidden" name="mode" value="date" />
        <input type="hidden" name="id" value="<?=$id?>" />
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
          <div class="clear"><a class="button" href="javascript:document.stat.submit()" onclick="this.blur();"><span>찾 기</span></a></div>
        </fieldset>
      </form>
      <form name="reg" method="post" action="reg_tax.php">
        <input type="hidden" name="id" value="<?=$id?>" />
        <table summary="member list">
          <caption>
          개별업체 정산리스트 (
          <?=number_format($total)?>
          건 )<br />
          (배송 완료된 건에 대해서만 출력됩니다.)
          </caption>
          <thead>
            <tr class="odd">
              <th scope="col">번호</th>
              <th scope="col">주문일</th>
              <th scope="col">업체명(구매자명)</th>
              <th scope="col">품목</th>
              <th scope="col">주문액<br />
                (NET)</th>
              <th scope="col">실정산액<br />
                (NET)</th>
              <th scope="col">상세내용</th>
            </tr>
          </thead>
          <!--
          <tfoot>
            <tr>
              <td colspan="7" height="40" align="center" class="text"><?php
	 $url = "$PHP_SELF?mode=$mode&id=$id&date1=$date1&date2=$date2"; 
 	 page_avg($totalpage,$cpage,$url); 
   ?>
                &nbsp; </td>
            </tr>
          </tfoot>
          -->
          <tbody>
            <?php		
switch ($mode) {
	case 	'date' :
  	$sql_2 = "SELECT * FROM member, mall_order WHERE (mall_order.cancel = 'N') AND (member.id='$id') AND (mall_order.user_id='$id') AND (mall_order.status = '8' OR mall_order.status = '-1' ) AND mall_order.createdate BETWEEN  '$date1' AND '$date2' ORDER BY mall_order.num DESC ";
  	break;
	default :
  	$sql_2 = "SELECT * FROM member, mall_order WHERE (mall_order.cancel = 'N') AND (member.id='$id') AND (mall_order.user_id='$id') AND (mall_order.status = '8' OR mall_order.status = '-1' ) ORDER BY mall_order.num DESC ";								  
}

  $result_2 = mysqli_query($connect, $sql_2);
	$total_2 = mysqli_num_rows($result_2);

	if($total_2 == 0) {
?>
            <tr>
              <td colspan="7"><p>정산할 내역이 없습니다.</p></td>
            </tr>
            <?php
    }else {    		
 	
	for($i=1; $list = mysqli_fetch_array($result_2); $i++){

		$or_sql = "SELECT * FROM mall_order WHERE num = '$list[num]' ";
		$or_res = mysqli_query($connect, $or_sql);
		$or_row = mysqli_fetch_array($or_res);

		$a_goods_fk = explode(",", $or_row['goods_fk']);
		
		$pro_sql="SELECT * FROM products WHERE num='$a_goods_fk[0]'";
  	$pro_result = mysqli_query($connect, $pro_sql);
   	$pro_row = mysqli_fetch_array($pro_result);

		//$goods_name= shortenStr($pro_row['name'],30);
		$goods_name = cut_string_utf8($pro_row['name'],30,'...');
		
      
	   $bunho = $total - ( $i + $cline) + 1; 
	   
      if($i%2 == 0)
	      echo "<tr class=\"odd\">\n";
      elseif ($or_row['status']=="-1") {
        echo "<tr bgcolor=\"#FBAFFF\">\n";
      }
		  
 ?>
          <td><?=$bunho?></td>
            <td><?=$list['createdate']?></td>
            <td><?=$list['company_name']." (".$list['buyer_name'].")"?></td>
            <td class="left"><?=$goods_name?>
              (외)</td>
            <td class="won"><?=number_format($list['amount'])?>
              </td>
            <td class="won"><?php
			/*
			    $t_res = mysqli_query($connect, 'SELECT d_charge FROM misc_setup');
				$t_row = mysqli_fetch_array($t_res);
									  
				if($list['last_amount'] < 100000 and $or_row['delivery_type'] == 'L' ) {
					$tax_amount = $list['last_amount']-$t_row['d_charge'];
					echo number_format($tax_amount);
				} else {
					$tax_amount = $list['last_amount'];
				    echo number_format($tax_amount);
				}
				*/
				$tax_amount = $list['last_amount'];
				echo number_format($tax_amount);
			?>
              </td>
            <td><a href='../order/or_view.php?oid=<?=$list['num']?>&amp;page=<?=$page?>&from=stats&id=<?=$id?>'> <img src="../images/details.gif" alt="주문내역 보기" /> </a></td>
          </tr>
          <?php
	    $goods_name = $goods_name." (외)";	
		$tot_amount = $tot_amount + (int)$tax_amount;
	}
	
	
    mysqli_free_result($result_2);
  ?>
          <tr>
            <td colspan="5"><strong>실정산액 합계:</strong></td>
            <td class="won"><strong>
              <?=number_format($tot_amount)?>
              </strong></td>
            <td></td>
          </tr>
          <?php
		  }
		  ?>
            </tbody>
          
        </table>
        <fieldset>
          <legend>정산등록</legend>
          <p>
            <label for="reg_date">발행일 :</label>
            <input type="text" class="w8em format-y-m-d divider-dash highlight-days-67 range-low-2008-01-01 no-transparency" name="reg_date" id="reg_date"  value="" size="10" />
            <br />
            <label for="paid">결제여부 :</label>
            <input type="radio" name="paid" value="Y" checked />
            영수
            <input type="radio" name="paid" value="N" />
            청구
            <input type="hidden" name="sum" value="<?=$tot_amount?>" />
            <input type="hidden" name="goods_name" value="<?=$goods_name?>" />
          </p>
          <div class="clear"><a class="button" href="javascript:document.reg.submit()" onclick="this.blur();"><span>등록</span></a></div>
        </fieldset>
      </form>
      <table summary="page nav">
        <tbody>
          <tr>
            <td><div class="clear"><a class="button" href="top_stat_list.php" onclick="this.blur();"><span>정산 목록</span></a></div></td>
          </tr>
        </tbody>
      </table>
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
