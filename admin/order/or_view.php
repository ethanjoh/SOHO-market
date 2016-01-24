<?php

//관리자 인증 파일
include "../../util/admin_auth.php";
// 데이타베이스 연결정보 및 기타설정
include "../../util/config.php";
// 각종 유틸함수
include "../../util/util.php";
// MySQL 연결
$connect = my_connect($host, $dbid, $dbpass, $dbname);

//메타정보
$info_query = "SELECT * FROM admin_setup";
$info_res   = mysqli_query($connect, $info_query);
$info       = mysqli_fetch_array($info_res);

$sql_1       = "SELECT num FROM mall_order WHERE cancel='N' AND status='3' AND user_id <> 'guest' ";
$res_1       = mysqli_query($connect, $sql_1);
$unchk_total = mysqli_num_rows($res_1);

?>
<!DOCTYPE html>
<html lang="ko">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keyword" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel="shortcut icon" href="/favicon.ico">

    <title><?=$info['company_name'];?> :: 운영업체 관리자 홈</title>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.css" rel="stylesheet">
    <link href="/admin/css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="/css/font-awesome.min.css" rel="stylesheet" />

    <!-- Custom styles for this template -->
    <link href="/admin/css/style.css" rel="stylesheet">
    <link href="/admin/css/style-responsive.css" rel="stylesheet" />
    <link href="/admin/css/jquery-ui.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
  </head>

	<!-- <body onLoad=init();> -->
	<body>
	  <section id="container" >
	      <!--header start-->
	      <?php include "../include/admin_head.php";?>
	      <!--header end-->

	      <!--sidebar start-->
	      <?php include "../include/admin_sidebar.php";?>
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
							  <li><i class="fa fa-info-circle"></i> 반품처리방법 : 결제상태-[반품]에 체크하고, 배송상태-[반품회수]에 체크 및 날짜지정 후 [저장하기]</li>
							  <li><i class="fa fa-info-circle"></i> 상품명을 클릭할 경우 상품정보 수정창이 나타납니다.</li>
							  <li><i class="fa fa-info-circle"></i> 상품이미지를 클릭할 경우 사이트의 상품 페이지를 엽니다.</li>
							</ul>
		                </section>
					</div>
				</div>
				<!-- info end -->

		      <?php
$sql = "SELECT * FROM mall_order WHERE num = '$oid' ";
$res = mysqli_query($connect, $sql);
$row = mysqli_fetch_array($res);

$today = date("Y-m-d H:i:s");

