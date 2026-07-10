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
$sql = "SELECT * FROM mall_order WHERE num = '$oid' ";
$res = mysqli_query($connect, $sql);
$row = mysqli_fetch_array($res);

$a_goods_fk = explode(",", $row['goods_fk']);
$org_price = explode(",", $row['goods_price']);
$mod_price = explode(",", $row['mod_price']);
$org_volume = explode(",", $row['goods_count']); //주문수량
$mod_volume = explode(",", $row['mod_count']); //변경된 수량
$option = explode(",", $row['goods_kind']); //옵션정보

$temp .= "<form name=\"or_update_order\" method=\"post\" action=\"or_update_order.php\">
                <input type=\"hidden\" name=\"oid\" value=\"$oid\" />
				<input type=\"hidden\" name=\"page\" value=\"$page\" />
				<table summary=\"view order list\" class=\"order_detail\">
				<caption>주문 상세내역</caption>
				<thead>
					<tr>	
						<th scope=\"col\" class=\"member\" >이미지</th>
						<th scope=\"col\" class=\"member\" >상품명</th>
						<th scope=\"col\" class=\"member\" >옵션</th>
						<th scope=\"col\" class=\"member\" >주문수량</th>
						<th scope=\"col\" class=\"member\" >수량변경</th>						
						<th scope=\"col\" class=\"member\" >소비자가</th>						
						<th scope=\"col\" class=\"member\" >공급가</th>
						<th scope=\"col\" class=\"member\" >공급가변경</th>
						<th scope=\"col\" class=\"member\" >공급가합</th>
					</tr>
				</thead>
				<tbody>";

$pro_row = array();

 //물건 정보를 불러옵니다.
for($i=0; $i<sizeof($a_goods_fk); $i++){
   $pro_sql="SELECT * FROM products WHERE num='$a_goods_fk[$i]'";
   $pro_result = mysqli_query($connect, $pro_sql);
   $t_row=mysqli_fetch_array($pro_result);	
   
   $pro_row[$i]=$t_row;
   $pro_row[$i]['org_price'] = $org_price[$i];
   $pro_row[$i]['mod_price'] = $mod_price[$i];
   $pro_row[$i]['org_volume'] = $org_volume[$i];
   $pro_row[$i]['mod_volume'] = $mod_volume[$i];
   $pro_row[$i]['option'] = $option[$i];
}


function cmp($a, $b)
{
    return strcmp($a["id"], $b["id"]);
}

usort($pro_row, "cmp");
?>
<!--
<pre>
<?php
print_r($pro_row);
?>
</pre>
-->
<?php

