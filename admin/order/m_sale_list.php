<?php

//관리자 인증 파일
include "../../util/admin_auth.php";
// 데이타베이스 연결정보 및 기타설정
include "../../util/config.php";
// 각종 유틸함수
include "../../util/util.php";
include "../include/graph.php";
// MySQL 연결
$connect=my_connect($host,$dbid,$dbpass,$dbname);

?>
<!DOCTYPE HTML>
<html>
  <head>
  <meta charset="UTF-8">
  <title>B2B 모바일 관리자</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.css" />
  <link rel="stylesheet" href="../css/m_layout.css" />
  <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>  
  <script src="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.js"></script>

  </head>

  <body>
  <div data-role="page" data-theme="b">
    <div data-role="header" style="overflow:hidden;"> <a href="#" onClick="javascript:history.back(-1);" data-icon="arrow-l">뒤로</a>
      <h1>판매 현황</h1>
      <a href="../m.php" data-icon="home">홈</a> </div>
    <div data-role="content">
      <form name="f" method="get" action="m_sale_list.php">
        <input type="hidden" name="mode" value="date" />
        시작일 : <input type="date" name="date1" id="sd" value="" />
        종료일 : <input type="date" name="date2" id="ed" value="" />
        <input type="submit" value="검색" data-theme="e" />
      </form>
      <?php
$total = 0; //공급가합
$sales = array();

if($mode == "date") {
	$search_qry = " AND createdate BETWEEN '$date1' AND '$date2' ";
	$date = "(".$date1." ~ ".$date2.")";
}else {
	$today = date("Y-m-d");
	$search_qry = " AND createdate='$today' ";
	$date = "(".$today." ~ ".$today.")";
}

					
//1. 전체 주문을 구한다.
$sql = "SELECT * FROM mall_order WHERE cancel='N' AND status='8'  $search_qry ORDER BY num DESC";
$res = mysqli_query($connect, $sql);

	//2. 각 주문에서 제품코드를 구한다.
	for($i=0; $row = mysqli_fetch_array($res); $i++) {
		$a_goods_fk = explode(",", $row['goods_fk']);
		$mod_volume = explode(",", $row['mod_count']); //변경된 수량
		$mod_price = explode(",", $row['mod_price']); //변경된 수량
		$option = explode(",", $row['goods_kind']); //옵션정보
		
		//판매금액 집계를 위한 배열
		$sales[] = array(num=>$row['num'], createdate=>$row['createdate'], sub_total=>$row['last_amount']);	
		$total += $row['last_amount'];	
	
		//3. 해당 주문에서 해당 공급업체의 상품이 있는지 확인한다.
		for($j=0; $j<sizeof($a_goods_fk); $j++){
			$p_sql="SELECT * FROM products WHERE num='$a_goods_fk[$j]' ";
			$p_result = mysqli_query($connect, $p_sql);
			$p_row = mysqli_fetch_array($p_result);
			$p_no = mysqli_num_rows($p_result);
			
			//$offer_price = $p_row['retail_price'];
			$offer_price = $mod_price[$j];
			//$sub_total = $offer_price * $mod_volume[$j];
	
			$goods[] = array(num=>$p_row['num'], company=>$p_row['company'], name=>$p_row['name'], option=>$option[$j], quantity=>$mod_volume[$j]);	
			//$total += $sub_total;	
		}//for end
	}//for end

function cmp($a, $b)
{
	if ($a["quantity"] == $b["quantity"]) {
        return 0;
    }
    return ($a["quantity"] > $b["quantity"]) ? -1 : 1;
	
    //return strcmp($a["quantity"], $b["quantity"]);
}

if($p_no) {		
	foreach($goods as $values) {
		$new[$values['num']]['company'] = $values['company'];	
		$new[$values['num']]['name'] = $values['name'];	
		$new[$values['num']]['option'] = $values['option'];	
		$new[$values['num']]['quantity'] += $values['quantity'];
	} 
	
usort($new, "cmp");



	$i=0;
	foreach($new as $row) {
		if($i!=0) {
			$temp_qty .= ",";
			$temp_name .= ",";
		}
			$temp_qty .= $row['quantity'];
			$temp_name .= $row['name'];
		
		$i++;
	}
	
	?>
      <table>
        <thead>
          <tr>
            <th>번호</th>
            <th>판매일</th>
            <th>확정액 합(VAT 별도)</th>
          </tr>
        </thead>
        <tbody>
          <?php  

	foreach($sales as $key => $values) {
		$sum[$values['createdate']] += $values['sub_total']; 
	} 
	
    reset($sum);
	ksort($sum);
	
	$day = array("일","월","화","수","목","금","토");

	$i=0;
	foreach($sum as $date=>$sub_total) {
	?>
          <tr>
            <td><?=$i+1?></td>
            <td><?=$date?> (<?=$day[date("w",strtotime($date))]?>)</td>
            <td style="text-align:right;"><?=number_format($sub_total)?></td>
          </tr>
          <?php
		  
		if($i!=0) {
			$temp_createdate .= ",";
			$temp_total .= ",";
		}
			$temp_createdate .= $date;
			$temp_total .= $sub_total;
		
		$i++;
	}
	
	?>
            </tr>
          
          <tr>
            <td colspan="2"><strong>확정금액 총합:</strong></td>
            <td style="text-align:right;"><strong>
              <?=number_format($total)?>
              </strong></td>
          </tr>
        </tbody>
      </table>
      <?php         
} else {
?>
      <tr>
        <td colspan="4"><p>조회 결과가 없습니다.</p></td>
      </tr>
      </tbody>
      </table>
      <?php 
}
?>
    </div>
  </div>
</body>
</html>
