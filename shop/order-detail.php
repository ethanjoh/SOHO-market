<?php include_once '../include/header.php';?>

    <!-- content -->
    <div class="content">

        <!-- CONTAINER: order list -->
        <div class="container">
            <?php
$oid  = set_var($_GET['oid']);
$page = set_var($_GET['page']);

$sql = "SELECT * FROM mall_order WHERE num = '$oid' ";
$res = mysqli_query($connect, $sql);
$row = mysqli_fetch_array($res);

// retrieve PG data
// $pg_sql    = "SELECT * FROM pg_info WHERE LGD_OID='$row[lgd_oid]' ";
// $pg_result = mysqli_query($connect, $pg_sql);
// $pg_row    = mysqli_fetch_array($pg_result);

// switch ($pg_row['LGD_PAYTYPE']) {
//   case 'SC0040':
//     if($pg_row['LGD_RESPCODE'] == "0000")
//       if($pg_row['LGD_CASFLAG'] == "R") {

//         $pay_status = "<img src='../images/bank--pencil.png' alt='가상계좌 할당' /> 계좌할당 : <h4>가상계좌 - ".$pg_row['LGD_ACCOUNTNUM']."</h4>\n";
//         $pay_status .= "<p>1) 가상계좌는 일회성 계좌이므로 재사용시(다시 그 계좌로 입금하시는 경우) 타인의 계좌로 입금될 가능성이 있습니다.<br />\n";
//         $pay_status .= "이 경우는 고객의 책임이므로 사용에 주의하시기 바랍니다. <br />\n";
//         $pay_status .= "2) 가상계좌의 경우 CD기에서 현금입금 하실 수 없습니다.  CD기에서 이체는 가능합니다.</p>\n";

//       }elseif($pg_row['LGD_CASFLAG'] == "I")
//         $pay_status = "<img src='../images/bank--plus.png' alt='가상계좌 입금' /> 입금완료";
//     elseif($pg_row['LGD_CASFLAG'] == "C")
//         $pay_status = "<img src='../images/bank.png' alt='가상계좌 취소' /> 입금취소";
//     else
//       $pay_status = "<img src='../images/bank--exclamation.png' alt='계좌이체 실패' /> 이체실패(".$pg_row['LGD_RESPCODE'].")";

//     break;
//   case 'SC0030':
//     if($pg_row['LGD_RESPCODE'] == "0000")
//       $pay_status = "<img src='../images/bank.png' alt='계좌이체 완료' /> 이체완료";
//     else
//       $pay_status = "<img src='../images/bank--exclamation.png' alt='계좌이체 실패' /> 이체실패(".$pg_row['LGD_RESPCODE'].")";

//     break;

//   default: //SC0010 credit card
//     if($pg_row['LGD_RESPCODE'] == "0000")
//       $pay_status = "<img src='../images/credit-card-green.png' alt='카드결제 완료' /> 결제완료";
//     else
//       $pay_status = "<img src='../images/credit-card--exclamation.png' alt='카드결제 실패' /> 결제실패(".$pg_row['LGD_RESPCODE'].")";

//     break;
// }

$a_goods_fk = explode(",", $row['goods_fk']);
$org_price  = explode(",", $row['goods_price']);
$mod_price  = explode(",", $row['mod_price']);
$org_volume = explode(",", $row['goods_count']);
$mod_volume = explode(",", $row['mod_count']);
$option     = explode(",", $row['goods_kind']);
$tot_amount = 0;
$org_amount = 0;
$t_count    = 0;
$mt_count   = 0;
$pay_status = '';

$order_detail = '<div class="panel panel-success margin-top-10">';
$order_detail .= '  <div class="panel-heading">주문내역</div>';
$order_detail .= '    <div class="panel-body">';
$order_detail .= '      <div class="table-responsive">';
$order_detail .= '          <table class="table">';
$order_detail .= '            <thead>';
$order_detail .= '              <tr>';
$order_detail .= '                <th>이미지</th>';
$order_detail .= '                <th>상품명</th>';
$order_detail .= '                <th>옵션</th>';
$order_detail .= '                <th>주문수량</th>';
$order_detail .= '                <th>출고수량</th>';
$order_detail .= '                <th>공급가</th>';
$order_detail .= '                <th>변경공급가</th>';
$order_detail .= '                <th>공급가합</th>';
$order_detail .= '             </tr>';
$order_detail .= '           </thead>';
$order_detail .= '           <tbody>';