for($i=0;$i<sizeof($pro_row); $i++){
	$goods_name = $pro_row[$i]['name'];
	$img_char = $pro_row[$i]['s_image_name'];
	
	 //상품옵션 품절표시
	 //상품 옵션이 있는지 확인 후 진행
	 if($pro_row[$i]['opt'] != "") {			 
		 //장바구니의 옵션과 제품정보를 비교하여 품절옵션이 있는지 확인
		 $t_opt = explode(",", $pro_row[$i]['opt']); //제품의 옵션명을 배열로 만들어준다
		 $t_opt_stock = explode(",", $pro_row[$i]['opt_stock']); //제품의 옵션재고를 배열로 만들어준다		 
		 
		 //옵션의 문자열 비교
		 for($j=0;$j<count($t_opt);$j++) {
			$str = strcmp($t_opt[$j], $pro_row[$i]['option']);
			
			if(!$str) { //문자열이 같다면 문자열 대체
				if($t_opt_stock[$j] == "0")
					$pro_row[$i]['option'] .= " (품절)";
				elseif($t_opt_stock[$j] == "-1")
					$pro_row[$i]['option'] .= " (단종)";
				else
					$pro_row[$i]['option'] = $t_opt[$j];
			}
		 }//end of for loop
	 }//end of if clause   	
   
	$temp .= "
			<tr>\n
			  <td><a href=\"http://www.".$_SERVER['SERVER_NAME']."/shop/detail.php?pnum=$pro_row[$i][num]&amp;lcode=$pro_row[$i][category_l]&amp;mcode=$pro_row[$i][category_m]&amp;scode=$pro_row[$i][category_s]\" target=\"_blank\"><img src=\"".$img_char."\" width=\"50\" height=\"50\"></a></td>\n
			  <td class=\"left\"><div class=\"brand\">[".$pro_row[$i]['company']."]</div>";
	

$temp .= show_icon($pro_row[$i])."&nbsp;<a href=\"#\" onclick=\"javascript:open_win('edit_pro.php?oid=$oid&amp;p_num=$pro_row[$i][num]&amp;lcode=$pro_row[$i][category_l]&amp;mcode=$pro_row[$i][category_m]&amp;scode=$pro_row[$i][category_s]','nwin','scrollbars=yes,resizable=yes, width=800,height=650');\">".stripslashes($goods_name)."</td>\n
			  <td>"; 

/*
	if($option[$i]) 
		$temp .= "$option[$i]"; */

	if($pro_row[$i]['opt']) 
		$temp .= $pro_row[$i]['option'];
	
	$temp .="</td>\n";
			  
	if($pro_row[$i]['org_volume'] > 1)
		$temp .= "<td><font color=\"red\"><strong>".$pro_row[$i]['org_volume']."</strong></font></td>\n";
	else 
	    $temp .= "<td>".$pro_row[$i]['org_volume']."</td>\n";
				
	$temp .= "<td><input class=\"num\" type=\"text\" name=\"mod_volume[]\" size=\"5\" value=\"".$pro_row[$i]['mod_volume']."\"/>&nbsp;<input type=\"submit\" value=\"변경\" /></td>\n";
			  
	if ($pro_row[$i]['sale_price']) {
		$temp .= "<td class=\"won\"><s>".number_format($pro_row[$i]['retail_price'])."</s>\n".number_format($pro_row[$i]['sale_price'])." 원\n";
	}else {
		$temp .= "<td class=\"won\">".number_format($pro_row[$i]['retail_price'])." 원\n";
	}
			  
   if($pro_row[$i]['fixed_price']) { 		
   		$temp .= "<td class=\"won\"><img src=\"../images/lock.png\" alt=\"고정공급가\">".number_format($pro_row[$i]['org_price'])." 원</td>\n";	 
   }else {
		$temp .= "<td class=\"won\">".number_format($pro_row[$i]['org_price'])." 원</td>\n";   
   }
			  
	$temp .="<td class=\"won\"><input class=\"num\" type=\"text\" name=\"mod_price[]\" size=\"5\" value=\"".$pro_row[$i]['mod_price']."\"/>&nbsp;<input type=\"submit\" value=\"변경\" /></td>\n";		  
	
			  $sub_amount = (int)$pro_row[$i]['mod_volume'] * (int)$pro_row[$i]['mod_price'];
			  $sub_amount = number_format($sub_amount);		  
			  
	$temp .= "<td class=\"won\">$sub_amount 원</td>
				   </tr>";
		
	$tot_amount = $tot_amount + ((int)$mod_price[$i] * (int)$pro_row[$i]['mod_volume']);
	$org_amount = $org_amount + ((int)$org_price[$i] * (int)$pro_row[$i]['org_volume']);
	$t_count = $t_count + (int)$pro_row[$i]['org_volume'];
	$mt_count = $mt_count + (int)$pro_row[$i]['mod_volume'];
	
}
 
 $trans_cost = trans_cal($tot_amount, $connect); 
// $last_cost = $tot_amount + $row['trans_cost'];
$last_cost = $tot_amount;
 
 if($row['trans_cost'] != "0"){
   $amount_o = $tot_amount + $row['trans_cost'];
   $amount_temp = " ( $tot_amount 원 + $row[trans_cost] 원 ) ";
 }
 else{
   $amount_o = $tot_amount;
 }

 //$tot_amount = number_format($tot_amount);
 
   //배송정책 가져옴
$query4 = "SELECT * FROM misc_setup WHERE id='admin' ";
$result4 = mysqli_query($connect, $query4);
$misc = mysqli_fetch_array($result4);

 $temp .= "
    <tr>\n
        <td colspan=\"3\" class=\"left\">▶ SUB TOTAL</td>\n
		<td><font color='blue'>$t_count</font>개</td>\n
		<td><font color='blue'>$mt_count</font>개</td>\n";
		
		if($tot_amount >=$misc['min_sum']) 
				 $t_str .= "<strong><font color=\"#AE3E0D\">".
                number_format($last_cost)."&nbsp;원 (VAT : ".number_format($last_cost*0.1)."원)</font><br/>(배송비 무료)</strong>";
		else 	
				 $t_str .= "<strong><font color=\"#AE3E0D\">".
                number_format($last_cost)."&nbsp;원(VAT : ".number_format($last_cost*0.1)."원)</font><br/>(착불)</strong>";
                				
 $temp .= "<td colspan=\"4\">".$t_str."</td>\n
 				 </tr>\n";
				 
 $temp .= "				 
	<tr>\n
        <td colspan=\"5\" class=\"left\">▶ TOTAL</td>\n
		<td colspan=\"4\"><strong><font color=\"#AE3E0D\">".number_format($last_cost*1.1)."&nbsp;원 (VAT 포함)</font></strong>\n
	</tr>
 </tbody>\n
	</table>\n
	 </form>\n";

