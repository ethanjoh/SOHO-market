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
<script language="JavaScript" src="../../js/global.js" ></script>
<script language="JavaScript" src="../js/admin.js" ></script>
<script language="JavaScript" src="../js/chrome.js" >
/***********************************************
* Chrome CSS Drop Down Menu- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/
</script>
<!-- popup calendar -->
<script type="text/javascript" src="../js/datepicker.js"></script>
<link href="../css/datepicker.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
//<![CDATA[

/*
        A "Reservation Date" example using two datePickers
        --------------------------------------------------

        * Functionality

        1. When the page loads:
                - We clear the value of the two inputs (to clear any values cached by the browser)
                - We set an "onchange" event handler on the startDate input to call the setReservationDates function
        2. When a start date is selected
                - We set the low range of the endDate datePicker to be the start date the user has just selected
                - If the endDate input already has a date stipulated and the date falls before the new start date then we clear the input's value

        * Caveats (aren't there always)

        - This demo has been written for dates that have NOT been split across three inputs

*/

function makeTwoChars(inp) {
        return String(inp).length < 2 ? "0" + inp : inp;
}

function initialiseInputs() {
        // Clear any old values from the inputs (that might be cached by the browser after a page reload)
        //document.getElementById("sd").value = "";

        // Add the onchange event handler to the start date input
        datePickerController.addEvent(document.getElementById("sd"), "change", setReservationDates);
}

var initAttempts = 0;

function setReservationDates(e) {
        // Internet Explorer will not have created the datePickers yet so we poll the datePickerController Object using a setTimeout
        // until they become available (a maximum of ten times in case something has gone horribly wrong)

        try {
                var sd = datePickerController.getDatePicker("sd");
        } catch (err) {
                if(initAttempts++ < 10) setTimeout("setReservationDates()", 50);
                return;
        }

        // Check the value of the input is a date of the correct format
        var dt = datePickerController.dateFormat(this.value, sd.format.charAt(0) == "m");

        // If the input's value cannot be parsed as a valid date then return
        if(dt == 0) return;

        // At this stage we have a valid YYYYMMDD date

}

function removeInputEvents() {
        // Remove the onchange event handler set within the function initialiseInputs
        datePickerController.removeEvent(document.getElementById("sd"), "change", setReservationDates);
}

datePickerController.addEvent(window, 'load', initialiseInputs);
datePickerController.addEvent(window, 'unload', removeInputEvents);

//]]>
</script>
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
$sql = "SELECT * FROM mall_order WHERE num = '$oid' ";
$res = mysqli_query($connect, $sql);
$row = mysqli_fetch_array($res);

$a_goods_fk = explode(",", $row['goods_fk']);
$org_price = explode(",", $row['goods_price']);
$mod_price = explode(",", $row['mod_price']);
$org_volume = explode(",", $row['goods_count']);
$mod_volume = explode(",", $row['mod_count']);
$option = explode(",", $row['goods_kind']); //옵션정보

$temp .= "<form name='update_order' method='post' action='or_update_order.php'>
                <input type='hidden' name='oid' value='$oid' />
				<input type='hidden' name='page' value='$page' />
				<input type='hidden' name='from' value='quot' />
				<table summary='view order list' class='order_detail'>
				<caption>주문내역(<img src='../images/warning.gif' alt='주의' />수량이나 공급가를 변경할 때만 변경버튼을 누르세요.)</caption>
				<thead>
					<tr>	
						<th scope='col' class='member'>이미지</th>
						<th scope='col' class='member'>상품명</th>
						<th scope='col' class='member'>옵션</th>
						<th scope='col' class='member'>주문수량</th>
						<th scope='col' class='member'>수량변경</th>						
						<th scope='col' class='member'>소비자가</th>
						<th scope='col' class='member'>공급가변경</th>						
						<th scope='col' class='member'>합</th>
					</tr>
				</thead>
				<tbody>";

 //물건 정보를 불러옵니다.