//$com = explode(",", $row['company_name']);
$a_goods_fk = explode(",", $row['goods_fk']);
$org_price  = explode(",", $row['goods_price']);
$mod_price  = explode(",", $row['mod_price']);
$org_volume = explode(",", $row['goods_count']); //주문수량
$mod_volume = explode(",", $row['mod_count']); //변경된 수량
$option     = explode(",", $row['goods_kind']); //옵션정보
?>

				<!-- order list start -->
				<div class="row">
		            <div class="col-sm-12">
						<section class="panel">
							<header class="panel-heading table-head">
							    주문 상세내역 ( <?=$oid;?> )
						  	</header>
						  	<div class="panel-body">

							<form class="form-inline" role="form" name="or_update_order" method="post" action="or_update_order.php">
							<input type="hidden" name="oid" value="<?=$oid;?>" />
							<input type="hidden" name="page" value="<?=$page;?>" />
							<div class="table-responsive">
							<table class="table table-striped">
								<thead>
									<tr>
										<th>이미지</th>
										<th>상품명</th>
										<th>주문수량</th>
										<th>수량변경</th>
										<!-- <th>소비자가</th> -->
										<th>공급가</th>
										<th>공급가변경</th>
										<th>공급가합</th>
										<th>세액</th>
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
    $img_char   = $pro_row['s_image_name'];

    //상품옵션 품절표시
    //상품 옵션이 있는지 확인 후 진행
    if ($option[$i] != "") {
        //장바구니의 옵션과 제품정보를 비교하여 품절옵션이 있는지 확인
        $t_opt       = explode(",", $pro_row['opt']); //제품의 옵션명을 배열로 만들어준다
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
									  		<a href="http://<?=$_SERVER['SERVER_NAME'];?>/shop/detail.php?pnum=<?=$pro_row['num'];?>&amp;lcode=<?=$pro_row['category_l'];?>&amp;mcode=<?=$pro_row['category_m'];?>&amp;scode=<?=$pro_row['category_s'];?>" target="_blank"><img src="<?=$img_char;?>" width="50" height="50"></a>
									  	</td>
									  	<td><div class="brand">[<?=$pro_row['company'];?>]</div>
										  <?=show_icon($pro_row);?> &nbsp;<a href="" onclick="javascript:open_win('edit_pro.php?oid=<?=$oid;?>&amp;p_num=<?=$pro_row['num'];?>&amp;lcode=<?=$pro_row['category_l'];?>&amp;mcode=<?=$pro_row['category_m'];?>&amp;scode=<?=$pro_row['category_s'];?>','nwin','scrollbars=yes,resizable=yes, width=800,height=650');"><?=stripslashes($goods_name);?></a>
										<?php
if ($option[$i]) {
        echo "<p>" . $option[$i] . "</p>\n";
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
											<input type="text" class="form-control" name="mod_volume[]" size="5" value="<?=$mod_volume[$i];?>" />&nbsp;<input class="form-control" type="submit" value="변경" />
										</td>

<!-- 										<?php
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
											<?=number_format($org_price[$i]);?> 원<br>(<?=number_format((1 - ($org_price[$i] / $pro_row['retail_price'])) * 100);?> % ↓)
										</td>
										<td>
											<input type="text" class="form-control" name="mod_price[]" size="5" value="<?=$mod_price[$i];?>"/>&nbsp;<input class="form-control" type="submit" value="변경" />
										</td>

										<?php
$sub_amount = (int) $mod_volume[$i] * (int) $mod_price[$i];
    //$sub_amount = number_format($sub_amount);
    ?>

										<td><?=number_format($sub_amount);?> 원</td>
										<td><?=number_format($sub_amount * 0.1);?> 원</td>
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
									  	<td colspan="2">▶ SUB TOTAL</td>
									  	<td><?=$t_count;?> 개</td>
										<td><?=$mt_count;?> 개</td>
										<!-- <td></td> -->
										<td></td>
										<td></td>
									 	<td><?=number_format($last_cost);?> 원</td>
									 	<td><?=number_format($last_cost * 0.1);?> 원</td>
									</tr>

										<?php
//$last_cost2 = $row['delivery_cost'] + $row['ship_cost']; //최종입력될 가격
;?>

									<?php
// $final = $last_cost + $last_cost2;
$final = $last_cost;
?>

									<tr>
										<td colspan="7">▶ TOTAL (inc.VAT)</td>
										<td colspan="2"><?=number_format($final * 1.1);?> 원</td>
									</tr>

 									<tr>
 						    			<td colspan="2" >▶ 배송 시 요청사항 </td>
 							   			<td colspan="6" ><font color="#AE3E0D"><?=nl2br($row['memo']);?></font></td>
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
										<a class="btn btn-primary" href="top_order_list.php?mode=<?=$mode;?>&amp;oid=<?=$oid;?>&amp;key_value=<?=$key_value;?>&amp;page=<?=$page;?>">주문 목록</a>
										<a class="btn btn-default" href="" onclick="javascript:open_win('print_quot.php?oid=<?=$oid;?>','nwin','scrollbars=yes,resizable=yes,width=685');"><i class="fa fa-print"></i> 명세서 출력</a>
										<a class="btn btn-default" href="quottoexcel.php?oid=<?=$oid;?>"><i class="fa fa-file-excel-o"></i> 엑셀로 명세서 다운로드</a>
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

$a_status['0'] = "<i class=\"fa fa-exclamation-triangle\"></i> 발송지연";
$a_status['3'] = "<i class=\"fa fa-circle\"></i> 미처리 주문";
$a_status['5'] = "<i class=\"fa fa-check-circle\"></i> 주문확인";
$a_status['7'] = "<i class=\"fa fa-cube\"></i> 포장완료";
$a_status['8'] = "<i class=\"fa fa-truck\"></i> 발송완료(" . $row['senddate'] . ")";

//도서신간지역 구분
$bg = check_zipno($zipno, $row);

?>

				<!-- order list start -->
				<div class="row">
		            <div class="col-sm-12">
						<section class="panel">
							<header class="panel-heading table-head">
							    주문번호 <?=$row['orderid'];?> (주문일시 : <?=$row['createdate'];?>)
						  	</header>
						  	<div class="panel-body">
						  		<div class="table-responsive">
								<table class="table">
								<tbody>
								  <tr <?=$bg[0];?>>
								    <th>구매자(<?=$row['user_id'];?>)
								    	<!-- <p><img src="../images/12.gif" /><a href="../member/new_msg.php?mode=reply&amp;id=<?=$row['user_id'];?>" target="_blank">[쪽지 보내기]</a></p> -->
								    </th>
								    <td
								    	<ul>
								        	<li><?=$row['buyer_name'];?></li>
								        	<li><?=$row['buyer_zipno'];?></li>
								        	<li><?=$row['buyer_address'];?></li>
								        	<li><?=$row['buyer_phone'];?></li>
								        	<li><?=$row['buyer_hphone'];?></li>
								     	</ul>
								     </td>
								    <th>수령자</th>
								    <td <?=$bg[1];?>>
								    	<ul>
								        	<li><?=$row['recipient_name'];?></li>
								        	<li><?=$row['recipient_zipno'];?></li>
								        	<li><?=$row['recipient_address'];?></li>
								        	<li><?=$row['recipient_hphone'];?></li>
								        	<li><?=$row['recipient_phone'];?></li>
								      	</ul>
								     </td>
								  </tr>
								  <tr>
								    <th>결제조건</th>
								    <td  colspan="3">
								      <?php
$qry   = "SELECT * FROM member WHERE id='$row[user_id]' ";
$res   = mysqli_query($connect, $qry);
$mrows = mysqli_fetch_array($res);

switch ($mrows['payment_day']) {
    case "1":
        echo "당일 결제";
        break;
    case "2":
        echo "당월 말";
        break;
    case "3":
        echo "익월 5일";
        break;
    case "4":
        echo "익월 10일";
        break;
    case "5":
        echo "익월 15일";
        break;
    case "6":
        echo "익월 20일";
        break;
    case "7":
        echo "익월 25일";
        break;
    case "8":
        echo "익월 말";
        break;
    case "9":
        echo "기타";
        break;
}
?></td>
								  </tr>
								  <tr>
								    <th>관리자 메모<br /><p>(★ 자동 저장됨) </p></th>
								    <td  colspan="3">
										<textarea name="add_memo" class="form-control" style="width:50%;height:50px;"><?=$row['supplement'];?></textarea>
								    </td>
								  </tr>
								  <tr>
								    <th>주문금액</th>
								    <td>
								    	<?=number_format($row['amount'] * 1.1);?> 원 (VAT 포함) = <?=number_format($row['amount']);?> + <?=number_format($row['amount'] * 0.1);?>(VAT) <br />
								    </td>
								    <th>확정금액</th>
								    <td  colspan="3"><?php
if ($row['status'] == '7' || $row['status'] == '8') {
    echo "<strong><font color=\"#AE3E0D\">" .
    number_format($final * 1.1) . "&nbsp;원 (VAT 포함)</font> = " . number_format($final) . " + " . number_format($final * .1) . " (VAT)</strong>\n";

} else {
    echo "<strong>최종 입금금액을 산출 중입니다.</strong>";
}
?></td>
								  </tr>
								  <tr>
								    <th rowspan="2">배송상태</th>
<!-- 								  </tr>
								  <tr> -->
								    <td  colspan="3"><!--<?=$a_status[$row['status']];?>--> <div class="loading"><?=$a_status[$row['status']];?></div> (상태변경은 아래에서 하세요.)</td>
								  </tr>
								  <tr>
								    <td colspan="3">

								      	<form class="form-inline" role="form" name="form0" method="post" action="or_changed.php" style="display: inline-block;">
								        <input type="hidden" name="mode" id="mode0" value="1" />
								        <input type="hidden" name="oid" id="oid0" value="<?=$oid;?>" />
								        <input type="hidden" name="key" value="<?=$key;?>" />
								        <input type="hidden" name="key_value" value="<?=$key_value;?>" />
								        <input type="hidden" name="page" value="<?=$page;?>" />
								        <input type="hidden" name="status" value="<?=$row['status'];?>" />
								        <input type="hidden" name="last_amount" value="<?=$final;?>" />
								        <input type="hidden" name="sms" value="<?=$mrows['sms'];?>" />
								        <input type="hidden" name="buyer_hphone" value="<?=$row['buyer_hphone'];?>" />
								        <input type="hidden" name="buyer_name" value="<?=$row['buyer_name'];?>" />
								        <input type="hidden" name="delivery_type" value="<?=$row['delivery_type'];?>" />
								        <!-- <a href="javascript:document.form0.submit()" onclick="return confirm('주문확인 하셨습니까?')">주문확인</a> -->
								    	<button id="check" class="form-control" type="submit" onclick="return confirm('주문확인 하셨습니까?')"><i class="fa fa-check-circle"></i> 주문확인</button>
								    <!-- <div id="result"></div> -->
								    	</form>

								     >>>
								      <form class="form-inline" role="form" name="form1" method="post" action="or_changed.php" style="display: inline-block;">
								        <input type="hidden" name="mode" id="mode1" value="2" />
								        <input type="hidden" name="oid" id="oid1" value="<?=$oid;?>" />
								        <input type="hidden" name="key" value="<?=$key;?>" />
								        <input type="hidden" name="key_value" value="<?=$key_value;?>" />
								        <input type="hidden" name="page" value="<?=$page;?>" />
								        <input type="hidden" name="status" value="<?=$row['status'];?>" />
								        <input type="hidden" name="last_amount" id="last_amount1" value="<?=$final;?>" />
								        <input type="hidden" name="sms" value="<?=$mrows['sms'];?>" />
								        <input type="hidden" name="buyer_hphone" value="<?=$row['buyer_hphone'];?>" />
								        <input type="hidden" name="buyer_name" value="<?=$row['buyer_name'];?>" />
								        <input type="hidden" name="delivery_type" value="<?=$row['delivery_type'];?>" />
								        <!-- <a href="javascript:document.form.submit()" onclick="return confirm('포장이 완료되었습니까?\n확정된 금액으로 입력됩니다.')" >포장완료</a> -->
								        <button id="pack" class="form-control" type="submit" onclick="return confirm('포장이 완료되었습니까?\n확정된 금액으로 입력됩니다.')"><i class="fa fa-cube"></i> 포장완료</button>
								      </form>

								      <<<
									<form class="form-inline" role="form" name="form2" method="post" action="or_changed.php" style="display: inline-block;">
								        <input type="hidden" name="mode" id="mode2" value="0" />
								        <input type="hidden" name="oid" id="oid2" value="<?=$oid;?>" />
								        <input type="hidden" name="key" value="<?=$key;?>" />
								        <input type="hidden" name="key_value" value="<?=$key_value;?>" />
								        <input type="hidden" name="page" value="<?=$page;?>" />
								        <input type="hidden" name="status" value="<?=$row['status'];?>" />
								        <input type="hidden" name="last_amount" id="last_amount2" value="<?=$final;?>" />
								        <input type="hidden" name="sms" value="<?=$mrows['sms'];?>" />
								        <input type="hidden" name="buyer_hphone" value="<?=$row['buyer_hphone'];?>" />
								        <input type="hidden" name="buyer_name" value="<?=$row['buyer_name'];?>" />
								        <input type="hidden" name="delivery_type" value="<?=$row['delivery_type'];?>" />
								      <!-- <a href="javascript:document.form1.submit()" onclick="return confirm('발송이 지연됩니까?')">발송지연</a> -->
								      	<button id="delay" class="btn btn-warning"  onclick="return confirm('발송이 지연됩니까?')"><i class="fa fa-exclamation-triangle"></i> 발송지연</button>
									</form>
									<p>

								      <form class="form-inline" role="form" name="form3" method="post" action="or_changed.php"  style="display: inline-block;">
								        <input type="hidden" name="mode" id="mode3" value="3" />
								        <input type="hidden" name="oid" id="oid3" value="<?=$oid;?>" />
								        <input type="hidden" name="key" id="key3" value="<?=$key;?>" />
								        <input type="hidden" name="key_value" id="key_value3" value="<?=$key_value;?>" />
								        <input type="hidden" name="page" id="page3" value="<?=$page;?>" />
								        <input type="hidden" name="status" value="<?=$row['status'];?>" />
								        <input type="hidden" name="last_amount" id="last_amount3" value="<?=$final;?>" />
								        <input type="hidden" name="senddate" value="<?=$row['status'] == '8' ? $row['senddate'] : $today;?>" />
								         운송장 번호
								        <input type="text" class="form-control" name="track_no" id="track_no" value="<?=$row['track_no'];?>" size="80" />
								        &nbsp;<!-- <a href="javascript:document.form2.submit()" onclick="return confirm('운송장번호를 입력하셨습니까?')">발송완료</a> -->
								        <button id="send" class="btn btn-success" type="submit" onclick="return confirm('운송장번호를 입력하셨습니까?')"><i class="fa fa-truck"></i> 발송완료</button>&nbsp;<i class="fa fa-calendar"></i>&nbsp;<input type="text" class="form-control" name="senddate" id="senddate" value="<?=$row['status'] == '8' ? $row['senddate'] : $today;?>" size="10" />
								        <p class="help-block"><i class="fa fa-exclamation-triangle"></i> 여러 개 운송장 입력 시 구분은 ',(콤마)' 하세요 </p>
								      </form>
<?php
if ($row['status'] == "8" || $row['status'] == "-1" && $row['delivery_type'] == "L") {
    //택배사 정보
    $log_sql    = "SELECT * FROM misc_setup";
    $log_result = mysqli_query($connect, $log_sql);
    $log_row    = mysqli_fetch_array($log_result);

    //운송장번호 분리
    $t_no_arr = explode(",", $row['track_no']);
    echo "<p class=\"help-block\">(<i class=\"fa fa-exclamation-circle\"></i> 상품추적 : " . $log_row['logistics'] . " 택배 ";

    for ($i = 0; $i < count($t_no_arr); $i++) {
        //운송장번호 '-' 제거
        $t_no = preg_replace("/-/", "", $t_no_arr[$i]);
        echo "<a href=\"#\" onClick=\"javascript:TrackInfo(" . $t_no . ");\">" . $t_no . " </a> ";
    }

    echo ")</p>";
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
									<a class="btn btn-primary" href="top_order_list.php?mode=<?=$mode;?>&amp;oid=<?=$oid;?>&amp;key_value=<?=$key_value;?>&amp;page=<?=$page;?>">주문 목록</a>
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
	  <?php include "../include/admin_footer.php";?>
      <!--footer end-->
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="/js/vendor/jquery-2.2.0.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="/admin/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="/admin/js/jquery.scrollTo.min.js"></script>
    <script src="/admin/js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="/admin/js/respond.min.js" ></script>

    <!--common script for all pages-->
    <script src="/admin/js/common-scripts.js"></script>

    <!-- custom scripts -->
    <script src="/js/global.js" ></script>
    <script src="/admin/js/admin.js" ></script>
    <script src="/admin/js/jquery-ui.min.js"></script>
    <script src="/admin/js/jq_datepicker.js" ></script>
	<script>
		 $("textarea").keyup(function() {
		 	 $.post("add_memo.php", {
		 	 	add_memo:$("textarea").val(),
		 	 	oid:"<?=$oid;?>",
		 	 	key:"<?=$key;?>",
		 	 	key_value:"<?=$key_value;?>",
		 	 	page:"<?=$page;?>"
		 	 });
		 });
	</script>
  </body>
</html>

