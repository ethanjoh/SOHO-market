<?php include_once '../include/header.php';?>

<?php
$sql_1       = "SELECT num FROM mall_order WHERE cancel='N' AND status='3' AND user_id <> 'guest' ";
$res_1       = mysqli_query($connect, $sql_1);
$unchk_total = mysqli_num_rows($res_1);

$mode      = set_var($_GET['mode']);
$pmode     = set_var($_GET['pmode']);
$key       = set_var($_GET['key']);
$key_value = set_var($_GET['key_value']);
$keyword   = set_var($_GET['keyword']);
$date1     = set_var($_GET['date1']);
$date2     = set_var($_GET['date2']);
$lcode     = set_var($_GET['lcode']);
$mcode     = set_var($_GET['mcode']);
$scode     = set_var($_GET['scode']);

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
							  <li><i class="fa fa-info-circle"></i> 업체별 기간검색하기 : 1. 하단 검색조건에서 "업체명"으로 업체 검색 -> 2. 검색결과에서 해당 업체명 클릭 -> 3. 날짜검색에서 기간 설정 후 검색</li>
							</ul>
		                </section>

				      <?php
$today = date("Y-m-d");

//미확인건
$unchk_sql   = "SELECT * FROM mall_order WHERE cancel='N' AND status='3' AND user_id <> 'guest' ";
$unchk_res   = mysqli_query($connect, $unchk_sql);
$unchk_total = mysqli_num_rows($unchk_res);

//금일주문건
$today_sql   = "SELECT * FROM mall_order WHERE cancel='N' AND date(createdate)='$today' AND user_id <> 'guest' ";
$today_res   = mysqli_query($connect, $today_sql);
$today_total = mysqli_num_rows($today_res);

//발송대기건
$paid_sql   = "SELECT * FROM mall_order WHERE cancel='N' AND status='7' AND user_id <> 'guest' ";
$paid_res   = mysqli_query($connect, $paid_sql);
$paid_total = mysqli_num_rows($paid_res);

//미결제건
$nopaid_sql   = "SELECT * FROM mall_order WHERE cancel='N' AND pchk='N' AND user_id <> 'guest' ";
$nopaid_res   = mysqli_query($connect, $nopaid_sql);
$nopaid_total = mysqli_num_rows($nopaid_res);

//발송지연건
$delay_sql   = "SELECT * FROM mall_order WHERE cancel='N' AND status='0' AND user_id <> 'guest' ";
$delay_res   = mysqli_query($connect, $delay_sql);
$delay_total = mysqli_num_rows($delay_res);

//쪽지
// $memo_sql  = "SELECT * FROM message_info WHERE receive_chk='N' AND receiveid_fk = 'admin'  ";
// $memo_res  = mysqli_query($connect, $memo_sql);
// $msg_total = mysqli_num_rows($memo_res);

switch ($mode) {
    // case 'search' : $sql_2="SELECT orderid FROM mall_order
    //                         WHERE user_id <> 'guest' AND $key LIKE '%$key_value%' "; break;
    case 'search':$sql_2 = "SELECT * FROM mall_order
					                          	  WHERE user_id <> 'guest' AND (buyer_name LIKE '%$key_value%' OR user_id LIKE '%$key_value%' OR recipient_name LIKE '%$key_value%' OR goods_name LIKE '%$key_value%')";
        break;

    case 'date':$sql_2 = "SELECT orderid FROM mall_order
						                          WHERE cancel = 'N' AND date(createdate) BETWEEN '$date1' AND '$date2' AND user_id = '$key_value' ";
        break;
    case 'today':$today = date("Y-m-d");
        $sql_2              = "SELECT orderid FROM mall_order
						                          WHERE cancel = 'N' AND user_id <> 'guest' AND date(createdate) = '$today' ";
        break;
    case 'unchk':$sql_2 = "SELECT orderid FROM mall_order
						                          WHERE cancel = 'N' AND user_id <> 'guest' AND status = '3' ";
        break;
    case 'chk':$sql_2 = "SELECT orderid FROM mall_order
						                          WHERE cancel = 'N' AND user_id <> 'guest' AND status = '5' ";
        break;
    case 'paid':$sql_2 = "SELECT orderid FROM mall_order
						                          WHERE cancel = 'N' AND user_id <> 'guest' AND status = '7' ";
        break;
    case 'nopaid':$sql_2 = "SELECT orderid FROM mall_order
						                          WHERE cancel = 'N' AND user_id <> 'guest' AND pchk = 'N' ";
        break;
    case 'delay':$sql_2 = "SELECT orderid FROM mall_order
						                          WHERE cancel = 'N' AND user_id <> 'guest' AND status = '0' ";
        break;
    case 'finish':$sql_2 = "SELECT orderid FROM mall_order
						                          WHERE cancel = 'N' AND user_id <> 'guest' AND status = '8' ";
        break;
    case 'cancel':$sql_2 = "SELECT orderid FROM mall_order
						                          WHERE cancel = 'Y' AND user_id <> 'guest' ";
        break;
    case 'return':$sql_2 = "SELECT * FROM mall_order
						                          WHERE cancel = 'N' AND user_id <> 'guest' AND status = '-1' ";
        break;
    default:$sql_2 = "SELECT orderid FROM mall_order
						                          WHERE user_id <> 'guest' ";
}