//물건 정보를 불러옵니다.
for ($i = 0; $i < sizeof($a_goods_fk); $i++) {
    $pro_sql    = "SELECT * FROM products WHERE num='$a_goods_fk[$i]'";
    $pro_result = mysqli_query($connect, $pro_sql);
    $pro_row    = mysqli_fetch_array($pro_result);
    $goods_name = $pro_row['name'];
    $img_char   = $pro_row['s_image1_name'];

    //상품옵션 품절표시
    //상품 옵션이 있는지 확인 후 진행
    if ($option[$i] != "" || $option2[$i] != "") {
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

    } //end of if clause

    $order_detail .= "        <tr>\n";
    $order_detail .= "          <td><img src=\"" . $img_char . "\" /></td>\n";
    $order_detail .= "          <td>" . show_icon($pro_row) . stripslashes($goods_name) . "</td>\n";
    $order_detail .= "          <td>\n";

    if ($option[$i]) {
        $order_detail .= $option[$i];
    }

    $order_detail .= "          </td>\n";
    $order_detail .= "          <td>" . $org_volume[$i] . "</td>\n";
    $order_detail .= "          <td>" . $mod_volume[$i] . "</td>\n";

    if ($pro_row['fixed_price']) {
        $order_detail .= "        <td><img src=\"../images/lock.png\" alt=\"고정공급가\">" . number_format($org_price[$i]) . "</td>\n";

    } else {
        $order_detail .= "        <td>" . number_format($org_price[$i]) . "</td>\n";
    }

    $order_detail .= "          <td>" . number_format($mod_price[$i]) . "</td>\n";

    $sub_amount = (int) $mod_volume[$i] * (int) $mod_price[$i];
    $sub_amount = number_format($sub_amount);

    $order_detail .= "          <td>" . $sub_amount . "</td>\n";
    $order_detail .= "        </tr>\n";

    $tot_amount = $tot_amount + ((int) $mod_price[$i] * (int) $mod_volume[$i]);
    $org_amount = $org_amount + ((int) $org_price[$i] * (int) $org_volume[$i]);
    $t_count    = $t_count + (int) $org_volume[$i];
    $mt_count   = $mt_count + (int) $mod_volume[$i];

}

$trans_cost = trans_cal($tot_amount);
$last_cost  = $tot_amount + $trans_cost;

if ($trans_cost > 0) {
    $amount_o            = $tot_amount + $trans_cost;
    $amount_order_detail = " ( $tot_amount 원 + $trans_cost 원 ) ";
} else {
    $amount_o = $tot_amount;
}

//$tot_amount = number_format($tot_amount);
$order_detail .= "          <tr>\n";
$order_detail .= "            <td colspan=\"3\"> 추가금액 :</td>\n";
$order_detail .= "            <td colspan=\"5\"></td>\n";
$order_detail .= "            <td>\n";

if ($row['a_charge'] != 0) {
    $order_detail .= "+ " . number_format($row['a_charge']);
}

$order_detail .= "            </td>\n";
$order_detail .= "          </tr>\n";

$last_cost2 = $last_cost + $row['a_charge'];

$order_detail .= "          <tr>\n";
$order_detail .= "            <td colspan=\"3\"><h4>합계 : </h4></td>\n";
$order_detail .= "            <td>" . $t_count . " 개</td>\n";
$order_detail .= "            <td>" . $mt_count . " 개</td>\n";

// get delivery fee info.
$dqry = "SELECT * FROM misc_setup ";
$dres = mysqli_query($connect, $dqry);
$drow = mysqli_fetch_array($dres);

$t_str = '';

if ($tot_amount >= $drow['min_sum']) {
    $t_str .= "<strong>" . number_format($last_cost2) . "&nbsp;원 (VAT 포함)<br/>(배송비 무료)</strong>";
} else {
    $t_str .= "<strong>" . number_format($last_cost2) . "&nbsp;원 (VAT 포함)<br/>(배송비: 착불)</strong>";
}

$order_detail .= "              <td></td>\n";
$order_detail .= "              <td></td>\n";
$order_detail .= "              <td colspan=\"2\"><h4>" . $t_str . "</h4></td>\n";
$order_detail .= "            </tr>\n";
$order_detail .= "          </tbody>\n";
$order_detail .= "        </table>\n";
$order_detail .= "      </div>\n";
$order_detail .= "    </div> <!-- end of table-resposive -->\n";
$order_detail .= "</div>\n";

