<?php include_once '../include/header.php';?>

<?php

$mode    = set_var($_GET['mode']);
$key     = set_var($_GET['key']);
$keyword = set_var($_GET['keyword']);
?>
	<body>
	  <section id="container" >
	      <!--header start-->
	      <?php include_once "../include/admin_head.php";?>
	      <!--header end-->

	      <!--sidebar start-->
	      <?php include_once "../include/admin_sidebar.php";?>
	      <!--sidebar end-->

		<!--main content start-->
		<section id="main-content">
			<section class="wrapper">

				<!-- info start-->
				<div class="row">
		        	<div class="col-sm-12">
						<section class="panel">
							<header class="panel-heading">
							  사용방법
							</header>
							<ul class="info-body">
							  <li><i class="fa fa-info-circle"></i> 재고 부족 등으로 수량을 변경할 때에만 수량 입력 후 [변경] 버튼을 누르세요.</li>
							  <li><i class="fa fa-info-circle"></i> 특별히 공급가를 변경할 필요가 있을 때에만 공급가 입력 후 [변경] 버튼을 누르세요.</li>
							  <li><i class="fa fa-info-circle"></i> 배송지는 구매자의 주소를 확인하시고, 수령자란에 내용이 있는 경우에는 해당 주소로 발송하세요.</li>
							  <li><i class="fa fa-info-circle"></i> 구매자나 수령자의 주소가 제주도 등 도선료가 추가될 경우 붉은 배경색으로 표시됩니다.</li>
							  <li><i class="fa fa-info-circle"></i> 상품명을 클릭할 경우 상품정보 수정창이 나타납니다.</li>
							  <li><i class="fa fa-info-circle"></i> 상품이미지를 클릭할 경우 사이트의 상품 페이지를 엽니다.</li>
							</ul>
		                </section>
					</div>
				</div>
				<!-- info end -->

<?php

$oid = set_var($_GET['oid']);

$sql = "SELECT * FROM mall_order WHERE num = '$oid' ";
$res = mysqli_query($connect, $sql);
$row = mysqli_fetch_array($res);

$today = date("Y-m-d H:i:s");

//$com = explode(",", $row['company_name']);
$a_goods_fk = explode(",", $row['goods_fk']);
$org_price  = explode(",", $row['goods_price']);
$mod_price  = explode(",", $row['mod_price']);
$org_volume = explode(",", $row['goods_count']); //주문수량
$mod_volume = explode(",", $row['mod_count']);   //변경된 수량
$option     = explode(",", $row['goods_kind']);  //옵션정보

$tot_amount = 0;
$org_amount = 0;
$t_count    = 0;
$mt_count   = 0;

$page = set_var($_GET['page']);
?>

				<!-- order list start -->
				<div class="row">
		            <div class="col-sm-12">
						<section class="panel">
							<header class="panel-heading table-head">
							    주문 상세내역 (							                         							                         							                         							                         							                         							                         							                         							                         							                         							                         							                         							                         							                         							                         							                         							                         							                         							                         							                         							                         							                         							                         							                         							                          <?php echo $oid; ?> )
						  	</header>
						  	<div class="panel-body">

							<form class="form-inline" role="form" name="or_update_order" method="post" action="or_update_order.php">
							<input type="hidden" name="oid" value="<?php echo $oid; ?>" />
							<input type="hidden" name="page" value="<?php echo $page; ?>" />
							<div class="table-responsive">
							<table class="table table-striped">
								<thead>
									<tr>
										<th>이미지</th>
										<th>상품명</th>
										<th>주문수량</th>
										<th>수량변경</th>
										<th>공급가</th>
										<th>공급가변경</th>
										<th>공급가합</th>
									</tr>
								</thead>
								<tbody>

<?php

