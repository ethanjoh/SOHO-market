<?php include_once '../include/header.php';?>

<?php

$sql_1       = "SELECT num FROM mall_order WHERE user_flag = 'c' AND cancel='N' AND status='3' AND user_id <> 'guest' ";
$res_1       = mysqli_query($connect, $sql_1);
$unchk_total = mysqli_num_rows($res_1);

$reUrl = urlencode($_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING']);
?>

	<body onLoad="init()">
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
                <li><i class="fa fa-info-circle"></i> 신규주문 확인을 위해 5분마다 화면이 자동으로 새로고침됩니다.</li>
                <li><i class="fa fa-info-circle"></i> 수동으로 신규주문을 확인하시려면 미처리 주문건이나 전체 주문 버튼을 누르세요</li>
                <li><i class="fa fa-info-circle"></i> 업체별 기간검색하기 : 1. 하단 검색조건에서 "업체명"으로 업체 검색 -> 2. 검색결과에서 해당 업체명 클릭 -> 3. 날짜검색에서 기간 설정 후 검색</li>
                <li><i class="fa fa-info-circle"></i> 최소주문금액 이상은 무료배송, 미만은 택배비 추가 후 선불 표시됩니다.</li>
							</ul>
		        </section>

<?php

$today = date("Y-m-d");

//미확인건
$unchk_sql   = "SELECT * FROM mall_order WHERE user_flag = 'c' AND cancel='N' AND status='3' AND user_id <> 'guest' ";
$unchk_res   = mysqli_query($connect, $unchk_sql);
$unchk_total = mysqli_num_rows($unchk_res);

//금일주문건
$today_sql   = "SELECT * FROM mall_order WHERE user_flag = 'c' AND cancel='N' AND date(createdate)='$today' AND user_id <> 'guest' ";
$today_res   = mysqli_query($connect, $today_sql);
$today_total = mysqli_num_rows($today_res);

//발송대기건
$paid_sql   = "SELECT * FROM mall_order WHERE user_flag = 'c' AND cancel='N' AND status='7' AND user_id <> 'guest' ";
$paid_res   = mysqli_query($connect, $paid_sql);
$paid_total = mysqli_num_rows($paid_res);

//미결제건
$nopaid_sql   = "SELECT * FROM mall_order WHERE user_flag = 'c' AND cancel='N' AND pchk='N' AND user_id <> 'guest' ";
$nopaid_res   = mysqli_query($connect, $nopaid_sql);
$nopaid_total = mysqli_num_rows($nopaid_res);

//발송지연건
$delay_sql   = "SELECT * FROM mall_order WHERE user_flag = 'c' AND cancel='N' AND status='0' AND user_id <> 'guest' ";
$delay_res   = mysqli_query($connect, $delay_sql);
$delay_total = mysqli_num_rows($delay_res);

//쪽지
// $memo_sql  = "SELECT * FROM message_info WHERE user_flag = 'c' AND receive_chk='N' AND receiveid_fk = 'admin'  ";
// $memo_res  = mysqli_query($connect, $memo_sql);
// $msg_total = mysqli_num_rows($memo_res);

$mode    = set_var($_GET['mode']);
$key     = set_var($_GET['key']);
$keyword = set_var($_GET['keyword']);
$date1   = set_var($_GET['date1']);
$date2   = set_var($_GET['date2']);

switch ($mode) {
    // case 'search' : $sql_2="SELECT orderid FROM mall_order
    //                         WHERE user_flag = 'c' AND user_id <> 'guest' AND $key LIKE '%$keyword%' "; break;
    case 'search':$sql_2 = "SELECT * FROM mall_order WHERE user_flag = 'c' AND user_id <> 'guest' AND (buyer_name LIKE '%$keyword%' OR user_id LIKE '%$keyword%' OR recipient_name LIKE '%$keyword%' OR goods_name LIKE '%$keyword%')";
        break;

    case 'date':$sql_2 = "SELECT orderid FROM mall_order WHERE user_flag = 'c' AND cancel = 'N' AND date(createdate) BETWEEN '$date1' AND '$date2' AND user_id = '$keyword' ";
        break;
    case 'today':$today = date("Y-m-d");
        $sql_2              = "SELECT orderid FROM mall_order WHERE user_flag = 'c' AND cancel = 'N' AND user_id <> 'guest' AND date(createdate) = '$today' ";
        break;
    case 'unchk':$sql_2 = "SELECT orderid FROM mall_order WHERE user_flag = 'c' AND cancel = 'N' AND user_id <> 'guest' AND status = '3' ";
        break;
    case 'chk':$sql_2 = "SELECT orderid FROM mall_order WHERE user_flag = 'c' AND cancel = 'N' AND user_id <> 'guest' AND status = '5' ";
        break;
    case 'paid':$sql_2 = "SELECT orderid FROM mall_order WHERE user_flag = 'c' AND cancel = 'N' AND user_id <> 'guest' AND status = '7' ";
        break;
    case 'nopaid':$sql_2 = "SELECT orderid FROM mall_order WHERE user_flag = 'c' AND cancel = 'N' AND user_id <> 'guest' AND pchk = 'N' ";
        break;
    case 'delay':$sql_2 = "SELECT orderid FROM mall_order WHERE user_flag = 'c' AND cancel = 'N' AND user_id <> 'guest' AND status = '0' ";
        break;
    case 'finish':$sql_2 = "SELECT orderid FROM mall_order WHERE user_flag = 'c' AND cancel = 'N' AND user_id <> 'guest' AND status = '8' ";
        break;
    case 'cancel':$sql_2 = "SELECT orderid FROM mall_order WHERE user_flag = 'c' AND cancel = 'Y' AND user_id <> 'guest' ";
        break;
    case 'return':$sql_2 = "SELECT * FROM mall_order WHERE user_flag = 'c' AND cancel = 'N' AND user_id <> 'guest' AND status = '-1' ";
        break;
    default:$sql_2 = "SELECT orderid FROM mall_order WHERE user_flag = 'c' AND user_id <> 'guest' ";
}

$res_2 = mysqli_query($connect, $sql_2);
$total = mysqli_num_rows($res_2);

$page  = set_var($_GET['page']);
$scale = 30;

if ($page == '') {
    $page = 1;
}

$cpage     = intval($page);
$totalpage = intval($total / $scale);

if ($totalpage * $scale != $total) {
    $totalpage = $totalpage + 1;
}

if ($cpage == 1) {
    $cline = 0;
} else {
    $cline = ($cpage * $scale) - $scale;
}

$limit = $cline + $scale;

if ($limit >= $total) {
    $limit = $total;
}

$scale1 = $limit - $cline;
?>

<?php

if ($mode == "search") {
    ?>
						<!-- calendar start -->
						<form name="form" method="get" action="top_order_list.php" class="form-inline form-group" role="form">
						<input type="hidden" name="mode" value="date" />
						<input type="hidden" name="key" value="<?php echo $key; ?>" />
						<input type="hidden" name="keyword" value="<?php echo $keyword; ?>" />
						<div class="panel panel-info">
						  <div class="panel-heading">날짜 검색</div>
							  <div class="panel-body text-center">
							    <div class="row text-center">
							      <div class="form-group">
							          <label for="sd"><i class="fa fa-calendar"></i> 시작일 :</label>
							          <input type="text" class="form-control" name="date1" id="sd" value="" size="10" />
							      </div>
							      <div class="form-group">
							          <label for="ed"><i class="fa fa-calendar"></i> 종료일 :</label>
							          <input type="text" class="form-control" name="date2" id="ed" value="" size="10" />
							      </div>
							      <div class="form-group">
							          <button class="btn btn-primary btn-sm" onclick="document.form.submit()"><i class="fa fa-search"></i>검색</button>
							      </div>
							    </div>
						    </div>
						</div>
						</form>
						<!-- calendar end -->

<?php
}
?>
					</div>
				</div>
				<!-- info end -->

				<!-- buttons start -->
				<div class="row">
					<div class="col-sm-12">
						<div class="table-responsive">
						<table class="table">
							<tbody>
							  <tr>
							    <td class="text-center">
						        	<a class="btn btn-default" href="top_order_list.php?mode=today">금일 주문건 (<?php echo $today_total; ?>)</a>
						        	<a class="btn btn-default" href="top_order_list.php?mode=unchk">미처리 주문건 (<?php echo $unchk_total; ?>)</a>
						        	<a class="btn btn-default" href="top_order_list.php?mode=chk">주문확인건 </a>
						        	<a class="btn btn-default" href="top_order_list.php?mode=delay">발송지연건(<?php echo $delay_total; ?>)</a>
						        	<a class="btn btn-default" href="top_order_list.php?mode=paid">발송대기건 (<?php echo $paid_total; ?>)</a>
						        	<a class="btn btn-default" href="top_order_list.php?mode=finish">발송완료건</a>
						        	<a class="btn btn-default" href="top_order_list.php?mode=cancel">주문취소건</a>
						        	<!-- <a class="btn btn-default" href="top_order_list.php?mode=return">반품회수건</a> -->
						        	<a class="btn btn-primary" href="top_order_list.php?mode=all">전체 주문</a>
							    </td>
							  </tr>
							</tbody>
						</table>
						</div>
					</div>
				</div>
				<!-- buttons end -->

				<!-- order list start -->
				<div class="row">
		            <div class="col-sm-12">
						<section class="panel">
							<header class="panel-heading table-head">
							    기업회원 주문 목록 (총
                                <?php echo number_format($total); ?>
                                건)
						  	</header>
						  	<div class="panel-body">
						  	<div class="table-responsive">
					      	<table class="table table-striped">
						        <thead>
						          <tr>
						            <!--<th  class="member" scope="col">주문번호</th>-->
						            <th>주문일시</th>
						            <th>ID</th>
						            <th>업체명</th>
						            <!-- <th>거래형태</th> -->
						            <th>할인율</th>
						            <th>주문액</th>
						            <th>택배비</th>
                        <th>결제상태</th>
						            <th>처리상태</br>(발송일)</th>
						            <th>취소/삭제</th>
						          </tr>
						        </thead>
					        	<tbody>
<?php

switch ($mode) {
    // case 'search' : $sql_4 = "SELECT * FROM mall_order
    //                           WHERE user_flag = 'c' AND $key LIKE '%$keyword%' AND user_id <> 'guest' ORDER BY num DESC LIMIT $cline,$scale1 "; break;
    case 'search':$sql_4 = "SELECT * FROM mall_order WHERE user_flag = 'c' AND user_id <> 'guest' AND (buyer_name LIKE '%$keyword%' OR user_id LIKE '%$keyword%' OR recipient_name LIKE '%$keyword%' OR goods_name LIKE '%$keyword%') ORDER BY num DESC LIMIT $cline,$scale1 ";
        break;

    case 'date':$sql_4 = "SELECT * FROM mall_order WHERE user_flag = 'c' AND cancel = 'N' AND date(createdate) BETWEEN '$date1' AND '$date2' AND user_id = '$keyword' ORDER BY num DESC LIMIT $cline,$scale1 ";
        break;
    case 'today':
        $today = date("Y-m-d");
        $sql_4 = "SELECT * FROM mall_order WHERE user_flag = 'c' AND cancel = 'N' AND user_id <> 'guest' AND date(createdate) = '$today' ORDER BY num DESC LIMIT $cline,$scale1 ";
        break;
    case 'unchk':$sql_4 = "SELECT * FROM mall_order WHERE user_flag = 'c' AND cancel = 'N' AND status = '3' AND user_id <> 'guest' ORDER BY num DESC LIMIT $cline,$scale1 ";
        break;
    case 'chk':$sql_4 = "SELECT * FROM mall_order WHERE user_flag = 'c' AND cancel = 'N' AND user_id <> 'guest' AND status = '5' ORDER BY num DESC LIMIT $cline,$scale1 ";
        break;
    case 'paid':$sql_4 = "SELECT * FROM mall_order WHERE user_flag = 'c' AND cancel = 'N' AND user_id <> 'guest' AND status = '7' ORDER BY num DESC LIMIT $cline,$scale1 ";
        break;
    case 'nopaid':$sql_4 = "SELECT * FROM mall_order WHERE user_flag = 'c' AND cancel = 'N' AND user_id <> 'guest' AND pchk = 'N' ORDER BY num DESC LIMIT $cline,$scale1 ";
        break;
    case 'delay':$sql_4 = "SELECT * FROM mall_order WHERE user_flag = 'c' AND cancel = 'N' AND user_id <> 'guest' AND status = '0' ORDER BY num DESC LIMIT $cline,$scale1 ";
        break;
    case 'finish':$sql_4 = "SELECT * FROM mall_order WHERE user_flag = 'c' AND cancel = 'N' AND user_id <> 'guest' AND status = '8' ORDER BY num DESC LIMIT $cline,$scale1 ";
        break;
    case 'cancel':$sql_4 = "SELECT * FROM mall_order WHERE user_flag = 'c' AND cancel = 'Y'  AND user_id <> 'guest' ORDER BY num DESC LIMIT $cline,$scale1 ";
        break;
    case 'return':$sql_4 = "SELECT * FROM mall_order WHERE user_flag = 'c' AND cancel = 'N' AND user_id <> 'guest' AND status = '-1' ORDER BY num DESC LIMIT $cline,$scale1 ";
        break;
    default:$sql_4 = "SELECT * FROM mall_order WHERE user_flag = 'c' AND user_id <> 'guest' ORDER BY num DESC LIMIT $cline,$scale1 ";
}

$a_pay_type['1'] = "무통장 입금";
$a_pay_type['2'] = "신용카드";
$a_pay_type['3'] = "휴대폰 결제";

$res_4 = mysqli_query($connect, $sql_4);
// $t_no = mysqli_num_rows($res_4);

if ($res_4) {

    $total   = 0; //금일주문총액
    $o_total = 0;

    for ($i = 0; $row = mysqli_fetch_array($res_4); $i++) {

        //회원정보
        $sql  = "SELECT * FROM member WHERE id='$row[user_id]' ";
        $res  = mysqli_query($connect, $sql);
        $trow = mysqli_fetch_array($res);

        $pay_status = '';
        $pay_status = get_pg_info2($row['orderid']);

        /**
         * 주문 취소
         */
        if ($row['cancel'] == 'Y') {
            $c_color    = '#EBEBEB';
            $status_now = "주문취소";
                                           //$o_total -= $row['amount'];
            $total -= $row['last_amount']; //취소에 따른 합계금액차감
            ?>
					          <tr bgcolor="<?php echo $c_color; ?>">
					            <td><a href="or_view.php?mode=<?php echo $mode; ?>&amp;oid=<?php echo $row['num']; ?>&amp;key=<?php echo $key; ?>&amp;keyword=<?php echo $keyword; ?>&amp;page=<?php echo $page; ?>"><?php echo $row['createdate']; ?></a></td>
					            <td><?php echo $row['user_id']; ?></td>
					            <td>
<?php

            if ($row['recipient_name']) {
                echo '<a href="top_order_list.php?mode=search&amp;key=user_id&amp;keyword=' . $row['user_id'] . '">' . $row['buyer_name'] . '</a> <i class="fa fa-arrow-right"></i> (' . $row['recipient_name'] . ')';
            } else {
                echo '<a href="top_order_list.php?mode=search&amp;key=user_id&amp;keyword=' . $row['user_id'] . '">' . $row['buyer_name'] . '</a>';
            }

            if ($row['memo_to_admin']) {
                echo ' <i class="fa fa-envelope pop memo-color" data-toggle="popover" data-container="body" title="담당자에게 요청사항" data-content="' . $row['memo_to_admin'] . '"></i>';
            }
            ?>
								</td>
					            <td><?php echo $trow['dc_rate']; ?> %</td>
					            <td>-</td>
                      <td>-</td>
					            <td><?php echo $pay_status; ?></td>
                      <td>-</td>
					            <td><a type="button" class="btn btn-xs btn-danger" href="or_delete.php?mode=d&amp;oid=<?php echo $row['num']; ?>&amp;page=<?php echo $page; ?>" onclick="return confirm('취소된 주문입니다.\n삭제하시겠습니까?')"><i class="fa fa-trash-o"></i></a></td>
<?php

            /**
             * 정상 주문처리
             */
        } else {
            if ($row['status'] == '1') {
                $c_color    = '#FFC8C8';
                $status_now = '<i class="fa fa-pause"> 미처리';
            } else if ($row['status'] == '3') {
                $c_color    = '#FFC8C8';
                $status_now = '<i class="fa fa-pause"> 미처리';
            } else if ($row['status'] == '5') {
                $c_color    = '#f7e8aa';
                $status_now = '<i class="fa fa-check"></i> 주문확인';
            } else if ($row['status'] == '7') {
                $c_color    = '#EFFCFC';
                $status_now = '<i class="fa fa-flag-checkered"></i> 발송대기';
            } else if ($row['status'] == '8' && $row['pchk'] == "Y") {
                $c_color    = '#FFFFFF';
                $status_now = '<i class="fa fa-check-square-o"></i> 발송완료';
                $status_now .= "</br>(" . $row['senddate'] . ")";
            } else if ($row['status'] == '0') {
                $c_color    = '#FFC995';
                $status_now = '<i class="fa fa-minus-square"></i> 발송지연';
            } else if ($row['status'] == '-1') {
                $c_color    = '#FBAFFF';
                $status_now = "⊙반품회수⊙";
                $status_now .= "</br>(" . $row['returndate'] . ")";
            } else if ($row['status'] == '8' && $row['pchk'] == "R") {
                $c_color    = '#FBAFFF';
                $status_now = "⊙반품회수 중⊙";
            }

            ?>
					          <tr style="background-color:<?php echo $c_color; ?>;">
					            <td><a href="or_view.php?mode=<?php echo $mode; ?>&amp;oid=<?php echo $row['num']; ?>&amp;key=<?php echo $key; ?>&amp;keyword=<?php echo $keyword; ?>&amp;page=<?php echo $page; ?>"><?php echo $row['createdate']; ?></a></td>
					            <td><?php echo $row['user_id']; ?></td>
                                <td>
<?php

            if ($row['recipient_name']) {
                echo '<a href="top_order_list.php?mode=search&amp;key=user_id&amp;keyword=' . $row['user_id'] . '">' . $row['buyer_name'] . '</a> <i class="fa fa-arrow-right"></i> (' . $row['recipient_name'] . ')';
            } else {
                echo '<a href="top_order_list.php?mode=search&amp;key=user_id&amp;keyword=' . $row['user_id'] . '">' . $row['buyer_name'] . '</a>';
            }

            if ($row['memo_to_admin']) {
                echo ' <i class="fa fa-envelope pop memo-color" data-toggle="popover" data-container="body" title="담당자에게 요청사항" data-content="' . $row['memo_to_admin'] . '"></i>';
            }
            ?>
								</td>
					            <td><?php echo $trow['dc_rate']; ?> %</td>
					            <td>
<?php

            // if ($row['last_amount'] == 0 && $row['status'] == "8") {
            //     echo " 0";
            // } else if ($row['status'] == "0" || $row['status'] == "1" || $row['status'] == "3" || $row['status'] == "5") {
            //     echo "미확정";
            // } else if ($row['amount'] != $row['last_amount']) {
            //     echo "<font color=\"#CC0066\">" . number_format($row['last_amount']) . "</font>";
            // } else {
            //     echo number_format($row['last_amount']);
            // }
            echo number_format($row['amount'] + $row['trans_cost']);

            ?>
								</td>
		            <td>
<?php

            if ($row['delivery_type'] == 'L' || $row['delivery_type'] == 'L1') {
                if ($row['trans_cost'] == '0') {
                    echo "무료배송";
                } else if ($row['trans_cost'] > 0) {
                    echo "선불";
                } else if ($row['trans_cost'] == "-1") {
                    echo "(합포장)";
                }

                //else if($row['trans_cost'] == "-2")
                //    echo "(반품    )";
            } else {
                echo "-";
            }

            ?>
								</td>

                      <td><?php echo $pay_status; ?></td>
					            <td><?php echo $status_now; ?></td>
					            <td><a type="button" class="btn btn-xs btn-default" href="or_delete.php?oid=<?php echo $row['num']; ?>&amp;page=<?php echo $page; ?>" onclick="return confirm('정말 주문을 취소하시겠습니까?')"><i class="fa fa-times"></i></a></td>
					          </tr>
<?php

            $o_total += $row['amount'];
            $total += ($row['amount'] + $row['trans_cost']);
        } // else end
    }
    ; // for loop end
    ?>
					          <tr>
					            <td colspan="4"><strong>총합:</strong></td>
					            <!--<td><strong>
					              <?php echo number_format($o_total); ?>
					              </strong></td>-->
					            <td><strong><?php echo number_format($total); ?></strong></td>
					            <td></td>
					            <td></td>
					            <td></td>
                      <td></td>
					          </tr>
<?php
} else {
    ?>
					          <tr>
					            <td colspan="8"><p>해당 주문내역이 없습니다.</p></td>
					          </tr>
<?php
}
?>
					        </tbody>
					      </table>
					      </div>
					     </div>
						</section>
					</div>
				</div>
				<!-- order list end -->

		        <!-- page navigation start -->
				<div class="row text-center">
					<div class="col-sm-12">
						<div class="table-responsive">
				        <table class="table">
				          <tbody>
				            <tr>
				              <td>
<?php

$pmode = set_var($_GET['pmode']);
$lcode = set_var($_GET['lcode']);
$mcode = set_var($_GET['mcode']);

$url = $_SERVER['PHP_SELF'] . "?mode=" . $mode . "&pmode=" . $pmode . "&lcode=" . $lcode . "&mcode=" . $mcode . "&key=" . $key . "&keyword=" . $keyword;
page_nav($totalpage, $cpage, $url);
?>
				              </td>
				            </tr>
				          </tbody>
				        </table>
				        </div>
					</div>
				</div>
		        <!-- page navigation end -->

	      		<!-- search start -->
				<div class="row text-center">
					<div class="col-sm-12">
				    	<form class="form-inline" role="form" method="get" name="search" action="top_order_list.php">
				        <input type="hidden" name="mode" value="search">
				        <div class="ui-widget form-group">
				            <input type="text" class="form-control" name="keyword" id="keyword" placeholder="수령인,업체명,아이디,상품명 입력" autocomplete="off">
				            <button class="btn btn-primary" onclick="search.submit()"><i class="fa fa-search"></i>검 색</button>
				        </div>
				      </form>
					</div>
				</div>
				<!-- search end -->

          </section>
      </section>
      <!--main content end-->

      <!--footer start-->
	  <?php include_once "../include/admin_footer.php";?>
      <!--footer end-->

    <script src="/admin/js/jquery-ui.min.js"></script>
    <script src="/admin/js/jq_datepicker.js" ></script>
	<script>
		$(function() {

		    $(".pop").popover({
		      placement : 'top'
		    });

		    $("#guestModal0").modal("show");

		});
	</script>

  </body>
</html>