if($row['payment_type']==1) { $payment_type = "무통장 입금"; }
if($row['payment_type']==2) { $payment_type = "신용카드"; }
if($row['payment_type']==2) { $payment_type = "휴대폰 결제"; }


$a_status['3'] = "<img src='../images/new_red.gif' />미처리 주문"; 
$a_status['5'] = "<img src='../images/order_state_mini_2.gif' />주문확인"; 
$a_status['7'] = "<img src='../images/order_state_mini_3.gif' alt='포장완료' />포장완료"; 
$a_status['8'] = "<img src='../images/order_state_mini_4.gif' alt='발송완료' />발송완료"; 

//도서신간지역 구분
$bg = check_zipno($zipno, $row);

/*
$zipno1 = explode('-', $row['buyer_zipno']);
if($row['recipient_zipno'])
	$zipno2 = explode('-', $row['recipient_zipno']);

if($zipno1[0] == "690" || $zipno1[0] == "695" || $zipno1[0] == "697" || $zipno1[0] == "699") // 제주도
	$bg1 = "bgcolor = \"#FFC8C8\" ";
if($zipno2[0] == "690" || $zipno2[0] == "695" || $zipno2[0] == "697" || $zipno2[0] == "699") // 제주도
	$bg2 = "bgcolor = \"#FFC8C8\" ";
	*/
	