//물건 정보를 불러옵니다.
for ($i = 0; $i < sizeof($a_goods_fk); $i++) {
    $pro_sql    = "SELECT * FROM products WHERE num='$a_goods_fk[$i]'";
    $pro_result = mysqli_query($connect, $pro_sql);
    $pro_row    = mysqli_fetch_array($pro_result);

    //$goods_name= cut_string_utf8($pro_row['name'],30, "...");
    $goods_name = $pro_row['name'];
    $img_char   = $pro_row['s_image1_name'];

    //상품옵션 품절표시
    //상품 옵션이 있는지 확인 후 진행
    if ($option[$i] != "") {
                                                            //장바구니의 옵션과 제품정보를 비교하여 품절옵션이 있는지 확인
        $t_opt       = explode(",", $pro_row['opt']);       //제품의 옵션명을 배열로 만들어준다
        $t_opt_stock = explode(",", $pro_row['opt_stock']); //제품의 옵션재고를 배열로 만들어준다

        //옵션의 문자열 비교
        for ($j = 0; $j < count($t_opt); $j++) {
            $str = strcmp($t_opt[$j], $option[$i]);

            if (!$str) {
                //문자열이 같다면 문자열 대체
                if ($t_opt_stock[$j] == "0") {
                    $option[$i] .= " (품절)";
                } elseif ($t_opt_stock[$j] == "-1") {
                    $option[$i] .= " (단종)";
                } else {
                    $option[$i] = $t_opt[$j];
                }

            }

        } //end of for loop
    }
    ; //end of if clause
    ?>

									<tr>
										<td>
									  		<a href="http://<?php echo $_SERVER['SERVER_NAME']; ?>/shop/detail.php?pnum=<?php echo $pro_row['num']; ?>&amp;lcode=<?php echo $pro_row['category_l']; ?>&amp;mcode=<?php echo $pro_row['category_m']; ?>&amp;scode=<?php echo $pro_row['category_s']; ?>" target="_blank"><img src="<?php echo $img_char; ?>" width="50" height="50"></a>
									  	</td>
									  	<td><div class="brand">[<?php echo $pro_row['company']; ?>]</div>
										  <?php echo show_icon($pro_row['num']); ?> &nbsp;<a href="" onclick="javascript:open_win('edit_pro.php?oid=<?php echo $oid; ?>&amp;p_num=<?php echo $pro_row['num']; ?>&amp;lcode=<?php echo $pro_row['category_l']; ?>&amp;mcode=<?php echo $pro_row['category_m']; ?>','nwin','scrollbars=yes,resizable=yes, width=800,height=650');"><?php echo stripslashes($goods_name); ?></a>
<?php

    if ($option[$i]) {
        echo "<p>[" . $option[$i] . "]</p>\n";
    }

    ?>
										</td>

<?php

    if ($org_volume[$i] > 1) {
        echo "<td><strong>" . $org_volume[$i] . "</strong></td>\n";
    } else {
        echo "<td>" . $org_volume[$i] . "</td>\n";
    }
    ?>
										<td>
											<input type="text" class="form-control" name="mod_volume[]" size="5" value="<?php echo $mod_volume[$i]; ?>" />&nbsp;<input class="form-control" type="submit" value="변경" />
										</td>

<!--
<?php

    if ($pro_row['sale_price']) {
        echo "<td><s>" . number_format($pro_row['retail_price']) . "</s> 원<br/>" . number_format($pro_row['sale_price']) . " 원\n";
    } else {
        echo "<td>" . number_format($pro_row['retail_price']) . " 원\n";
    }

    if ($pro_row['fixed_price']) {
        echo "<td><img src=\"../images/lock.png\" alt=\"고정공급가\">" . number_format($org_price[$i]) . " 원<br>(" . number_format((1 - ($org_price[$i] / $pro_row['retail_price'])) * 100) . "% ↓)</td>\n";
    } else {
        echo "<td>" . number_format($org_price[$i]) . " 원<br>(" . number_format((1 - ($org_price[$i] / $pro_row['retail_price'])) * 100) . "% ↓)</td>\n";
    }
    ?> -->
										<td>
											<?php echo number_format($org_price[$i]); ?> 원<br>(<?php echo number_format((1 - ($org_price[$i] / $pro_row['retail_price'])) * 100); ?> % ↓)
										</td>
										<td>
											<input type="text" class="form-control" name="mod_price[]" size="5" value="<?php echo $mod_price[$i]; ?>"/>&nbsp;<input class="form-control" type="submit" value="변경" />
										</td>

<?php

    $sub_amount = (int) $mod_volume[$i] * (int) $mod_price[$i];
    //$sub_amount = number_format($sub_amount);
    ?>

										<td><?php echo number_format($sub_amount); ?> 원</td>
									</tr>

<?php

    $tot_amount = $tot_amount + ((int) $mod_price[$i] * (int) $mod_volume[$i]);
    $org_amount = $org_amount + ((int) $org_price[$i] * (int) $org_volume[$i]);
    $t_count    = $t_count + (int) $org_volume[$i];
    $mt_count   = $mt_count + (int) $mod_volume[$i];

} // end of for loop