if ($row['payment_type'] == 1) {$payment_type = "무통장 입금";}
if ($row['payment_type'] == 2) {$payment_type = "신용카드";}
if ($row['payment_type'] == 3) {$payment_type = "실시간 계좌이체";}

//택배사 정보
$log_sql    = "SELECT * FROM misc_setup";
$log_result = mysqli_query($connect, $log_sql);
$log_row    = mysqli_fetch_array($log_result);

//운송장번호 '-' 제거
// $tracking_no =  preg_replace("/-/","",$row['track_no']);

$a_status['3'] = "<i class=\"fa fa-pause\"></i>상품을 준비 중입니다.";
$a_status['5'] = "<i class=\"fa fa-check\"></i>주문확인 후 포장 중입니다.";
$a_status['7'] = "<i class=\"fa fa-flag-checkered\"></i>포장완료 후 발송 준비 중입니다.";
$a_status['8'] = "<i class=\"fa fa-check-square-o\"></i> 상품을 발송했습니다. (운송장 번호: " . $log_row['logistics'] . " 택배 ";
$t_no_arr      = explode(",", $row['track_no']);

for ($i = 0; $i < count($t_no_arr); $i++) {
    //운송장번호 '-' 제거
    $t_no = preg_replace("/-/", "", $t_no_arr[$i]);
    $a_status['8'] .= "<a href=\"#\" onClick=\"javascript:TrackInfo(" . $t_no . ");\">" . $t_no . " </a> ";
}

$a_status['8'] .= ")";

?>

        <?php echo $order_detail; ?>

            <div class="panel panel-info">
              <div class="panel-heading">주문정보</div>
                <div class="panel-body">

                    <div class="row">
                        <div class="col-sm-3">주문번호</div>
                        <div class="col-sm-9"><?php echo $row['orderid']; ?> (주문일 : <?php echo $row['createdate']; ?> )</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">구매자( <?php echo $row['user_id']; ?> )</div>
                        <div class="col-sm-9">
                            <?php echo $row['buyer_name']; ?><br />
                            <?php echo $row['buyer_zipcode']; ?> <br />
                            <?php echo $row['buyer_address']; ?><br />
                            <?php echo $row['buyer_phone']; ?><br />
                            <?php echo $row['buyer_hphone']; ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">수령자</div>
                        <div class="col-sm-9">
                            <?php echo $row['recipient_name']; ?><br />
                            <?php echo $row['recipient_zipcode']; ?><br />
                            <?php echo $row['recipient_address']; ?><br />
                            <?php echo $row['recipient_phone']; ?><br />
                            <?php echo $row['recipient_hphone']; ?></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">결제방법</div>
                        <div class="col-sm-9">
                            <?php echo $pay_status; ?>
                            <?php
//무통장 입금시만 출력
if ($row['payment_type'] == '3') {
    ?>
                                  <p>
                                  <?php echo $row['bank']; ?><br />
                                  (입금자: <?php echo $row['account']; ?> / 입금예정일 : <?php echo $row['deposit_date']; ?>)
                                  </p>
                              <?php

}
?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">주문금액</div>
                        <div class="col-sm-9"><?php echo number_format($org_amount); ?> 원</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">처리상태</div>
                        <div class="col-sm-9"><?php echo $a_status[$row['status']]; ?></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">배송 시 요청사항</div>
                        <div class="col-sm-9"><?php echo nl2br($row['memo_to_delivery']); ?></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">담당자에게 요청사항</div>
                        <div class="col-sm-9"><?php echo nl2br($row['memo_to_admin']); ?></div>
                    </div>
                    <div class="row warning">
                        <div class="col-sm-3">※ 관리자 메모</div>
                        <div class="col-sm-9"><?php echo nl2br($row['supplement']); ?></div>
                    </div>


                </div> <!-- end panel body -->
            </div> <!-- end panel -->
            <div class="row text-center">
              <a class="btn btn-primary" href="order-list.php?page=<?php echo $page; ?>">주문 목록</a>
            </div>



        </div>
        <!-- /.container -->
    </div>
    <!-- /.content -->
</div>
<!-- /.wrapper -->

<?php include_once '../include/brands.php';?>

<?php include_once '../include/footer.php';?>

    </body>
</html>