$res_2 = mysqli_query($connect, $sql_2);
$total = mysqli_num_rows($res_2);

$scale = 30;
$page  = '';

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
						<input type="hidden" name="key" value="<?=$key;?>" />
						<input type="hidden" name="key_value" value="<?=$key_value;?>" />
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

		<?php }
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
						        	<a class="btn btn-default" href="top_order_list.php?mode=today">금일 주문건 (<?=$today_total;?>)</a>
						        	<a class="btn btn-default" href="top_order_list.php?mode=unchk">미처리 주문건 (<?=$unchk_total;?>)</a>
						        	<a class="btn btn-default" href="top_order_list.php?mode=chk">주문확인건 </a>
						        	<a class="btn btn-default" href="top_order_list.php?mode=delay">발송지연건(<?=$delay_total;?>)</a>
						        	<a class="btn btn-default" href="top_order_list.php?mode=paid">발송대기건 (<?=$paid_total;?>)</a>
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
							    주문 목록 (총 <?=number_format($total);?> 건)
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
						            <!-- <th>택배비</th> -->
						            <th>처리</br>(발송일)</th>
						            <th>취소/삭제</th>
						          </tr>
						        </thead>
					        	<tbody>
					          <?php
switch ($mode) {
    // case 'search' : $sql_4 = "SELECT * FROM mall_order
    //                           WHERE $key LIKE '%$key_value%' AND user_id <> 'guest' ORDER BY num DESC LIMIT $cline,$scale1 "; break;
    case 'search':$sql_4 = "SELECT * FROM mall_order
						                          WHERE user_id <> 'guest' AND (buyer_name LIKE '%$key_value%' OR user_id LIKE '%$key_value%' OR recipient_name LIKE '%$key_value%' OR goods_name LIKE '%$key_value%') ORDER BY num DESC LIMIT $cline,$scale1 ";
        break;

    case 'date':$sql_4 = "SELECT * FROM mall_order
						                          WHERE cancel = 'N' AND date(createdate) BETWEEN '$date1' AND '$date2' AND user_id = '$key_value' ORDER BY num DESC LIMIT $cline,$scale1 ";
        break;
    case 'today':$today = date("Y-m-d");
        $sql_4              = "SELECT * FROM mall_order
						                          WHERE cancel = 'N' AND user_id <> 'guest' AND date(createdate) = '$today' ORDER BY num DESC LIMIT $cline,$scale1 ";
        break;
    case 'unchk':$sql_4 = "SELECT * FROM mall_order
						                          WHERE cancel = 'N' AND status = '3' AND user_id <> 'guest' ORDER BY num DESC LIMIT $cline,$scale1 ";
        break;
    case 'chk':$sql_4 = "SELECT * FROM mall_order
						                          WHERE cancel = 'N' AND user_id <> 'guest' AND status = '5' ORDER BY num DESC LIMIT $cline,$scale1 ";
        break;
    case 'paid':$sql_4 = "SELECT * FROM mall_order
						                          WHERE cancel = 'N' AND user_id <> 'guest' AND status = '7' ORDER BY num DESC LIMIT $cline,$scale1 ";
        break;
    case 'nopaid':$sql_4 = "SELECT * FROM mall_order
						                          WHERE cancel = 'N' AND user_id <> 'guest' AND pchk = 'N' ORDER BY num DESC LIMIT $cline,$scale1 ";
        break;
    case 'delay':$sql_4 = "SELECT * FROM mall_order
						                          WHERE cancel = 'N' AND user_id <> 'guest' AND status = '0' ORDER BY num DESC LIMIT $cline,$scale1 ";
        break;
    case 'finish':$sql_4 = "SELECT * FROM mall_order
						                          WHERE cancel = 'N' AND user_id <> 'guest' AND status = '8' ORDER BY num DESC LIMIT $cline,$scale1 ";
        break;
    case 'cancel':$sql_4 = "SELECT * FROM mall_order
						                          WHERE cancel = 'Y' AND user_id <> 'guest' ORDER BY num DESC LIMIT $cline,$scale1 ";
        break;
    case 'return':$sql_4 = "SELECT * FROM mall_order
						                          WHERE cancel = 'N' AND user_id <> 'guest' AND status = '-1' ORDER BY num DESC LIMIT $cline,$scale1 ";
        break;
    default:$sql_4 = "SELECT * FROM mall_order
						                          WHERE user_id <> 'guest' ORDER BY num DESC LIMIT $cline,$scale1 ";
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

        //주문소스 추출
        $os = substr($row['num'], 0, 1);
        if ($os == "m") {
            $os_icon = "<img src=\"../images/smartphone.png\">";
        } else {
            $os_icon = "";
        }

        //회원정보
        $sql  = "SELECT * FROM member WHERE id='$row[user_id]' ";
        $res  = mysqli_query($connect, $sql);
        $trow = mysqli_fetch_array($res);

        if ($row['cancel'] == 'Y') {
            $c_color    = '#EBEBEB';
            $status_now = "주문취소";
            //$o_total -= $row['amount'];
            $total -= $row['last_amount']; //취소에 따른 합계금액차감
            ?>
					          <tr bgcolor="<?=$c_color;?>">
					            <td><?=$os_icon;?> <a href="or_view.php?mode=<?=$mode;?>&amp;oid=<?=$row['num'];?>&amp;key=<?=$key;?>&amp;key_value=<?=$key_value;?>&amp;page=<?=$page;?>"><?=$row['createdate'];?></a></td>
					            <td><?=$row['user_id'];?></td>
					            <td>
					            <?php
if ($row['recipient_name']) {
                echo "<a href=\"top_order_list.php?mode=search&amp;key=user_id&amp;key_value=" . $row['user_id'] . "\">" . $row['buyer_name'] . "</a> -> (" . $row['recipient_name'] . ") ";
            } else {
                echo "<a href=\"top_order_list.php?mode=search&amp;key=user_id&amp;key_value=" . $row['user_id'] . "\">" . $row['buyer_name'] . "</a> ";
            }

            if ($row['supplement']) {
                ?>
                        			<i class="fa fa-comment pop" data-toggle="popover" data-container="body" title="관리자 메모" data-content="<?=$row['supplement'];?>"></i>
					             <?php
}
            ?>
								</td>
					            <td><?=$trow['dc_rate'];?> %</td>
					            <td>-</td>
					            <td>-</td>
					            <td><a type="button" class="btn btn-danger" href="or_delete.php?mode=d&amp;oid=<?=$row['num'];?>&amp;page=<?=$page;?>" onclick="return confirm('취소된 주문입니다.\n삭제하시겠습니까?')"><i class="fa fa-trash-o"></i></a></td>
					            <?php
} else {
            if ($row['status'] == '1') {
                $c_color    = '#FFC8C8';
                $status_now = "미처리";
            } else if ($row['status'] == '3') {
                $c_color    = '#FFC8C8';
                $status_now = "미처리";
            } else if ($row['status'] == '5') {
                $c_color    = '#f7e8aa';
                $status_now = "주문확인";
            } else if ($row['status'] == '7') {
                $c_color    = '#EFFCFC';
                $status_now = "발송대기";
            } else if ($row['status'] == '8' && $row['pchk'] == "Y") {
                $c_color    = '#FFFFFF';
                $status_now = "발송완료";
                $status_now .= "</br>(" . $row['senddate'] . ")";
            } else if ($row['status'] == '0') {
                $c_color    = '#FFC995';
                $status_now = ">발송지연<";
            } else if ($row['status'] == '-1') {
                $c_color    = '#FBAFFF';
                $status_now = "⊙반품회수⊙";
                $status_now .= "</br>(" . $row['returndate'] . ")";
            } else if ($row['status'] == '8' && $row['pchk'] == "R") {
                $c_color    = '#FBAFFF';
                $status_now = "⊙반품회수 중⊙";
            }

            //주문소스 추출
            $os = substr($row['orderid'], 0, 1);
            if ($os == "m") {
                $os_icon = "<img src=\"../images/smartphone.png\">";
            } else {
                $os_icon = "";
            }

            ?>
					          <tr>
					            <td><?=$os_icon;?> <a href="or_view.php?mode=<?=$mode;?>&amp;oid=<?=$row['num'];?>&amp;key=<?=$key;?>&amp;key_value=<?=$key_value;?>&amp;page=<?=$page;?>"><?=$row['createdate'];?></a></td>
					            <td><?=$row['user_id'];?></td>
					            <td>
					            <?php

            if ($row['recipient_name']) {
                echo "<a href=\"top_order_list.php?mode=search&amp;key=user_id&amp;key_value=" . $row['user_id'] . "\">" . $row['buyer_name'] . "</a> -> (" . $row['recipient_name'] . ") ";
            } else {
                echo "<a href=\"top_order_list.php?mode=search&amp;key=user_id&amp;key_value=" . $row['user_id'] . "\">" . $row['buyer_name'] . "</a> ";
            }

            if ($row['supplement']) {
                ?>
                        			<i class="fa fa-comment pop" data-toggle="popover" data-container="body" title="관리자 메모" data-content="<?=$row['supplement'];?>"></i>
					             <?php
}
            ?>
								</td>
					            <td><?=$trow['dc_rate'];?> %</td>
					            <td>
					            	<?php
if ($row['last_amount'] == 0 && $row['status'] == "8") {
                echo " 0";
            } else if ($row['status'] == "0" || $row['status'] == "1" || $row['status'] == "3" || $row['status'] == "5") {
                echo "미확정";
            } else if ($row['amount'] != $row['last_amount']) {
                echo "<font color=\"#CC0066\">" . number_format($row['last_amount']) . "</font>";
            } else {
                echo number_format($row['last_amount']);
            }

            ?>
								</td>
								<!--
					            <td>
					            <?php
if ($row['delivery_type'] == 'L' || $row['delivery_type'] == 'L1') {
                if ($row['trans_cost'] == '0') {
                    echo "선불";
                } else if ($row['trans_cost'] > 0) {
                    echo "<font color=\"#FF0000\">착불</font>";
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
								-->

					            <td><?=$status_now;?></td>
					            <td><a type="button" class="btn btn-default" href="or_delete.php?oid=<?=$row['num'];?>&amp;page=<?=$page;?>" onclick="return confirm('정말 주문을 취소하시겠습니까?')"><i class="fa fa-times"></i></a></td>
					          </tr>
					          <?php

            $o_total += $row['amount'];
            $total += $row['last_amount'];
        } // else end
    }
    ; // for loop end
    ?>
					          <tr>
					            <td colspan="4"><strong>총합(NET):</strong></td>
					            <!--<td><strong>
					              <?=number_format($o_total);?>
					              </strong></td>-->
					            <td><strong><?=number_format($total);?></strong></td>
					            <td></td>
					            <td></td>
					            <!-- <td></td> -->
					          </tr>
					          <?php
} else {
    ?>
					          <tr>
					            <td colspan="7"><p>해당 주문내역이 없습니다.</p></td>
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
$url = $_SERVER['PHP_SELF'] . "?mode=" . $mode . "&pmode=" . $pmode . "&lcode=" . $lcode . "&mcode=" . $mcode . "&scode=" . $scode . "&key=" . $key . "&keyword=" . $keyword;
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
				            <input type="text" class="form-control" name="key_value" id="key_value" placeholder="수령인,업체명,아이디,상품명 입력" autocomplete="off">
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

		$(function() {

		    $(".pop").popover({
		      placement : 'top'
		    });

		    $("#guestModal0").modal("show");

		});
	</script>

  </body>
</html>