$trans_cost = trans_cal($tot_amount, $connect);
// $last_cost = $tot_amount + $row['trans_cost'];
$last_cost = $tot_amount;

if ($row['trans_cost'] != "0") {
    $amount_o            = $tot_amount + $row['trans_cost'];
    $amount_order_detail = " ( " . $tot_amount . " 원 + " . $row['trans_cost'] . " 원 ) ";
} else {
    $amount_o = $tot_amount;
}

//$tot_amount = number_format($tot_amount);

//배송정책 가져옴
$query4  = "SELECT * FROM misc_setup WHERE id='admin' ";
$result4 = mysqli_query($connect, $query4);
$misc    = mysqli_fetch_array($result4);

?>
							</form>
                  <tr>
                    <td colspan="2">택배비 :</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><i class="fa fa-krw"></i> <?php echo number_format($row['trans_cost']); ?> <i class="fa fa-plus-circle"></i></td>
                  </tr>
									<tr>
									  <td colspan="2">▶ TOTAL</td>
									  <td><?php echo $t_count; ?> 개</td>
										<td><?php echo $mt_count; ?> 개</td>
										<!-- <td></td> -->
										<td></td>
										<td></td>
									 	<td><i class="fa fa-krw"></i> <?php echo number_format($amount_o); ?></td>
									</tr>

<?php

//$last_cost2 = $row['delivery_cost'] + $row['ship_cost']; //최종입력될 가격
// $final = $last_cost + $last_cost2;
$final = $last_cost;
?>
 									<tr>
 						    			<td colspan="8" ><i class="fa fa-envelope"></i> 배송 시 요청사항: <span><?php echo nl2br($row['memo_to_delivery']); ?></span>
 						    			<p class="margin-top-10"><i class="fa fa-envelope"></i> 담당자에게 요청사항:  <span><?php echo nl2br($row['memo_to_admin']); ?></span></p></td>
 									</tr>
	 						 	</tbody>
	 						</table>
	 						</div>
					     </div>
						</section>
					</div>
				</div>
				<!-- order list end -->


				<!-- buttons start -->
				<div class="row">
					<div class="col-sm-12">
					<div class="table-responsive">
						<table class="table">
							<tbody>
								<tr>
									<td colspan="9" class="text-center">
										<a class="btn btn-primary" href="top_order_list.php?mode=<?php echo $mode; ?>&amp;oid=<?php echo $oid; ?>&amp;key=<?php echo $key; ?>&amp;keyword=<?php echo $keyword; ?>&amp;page=<?php echo $page; ?>">주문 목록</a>
										<a class="btn btn-default" href="" onclick="javascript:open_win('print_quot.php?oid=<?php echo $oid; ?>','nwin','scrollbars=yes,resizable=yes,width=685');"><i class="fa fa-print"></i> 명세서 출력</a>
										<a class="btn btn-default" href="quottoexcel.php?oid=<?php echo $oid; ?>"><i class="fa fa-file-excel-o"></i> 엑셀로 명세서 다운로드</a>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					</div>
				</div>
				<!-- buttons end -->