for($i=0; $i<sizeof($a_goods_fk); $i++){
   $pro_sql="SELECT * FROM products WHERE num='$a_goods_fk[$i]'";
   $pro_result = mysqli_query($connect, $pro_sql);
   $pro_row = mysqli_fetch_array($pro_result);

   //$goods_name= shortenStr($pro_row['name'],30);
   $goods_name= $pro_row['name'];
   $img_char = $pro_row['s_image_name'];

$temp .= "
		<tr>\n
		  <td><img src='$img_char' width='50' height='50'></td>\n
         <td class='member'><a href='http://www.".$_SERVER['SERVER_NAME']."/shop/detail.php?pnum=".$pro_row['num']."&amp;lcode=".$pro_row['category_l']."&amp;mcode=".$pro_row['category_m']."&amp;scode=".$pro_row['category_s']."' target='_blank'>[".$pro_row['company']."] ".$goods_name."</a><td>"; 
if($option[$i]) 
	$temp .= $option[$i];
else
	$temp .= "";
		  
$temp .= "</td>\n
		  <td>".$org_volume[$i]."</td>
		  <td><input class='num' type='text' name='mod_volume[]' size='5' value='".$mod_volume[$i]."' />&nbsp;<input type='submit' value='변경' /></td>		  
		  <td>".number_format($org_price[$i])." 원</td>\n
	  	  <td><input class='num' type='text' name='mod_price[$i]' size='5' value='".$mod_price[$i]."' />&nbsp;<input type='submit' value='변경' /></td>\n";		  

		  $sub_amount = (int)$mod_volume[$i] * (int)$mod_price[$i];
	  	  //$sub_amount = number_format($sub_amount);		  
		  
$temp .= "<td>".number_format($sub_amount)." 원</td>
		       </tr>";
	
	$tot_amount = $tot_amount + ((int)$mod_price[$i] * (int)$mod_volume[$i]);
	$org_amount = $org_amount + ((int)$org_price[$i] * (int)$org_volume[$i]);
	$t_count = $t_count + (int)$org_volume[$i];
	$mt_count = $mt_count + (int)$mod_volume[$i];
	
}
 
 $trans_cost = trans_cal($tot_amount, $connect); 
 $last_cost = $tot_amount + $trans_cost;
 
 if($trans_cost > 0){
   $amount_o = $tot_amount + $trans_cost;
   $amount_temp = " ( $tot_amount 원 + $trans_cost 원 ) ";
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
    <tr>
        <td colspan='3'>합계 : </td>
		<td><font color='blue'>$t_count</font>개</td>
		<td><font color='blue'>$mt_count</font>개</td>\n";

	if($tot_amount >=$misc['min_sum']) 
				 $str .= "<strong><font color=\"#AE3E0D\">".
                number_format($last_cost)."&nbsp;원</font><br/>(배송비 무료)</strong>";
		else 	
				 $str .= "<strong><font color=\"#AE3E0D\">".
                number_format($last_cost)."&nbsp;원</font><br/>(배송비: ".number_format($misc['d_charge'])."원 포함)</strong>";
				                				
 $temp .= "<td colspan=\"3\">".$str."</td>\n
 	   </tr>\n
	 </tbody>\n
	</table>\n
 </form>\n";

if($row['payment_type']==1) { $payment_type = "무통장 입금"; }
if($row['payment_type']==2) { $payment_type = "신용카드"; }
if($row['payment_type']==2) { $payment_type = "휴대폰 결제"; }


$a_status['3'] = "<img src='../images/flag_checked.gif' />미확인 주문"; 
$a_status['5'] = "<img src='../images/order_state_mini_2.gif' />주문확인"; 
$a_status['8'] = "<img src='../images/flag_checked.gif' />발송완료"; 
?>
      <table summary="view order detail">
        <caption>
        주문 상세내역
        <?=$oid?>
        </caption>
        <tbody>
          <tr>
            <td colspan="2"><?=$temp?></td>
          </tr>
          <tr>
            <td colspan="2"><div class="clear"><a class="button" href="javascript:open_win('print_note.php?oid=<?=$oid?>&from=quot','nwin','scrollbars=yes,resizable=yes');" onclick="this.blur();"><span>명세서 출력</span></a><a class="button" href="or_quot_list.php?page=<?=$page?>" onclick="this.blur();"><span>비회원 주문목록</span></a></div></td>
          </tr>
          <tr class="odd">
            <th scope="row" class="column1">주문번호</th>
            <td class="order"><?=$row['orderid']?>
              (주문일 :
              <?=$row['createdate']?>
              )</td>
          </tr>
          <tr>
            <th scope="row" class="column1">주문자(
              <?=$row['user_id']?>
              )</th>
            <td class="order"> 성명 :
              <?=$row['buyer_name']?>
              <br>
              우편번호 :
              <?=$row['buyer_zipno']?>
              <br>
              배송주소 :
              <?=$row['buyer_address']?>
              <br>
              전화번호 :
              <?=$row['buyer_phone']?>
              <br>
              휴대폰 :
              <?=$row['buyer_hphone']?>
              <br>
              e-mail : <a href='mailto:<?=$row['buyer_email']?>'> (메일 전송)▶
              <?=$row['buyer_email']?>
              </a></td>
          </tr>
          <tr>
            <th scope="row" class="column1">주문요청사항</th>
            <td class="order"><?=$row['memo']?></td>
          </tr>
          <tr class="odd">
            <th scope="row" class="column1">주문금액</th>
            <td class="order"><?=number_format($row['amount'])?>
              원
              <?=$trans_cost>0 ? "(배송비 별도)" : "(배송비 무료)"?></td>
          </tr>
          <tr>
            <th scope="row" class="column1"> 확정금액</th>
            <td class="order"><strong><font color="#AE3E0D">
              <?=number_format($last_cost)?>
              원</font></strong></td>
          </tr>
          <tr class="odd">
            <th rowspan="2" class="column1" scope="row">상태</th>
            <td class="order"><?=$a_status[$row['status']]?>
              (상태변경은 아래에서 하세요.)</td>
          </tr>
          <tr class="odd">
            <td class="order"><form name="form" method="get" action="or_quot_changed.php">
                <input type="hidden" name="mode" value="3" />
                <input type="hidden" name="oid" value="<?=$oid?>" />
                <input type="hidden" name="status" value="<?=$row['status']?>" />
                <input type="hidden" name="last_amount" value="<?=$sub_amount?>" />
                <img src="/admin/images/order_state_mini_2.gif" /><a href="or_quot_changed.php?mode=1&amp;oid=<?=$oid?>&amp;status=<?=$row['status']?>" onclick="return confirm('주문을 확인하셨습니까?')">주문 확인</a> <img src="/admin/images/arrow_collapse.gif" /> 운송장번호
                <input type="text" name="track_no" value="<?=$row['track_no']?>" size="20" />
                <img src="../images/flag_checked.gif" /><a href="javascript:document.form.submit()" onclick="return confirm('발송처리하시겠습니까?\n확정된 금액으로 입력됩니다.')">발송완료</a>
              </form></td>
          </tr>
        </tbody>
      </table>
      <table summary="back to list">
        <tr>
          <td height='25'><div class="clear"><a class="button" href="or_quot_list.php?page=<?=$page?>" onclick="this.blur();"><span>비회원 주문목록</span></a></div></td>
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