?>
      <fieldset class="info">
        <legend><img src="../images/info.png" alt="안내" /> 사용방법</legend>
        <ul>
          <li style="text-align:left">재고 부족 등으로 수량을 변경할 때에만 수량 입력 후 [변경] 버튼을 누르세요.</li>
          <li style="text-align:left">특별히 공급가를 변경할 필요가 있을 때에만 공급가 입력 후 [변경] 버튼을 누르세요.</li>
          <li style="text-align:left">배송지는 구매자의 주소를 확인하시고, 수령자란에 내용이 있는 경우에는 해당 주소로 발송하세요.</li>
          <li style="text-align:left">구매자나 수령자의 주소가 제주도 등 도선료가 추가될 경우 붉은 배경색으로 표시됩니다.</li>                    
        </ul>
      </fieldset>
      <table summary="view order detail">
        <thead>
          <tr>
            <th colspan="2">주문
              <?=$oid?>
            </th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td colspan="2"><?=$temp?></td>
          </tr>
          <tr>
            <td colspan="2"><div class="full"><a class="button" href="javascript:open_win('print_quot.php?oid=<?=$oid?>','nwin','scrollbars=yes,resizable=yes');" onclick="this.blur();"><span>명세서 출력</span></a><a class="button" href="top_order_list.php?mode=<?=$mode?>&amp;key=<?=$key?>&amp;key_value=<?=$key_value?>&amp;page=<?=$page?>" onclick="this.blur();"><span>주문 목록</span></a><img src="../images/excel_icon.gif" width="16" height="16" alt="excel" /><a href="quottoexcel.php?oid=<?=$oid?>">명세서 엑셀로 다운로드</a></div></td>
          </tr>
          <tr class="odd">
            <th scope="row" class="column1">주문번호</th>
            <td class="order"><?=$row['orderid']?>
              (주문일 :
              <?=$row['createdate']?>
              )</td>
          </tr>
          <tr <?=$bg[0]?>>
            <th scope="row" class="column1">구매자(
              <?=$row['user_id']?>
              )</th>
            <td class="order"> 업체명 :
              <?=$row['buyer_name']?>
              <br/>
              우편번호 :
              <?=$row['buyer_zipno']?>
              <br/>
              배송주소 :
              <?=$row['buyer_address']?>
              <br/>
              연락번호 :
              <?=$row['buyer_phone']?>
              <br/>
              담당자 휴대폰 :
              <?=$row['buyer_hphone']?>
              <!--
              <br/>
              담당자 e-mail : <a href='mailto:<?=$row['buyer_email']?>'> (메일 전송)▶
              <?=$row['buyer_email']?>
              </a>
              -->
              </td>
          </tr>
          <tr <?=$bg[1]?>>
            <th scope="row" class="column1">수령자</th>
            <td class="order">수령자명 :
              <?=$row['recipient_name']?>
              <br/>
              우편번호 :
              <?=$row['recipient_zipno']?>
              <br/>
              배송주소 :
              <?=$row['recipient_address']?>
              <br/>
              연락번호 :
              <?=$row['recipient_phone']?>
              <br/>
              휴대폰 :
              <?=$row['recipient_hphone']?></td>
          </tr>
          <tr>
            <th scope="row" class="column1">결제방법 / 결제일</th>
            <td class="order"><?=$payment_type?>
              /
              <?php 
			  	$qry = "SELECT * FROM member WHERE id='$row[user_id]' ";
				$res = mysqli_query($connect, $qry);
				$mrows = mysqli_fetch_array($res);
			  
				switch ($mrows['payment_day']) {
					case "1" :
						echo "당일 결제";
						break;
					case "2" :
						echo "당월 말";
						break;						
					case "3" :
						echo "익월 5일";
						break;
					case "4" :
						echo "익월 10일";
						break;
					case "5" :
						echo "익월 15일";
						break;
					case "6" :
						echo "익월 20일";
						break;
					case "7" :
						echo "익월 25일";
						break;
					case "8" :
						echo "익월 말";
						break;
					case "9" :
						echo "기타";
						break;
				}
			?></td>
          </tr>
          <tr class="odd">
            <th scope="row" class="column1">배송방법</th>
            <td class="order"><?php
            	switch ($row['delivery_type']) {
                	case "L":
						echo "<strong>택배</strong>";
                        break;
                    case "D":
						echo "<strong>방문수령</strong>";
						break;
                    case "Q":
						echo "<font color='red'><strong>퀵서비스 (긴급배송건입니다.)</strong> </font>";
						break;
                  }
            ?></td>
          </tr>
          <tr>
            <th scope="row" class="column1">배송시 요청사항</th>
            <td class="order"><font color="#AE3E0D">
              <?=nl2br($row['memo'])?>
              </font></td>
          </tr>
          <tr class="odd">
            <th scope="row" class="column1">관리자 메모</th>
            <td class="order">
              <form name="add_memo" method="post" action="add_memo.php">
                <input type="hidden" name="oid" value="<?=$oid?>" />
                <textarea name="add_memo" style="width:80%"><?=$row['supplement']?></textarea>
                <input type="submit" value="메모하기" style="vertical-align:top" />
              </form>
             </td>
          </tr>
          <tr>
            <th scope="row" class="column1">주문금액</th>
            <td class="order"><?=number_format($row['amount']*1.1)?>
              원 (VAT 포함) =
              <?=number_format($row['amount'])?>
              +
              <?=number_format($row['amount']*0.1)?>
              (VAT)
              <?=$trans_cost>0 ? "(착불)" : "(배송비 무료)"?>
              <br />
              <span class="column1">적립금 사용</span> (
              <?=number_format($row['mileage_use'])?>
              원 )<br />
              <span class="column1">적립금 적립</span> (
              <?=number_format($row['mileage_add'])?>
              원 ) </td>
          </tr>
          <tr class="odd">
            <th scope="row" class="column1">확정금액</th>
            <td class="order"><?php 
				if($row['status'] == '7' || $row['status'] == '8') {
					if($tot_amount >= (int)$misc['min_sum']) 
						echo "<strong><font color=\"#AE3E0D\">".
                    	number_format($last_cost*1.1)."&nbsp;원 (VAT 포함)</font> = ".number_format($last_cost)." + ".number_format($last_cost*.1)."(VAT)&nbsp;(배송비 무료)</strong>\n";
					else 	
						echo "<strong><font color=\"#AE3E0D\">".
                    	number_format($last_cost*1.1)."&nbsp;원 (VAT 포함) = ".number_format($last_cost)." + ".number_format($last_cost*0.1)."(VAT)</font>&nbsp;(착불 또는 선결제 시 배송비: ".number_format($misc['d_charge'])."원 별도)</strong>\n";
				}else {
					echo "<strong>최종 입금금액을 산출 중입니다.</strong>";
				}
            ?></td>
          </tr>
          <tr>
            <th rowspan="3" class="column1" scope="row">상태</th>
            <td class="order"><?php
				if($row['delivery_type'] == 'L') {
            ?>
              <input type="radio" name="trans_cost" <?php if($row['trans_cost'] == 0) echo("checked"); ?> onclick="d_change('d1', '<?=$oid?>', '<?=$key?>', '<?=$key_value?>', '<?=$page?>');" />
              선불&nbsp;
              <input type="radio" name="trans_cost" <?php if($row['trans_cost'] > 0) echo("checked"); ?> onclick="d_change('d2', '<?=$oid?>', '<?=$key?>', '<?=$key_value?>', '<?=$page?>');" />
              착불&nbsp;
              <input type="radio" name="trans_cost" <?php if($row['trans_cost'] < 0) echo("checked"); ?> onclick="d_change('d3', '<?=$oid?>', '<?=$key?>', '<?=$key_value?>', '<?=$page?>');" />
              합포장(운송장 출력안됨)&nbsp; <font color="#FF0000">(택배비 설정 전에 금액 등을 반드시 확인하시기 바랍니다.)</font>
              <?php
				}else {
              		echo "택배가 아닙니다.";
				}
				?></td>
          </tr>
          <tr>
            <td class="order"><?=$a_status[$row['status']]?>
              (상태변경은 아래에서 하세요.)</td>
          </tr>
          <tr class="odd">
            <td class="order"><form name="form" method="get" action="or_changed.php">
                <input type="hidden" name="mode" value="2" />
                <input type="hidden" name="oid" value="<?=$oid?>" />
                <input type="hidden" name="key" value="<?=$key?>" />
                <input type="hidden" name="key_value" value="<?=$key_value?>" />
                <input type="hidden" name="page" value="<?=$page?>" />
                <input type="hidden" name="status" value="<?=$row['status']?>" />
                <input type="hidden" name="last_amount" value="<?=$last_cost?>" />
                <input type="hidden" name="sms" value="<?=$mrows['sms']?>" />
                <input type="hidden" name="buyer_hphone" value="<?=$row['buyer_hphone']?>" />
                <input type="hidden" name="buyer_name" value="<?=$row['buyer_name']?>" />
                <input type="hidden" name="delivery_type" value="<?=$row['delivery_type']?>" />
                <img src="/admin/images/order_state_mini_2.gif" /><a href="or_changed.php?mode=1&amp;oid=<?=$oid?>&amp;status=<?=$row['status']?>" onclick="return confirm('주문확인 하셨습니까?')">주문확인</a> <img src="/admin/images/arrow_collapse.gif" /> <img src="/admin/images/order_state_mini_3.gif" /><a href="javascript:document.form.submit()" onclick="return confirm('포장이 완료되었습니까?\n확정된 금액으로 입력됩니다.')">포장완료</a>
              </form>
              <form name="form1" method="get" action="or_changed.php">
                <input type="hidden" name="mode" value="3" />
                <input type="hidden" name="oid" value="<?=$oid?>" />
                <input type="hidden" name="key" value="<?=$key?>" />
                <input type="hidden" name="key_value" value="<?=$key_value?>" />
                <input type="hidden" name="page" value="<?=$page?>" />
                <input type="hidden" name="status" value="<?=$row['status']?>" />
                <input type="hidden" name="last_amount" value="<?=$last_cost?>" />
                <img src="/admin/images/arrow_collapse.gif" /> <img src="/admin/images/order_state_mini_4.gif" />운송장 번호
                <input type="text" name="track_no" value="<?=$row['track_no']?>" />
                &nbsp;<a href="javascript:document.form1.submit()" onclick="return confirm('운송장번호를 입력하셨습니까?')">발송완료</a>
              </form>
              <?php
			  	if($row['status'] == "8" && $row['delivery_type'] == "L") {
					//택배사 정보
					$log_sql="SELECT * FROM misc_setup";
					$log_result = mysqli_query($connect, $log_sql);
					$log_row = mysqli_fetch_array($log_result);
					
					//운송장번호 '-' 제거
					$tracking_no =  preg_replace("/-/","",$row['track_no']);
					echo "(<img src=\"../images/warning.gif\" alt=\"주의\" />상품추적 : ".$log_row['logistics']." 택배 <a href=\"#\" onClick=\"javascript:TrackInfo(".$tracking_no.");\">".$tracking_no." </a>)";
				}
				?></td>
          </tr>
          <?
   //무통장 입금시만 출력
   if($row['payment_type']=='1'){
   ?>
          <tr>
            <th scope="row" class="column1">입금은행명</th>
            <td class="order"><?=$row['bank']?>
              (입금자:
              <?=$row['account']?>
              / 입금예정일 :
              <?=$row['deposit_date']?>
              )</td>
          </tr>
          <?
   }
  ?>
        </tbody>
      </table>
      <table summary="back to list">
        <tr>
          <td height='25'><div class="clear"><a class="button" href="top_order_list.php?mode=<?=$mode?>&amp;key=<?=$key?>&amp;key_value=<?=$key_value?>&amp;page=<?=$page?>" onclick="this.blur();"><span>주문 목록</span></a></div></td>
        </tr>
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