<?php

if ($row['payment_type'] == 1) {$payment_type = "무통장 입금";}
if ($row['payment_type'] == 2) {$payment_type = "신용카드";}
if ($row['payment_type'] == 2) {$payment_type = "휴대폰 결제";}

$a_status['0'] = '<i class="fa fa-exclamation-triangle"></i> 발송지연';
$a_status['3'] = '<i class="fa fa-circle"></i> 미처리 주문';
$a_status['5'] = '<i class="fa fa-check-circle"></i> 주문확인';
$a_status['7'] = '<i class="fa fa-cube"></i> 포장완료';
$a_status['8'] = '<i class="fa fa-truck"></i> 발송완료(' . $row['senddate'] . ')';

//도서신간지역 구분
// $bg = check_zipno($row['recipient_zipcode'], $row);

?>

				<!-- order list start -->
				<div class="row">
		            <div class="col-sm-12">
						<section class="panel">
							<header class="panel-heading table-head">
							    주문번호							                							                							                							                							                							                							                							                							                							                							                							                							                							                							                							                							                							                							                							                							                							                							                							                 <?php echo $row['orderid']; ?> (주문일시 :<?php echo $row['createdate']; ?>)
						  	</header>
						  	<div class="panel-body">
						  		<div class="table-responsive">
								<table class="table">
								<tbody>
								  <tr>
								    <th width="15%">구매자(<?php echo $row['user_id']; ?>)
								    	<!-- <p><img src="../images/12.gif" /><a href="../member/new_msg.php?mode=reply&amp;id=<?php echo $row['user_id']; ?>" target="_blank">[쪽지 보내기]</a></p> -->
								    </th>
								    <td
								    	<ul>
								        	<li><?php echo $row['buyer_name']; ?></li>
								        	<li><?php echo $row['buyer_zipcode']; ?></li>
								        	<li><?php echo $row['buyer_address']; ?></li>
								        	<li><?php echo $row['buyer_phone']; ?></li>
								        	<li><?php echo $row['buyer_hphone']; ?></li>
								     	</ul>
								     </td>
								    <th>수령자</th>
								    <td width="25%">
								    	<ul>
								        	<li><?php echo $row['recipient_name']; ?></li>
								        	<li><?php echo $row['recipient_zipcode']; ?></li>
								        	<li><?php echo $row['recipient_address']; ?></li>
								        	<li><?php echo $row['recipient_hphone']; ?></li>
								        	<li><?php echo $row['recipient_phone']; ?></li>
								      	</ul>
								     </td>
								  </tr>
								  <tr>
								    <th>결제방법</th>
								    <td  colspan="3">
<?php

$pg_info    = get_pg_info($row['orderid']);
$pay_status = $pg_info['pay_status'];

$qry   = "SELECT * FROM member WHERE id='$row[user_id]' ";
$res   = mysqli_query($connect, $qry);
$mrows = mysqli_fetch_array($res);

// switch ($mrows['payment_day']) {
//     case "1":
//         echo "당일 결제";
//         break;
//     case "2":
//         echo "당월 말";
//         break;
//     case "3":
//         echo "익월 5일";
//         break;
//     case "4":
//         echo "익월 10일";
//         break;
//     case "5":
//         echo "익월 15일";
//         break;
//     case "6":
//         echo "익월 20일";
//         break;
//     case "7":
//         echo "익월 25일";
//         break;
//     case "8":
//         echo "익월 말";
//         break;
//     case "9":
//         echo "기타";
//         break;
// }

if ($pg_info['pay_type'] == "WIRE" || $pg_info['pay_type'] == "BANK") {
    if ($pg_info['apply_receipt'] != '0' && $pg_info['apply_receipt'] != '1') {
        echo '<p><i class="fa fa-print" aria-hidden="true"></i> 현금영수증 미발행</p>';
    } else {
        echo '<p><i class="fa fa-print" aria-hidden="true"></i> 현금영수증 발급됨</p>';
    }
}

echo $pay_status;

// 결제수단 상세내역 보여주기
show_pay_data($row['orderid']);

//영수증 출력버튼
// retrieve PG data
$pg_sql    = "SELECT * FROM pg_info WHERE LGD_OID='$row[orderid]' ";
$pg_result = mysqli_query($connect, $pg_sql);
$pg_row    = mysqli_fetch_array($pg_result);

$print_receipt = '';

// if ($row['status'] == '8') {
if ($pg_row['LGD_RESPCODE'] == '0000') {

    $authdata = md5($pg_row['LGD_MID'] . $pg_row['LGD_TID'] . $MERTKEY);

    if ($pg_row['LGD_PAYTYPE'] == "SC0010") {
        //신용카드 결제일 때
        $print_receipt = '<a href="javascript:showReceiptByTID(\'' . $pg_row['LGD_MID'] . '\', \'' . $pg_row['LGD_TID'] . '\', \'' . $authdata . '\')"><i class="fa fa-print"></i> 카드전표 출력</a>';
    } elseif ("SC0030" == $pg_row['LGD_PAYTYPE']) {
                                //계좌이체일 때
        $seqno         = "t/t"; //계좌이체는 임의의 정보 입력
        $print_receipt = '<a href="javascript:showCashReceipts(\'' . $pg_row['LGD_MID'] . '\',\'' . $pg_row['LGD_OID'] . '\',\'' . $seqno . '\',\'BANK\',\'' . $CST_PLATFORM . '\')"><i class="fa fa-print"></i> 영수증 출력</a>';
    } elseif ("SC0040" == $pg_row['LGD_PAYTYPE']) {
        $seqno         = $pg_row['LGD_CASSEQNO'];
        $print_receipt = '<a href="javascript:showCashReceipts(\'' . $pg_row['LGD_MID'] . '\',\'' . $pg_row['LGD_OID'] . '\',\'' . $seqno . '\',\'CAS\',\'' . $CST_PLATFORM . '\')"><i class="fa fa-print"></i> 영수증 출력</a>';
    }

    echo $print_receipt;
}

?>
                                    </td>
								  </tr>
								  <tr>
								    <th>관리자 메모<br /><p>(★ 자동 저장됨) </p></th>
								    <td  colspan="3">
										<textarea name="add_memo" class="form-control" style="width:50%;height:50px;"><?php echo $row['supplement']; ?></textarea>
								    </td>
								  </tr>
								  <tr>
								    <th>주문금액</th>
								    <td>
								    	<?php echo number_format($amount_o); ?> 원 (VAT 포함) <br />
								    </td>
<!-- 								    <th>확정금액</th>
								    <td  colspan="3">
<?php

if ($row['status'] == '7' || $row['status'] == '8') {
    echo '<strong><font color="#AE3E0D">' . number_format($final) . ' 원 (VAT 포함)</font></strong>' . "\r\n";

} else {
    echo "<strong>최종 입금금액을 산출 중입니다.</strong>";
}
?>
                    </td> -->
								  </tr>
								  <tr>
								    <th rowspan="2">배송상태</th>
								    <td  colspan="3"><div class="loading"><?php echo $a_status[$row['status']]; ?></div> (상태변경은 아래에서 하세요.)</td>
								  </tr>
								  <tr>
								    <td colspan="3">

								      	<form class="form-inline" role="form" name="form0" method="post" action="or_changed.php" style="display: inline-block;">
									        <input type="hidden" name="mode" id="mode0" value="orderConfirm" />
									        <input type="hidden" name="oid" id="oid0" value="<?php echo $oid; ?>" />
									        <input type="hidden" name="key" value="<?php echo $key; ?>" />
									        <input type="hidden" name="keyword" value="<?php echo $keyword; ?>" />
									        <input type="hidden" name="page" value="<?php echo $page; ?>" />
									        <input type="hidden" name="status" value="<?php echo $row['status']; ?>" />
									        <input type="hidden" name="sms" value="<?php echo $mrows['sms']; ?>" />
                                            <input type="hidden" name="reUrl" value="<?php echo urlencode($_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING']); ?>" />
									    	<button id="check" class="form-control" type="submit" onclick="return confirm('주문을 확인처리 하시겠습니까?')"><i class="fa fa-check-circle"></i> 주문확인</button>
								    	</form>

								      <form class="form-inline" role="form" name="form1" method="post" action="or_changed.php" style="display: inline-block;">
								        <input type="hidden" name="mode" id="mode1" value="packingDone" />
								        <input type="hidden" name="oid" id="oid1" value="<?php echo $oid; ?>" />
								        <input type="hidden" name="key" value="<?php echo $key; ?>" />
								        <input type="hidden" name="keyword" value="<?php echo $keyword; ?>" />
								        <input type="hidden" name="page" value="<?php echo $page; ?>" />
								        <input type="hidden" name="status" value="<?php echo $row['status']; ?>" />
								        <input type="hidden" name="last_amount" id="last_amount1" value="<?php echo $final; ?>" />
								        <input type="hidden" name="sms" value="<?php echo $mrows['sms']; ?>" />
								        <input type="hidden" name="buyer_hphone" value="<?php echo $row['buyer_hphone']; ?>" />
								        <input type="hidden" name="buyer_name" value="<?php echo $row['buyer_name']; ?>" />
								        <input type="hidden" name="delivery_type" value="<?php echo $row['delivery_type']; ?>" />
                                        <input type="hidden" name="reUrl" value="<?php echo urlencode($_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING']); ?>" />
								        <button id="pack" class="form-control" type="submit" onclick="return confirm('포장 완료처리 하시겠습니까?')"><i class="fa fa-cube"></i> 포장완료</button>
								      </form>

									<form class="form-inline" role="form" name="form2" method="post" action="or_changed.php" style="display: inline-block;">
								        <input type="hidden" name="mode" id="mode2" value="delay" />
								        <input type="hidden" name="oid" id="oid2" value="<?php echo $oid; ?>" />
								        <input type="hidden" name="key" value="<?php echo $key; ?>" />
								        <input type="hidden" name="keyword" value="<?php echo $keyword; ?>" />
								        <input type="hidden" name="page" value="<?php echo $page; ?>" />
								        <input type="hidden" name="status" value="<?php echo $row['status']; ?>" />
								        <input type="hidden" name="last_amount" id="last_amount2" value="<?php echo $final; ?>" />
								        <input type="hidden" name="sms" value="<?php echo $mrows['sms']; ?>" />
								        <input type="hidden" name="buyer_hphone" value="<?php echo $row['buyer_hphone']; ?>" />
								        <input type="hidden" name="buyer_name" value="<?php echo $row['buyer_name']; ?>" />
								        <input type="hidden" name="delivery_type" value="<?php echo $row['delivery_type']; ?>" />
                                        <input type="hidden" name="reUrl" value="<?php echo urlencode($_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING']); ?>" />
								      	<button id="delay" class="btn btn-warning"  onclick="return confirm('발송이 지연됩니까?')"><i class="fa fa-exclamation-triangle"></i> 발송지연</button>
									</form>
									<p>

								      <form class="form-inline" role="form" name="form3" method="post" action="or_changed.php"  style="display: inline-block;">
								        <input type="hidden" name="mode" id="mode3" value="sent" />
								        <input type="hidden" name="oid" id="oid3" value="<?php echo $oid; ?>" />
								        <input type="hidden" name="key" id="key3" value="<?php echo $key; ?>" />
								        <input type="hidden" name="keyword" id="keyword3" value="<?php echo $keyword; ?>" />
								        <input type="hidden" name="page" id="page3" value="<?php echo $page; ?>" />
								        <input type="hidden" name="status" value="<?php echo $row['status']; ?>" />
								        <input type="hidden" name="last_amount" id="last_amount3" value="<?php echo $final; ?>" />
                                        <input type="hidden" name="reUrl" value="<?php echo urlencode($_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING']); ?>" />
								        <input type="hidden" name="senddate" value="<?php echo $row['status'] == '8' ? $row['senddate'] : $today; ?>" />
								         운송장 번호
								        <input type="text" class="form-control" name="track_no" id="track_no" value="<?php echo $row['track_no']; ?>" size="50" />
								        &nbsp;
								        <button id="send" class="btn btn-success" type="submit" onclick="return confirm('운송장번호를 입력하셨습니까?')"><i class="fa fa-truck"></i> 발송완료</button>&nbsp;<i class="fa fa-calendar"></i>&nbsp;<input type="text" class="form-control" name="senddate" id="senddate" value="<?php echo $row['status'] == '8' ? $row['senddate'] : $today; ?>" size="10" />
								        <p class="help-block"><i class="fa fa-exclamation-triangle"></i> 여러 개 운송장 입력 시 구분은 ',(콤마)'로 분리하세요 </p>
								      </form>
<?php

if ($row['status'] == "8" || $row['status'] == "-1" && $row['delivery_type'] == "L") {
    //택배사 정보
    // $log_sql    = "SELECT * FROM misc_setup";
    // $log_result = mysqli_query($connect, $log_sql);
    // $log_row    = mysqli_fetch_array($log_result);

    // //운송장번호 분리
    // $t_no_arr = explode(",", $row['track_no']);
    echo '<p class="help-block">(<i class="fa fa-exclamation-circle"></i> 상품추적 : ' . show_logistics();

    // for ($i = 0; $i < count($t_no_arr); $i++) {
    //     //운송장번호 '-' 제거
    //     $t_no = preg_replace("/-/", "", $t_no_arr[$i]);
    //     echo "<a href=\"#\" onClick=\"javascript:TrackInfo(" . $t_no . ");\">" . $t_no . " </a> ";
    // }

    echo show_track_no($oid) . ' )</p>';
}
?>
									</p>

									</td>
								  </tr>
								</tbody>
							</table>
							</div>
					     </div>
						</section>
					</div>
				</div>
				<!-- order list end -->

				<!-- buttons start -->
				<div class="row">
					<div class="col-sm-12">
						<div class="table-responsive">
						<table class="table">
							<tbody>
								<tr>
								<td colspan="9" class="text-center">
									<a class="btn btn-primary" href="top_order_list.php?mode=<?php echo $mode; ?>&amp;oid=<?php echo $oid; ?>&amp;key=<?php echo $key; ?>&amp;keyword=<?php echo $keyword; ?>&amp;page=<?php echo $page; ?>">주문 목록</a>
								</td>
								</tr>
							</tbody>
						</table>
						</div>
					</div>
				</div>
				<!-- buttons end -->


          </section>
      </section>
      <!--main content end-->

      <!--footer start-->
	  <?php include_once "../include/admin_footer.php";?>
      <!--footer end-->

    <script src="/admin/js/jquery-ui.min.js"></script>
    <script src="/admin/js/jq_datepicker.js" ></script>
  	<script>
  		 $("textarea").keyup(function() {
  		 	 $.post("add_memo.php", {
  		 	 	add_memo:$("textarea").val(),
  		 	 	oid:"<?php echo $oid; ?>",
  		 	 	key:"<?php echo $key; ?>",
  		 	 	keyword:"<?php echo $keyword; ?>",
  		 	 	page:"<?php echo $page; ?>"
  		 	 });
  		 });
  	</script>
    <script language="JavaScript" src="https://pgweb.tosspayments.com/WEB_SERVER/js/receipt_link.js"></script>
  </body>
</html>

